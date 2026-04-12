@extends('layouts.merchant')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-6 border-b pb-4">إنشاء شحنة جديدة</h2>

                <form action="{{ route('merchant.shipments.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Receiver Name -->
                        <div class="md:col-span-2">
                            <label for="receiver_name" class="block text-sm font-medium text-gray-700 mb-1">اسم المستلم</label>
                            <input type="text" name="receiver_name" id="receiver_name" value="{{ old('receiver_name') }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('receiver_name') border-red-500 @enderror" required>
                            @error('receiver_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Receiver Phone -->
                        <div>
                            <label for="receiver_phone" class="block text-sm font-medium text-gray-700 mb-1">رقم هاتف المستلم</label>
                            <input type="text" name="receiver_phone" id="receiver_phone" value="{{ old('receiver_phone') }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('receiver_phone') border-red-500 @enderror" required>
                            @error('receiver_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">المدينة</label>
                            <select name="city" id="city" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('city') border-red-500 @enderror" required>
                                <option value="">اختر المدينة</option>
                                <option value="القاهرة" {{ old('city') == 'القاهرة' ? 'selected' : '' }}>القاهرة</option>
                                <option value="الجيزة" {{ old('city') == 'الجيزة' ? 'selected' : '' }}>الجيزة</option>
                                <option value="الإسكندرية" {{ old('city') == 'الإسكندرية' ? 'selected' : '' }}>الإسكندرية</option>
                                <option value="المنصورة" {{ old('city') == 'المنصورة' ? 'selected' : '' }}>المنصورة</option>
                                <option value="طنطا" {{ old('city') == 'طنطا' ? 'selected' : '' }}>طنطا</option>
                            </select>
                            @error('city')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Receiver Address -->
                        <div class="md:col-span-2">
                            <label for="receiver_address" class="block text-sm font-medium text-gray-700 mb-1">العنوان بالتفصيل</label>
                            <textarea name="receiver_address" id="receiver_address" rows="3" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('receiver_address') border-red-500 @enderror" required>{{ old('receiver_address') }}</textarea>
                            @error('receiver_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- COD Amount -->
                        <div>
                            <label for="cod_amount" class="block text-sm font-medium text-gray-700 mb-1">مبلغ التحصيل (COD)</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <input type="number" name="cod_amount" id="cod_amount" step="0.01" value="{{ old('cod_amount', 0) }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('cod_amount') border-red-500 @enderror" required>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">ج.م</span>
                                </div>
                            </div>
                            @error('cod_amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('merchant.shipments.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded transition duration-200">
                            إلغاء
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-10 rounded shadow-lg transition duration-200">
                            حفظ الشحنة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
