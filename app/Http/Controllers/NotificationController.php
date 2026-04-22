<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * جلب إشعارات المستخدم الحالي (أحدث 20)
     */
    public function index(): JsonResponse
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'data' => $notification->data,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'created_at_raw' => $notification->created_at->toISOString(),
                ];
            });

        $unreadCount = Auth::user()->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * تعليم إشعار واحد كمقروء
     */
    public function markAsRead(string $id): JsonResponse
    {
        $notification = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if (! $notification) {
            return response()->json(['message' => 'الإشعار غير موجود'], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'message' => 'تم تعليم الإشعار كمقروء',
            'unread_count' => Auth::user()->unreadNotifications()->count(),
        ]);
    }

    /**
     * تعليم جميع الإشعارات كمقروءة
     */
    public function markAllAsRead(): JsonResponse
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json([
            'message' => 'تم تعليم جميع الإشعارات كمقروءة',
            'unread_count' => 0,
        ]);
    }
}
