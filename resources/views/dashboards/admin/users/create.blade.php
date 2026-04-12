@extends('layouts.admin')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center gap-2 mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7"></path></svg>
        العودة للمستخدمين
    </a>
    <h1 class="text-2xl font-bold text-slate-800">إضافة مستخدم جديد</h1>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">الاسم بالكامل</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" value="{{ old('name') }}" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" value="{{ old('email') }}" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-slate-700 mb-2">كلمة المرور</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" required>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" required>
            </div>

            <div>
                <label for="phone" class="block text-sm font-bold text-slate-700 mb-2">رقم الهاتف</label>
                <input type="text" name="phone" id="phone" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" value="{{ old('phone') }}" required>
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="type" class="block text-sm font-bold text-slate-700 mb-2">نوع المستخدم</label>
                <select name="type" id="type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" required>
                    <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>مدير (Admin)</option>
                    <option value="merchant" {{ old('type') == 'merchant' ? 'selected' : '' }}>تاجر (Merchant)</option>
                    <option value="driver" {{ old('type') == 'driver' ? 'selected' : '' }}>سائق/مندوب (Driver)</option>
                </select>
                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-8">
            <label for="address" class="block text-sm font-bold text-slate-700 mb-2">العنوان الكامل</label>
            <textarea name="address" id="address" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition-all" required placeholder="مثلاً: مصر، القاهرة، التجمع الخامس...">{{ old('address') }}</textarea>
            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-100">
            <h3 class="text-sm font-bold text-slate-700 mb-4">تعيين الأدوار (Roles)</h3>
            <div class="flex flex-wrap gap-4">
                @foreach($roles as $role)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                    <span class="text-slate-700">{{ $role->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-slate-100">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold transition-colors">
                إنشاء المستخدم
            </button>
        </div>
    </form>
</div>
@endsection
