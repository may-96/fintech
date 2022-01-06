<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function accounts(){
        return $this->hasMany(Account::class);
    }

    public function agreements(){
        return $this->hasMany(Account::class);
    }
}
