<?php

namespace App\Models;

use App\Models\Proposal;
use App\Models\UserRequest;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use App\Notifications\PasswordReset;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable,HasRoles,HasApiTokens,LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'phone_c_data',
        'date_of_birth',
        'gender',
        'nationality',
        'password',
        'otp',
        'otp_expiry',
        'otp_verified_at',
        'profile_image',
        'association',
        'designation',
        'city'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'otp',
        'otp_expiry',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }

    /**
     * Get the user's devices.
     *
     * @return string
     */
    public function devices()
    {
        return $this->hasMany('App\Models\UserDevice');
    }

    public function scopeSalesperson($query)
    {
        return $query->whereHas('roles',function($q){
            $q->where('name','salesperson');
        });
    }

    public function scopeCustomer($query)
    {
        return $query->whereHas('roles',function($q){
            $q->where('name','customer');
        });
    }

    public function scopePurchaser($query)
    {
        return $query->whereHas('roles',function($q){
            $q->where('name','purchaser');
        });
    }

    public function scopeVendor($query)
    {
        return $query->whereHas('roles',function($q){
            $q->where('name','vendor');
        });
    }

    public function scopeEmployee($query)
    {
        return $query->whereHas('roles',function($q){
            $q->where('name','employee');
        });
    }

    public function getAssociation()
    {
        if ($this->association) {
            $as=explode('|',$this->association);
            $users=User::whereIn('id',$as)->get();
            return $users;
        } else {
            return collect();
        }

    }

    public function getProfileImageAttribute($value)
    {
        return $value ? ($this->provider ? $value : (url('/').'/storage/public/uploads/users/' . $value) ): "";
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function company_profile()
    {
        return $this->hasOne('App\Models\CompanyProfile','user_id');
    }

    public function proposals()
    {
        return $this->hasMany('App\Models\Proposal','supplier_id');
    }

    public function proposal_accepted()
    {
        $user_req=$this->requests;
        if ($user_req->count()) {
            $proposals=Proposal::whereIn('req_id',$user_req->pluck('id'))->where('status','ACCEPTED')->get();
            return $proposals;
        } else {
            return [];
        }

    }

    public function user_roles()
    {
        return $this->roles()->first();
    }

    public function nationalityData()
    {
        return $this->belongsTo('App\Models\Nationality','nationality');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\UserCompany','user_id');
    }

    // employee company
    public function employee_company()
    {
        return $this->hasOne('App\Models\CompanyEmployee','user_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address','user_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order','user_id');
    }

    public function payment_methods()
    {
        return $this->hasMany('App\Models\PaymentMethod','user_id');
    }

    public function completed_requests()
    {
        return $this->requests()->whereHas('proposals',function($q){
            $q->where('status','COMPLETED');
        })->get();
    }

    public function completed_proposals()
    {
        return $this->proposals()->has('request')->where('status','COMPLETED')->get();
    }

    public function pending_requests()
    {
        return $this->requests()->whereHas('proposals',function($q){
            $q->where('status','PENDING');
        })->get();
    }

    public function pending_proposals()
    {
        return $this->proposals()->has('request')->where('status','PENDING')->get();
    }

}
