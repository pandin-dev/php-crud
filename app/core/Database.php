<?php

require_once __DIR__ . '/Logger.php';

class Database
{
    private $pdo;
    private static $instance = null;
    private $logger;

    private function __construct()
    {
        $config = require_once __DIR__ . '/../../config/database.php';
        $this->logger = new Logger();
        
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($params);
        
        // Log da ação no banco de dados
        $action = $this->getActionFromSql($sql);
        $this->logger->logDatabaseAction($action, $sql, $params, $result);
        
        return $result;
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        
        // Log da ação no banco de dados
        $action = $this->getActionFromSql($sql);
        $this->logger->logDatabaseAction($action, $sql, $params, $result);
        
        return $result;
    }

    public function fetch($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        
        // Log da ação no banco de dados
        $action = $this->getActionFromSql($sql);
        $this->logger->logDatabaseAction($action, $sql, $params, $result);
        
        return $result;
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    private function getActionFromSql($sql)
    {
        $sql = trim(strtoupper($sql));
        
        if (strpos($sql, 'SELECT') === 0) {
            return 'SELECT';
        } elseif (strpos($sql, 'INSERT') === 0) {
            return 'INSERT';
        } elseif (strpos($sql, 'UPDATE') === 0) {
            return 'UPDATE';
        } elseif (strpos($sql, 'DELETE') === 0) {
            return 'DELETE';
        } elseif (strpos($sql, 'CREATE') === 0) {
            return 'CREATE';
        } elseif (strpos($sql, 'DROP') === 0) {
            return 'DROP';
        } elseif (strpos($sql, 'ALTER') === 0) {
            return 'ALTER';
        } else {
            return 'OTHER';
        }
    }

    public function getLogs()
    {
        return $this->logger->getLogs();
    }

    public function clearLogs()
    {
        return $this->logger->clearLogs();
    }
}
