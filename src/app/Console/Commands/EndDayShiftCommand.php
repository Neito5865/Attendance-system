<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
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
        \Log::info('DB_HOST: ' . env('DB_HOST'));
        \Log::info('DB_DATABASE: ' . env('DB_DATABASE'));
        \Log::info('DB_USERNAME: ' . env('DB_USERNAME'));
        \Log::info('DB_PASSWORD: ' . env('DB_PASSWORD'));

        $now = Carbon::now();
        $endOfDay = $now->copy()->startOfDay()->subSecond(); // 23:59:59 of the previous day
        $startOfDay = $now->copy()->startOfDay(); // 00:00:00 of the current day

        try{

            $timestamps = Timestamp::whereIn('status', [2, 3]) // 勤務中または休憩中のステータス
                ->whereNull('work_out')
                ->whereDate('work_in', '<', $startOfDay) // 日付を跨いでいるレコードを取得
                ->get();


            foreach ($timestamps as $timestamp) {
                if ($timestamp->status == 2) {
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
                }elseif($timestamp->status == 3){
                    // 1日目の休憩を終了
                    $ongoingBreaks = $timestamp->breakstamps()->whereNull('break_out')->get();
                    foreach ($ongoingBreaks as $break) {
                        $break->update([
                        'break_out' => $endOfDay,
                        ]);
                    }

                    // 1日目の勤務を終了
                    $timestamp->update([
                        'work_out' => $endOfDay,
                        'status' => 1, // 勤務終了
                    ]);

                    // 2日目の新しい勤務レコードを作成
                    $newTimestamp = Timestamp::create([
                        'user_id' => $timestamp->user_id,
                        'work_in' => $startOfDay,
                        'status' => 3, // 休憩中
                        ]);

                    // 2日目の新しい休憩レコードを作成
                    Breakstamp::create([
                        'timestamp_id' => $newTimestamp->id,
                        'break_in' => $startOfDay,
                        'break_out' => null,
                    ]);
                }
            }

            // 処理が正常に終了したことをログに記録
            Log::info('EndDayShiftCommand executed successfully.');
        } catch (\Exception $e) {
            // エラーが発生した場合は、エラーメッセージをログに記録
            Log::error('EndDayShiftCommand failed: ' . $e->getMessage());
        }
    }
}
