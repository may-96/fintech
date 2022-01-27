<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function institution(){
        return $this->belongsTo(Institution::class);
    }

    public function requisition(){
        return $this->belongsTo(Requisition::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function balances(){
        return $this->hasMany(Balance::class);
    }

    public function shared_with(){
        return $this->belongsToMany(User::class)->withTimestamps()->with(["id","nickname"]);
    }
}
