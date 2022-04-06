<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded=[];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function accounts(){
        return $this->hasMany(Account::class);
    }

    public function agreements(){
        return $this->hasMany(Account::class);
    }

    public function shared_accounts(){
        return $this->belongsToMany(Account::class)->withTimestamps()->withPivot(["id","nickname"]);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function update_error_code($error_field, $code){
        $this->$error_field = $code;
        $this->save();
    }

    public function shared_reports_with(){
        return $this->belongsToMany(User::class, 'report_user', 'shared_with', 'user_id')->withTimestamps()->withPivot(['id','view_cash_flow','view_expense','view_income','view_email','view_contact','view_credit_score','view_initials_only','view_account_initials_only','amount','token','shareable_link']);
    }

    public function shared_reports(){
        return $this->belongsToMany(User::class, 'report_user', 'user_id', 'shared_with')->withTimestamps()->withPivot(['id','view_cash_flow','view_expense','view_income','view_email','view_contact','view_credit_score','view_initials_only','view_account_initials_only','amount','token','shareable_link']);
    }

    public function report_requests(){
        return $this->belongsToMany(User::class, 'report_request', 'user_id', 'requested_from')->withTimestamps()->withPivot(['id','amount']);
    }

    public function report_requested_from(){
        return $this->belongsToMany(User::class, 'report_request', 'requested_from', 'user_id')->withTimestamps()->withPivot(['id','amount']);
    }


}
