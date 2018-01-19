<?php

namespace App;

class Consumers extends \Jenssegers\Mongodb\Eloquent\Model {

    protected $connection = 'mongodb';
    protected $collection = 'consumers';
}


?>