<?php

namespace App;

class newsletter extends \Jenssegers\Mongodb\Eloquent\Model {

    protected $connection = 'mongodb';
    protected $collection = 'newsletter';
}


?>