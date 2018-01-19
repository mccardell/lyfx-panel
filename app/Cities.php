<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cities extends Authenticatable
{
    protected $table = 'cities';
}


?>