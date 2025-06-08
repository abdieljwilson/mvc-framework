<?php

class HomeController extends Controller {
    public function index() {
        $userModel = $this->model('User');
        $users = $userModel->findAll();
        
        $data = [
            'title' => 'Home Page',
            'users' => $users
        ];
        
        $this->view('home/index', $data);
    }
    
    public function about() {
        $data = [
            'title' => 'About Us',
            'content' => 'This is our about page.'
        ];
        
        $this->view('home/about', $data);
    }
}