<?php

namespace App\Repositories\Dashboard\Notification;

use Illuminate\Pagination\LengthAwarePaginator;

interface NotificationRepositoryInterface
{
    /**
     * Get paginated notifications for the authenticated user.
     */
    public function getUserNotifications(): LengthAwarePaginator;

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(string $id): bool;

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead(): void;

    /**
     * Get the count of unread notifications for the authenticated user.
     */
    public function getUnreadCount(): int;
}
