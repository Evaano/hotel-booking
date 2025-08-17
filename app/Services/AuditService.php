<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuditService
{
    /**
     * Log a user action
     */
    public function logAction(string $action, string $description, array $context = []): void
    {
        $user = Auth::user();

        $logData = [
            'action' => $action,
            'description' => $description,
            'user_id' => $user ? $user->id : null,
            'user_email' => $user ? $user->email : null,
            'user_role' => $user ? $user->role : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'context' => $context,
            'timestamp' => now()->toISOString(),
        ];

        Log::channel('audit')->info('User Action', $logData);
    }

    /**
     * Log a booking creation
     */
    public function logBookingCreation(string $type, Model $booking, array $details = []): void
    {
        $this->logAction(
            'booking_created',
            "{$type} booking created",
            [
                'booking_type' => $type,
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id ?? null,
                'amount' => $booking->total_amount ?? null,
                'details' => $details,
            ]
        );
    }

    /**
     * Log a booking update
     */
    public function logBookingUpdate(string $type, Model $booking, array $changes, array $details = []): void
    {
        $this->logAction(
            'booking_updated',
            "{$type} booking updated",
            [
                'booking_type' => $type,
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id ?? null,
                'changes' => $changes,
                'details' => $details,
            ]
        );
    }

    /**
     * Log a booking cancellation
     */
    public function logBookingCancellation(string $type, Model $booking, ?string $reason = null): void
    {
        $this->logAction(
            'booking_cancelled',
            "{$type} booking cancelled",
            [
                'booking_type' => $type,
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id ?? null,
                'reason' => $reason,
                'amount' => $booking->total_amount ?? null,
            ]
        );
    }

    /**
     * Log a payment action
     */
    public function logPaymentAction(string $action, string $type, Model $booking, array $details = []): void
    {
        $this->logAction(
            "payment_{$action}",
            "Payment {$action} for {$type}",
            [
                'payment_action' => $action,
                'booking_type' => $type,
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id ?? null,
                'amount' => $booking->total_amount ?? null,
                'details' => $details,
            ]
        );
    }

    /**
     * Log a user authentication event
     */
    public function logAuthentication(string $action, array $details = []): void
    {
        $this->logAction(
            "auth_{$action}",
            "User authentication: {$action}",
            array_merge([
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ], $details)
        );
    }

    /**
     * Log a user role change
     */
    public function logRoleChange(int $userId, string $oldRole, string $newRole, ?string $reason = null): void
    {
        $this->logAction(
            'role_changed',
            'User role changed',
            [
                'user_id' => $userId,
                'old_role' => $oldRole,
                'new_role' => $newRole,
                'reason' => $reason,
                'changed_by' => Auth::id(),
            ]
        );
    }

    /**
     * Log a system configuration change
     */
    public function logSystemConfigChange(string $config, $oldValue, $newValue, ?string $reason = null): void
    {
        $this->logAction(
            'system_config_changed',
            'System configuration changed',
            [
                'config_key' => $config,
                'old_value' => $oldValue,
                'new_value' => $newValue,
                'reason' => $reason,
                'changed_by' => Auth::id(),
            ]
        );
    }

    /**
     * Log a data export/import action
     */
    public function logDataAction(string $action, string $type, array $details = []): void
    {
        $this->logAction(
            "data_{$action}",
            "Data {$action}: {$type}",
            array_merge([
                'data_type' => $type,
                'action' => $action,
            ], $details)
        );
    }

    /**
     * Log an error or security incident
     */
    public function logSecurityIncident(string $type, string $description, array $details = []): void
    {
        $this->logAction(
            'security_incident',
            "Security incident: {$type}",
            array_merge([
                'incident_type' => $type,
                'description' => $description,
                'severity' => $details['severity'] ?? 'medium',
            ], $details)
        );

        // Also log to security channel for immediate attention
        Log::channel('security')->warning("Security Incident: {$type}", [
            'description' => $description,
            'details' => $details,
            'user' => Auth::user(),
            'request' => request()->all(),
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Log API access
     */
    public function logApiAccess(string $endpoint, array $requestData = [], array $responseData = []): void
    {
        $this->logAction(
            'api_access',
            "API endpoint accessed: {$endpoint}",
            [
                'endpoint' => $endpoint,
                'request_data' => $this->sanitizeData($requestData),
                'response_data' => $this->sanitizeData($responseData),
                'response_time' => microtime(true) - LARAVEL_START,
            ]
        );
    }

    /**
     * Log file access
     */
    public function logFileAccess(string $action, string $filePath, array $details = []): void
    {
        $this->logAction(
            "file_{$action}",
            "File {$action}: {$filePath}",
            array_merge([
                'file_path' => $filePath,
                'action' => $action,
            ], $details)
        );
    }

    /**
     * Log database operations
     */
    public function logDatabaseOperation(string $operation, string $table, array $details = []): void
    {
        $this->logAction(
            "db_{$operation}",
            "Database {$operation} on {$table}",
            array_merge([
                'operation' => $operation,
                'table' => $table,
            ], $details)
        );
    }

    /**
     * Sanitize sensitive data before logging
     */
    private function sanitizeData(array $data): array
    {
        $sensitiveFields = ['password', 'token', 'secret', 'key', 'credit_card', 'ssn'];

        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '***REDACTED***';
            }
        }

        return $data;
    }

    /**
     * Get audit logs for a specific user
     */
    public function getUserAuditLogs(int $userId, int $limit = 100): array
    {
        // This would typically query a dedicated audit log table
        // For now, we'll return an empty array as this is just a service structure
        return [];
    }

    /**
     * Get audit logs for a specific action type
     */
    public function getActionAuditLogs(string $action, int $limit = 100): array
    {
        // This would typically query a dedicated audit log table
        // For now, we'll return an empty array as this is just a service structure
        return [];
    }

    /**
     * Export audit logs for compliance
     */
    public function exportAuditLogs(string $startDate, string $endDate, array $filters = []): array
    {
        // This would typically query a dedicated audit log table and format for export
        // For now, we'll return an empty array as this is just a service structure
        return [];
    }
}
