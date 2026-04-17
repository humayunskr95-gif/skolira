<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'app_name',
        'logo',
        'default_role',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'sms_api_key',
        'sms_sender',
    ];
}