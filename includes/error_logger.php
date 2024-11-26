<?php

function logError($message, $file = null, $line = null, $context = []) {
    $logDir = __DIR__ . '/../logs';
    
    // Create logs directory if it doesn't exist
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }
    
    $logFile = $logDir . '/error.log';
    
    // Get current timestamp
    $timestamp = date('Y-m-d H:i:s');
    
    // Format the error message
    $logMessage = "[{$timestamp}] ";
    $logMessage .= $file ? "File: {$file} " : "";
    $logMessage .= $line ? "Line: {$line} " : "";
    $logMessage .= "Message: {$message}";
    
    // Add context if available
    if (!empty($context)) {
        $logMessage .= " Context: " . json_encode($context);
    }
    
    $logMessage .= PHP_EOL;
    
    // Write to log file
    error_log($logMessage, 3, $logFile);
}

// Set custom error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    logError($errstr, $errfile, $errline, ['error_number' => $errno]);
    return true;
});

// Set exception handler
set_exception_handler(function($exception) {
    logError(
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine(),
        ['trace' => $exception->getTraceAsString()]
    );
});
