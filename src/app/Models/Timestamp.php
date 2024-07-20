<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timestamp extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'time_in',
        'time_out',
        'break_in',
        'break_out',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
