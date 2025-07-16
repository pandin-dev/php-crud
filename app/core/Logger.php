<?php

class Logger
{
    private $logFile;
    private $maxLogs = 2; // Máximo de 2 logs (duas últimas alterações)

    public function __construct()
    {
        $this->logFile = __DIR__ . '/../../logs/database_actions.json';
        $this->ensureLogFileExists();
    }

    private function ensureLogFileExists()
    {
        if (!file_exists($this->logFile)) {
            $this->saveLogsToFile([]);
        }
    }

    public function logDatabaseAction($action, $sql, $params = [], $result = null)
    {
        // Filtrar apenas operações CUD (Create, Update, Delete)
        if (!$this->isCUDOperation($action)) {
            return; // Não registra operações de leitura (SELECT)
        }

        $logs = $this->getExistingLogs();
        
        $logEntry = [
            'id' => uniqid(),
            'timestamp' => date('Y-m-d H:i:s'),
            'action' => $action,
            'sql' => $sql,
            'parameters' => $params,
            'result' => $this->formatResult($result),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ];

        // Adiciona o novo log no início do array
        array_unshift($logs, $logEntry);

        // Mantém apenas os últimos N logs
        $logs = array_slice($logs, 0, $this->maxLogs);

        $this->saveLogsToFile($logs);
    }

    private function isCUDOperation($action)
    {
        // Retorna true apenas para operações de escrita/modificação
        $cudOperations = ['INSERT', 'UPDATE', 'DELETE', 'CREATE', 'DROP', 'ALTER'];
        return in_array($action, $cudOperations);
    }

    private function getExistingLogs()
    {
        if (!file_exists($this->logFile)) {
            return [];
        }

        $content = file_get_contents($this->logFile);
        $logs = json_decode($content, true);

        return is_array($logs) ? $logs : [];
    }

    private function saveLogsToFile($logs)
    {
        $jsonContent = json_encode($logs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->logFile, $jsonContent);
    }

    private function formatResult($result)
    {
        if (is_bool($result)) {
            return $result ? 'success' : 'failure';
        }

        if (is_array($result)) {
            return count($result) . ' rows affected/returned';
        }

        if (is_object($result)) {
            return 'object returned';
        }

        return $result;
    }

    public function getLogs()
    {
        return $this->getExistingLogs();
    }

    public function clearLogs()
    {
        $this->saveLogsToFile([]);
    }

    public function getLogFile()
    {
        return $this->logFile;
    }
}
