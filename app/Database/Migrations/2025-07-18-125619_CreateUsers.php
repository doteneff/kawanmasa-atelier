<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField( [
            "id"=> [
                "type"=> "INT",
                "constraint"=> 11,
                "unsigned"=> true,
                "auto_increment"=> true
                ],
            "name"=> [
                "type"=> "VARCHAR",
                "constraint"=> 30
            ],
            "email"=> [
                "type"=> "VARCHAR",
                "constraint"=> 50
            ],
            "password"=> [
                "type"=> "VARCHAR",
                "constraint"=> 50,
            ]
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("users");


    }

    public function down()
    {
        $this->forge->dropTable("users");
    }
}
