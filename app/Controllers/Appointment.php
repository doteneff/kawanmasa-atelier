<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Appointment extends BaseController
{
    protected $appointmentModel;

    public function __construct(){
        $this->appointmentModel = new \App\Models\AppointmentModel();
    }

    public function index()
    {
        $data = $this->getAppointmentList(4);
        return view('appointments/index', [
            'appointments' => $data,
            'pager' => $this->appointmentModel->pager,
            'title' => 'My Appointments - Kawanmasa Atelier'
        ]);
    }

    public function viewReview($appointmentId)
    {
        $appointment = $this->appointmentModel->getReviewById($appointmentId);
        if (!$appointment) {
            return redirect()->to('/appointments')->with('error', 'Appointment not found');
        }

        return view('reviews/view', [
            'appointment' => $appointment,
            'title' => "View Review - Kawanmasa Atelier"
        ]);
    }

    public function writeReview($appointmentId)
    {
        $appointment = $this->appointmentModel->getReviewById($appointmentId);
        if (!$appointment) {
            return redirect()->to('/appointments')->with('error', 'Appointment not found');
        }

        return view('reviews/write', [
            'appointment' => $appointment,
            'title'=> 'Write Review - Kawanmasa Atelier'
        ]);
    }

    public function submitReview($appointmentId)
    {
        $review = $this->request->getPost('review');
        if (empty($review)) {
             return redirect()->back()->with('error', 'Review cannot be empty');
        }

        $appointment = $this->appointmentModel->find($appointmentId);
        if (!$appointment) {
            return redirect()->to('/appointments')->with('error', 'Appointment not found');
        }

        $this->appointmentModel->update($appointmentId, [
            'review' => $review
        ]);

        return redirect()->to('/appointments')->with('success', 'Thank you for your review!');
    }

    public function getAppointmentList($dataPerPage){
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->response->setJSON(['error' => 'User not authenticated'])
                                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $appointments = $this->appointmentModel->getPaginatedAppointmentList($user_id, $dataPerPage);
        
        $result = [];
        $today = date('Y-m-d H:i:s');

        foreach($appointments as $appointment){
            $status = (strtotime($today) > strtotime($appointment['appointment_at'])) ? 'completed' : 'pending'; 
            $has_review = !empty($appointment['review']);

            $result[] = [
                'id' => $appointment['id'],
                'date' => date('Y-m-d', strtotime($appointment['appointment_at'])) ,
                'time' => date('H:i:s', strtotime($appointment['appointment_at'])),
                'status' => $status,
                'has_review' => $has_review
            ];
        }

        return $result;
    }
}
