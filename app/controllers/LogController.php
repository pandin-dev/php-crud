<?php

require_once __DIR__ . '/../core/Database.php';

class LogController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function index()
    {
        $logs = $this->db->getLogs();
        require_once __DIR__ . '/../views/logs/index.php';
    }

    public function clear()
    {
        $this->db->clearLogs();
        header('Location: /logs');
        exit;
    }

    public function api()
    {
        header('Content-Type: application/json');
        $logs = $this->db->getLogs();
        echo json_encode($logs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
