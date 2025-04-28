<?php
namespace Dashboard;

use Common\Bmvc\BaseController;

class Controller extends BaseController {
    protected $model;
    protected $view;

    public function __construct() {
        parent::__construct();
        $this->model = new Model();
        $this->view = new View();
    }

    public function index() {
        if (!$this->isAuthenticated()) {
            header('Location: /dashboard/login');
            exit;
        }
        $this->view->render('dashboard', [
            'title' => 'Dashboard',
            'user' => $_SESSION['user'] ?? null
        ]);
    }

    public function login() {
        if ($this->isAuthenticated()) {
            header('Location: /dashboard');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = $this->model->validateLogin($email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['authenticated'] = true;
                header('Location: /dashboard');
                exit;
            }
            
            $this->view->render('login', [
                'error' => 'Invalid credentials',
                'email' => $email
            ]);
            return;
        }
        
        $this->view->render('login', [
            'title' => 'Login'
        ]);
    }

    public function logout() {
        session_destroy();
        header('Location: /dashboard/login');
        exit;
    }

    public function users() {
        if (!$this->isAuthenticated() || !$this->isAdmin()) {
            header('Location: /dashboard/login');
            exit;
        }
        
        $users = $this->model->all();
        $this->view->render('users', [
            'title' => 'User Management',
            'users' => $users
        ]);
    }

    private function isAuthenticated() {
        return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
    }

    private function isAdmin() {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
    }
}
