<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportRequestByLink extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "request_report_by_link";

    public function user(){
        return $this->belongsTo(User::class);
    }
}
