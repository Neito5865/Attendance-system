<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Timestamp;
use App\Models\Breakstamp;
use Carbon\Carbon;

class EndDayShiftCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shift:end-day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'End day for ongoing shifts and create new shifts if necessary';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $endOfDay = $now->copy()->subSecond(); // 23:59:59
        $startOfDay = $now->copy()->startOfDay(); // 00:00:00

        $timestamps = Timestamp::whereIn('status', [2, 3]) // 勤務中または休憩中のステータス
            ->whereNull('work_out')
            ->whereDate('work_in', '<', $startOfDay) // 日付を跨いでいるレコードを取得
            ->get();

        foreach($timestamps as $timestamp){
            // 1日目の勤務を終了
            $timestamp->update([
                'work_out' => $endOfDay,
                'status' => 1, // 勤務終了
            ]);

            // 2日目の新しい勤務レコードを作成
            $newTimestamp = Timestamp::create([
                'user_id' => $timestamp->user_id,
                'work_in' => $startOfDay,
                'status' => 2, // 勤務中
            ]);

            // 休憩中の場合、休憩を終了し、新しい休憩を開始
            if($timestamp->status == 3){
                $ongoingBreaks = $timestamp->breakstamps()->whereNull('break_out')->get();

                foreach($ongoingBreaks as $break){
                    // 1日目の休憩を終了
                    $break->update([
                        'break_out' => $endOfDay,
                    ]);

                    // 2日目の新しい休憩レコードを作成
                    Breakstamp::create([
                        'timestamp_id' => $newTimestamp->id,
                        'break_in' => $startOfDay,
                        'break_out' => null,
                    ]);
                }
                // 新しい勤務レコードのステータスを休憩中に設定
                $newTimestamp->update(['status' => 3]);
            }
            $this->info("User ID {$timestamp->user_id}'s shift was split across day.");
        }

        return 0; // コマンドが正常に実行されたことを示す
    }
}
