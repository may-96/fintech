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

    public function user_notified_by_email(){
        return $this->belongsToMany(User::class, 'report_link_email_user', 'report_request_link_id', 'user_id');
    }
}
