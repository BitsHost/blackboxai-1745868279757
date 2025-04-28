<?php
namespace Dashboard\Routes;

class Routes {
    public static function getRoutes() {
        return [
            // Dashboard routes
            '/dashboard' => [
                'controller' => 'Dashboard\Controller',
                'action' => 'index',
                'method' => 'GET'
            ],
            '/dashboard/login' => [
                'controller' => 'Dashboard\Controller',
                'action' => 'login',
                'method' => ['GET', 'POST']
            ],
            '/dashboard/logout' => [
                'controller' => 'Dashboard\Controller',
                'action' => 'logout',
                'method' => 'GET'
            ],
            '/dashboard/users' => [
                'controller' => 'Dashboard\Controller',
                'action' => 'users',
                'method' => 'GET'
            ],
            '/dashboard/users/add' => [
                'controller' => 'Dashboard\Controller',
                'action' => 'addUser',
                'method' => 'POST'
            ],
            '/dashboard/users/edit' => [
                'controller' => 'Dashboard\Controller',
                'action' => 'editUser',
                'method' => 'POST'
            ],
            '/dashboard/users/delete/{id}' => [
                'controller' => 'Dashboard\Controller',
                'action' => 'deleteUser',
                'method' => 'GET',
                'params' => ['id']
            ],
            '/dashboard/settings' => [
                'controller' => 'Dashboard\Controller',
                'action' => 'settings',
                'method' => 'GET'
            ]
        ];
    }
}
