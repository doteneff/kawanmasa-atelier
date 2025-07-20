<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Schedule extends BaseController
{
    protected $scheduleModel;

    public function __construct(){
        $this->scheduleModel = new \App\Models\ScheduleModel();
    }
    
    public function index()
    {
        return view('schedules/index');
    }

    public function getCalendarDateList(){
        $year = $this->request->getGet("year");
        $month = $this->request->getGet("month");

        $schedules = $this->scheduleModel->getBookingStatusPerDate($year, $month);

        $result = [];

        foreach($schedules as $schedule){
            $result[] = [
                'date' => $schedule['schedule_date'],
                'is_available' => $schedule['total_slots'] === 0 ? false : true,
                'total_slots' => $schedule['total_slots']
            ];
        }

        return $this->response->setJSON($result);
    }

    public function getTimeSlot(){
        $date = $this->request->getGet('date');

        $slot = $this->scheduleModel->getTimeSlotByDate($date);
        return $this->response->setJSON($slot);
    }

    public function bookTimeSlot() {
        $userId = session()->get('user_id');
        
        $data = $this->request->getJSON(true); // Accept JSON from Axios

        $scheduleId = (int)($data['schedule_id'] ?? 0);
        $selectedDate = $data['date'] ?? null;
        $selectedSlot = $data['time_slot'] ?? null;
        
        if (!$userId || !$scheduleId || !$selectedDate || !$selectedSlot) {
            return $this->response->setJSON(['error' => 'Invalid or missing input'])
                                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $slot = $this->scheduleModel->getTimeSlotById($scheduleId);
        if (!$slot) {
            return $this->response->setJSON(['error' => 'Invalid schedule ID'])
                                    ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        try {
            $combinedDateTime = new \DateTime($selectedDate . ' ' . $selectedSlot);
            $formattedDateTime = $combinedDateTime->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Invalid date/time format.'])
                                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $success = $this->scheduleModel->bookTimeSlotById($userId, $slot["id"], $formattedDateTime);
        if ($success) {
            return $this->response->setJSON([
                'message' => 'Booking successful.',
                'appointment' => [
                    'date' => $selectedDate,
                    'time_slot' => $selectedSlot,
                ]
            ]);
        } else {
            return $this->response->setJSON(['error' => 'Booking failed.'])
                                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
