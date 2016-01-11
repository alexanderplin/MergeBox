<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    protected $table = 'service_accounts';
    protected $fillable = ['user_id', 'service', 'service_email', 'service_id', 'service_accessToken'];
    public $timestamps = true;
}
