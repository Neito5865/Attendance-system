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
}
