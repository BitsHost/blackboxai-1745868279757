<?php
namespace Backup\Routes;

class Routes {
    public static function getRoutes() {
        return [
            '/backup' => [
                'controller' => 'Backup\Controller',
                'action' => 'index',
                'method' => 'GET'
            ],
            '/backup/create' => [
                'controller' => 'Backup\Controller',
                'action' => 'create',
                'method' => 'POST'
            ],
            '/backup/download/{id}' => [
                'controller' => 'Backup\Controller',
                'action' => 'download',
                'method' => 'GET',
                'params' => ['id']
            ],
            '/backup/delete/{id}' => [
                'controller' => 'Backup\Controller',
                'action' => 'delete',
                'method' => 'GET',
                'params' => ['id']
            ]
        ];
    }
}
