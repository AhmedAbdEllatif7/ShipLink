@extends('layouts.admin')

@section('title', 'تعديل الدور: ' . $role->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.roles.index') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center gap-2 mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7"></path></svg>
        العودة للأدوار
    </a>
    <h1 class="text-2xl font-bold text-slate-800">تعديل الدور: {{ $role->name }}</h1>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-8">
            <label for="name" class="block text-sm font-bold text-slate-700 mb-2">اسم الدور</label>
            <input type="text" name="name" id="name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all" value="{{ old('name', $role->name) }}" required @if($role->name === 'admin') readonly @endif>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @if($role->name === 'admin')
                <p class="text-slate-400 text-xs mt-1">لا يمكن تغيير اسم هذا الدور لأنه دور نظام أساسي.</p>
            @endif
        </div>

        <div class="mb-8">
            <h3 class="text-sm font-bold text-slate-700 mb-4">تخصيص الصلاحيات</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($permissions as $permission)
                <label class="flex items-center gap-3 p-4 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                    <span class="text-slate-700 font-medium">{{ $permission->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-slate-100">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold transition-colors">
                تحديث الدور
            </button>
        </div>
    </form>
</div>
@endsection
