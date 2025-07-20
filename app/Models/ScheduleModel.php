<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class ScheduleModel extends Model
{
    protected $table            = 'schedules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getBookingStatusPerDate($year, $month)
    {
        return $this->db->table('schedules s')
            ->select('DATE(s.date) as schedule_date')
            ->select('SUM(CASE WHEN s.is_available = 1 THEN 1 ELSE 0 END) as total_slots')
            ->selectCount('a.id', 'booked_count')
            ->join('appointments a', 'a.schedule_id = s.id', 'left')
            ->where('YEAR(s.date)', $year)
            ->where('MONTH(s.date)', $month)
            ->groupBy('DATE(s.date)')
            ->get()
            ->getResultArray();
    }

    public function getTimeSlotByDate($date)
    {
        $dateOnly = date('Y-m-d', strtotime($date));

        return $this->db->table('schedules s')
            ->select('s.id as schedule_id')
            ->select('TIME(s.date) as time_slot')
            ->select('is_available')
            ->where('DATE(s.date) =', $dateOnly)
            ->get()
            ->getResultArray();
    }

    public function getTimeSlotById($scheduleId)
    {
        return $this->db->table('schedules')
            ->where('id', $scheduleId)
            ->get()
            ->getRowArray();
    }

    public function bookTimeSlotById($userId, $scheduleId, $date)
    {
        var_dump($userId, $scheduleId, $date);

        $this->db->transStart();

        $this->db->table('schedules')
            ->where('id', $scheduleId)
            ->update(['is_available' => 0]);

        $this->db->table('appointments')->insert([
                'user_id' => $userId,
                'schedule_id' => $scheduleId,
                'appointment_at' => $date,
                'review' => null,
        ]);
            
        $this->db->transComplete();

        return $this->db->transStatus();
    }
}
