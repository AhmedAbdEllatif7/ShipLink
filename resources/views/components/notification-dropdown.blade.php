{{-- 
    Notification Dropdown Component
    يُستخدم في جميع الـ Layouts (admin, merchant, driver)
    يعتمد على Alpine.js لإدارة الحالة و fetch للتحديث
    
    Usage: @include('components.notification-dropdown')
    المعاملات: لا يحتاج - يقرأ من الـ API مباشرة
--}}

<div x-data="notificationDropdown()" x-init="fetchNotifications()" class="relative">
    {{-- زر الجرس --}}
    <button 
        @click="toggleDropdown()" 
        id="notification-bell-btn"
        class="relative w-10 h-10 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>

        {{-- بادج عدد الإشعارات غير المقروءة --}}
        <span 
            x-show="unreadCount > 0" 
            x-text="unreadCount > 9 ? '9+' : unreadCount"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform scale-0"
            x-transition:enter-end="transform scale-100"
            class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white shadow-sm"
            style="display: none;"
        ></span>

        {{-- Animation pulse when unread --}}
        <span 
            x-show="unreadCount > 0" 
            class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-red-400 rounded-full animate-ping opacity-30"
            style="display: none;"
        ></span>
    </button>

    {{-- القائمة المنسدلة --}}
    <div 
        x-show="isOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 transform -translate-y-2 scale-95"
        @click.away="isOpen = false"
        class="absolute left-0 mt-2 w-96 bg-white rounded-2xl shadow-2xl border border-slate-100 z-50 overflow-hidden"
        style="display: none;"
    >
        {{-- رأس القائمة --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 bg-gradient-to-l from-slate-50 to-white">
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                الإشعارات
                <span x-show="unreadCount > 0" x-text="'(' + unreadCount + ')'" class="text-xs text-red-500 font-bold" style="display: none;"></span>
            </h3>
            <button 
                x-show="unreadCount > 0"
                @click="markAllAsRead()"
                class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold transition-colors"
                style="display: none;"
            >
                قراءة الكل ✓
            </button>
        </div>

        {{-- محتوى الإشعارات --}}
        <div class="max-h-[400px] overflow-y-auto divide-y divide-slate-50" id="notification-list">
            
            {{-- حالة التحميل --}}
            <div x-show="loading" class="flex items-center justify-center py-12">
                <svg class="animate-spin h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            {{-- حالة فارغة --}}
            <div x-show="!loading && notifications.length === 0" class="flex flex-col items-center justify-center py-12 px-6 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-2.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-slate-500">لا توجد إشعارات</p>
                <p class="text-xs text-slate-400 mt-1">ستظهر الإشعارات الجديدة هنا</p>
            </div>

            {{-- عرض الإشعارات --}}
            <template x-for="notification in notifications" :key="notification.id">
                <div 
                    @click="handleNotificationClick(notification)"
                    :class="{ 
                        'bg-indigo-50/50 border-r-4 border-indigo-400': !notification.read_at,
                        'bg-white hover:bg-slate-50': notification.read_at 
                    }"
                    class="flex items-start gap-3 px-5 py-4 cursor-pointer transition-all duration-200 hover:bg-slate-50 group"
                >
                    {{-- أيقونة الإشعار --}}
                    <div 
                        class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg shadow-sm"
                        :class="{
                            'bg-blue-100': notification.data.color === 'blue',
                            'bg-indigo-100': notification.data.color === 'indigo',
                            'bg-amber-100': notification.data.color === 'amber',
                            'bg-emerald-100': notification.data.color === 'emerald',
                            'bg-slate-100': !notification.data.color
                        }"
                    >
                        <span x-text="notification.data.icon || '🔔'"></span>
                    </div>

                    {{-- محتوى الإشعار --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-700 mb-0.5" x-text="notification.data.title"></p>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-2" x-text="notification.data.message"></p>
                        <p class="text-[10px] text-slate-400 mt-1.5 font-medium" x-text="notification.created_at"></p>
                    </div>

                    {{-- نقطة غير مقروء --}}
                    <div x-show="!notification.read_at" class="flex-shrink-0 mt-2">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full block"></span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    function notificationDropdown() {
        return {
            isOpen: false,
            loading: false,
            notifications: [],
            unreadCount: 0,
            pollInterval: null,

            toggleDropdown() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    this.fetchNotifications();
                }
            },

            async fetchNotifications() {
                this.loading = true;
                try {
                    const response = await fetch('{{ route("notifications.index") }}', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    const data = await response.json();
                    this.notifications = data.notifications;
                    this.unreadCount = data.unread_count;
                } catch (error) {
                    console.error('فشل جلب الإشعارات:', error);
                } finally {
                    this.loading = false;
                }
            },

            async markAsRead(notificationId) {
                try {
                    const response = await fetch(`/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    const data = await response.json();
                    this.unreadCount = data.unread_count;
                    
                    // تحديث حالة الإشعار محلياً
                    const notification = this.notifications.find(n => n.id === notificationId);
                    if (notification) {
                        notification.read_at = new Date().toISOString();
                    }
                } catch (error) {
                    console.error('فشل تعليم الإشعار كمقروء:', error);
                }
            },

            async markAllAsRead() {
                try {
                    await fetch('{{ route("notifications.read-all") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    this.unreadCount = 0;
                    this.notifications.forEach(n => n.read_at = new Date().toISOString());
                } catch (error) {
                    console.error('فشل تعليم الكل كمقروء:', error);
                }
            },

            handleNotificationClick(notification) {
                if (!notification.read_at) {
                    this.markAsRead(notification.id);
                }
                if (notification.data.url && notification.data.url !== '#') {
                    window.location.href = notification.data.url;
                }
            },

            init() {
                // تحديث تلقائي كل 30 ثانية (Polling) - سيتم استبداله بـ Pusher لاحقاً
                this.pollInterval = setInterval(() => {
                    if (!this.isOpen) {
                        this.fetchNotifications();
                    }
                }, 30000);
            },

            destroy() {
                if (this.pollInterval) {
                    clearInterval(this.pollInterval);
                }
            }
        }
    }
</script>
