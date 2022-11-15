<?php

require '../vendor/autoload.php';

require_once '../connect/Connection.php';

use Illuminate\Database\Capsule\Manager as Capsule;
class Migrate extends Capsule
{
    public function __construct()
    {
        parent:: __construct();

        $this->run();
    }

    private function run()
    {
        /**
         * Users Tables by migration
        */
        if (!Capsule::schema()->hasTable('users'))
        {
            /** CREATE USERS TABLE */
            Capsule::schema()->create('users', function ($table) {
                $table->increments('id');
                $table->string('fname')->nullable();
                $table->string('lname')->nullable();
                $table->string('mname')->nullable();
                $table->string('gender')->nullable();
                $table->string('dob')->nullable();
                $table->string('email')->unique()->nullable();
                $table->string('telephone')->unique()->nullable();
                $table->string('maritalStatus')->nullable();
                $table->string('location')->nullable();
                $table->string('gpostcode')->nullable();
                $table->string('education')->nullable();
                $table->string('employment')->nullable();
                $table->string('jobs')->nullable();
                $table->string('age')->nullable();
                $table->string('worships')->nullable();
                $table->string('filename')->nullable();
                $table->timestamps();
            });
        }
       
        /**
         * Login Tables by migration
        */

        if(!Capsule::schema()->hasTable('logins'))
        {
            Capsule::schema()->create('logins', function ($table) {
                $table->increments('id');
                $table->string('email')->unique()->nullable();
                $table->string('password')->nullable();
                $table->string('telephone')->nullable()->unique();
                $table->string('userId')->nullable();
                $table->string('Ipaddress')->nullable();
                $table->string('permission')->nullable();
                $table->string('token')->nullable();
                $table->integer('status')->default('0');
                $table->integer('deleted')->default('0');
                $table->string('logcount')->nullable();
                $table->string('flags')->nullable();
                $table->string('chuechType')->default('headoffice');
                $table->timestamps();
            });
        }

        /**
         * Registration Tables by migration
        */

        if(!Capsule::schema()->hasTable('churchs'))
        {
            Capsule::schema()->create('churchs', function ($table) {
                $table->increments('id');
                $table->string('churchName')->nullable();
                $table->string('email')->unique()->nullable();
                $table->string('telephone')->nullable()->unique();
                $table->string('churchLocation')->nullable();
                $table->string('postCode')->nullable();
                $table->string('churchAddress')->nullable();
                $table->string('father')->nullable();
                $table->string('churchId')->nullable()->uniqid();
                $table->string('createdBy')->nullable();
                $table->integer('deleted')->default('0');
                $table->timestamps();
            });
        }

        /**
         * Activities Tables by migration
        */

        if(!Capsule::schema()->hasTable('activities'))
        {
            Capsule::schema()->create('activities', function ($table) {
                $table->increments('id');
                $table->string('activityname')->nullable();
                $table->string('activitypurpose')->nullable();
                $table->string('startdate')->unique();
                $table->string('startime')->nullable();
                $table->string('activityvenue')->nullable();
                $table->string('activityimage')->nullable();
                $table->string('activitydescription')->nullable();
                $table->string('activityId')->nullable()->uniqid();
                $table->string('createdBy')->nullable();
                $table->integer('deleted')->default('0');
                $table->timestamps();
            });
        }

        /**
         * Repositories Tables by migration
        */

        if(!Capsule::schema()->hasTable('repositories'))
        {
            Capsule::schema()->create('repositories', function ($table) {
                $table->increments('id');
                $table->string('fileType')->nullable();
                $table->string('fileName')->nullable();
                $table->string('attachment')->unique();
                $table->string('attachId')->nullable()->uniqid();
                $table->string('createdBy')->nullable();
                $table->integer('deleted')->default('0');
                $table->timestamps();
            });
        }  


        /**
         * Notifications Tables by migration
        */

        if(!Capsule::schema()->hasTable('notifications'))
        {
            Capsule::schema()->create('notifications', function ($table) {
                $table->increments('id');
                $table->string('noteTitle')->nullable();
                $table->string('startdate')->nullable();
                $table->string('enddate')->nullable();
                $table->string('location')->nullable();
                $table->string('description')->nullable();
                $table->string('createdBy')->nullable();
                $table->integer('deleted')->default('0');
                $table->timestamps();
            });
        }  


        /**
         * Agendas Tables by migration
        */

        if(!Capsule::schema()->hasTable('agendas'))
        {
            Capsule::schema()->create('agendas', function ($table) {
                $table->increments('id');
                $table->string('agendaTitle')->nullable();
                $table->string('startdate')->nullable();
                $table->string('startTime')->nullable();
                $table->string('description')->nullable();
                $table->string('createdBy')->nullable();
                $table->integer('deleted')->default('0');
                $table->timestamps();
            });
        } 
        
        
        /**
         * Educations Tables by migration
        */
        
        if(!Capsule::schema()->hasTable('educations'))
        {
            Capsule::schema()->create('educations', function ($table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->integer('deleted')->default('0');
                $table->timestamps();
            });
        }  

        /**
         * membercontrols Tables by migration
        */

        if(!Capsule::schema()->hasTable('membercontrols'))
        {
            Capsule::schema()->create('membercontrols', function ($table) {
                $table->increments('id');
                $table->string('profile')->nullable();
                $table->integer('marriage')->nullable();
                $table->integer('parent')->nullable();
                $table->integer('baptism')->nullable();
                $table->timestamps();
            });
        }  
        
    }    
}

new Migrate();
