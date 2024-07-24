<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timestamp extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'status',
        'work_in',
        'work_out',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function breakstamps(){
        return $this->hasMany(Breakstamp::class);
    }

    protected $appends = ['work_time', 'break_time'];

    protected $casts = [
        'work_in' => 'datetime',
        'work_out' => 'datetime',
    ];

    public function getBreakTimeAttribute(){
        $breaks = $this->breakstamps;
        $totalBreakTimeInSeconds = 0;
        $hasValidBreaks = false;

        foreach ($breaks as $break){
            if($break->break_in && $break->break_out){
                $totalBreakTimeInSeconds += $break->break_out->diffInSeconds($break->break_in);
                $hasValidBreaks = true;
            }
        }
        if ($hasValidBreaks){
            return gmdate('H:i:s', $totalBreakTimeInSeconds);
        }else{
            return '-';
        }

    }

    public function getWorkTimeAttribute(){
        if($this->work_in && $this->work_out){
            $diffInSeconds = $this->work_out->diffInSeconds($this->work_in);

            $hours = floor($diffInSeconds / 3600);
            $minutes = floor(($diffInSeconds % 3600) / 60);
            $seconds = $diffInSeconds % 60;

            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }else{
            return '-';
        }
    }
}
