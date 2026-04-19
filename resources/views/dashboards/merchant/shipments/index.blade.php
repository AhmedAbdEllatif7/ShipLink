@extends('layouts.merchant')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">الشحنات</h2>
                    @can('create', App\Models\Shipment::class)
                        <a href="{{ route('merchant.shipments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                            + إنشاء شحنة جديدة
                        </a>
                    @endcan
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    رقم التتبع
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    المستلم
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    المدينة
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    المبلغ (COD)
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    الحالة
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    التاريخ
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    العمليات
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shipments as $shipment)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap font-bold">{{ $shipment->tracking_number }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $shipment->receiver_name }}</p>
                                        <p class="text-gray-600 whitespace-no-wrap text-xs">{{ $shipment->receiver_phone }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $shipment->city }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ number_format($shipment->cod_amount, 2) }} ج.م</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span class="relative inline-block px-3 py-1 font-semibold text-{{ $shipment->status->color() }}-900 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-{{ $shipment->status->color() }}-200 opacity-50 rounded-full"></span>
                                            <span class="relative">{{ $shipment->status->label() }}</span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $shipment->created_at->format('Y-m-d') }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                        <div class="flex items-center justify-end gap-2">
                                            <button onclick="toggleQuickView('{{ $shipment->tracking_number }}', '{{ $shipment->receiver_name }}', '{{ $shipment->receiver_phone }}', '{{ $shipment->receiver_address }}', '{{ $shipment->city }}', '{{ number_format($shipment->cod_amount, 2) }}', '{{ $shipment->status->label() }}')" class="p-1 text-blue-600 hover:text-blue-900" title="عرض السريع">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            
                                            @can('update', $shipment)
                                                <a href="{{ route('merchant.shipments.edit', $shipment->id) }}" class="p-1 text-yellow-600 hover:text-yellow-900" title="تعديل">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                                </a>
                                            @endcan

                                            @can('delete', $shipment)
                                                <button onclick="confirmDelete({{ $shipment->id }}, '{{ $shipment->tracking_number }}')" class="p-1 text-red-600 hover:text-red-900" title="حذف">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center italic text-gray-500">
                                        لا توجد شحنات حالية.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Quick View -->
<div id="quick-view-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleQuickView()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start flex-row-reverse">
                    <div class="mt-3 text-center sm:mt-0 sm:mr-4 sm:text-right w-full">
                        <h3 class="text-xl leading-6 font-bold text-gray-900 border-b pb-3 mb-4" id="qv-tracking-number"></h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between border-b pb-2"><span class="font-semibold">المستلم:</span> <span id="qv-receiver-name"></span></div>
                            <div class="flex justify-between border-b pb-2"><span class="font-semibold">رقم الهاتف:</span> <span id="qv-receiver-phone"></span></div>
                            <div class="flex justify-between border-b pb-2"><span class="font-semibold">المدينة:</span> <span id="qv-city"></span></div>
                            <div class="flex justify-between border-b pb-2"><span class="font-semibold">العنوان:</span> <span id="qv-receiver-address"></span></div>
                            <div class="flex justify-between border-b pb-2"><span class="font-semibold">المبلغ (COD):</span> <span id="qv-cod-amount"></span> ج.م</div>
                            <div class="flex justify-between"><span class="font-semibold">الحالة:</span> <span id="qv-status"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <button type="button" onclick="toggleQuickView()" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Delete Confirmation -->
<div id="delete-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleDeleteModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start flex-row-reverse">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:mr-4 sm:text-right">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">تأكيد حذف الشحنة</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">هل أنت متأكد من حذف الشحنة رقم <span id="del-tracking-number" class="font-bold"></span>؟ هذا الإجراء لا يمكن التراجع عنه.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:w-auto sm:text-sm">حذف نهائياً</button>
                </form>
                <button type="button" onclick="toggleDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">إلغاء</button>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleQuickView(tracking = '', name = '', phone = '', address = '', city = '', amount = '', status = '') {
        const modal = document.getElementById('quick-view-modal');
        if (tracking) {
            document.getElementById('qv-tracking-number').innerText = tracking;
            document.getElementById('qv-receiver-name').innerText = name;
            document.getElementById('qv-receiver-phone').innerText = phone;
            document.getElementById('qv-receiver-address').innerText = address;
            document.getElementById('qv-city').innerText = city;
            document.getElementById('qv-cod-amount').innerText = amount;
            document.getElementById('qv-status').innerText = status;
        }
        modal.classList.toggle('hidden');
    }

    function confirmDelete(id, tracking) {
        document.getElementById('del-tracking-number').innerText = tracking;
        document.getElementById('delete-form').action = `/merchant/shipments/${id}`;
        toggleDeleteModal();
    }

    function toggleDeleteModal() {
        document.getElementById('delete-modal').classList.toggle('hidden');
    }
</script>
@endsection
