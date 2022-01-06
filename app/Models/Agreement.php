<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function institution(){
        return $this->belongsTo(User::class);
    }

    public function requisition(){
        return $this->hasOne(Requisition::class);
    }
    
}
