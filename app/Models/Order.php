<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Order extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'type', 'payload', 'user_id', 'file'];

    public function getTypeAttribute($type){
        return strtolower($type);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
