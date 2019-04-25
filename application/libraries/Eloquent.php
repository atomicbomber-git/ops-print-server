<?php

// Loads the Eloquent ORM, depends on the database library. (https://www.cloudways.com/blog/eloquent-illuminate-in-php-without-laravel/)
// Needs to call $this->database->load() first
use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent
{
    public function __construct()
    {
        $capsule = new Capsule();
        
        $capsule->addConnection([
            "driver" => get_instance()->db->dbdriver == "mysqli" ? "mysql" : get_instance()->error(500, "Database driver wrong."),
            "host" => get_instance()->db->hostname,
            "database" => get_instance()->db->database,
            "username" => get_instance()->db->username,
            "password" => get_instance()->db->password,
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}