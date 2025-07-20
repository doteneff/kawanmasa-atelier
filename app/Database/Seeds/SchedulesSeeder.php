<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use DateInterval;
use DateTime;
use DateTimeZone;

class SchedulesSeeder extends Seeder
{
    public function run()
    {
        $schedulesCount = $this->db->table("schedules")->countAll();
        
        if ($schedulesCount===0) {
            $days = 30;
            $slotPerDay = 9; // 8 in actual but we will skip 12:00 cause of lunch
            $baseDate = new DateTime("tomorrow 08:00:00", new DateTimeZone("Etc/UTC"));
            
            $data = [];
            
            for ($d = 0; $d < $days; $d++) {
                $dayStart = clone $baseDate;
                $dayStart->modify("+$d days");
    
                for ($j = 0; $j < $slotPerDay; $j++) {
                    $slotTime = clone $dayStart;
                    $slotTime->add(new DateInterval("PT{$j}H"));
                    if ($slotTime->format("H:i")==="12:00") {
                        continue;
                    }
                    $data[] = [
                        "date"=> $slotTime->format("Y-m-d H:i:s"),
                        "is_available"=> true,
                    ];
                }
            }
    
            $this->db->table("schedules")->insertBatch($data);

            echo"Successfully seed schedules data!";
        }
    }
}
