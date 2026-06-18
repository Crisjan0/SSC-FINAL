<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_name',
        'course',
        'year_level',
        'amount',
        'date',
        'description',
        'archive_batch_name',
        'recorded_by',
    ];
}
