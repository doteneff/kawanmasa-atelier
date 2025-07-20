<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=> [
                "type"=> "INT",
                "constraint"=> 11,
                "unsigned"=> true,
                "auto_increment"=> true,
            ],
            "user_id"=>[
                "type"=> "INT",
                "constraint"=> 11,
                "unsigned"=>true,
            ],
            "schedule_id"=>[
                "type"=> "INT",
                "constraint"=> 11,
                "unsigned"=>true,
            ],
            "appointment_at"=> [
                "type"=> "DATETIME",
            ],
            "review"=> [
                "type"=> "VARCHAR",
                "constraint"=> 300,
                "null"=> true,
            ]
        ]);
        $this->forge->addForeignKey("user_id","users","id","","CASCADE","fk_user_id");
        $this->forge->addForeignKey("schedule_id","schedules","id","","CASCADE","fk_schedule_id");
        $this->forge->addKey("id", true);
        $this->forge->createTable("appointments");
    }

    public function down()
    {
        $this->forge->dropTable("appointments");
    }
}
