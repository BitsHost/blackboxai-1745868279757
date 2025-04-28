<?php
namespace Dashboard;

use Common\Bmvc\BaseModel;

class Model extends BaseModel {
    protected $table = 'dashboard_users';
    
    public function __construct() {
        parent::__construct();
        $this->initializeDatabase();
    }

    private function initializeDatabase() {
        try {
            // Drop existing tables
            $this->db->exec("DROP TABLE IF EXISTS dashboard_users;");
            $this->db->exec("DROP TABLE IF EXISTS dashboard_settings;");
            
            $schema = file_get_contents(__DIR__ . '/sql/schema.sql');
            $statements = array_filter(array_map('trim', explode(';', $schema)));
            
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    $this->db->exec($statement);
                }
            }
        } catch (\PDOException $e) {
            die("Error initializing database: " . $e->getMessage());
        }
    }

    public function createUser($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->create($data);
    }

    public function validateLogin($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getUserByRole($role) {
        return $this->where('role', $role)->get();
    }
}
