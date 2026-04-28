<?php

namespace App\Repositories\Dashboard\Notification;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * Get paginated notifications for the authenticated user.
     */
    public function getUserNotifications(): Paginator
    {
        return Auth::user()
            ->notifications()
            ->latest()
            ->simplePaginate(config('shiplink.pagination_limit', 10));
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(string $id): bool
    {
        $notification = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            return true;
        }

        return false;
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    /**
     * Get the count of unread notifications for the authenticated user.
     */
    public function getUnreadCount(): int
    {
        return Auth::user()->unreadNotifications()->count();
    }
}
