<?php

class UserController extends Controller {
    public function index() {
        $userModel = $this->model('User');
        $users = $userModel->findAll();
        
        $this->view('users/index', ['users' => $users]);
    }
    
    public function show($id) {
        $userModel = $this->model('User');
        $user = $userModel->findById($id);
        
        if (!$user) {
            $this->redirect('/user');
        }
        
        $this->view('users/show', ['user' => $user]);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->model('User');
            
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];
            
            if ($userModel->create($data)) {
                $this->redirect('/user');
            } else {
                $this->view('users/create', ['error' => 'Failed to create user']);
            }
        } else {
            $this->view('users/create');
        }
    }
    
    public function edit($id) {
        $userModel = $this->model('User');
        $user = $userModel->findById($id);
        
        if (!$user) {
            $this->redirect('/user');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];
            
            if ($userModel->update($id, $data)) {
                $this->redirect('/user');
            } else {
                $this->view('users/edit', ['user' => $user, 'error' => 'Failed to update user']);
            }
        } else {
            $this->view('users/edit', ['user' => $user]);
        }
    }
    
    public function delete($id) {
        $userModel = $this->model('User');
        
        if ($userModel->delete($id)) {
            $this->redirect('/user');
        } else {
            $this->redirect('/user?error=delete_failed');
        }
    }
}
