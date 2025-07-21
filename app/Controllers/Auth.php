<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;


class Auth extends BaseController
{
    public function login() {
        return view('auth/login');
    }

    public function loginTest() {
        return view('auth/login_test');
    }

    public function loginPost() {
        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");
        
        $userModel = new UserModel();
        $user = $userModel->where("email", $email)->first();
        if ($user && password_verify($password, $user["password"])) {
            session()->set('user_id', $user['id']);
            return redirect()->to('/schedules');
        } else {
            return redirect()->back()->with('error','Invalid credentials');
        }
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}
