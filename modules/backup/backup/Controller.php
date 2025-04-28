<?php
namespace Backup;

use Common\Bmvc\BaseController;

class Controller extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->model = new Model();
        $this->view = new View();
        $this->requireAuth(); // Require authentication for all backup operations
    }

    public function index() {
        $backups = $this->model->getAllBackups();
        $this->view->render('backup', [
            'backups' => $backups,
            'message' => $_GET['message'] ?? null
        ]);
    }

    public function create() {
        try {
            $backupPath = $this->model->createBackup();
            $this->redirect('/backup', 'Backup created successfully');
        } catch (\Exception $e) {
            $this->redirect('/backup', 'Error creating backup: ' . $e->getMessage());
        }
    }

    public function download($id) {
        try {
            $backup = $this->model->getBackup($id);
            if (!$backup) {
                throw new \Exception('Backup not found');
            }

            $filePath = $backup['file_path'];
            if (!file_exists($filePath)) {
                throw new \Exception('Backup file not found');
            }

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        } catch (\Exception $e) {
            $this->redirect('/backup', 'Error downloading backup: ' . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $this->model->deleteBackup($id);
            $this->redirect('/backup', 'Backup deleted successfully');
        } catch (\Exception $e) {
            $this->redirect('/backup', 'Error deleting backup: ' . $e->getMessage());
        }
    }
}
