@extends('layouts.admin')

@section('title', 'تعديل بيانات المستخدم')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center gap-2 mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7"></path></svg>
        العودة للمستخدمين
    </a>
    <h1 class="text-2xl font-bold text-slate-800">تعديل بيانات: {{ $user->name }}</h1>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">الاسم بالكامل</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" value="{{ old('name', $user->name) }}" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" value="{{ old('email', $user->email) }}" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-slate-700 mb-2">كلمة المرور (اتركها فارغة للتجاهل)</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all">
            </div>

            <div>
                <label for="phone" class="block text-sm font-bold text-slate-700 mb-2">رقم الهاتف</label>
                <input type="text" name="phone" id="phone" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" value="{{ old('phone', $user->phone) }}" required>
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="type" class="block text-sm font-bold text-slate-700 mb-2">نوع المستخدم</label>
                <select name="type" id="type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all {{ $user->hasRole('super_admin') ? 'bg-slate-50 cursor-not-allowed opacity-75' : '' }}" required {{ $user->hasRole('super_admin') ? 'disabled' : '' }} onchange="toggleProfileFields(this.value)">
                    <option value="admin" {{ old('type', $user->type->value) == 'admin' ? 'selected' : '' }}>مدير (Admin)</option>
                    <option value="merchant" {{ old('type', $user->type->value) == 'merchant' ? 'selected' : '' }}>تاجر (Merchant)</option>
                    <option value="driver" {{ old('type', $user->type->value) == 'driver' ? 'selected' : '' }}>سائق/مندوب (Driver)</option>
                </select>
                @if($user->hasRole('super_admin'))
                    <input type="hidden" name="type" value="{{ $user->type->value }}">
                @endif
                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Merchant Fields -->
        <div id="merchant_fields" class="mb-8 p-6 bg-indigo-50/50 rounded-2xl border border-indigo-100 hidden">
            <h3 class="text-sm font-bold text-indigo-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                بيانات التاجر
            </h3>
            <div>
                <label for="company_name" class="block text-sm font-bold text-slate-700 mb-2">اسم الشركة / المتجر</label>
                <input type="text" name="company_name" id="company_name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all bg-white" value="{{ old('company_name', $user->merchant->company_name ?? '') }}" placeholder="مثلاً: شركة شيب لينك">
                @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Driver Fields -->
        <div id="driver_fields" class="mb-8 p-6 bg-amber-50/50 rounded-2xl border border-amber-100 hidden">
            <h3 class="text-sm font-bold text-amber-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                بيانات السائق
            </h3>
            <div>
                <label for="vehicle_type" class="block text-sm font-bold text-slate-700 mb-2">نوع المركبة</label>
                <select name="vehicle_type" id="vehicle_type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all bg-white">
                    <option value="motorcycle" {{ old('vehicle_type', $user->driver->vehicle_type ?? '') == 'motorcycle' ? 'selected' : '' }}>دراجة نارية (Motorcycle)</option>
                    <option value="car" {{ old('vehicle_type', $user->driver->vehicle_type ?? '') == 'car' ? 'selected' : '' }}>سيارة ملاكي (Car)</option>
                    <option value="van" {{ old('vehicle_type', $user->driver->vehicle_type ?? '') == 'van' ? 'selected' : '' }}>سيارة فان (Van)</option>
                    <option value="truck" {{ old('vehicle_type', $user->driver->vehicle_type ?? '') == 'truck' ? 'selected' : '' }}>شاحنة (Truck)</option>
                </select>
                @error('vehicle_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-8">
            <label for="address" class="block text-sm font-bold text-slate-700 mb-2">العنوان الكامل</label>
            <textarea name="address" id="address" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" required placeholder="مثلاً: مصر، القاهرة، التجمع الخامس...">{{ old('address', $user->address) }}</textarea>
            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-100">
            <h3 class="text-sm font-bold text-slate-700 mb-4">تعديل الأدوار (Roles)</h3>
            <div class="flex flex-wrap gap-4">
                @foreach($roles as $role)
                <label class="flex items-center gap-2 {{ $user->hasRole('super_admin') ? 'cursor-not-allowed opacity-75' : 'cursor-pointer' }}">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500" {{ $user->hasRole($role->name) ? 'checked' : '' }} {{ $user->hasRole('super_admin') ? 'disabled' : '' }}>
                    <span class="text-slate-700">{{ $role->name }}</span>
                    @if($user->hasRole('super_admin') && $user->hasRole($role->name))
                        <input type="hidden" name="roles[]" value="{{ $role->name }}">
                    @endif
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-slate-100">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg shadow-indigo-200 hover:scale-[1.02] transform">
                تحديث البيانات
            </button>
        </div>
    </form>
</div>

<script>
    function toggleProfileFields(type) {
        const merchantFields = document.getElementById('merchant_fields');
        const driverFields = document.getElementById('driver_fields');
        
        merchantFields.classList.add('hidden');
        driverFields.classList.add('hidden');
        
        if (type === 'merchant') {
            merchantFields.classList.remove('hidden');
        } else if (type === 'driver') {
            driverFields.classList.remove('hidden');
        }
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        toggleProfileFields(document.getElementById('type').value);
    });
</script>
@endsection
