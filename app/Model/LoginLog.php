<?php

namespace App\Model;

class LoginLog extends CommonModel
{
    protected $table = 'admin_login_log';
    public $_relation=['user'];
    public function user()
    {
        return $this->belongsTo('App\Model\User','uid','id');
    }
}
