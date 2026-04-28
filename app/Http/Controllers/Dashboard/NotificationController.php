<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Repositories\Dashboard\Notification\NotificationRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationRepositoryInterface $notificationRepository
    ) {}

    /**
     * جلب إشعارات المستخدم الحالي (مع Pagination)
     */
    public function index(Request $request): JsonResponse
    {
        $notifications = $this->notificationRepository->getUserNotifications();
        $unreadCount = $this->notificationRepository->getUnreadCount();

        return response()->json([
            'notifications' => NotificationResource::collection($notifications),
            'has_more' => $notifications->hasMorePages(),
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * تعليم إشعار واحد كمقروء
     */
    public function markAsRead(string $id): JsonResponse
    {
        $updated = $this->notificationRepository->markAsRead($id);

        if (!$updated) {
            return response()->json(['message' => 'الإشعار غير موجود'], 404);
        }

        return response()->json([
            'message' => 'تم تعليم الإشعار كمقروء',
            'unread_count' => $this->notificationRepository->getUnreadCount(),
        ]);
    }

    /**
     * تعليم جميع الإشعارات كمقروءة
     */
    public function markAllAsRead(): JsonResponse
    {
        $this->notificationRepository->markAllAsRead();

        return response()->json([
            'message' => 'تم تعليم جميع الإشعارات كمقروءة',
            'unread_count' => 0,
        ]);
    }
}
