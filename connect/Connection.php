<?php 
namespace connect\Connection;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;


class Connection extends Capsule
{
    public function __construct()
    {
        parent:: __construct();

        $this->conn();
    }

    private function conn()
    {
        $this->addConnection([
            'driver'    => DRIVER,
            'host'      => DB_HOST,
            'database'  => DB_NAME,
            'username'  => DB_USER,
            'password'  => DB_PASSWORD,
            'charset'   => CHARSET,
            'collation' => COLLATION,
            'prefix'    => PREFIX,
        ]);

        // Carbon::setWeekStartsAt(Carbon::SUNDAY);
        // Carbon::setWeekEndsAt(Carbon::SATURDAY);

        // Set the event dispatcher used by Eloquent models... (optional)

        $this->setEventDispatcher(new Dispatcher(new Container));

        // $capsule->setEventDispatcher( new \Illuminate\Events\Dispatcher( new \Illuminate\Container\Container ));

        // Make this Capsule instance available globally via static methods... (optional)
        $this->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->bootEloquent();
    }
}

new Connection();

