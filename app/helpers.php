<?php

use App\Models\ActivityLog;

if (!function_exists('activity_log')) {
    /**
     * Record a simplified audit log entry for the currently authenticated user.
     */
    function activity_log(string $action, $subject = null, ?string $description = null): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id,
            'description' => $description,
        ]);
    }
}