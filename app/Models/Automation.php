<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Automation extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date_time',
        'end_date_time',
    ];


    public function getStartDateTimeAttribute($date_time)
    {
        return format_date_time($date_time);
    }
    public function getEndDateTimeAttribute($date_time)
    {
        return format_date_time($date_time);
    }
    public function getRecurringStartWeekDayAttribute($day)
    {
        if (!$day)
            return $day;
        return ucfirst(strtolower($day));
    }
    public function getRecurringEndWeekDayAttribute($day)
    {
        if (!$day)
            return $day;
        return ucfirst(strtolower($day));
    }
}
