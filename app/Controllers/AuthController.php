<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    public function register()
    {
        helper(['form']);
        $data = [];

        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post') {
            $rules = [
                'nom' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]'
            ];

            if ($this->validate($rules)) {
                $userModel = new UserModel();
                $newData = [
                    'nom' => $this->request->getPost('nom'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'role' => 'client' // Rôle par défaut
                ];
                $userModel->save($newData);
                $session = session();
                $session->setFlashdata('success', 'Inscription réussie. Vous pouvez vous connecter.');
                return redirect()->to('/connexion');
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('auth/register', $data);
    }

    public function login()
    {
        helper(['form']);
        $data = [];

        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post') {
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required'
            ];

            if ($this->validate($rules)) {
                $userModel = new UserModel();
                $user = $userModel->where('email', $this->request->getPost('email'))->first();

                if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
                    $session = session();
                    $ses_data = [
                        'id' => $user['id'],
                        'nom' => $user['nom'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'isLoggedIn' => TRUE
                    ];
                    $session->set($ses_data);

                    if ($user['role'] === 'admin') {
                        return redirect()->to('/admin/dashboard');
                    } else {
                        return redirect()->to('/client/dashboard');
                    }
                } else {
                    $session = session();
                    $session->setFlashdata('error', 'Email ou mot de passe incorrect.');
                    return redirect()->to('/connexion');
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('auth/login', $data);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/connexion');
    }
}