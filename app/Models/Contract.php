<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Contract extends Model
{
    use LogsActivity;
    protected $fillable=[
        "order_id",
        "user_id",
        "user_address_id",
        "user_pm_id",
        "total_amount",
        "confirmed",
        'payment_obj'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function getStartDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function getEndDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function getRenewalDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function getRenewalReminderDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }
    
    public function customer()
    {
        return $this->belongsTo('App\Models\User','customer_id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    
    public function association()
    {
        return $this->belongsTo('App\Models\User','association_id');
    }
    
    public function vendor()
    {
        return $this->belongsTo('App\Models\User','vendor_id');
    }
    
    public function media()
    {
        return $this->hasMany('App\Models\ContractMedia','contract_id');
    }

    public function emp()
    {
        return $this->belongsTo('App\Models\User','emp_id');
    }
    
    public function product_categories()
    {
        return $this->hasMany('App\Models\ContractProductCategory','contract_id');
    }

    public function order_items()
    {
        return $this->hasOne('App\Models\OrderItem','order_id');
    }

    // relation to user address
    public function user_address()
    {
        return $this->belongsTo('App\Models\Address','user_address_id');
    }

    //status
    public function statuss()
    {
        return $this->hasMany('App\Models\OrderStatus','order_id');
    }

    //latest status
    public function latest_status()
    {
        return $this->hasOne('App\Models\OrderStatus','order_id')->latest();
    }

    //latest status
    public function ratingg()
    {
        return $this->hasOne('App\Models\Rating','order_id','order_id');
    }

    public function renew_contracts()
    {
        return $this->hasMany('App\Models\Contract','renew_from');
    }

    public static function getReminderContracts() {
        $now = \Carbon\Carbon::now();
        $threeMonthsFromNow = $now->copy()->addMonths(3)->format('d-m-Y');
        $oneMonthFromNow = $now->copy()->addMonths(1)->format('d-m-Y');
        $fifteenDaysFromNow = $now->copy()->addDays(15)->format('d-m-Y');
        $sevenDaysFromNow = $now->copy()->addDays(7)->format('d-m-Y');
        
        $contracts=Contract::whereNull('status');
        return $contracts_to_reminder= [
            '7-days' => (clone $contracts)->where('end_date', $sevenDaysFromNow)->get(),
            '15-days' => (clone $contracts)->where('end_date', $fifteenDaysFromNow)->get(),
            '1-month' => (clone $contracts)->where('end_date', $oneMonthFromNow)->get(),
            '3-month' => (clone $contracts)->where('end_date', $threeMonthsFromNow)->get(),
        ];
    }
}
