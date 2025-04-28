<?php
namespace Backup;

use Common\Bmvc\BaseModel;

class Model extends BaseModel {
    private $backupDir = 'data/backups';

    public function __construct() {
        parent::__construct();
        if (!file_exists($this->backupDir)) {
            mkdir($this->backupDir, 0777, true);
        }
    }

    public function getAllBackups() {
        $query = "SELECT * FROM backups ORDER BY created_at DESC";
        return $this->db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBackup($id) {
        $query = "SELECT * FROM backups WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createBackup() {
        $timestamp = date('Y-m-d_H-i-s');
        $backupName = "backup_{$timestamp}.zip";
        $backupPath = $this->backupDir . '/' . $backupName;

        // Create ZIP archive
        $zip = new \ZipArchive();
        if ($zip->open($backupPath, \ZipArchive::CREATE) !== TRUE) {
            throw new \Exception("Cannot create zip file");
        }

        // Add files to ZIP
        $this->addFolderToZip(dirname(__DIR__), $zip);
        $zip->close();

        // Save backup record to database
        $query = "INSERT INTO backups (filename, file_path, created_at) VALUES (?, ?, datetime('now'))";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$backupName, $backupPath]);

        return $backupPath;
    }

    public function deleteBackup($id) {
        $backup = $this->getBackup($id);
        if (!$backup) {
            throw new \Exception('Backup not found');
        }

        // Delete physical file
        if (file_exists($backup['file_path'])) {
            unlink($backup['file_path']);
        }

        // Delete database record
        $query = "DELETE FROM backups WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }

    private function addFolderToZip($folder, $zip, $subfolder = '') {
        $handle = opendir($folder);
        while (false !== ($entry = readdir($handle))) {
            if ($entry == '.' || $entry == '..' || $entry == $this->backupDir) {
                continue;
            }

            $path = $folder . '/' . $entry;
            $zipPath = $subfolder . ($subfolder ? '/' : '') . $entry;

            if (is_file($path)) {
                $zip->addFile($path, $zipPath);
            } elseif (is_dir($path)) {
                $zip->addEmptyDir($zipPath);
                $this->addFolderToZip($path, $zip, $zipPath);
            }
        }
        closedir($handle);
    }
}
