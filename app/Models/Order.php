<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Order extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'type', 'payload'];

    public function getTypeAttribute($type){
        return strtolower($type);
    }

}
