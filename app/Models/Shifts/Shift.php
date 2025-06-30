<?php

namespace App\Models\Shifts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;
use Auth;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_category',
        'start_time',
        'end_time',
        'location',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
