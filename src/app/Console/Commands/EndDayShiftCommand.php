<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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

        $now = Carbon::now();
        $endOfDay = $now->copy()->startOfDay()->subSecond();
        $startOfDay = $now->copy()->startOfDay();

        try{

            $timestamps = Timestamp::whereIn('status', [2, 3])
                ->whereNull('work_out')
                ->whereDate('work_in', '<', $startOfDay)
                ->get();


            foreach ($timestamps as $timestamp) {
                if ($timestamp->status == 2) {
                    $timestamp->update([
                        'work_out' => $endOfDay,
                        'status' => 1,
                    ]);

                    $newTimestamp = Timestamp::create([
                        'user_id' => $timestamp->user_id,
                        'work_in' => $startOfDay,
                        'status' => 2,
                    ]);
                }elseif($timestamp->status == 3){
                    $ongoingBreaks = $timestamp->breakstamps()->whereNull('break_out')->get();
                    foreach ($ongoingBreaks as $break) {
                        $break->update([
                        'break_out' => $endOfDay,
                        ]);
                    }

                    $timestamp->update([
                        'work_out' => $endOfDay,
                        'status' => 1,
                    ]);

                    $newTimestamp = Timestamp::create([
                        'user_id' => $timestamp->user_id,
                        'work_in' => $startOfDay,
                        'status' => 3,
                        ]);

                    Breakstamp::create([
                        'timestamp_id' => $newTimestamp->id,
                        'break_in' => $startOfDay,
                        'break_out' => null,
                    ]);
                }
            }

            \Log::info('EndDayShiftCommand executed successfully.');
        } catch (\Exception $e) {
            \Log::error('EndDayShiftCommand failed: ' . $e->getMessage());
        }
    }
}
