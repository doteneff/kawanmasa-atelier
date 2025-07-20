<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSchedules extends Migration
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
            "date"=> [
                "type"=> "DATETIME",
            ],
            "is_available"=> [
                "type"=> "BOOLEAN",
            ]
        ]);
        $this->forge->addKey("id", true);
        $this->forge->createTable("schedules");
            
    }

    public function down()
    {
        $this->forge->dropTable("schedules");
    }
}
