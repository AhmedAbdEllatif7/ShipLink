@extends('layouts.admin')

@section('title', 'إدارة الأدوار (Roles)')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">الأدوار والصلحيات</h1>
        <p class="text-slate-500">إدارة أدوار المستخدمين وتخصيص الصلاحيات لكل دور.</p>
    </div>
    @can('create roles')
    <a href="{{ route('admin.roles.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        إضافة دور جديد
    </a>
    @endcan
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl mb-6">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl mb-6">
    {{ session('error') }}
</div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-right border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-sm font-bold">
                <th class="px-6 py-4">اسم الدور</th>
                <th class="px-6 py-4">الصلاحيات</th>
                <th class="px-6 py-4">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($roles as $role)
            <tr class="hover:bg-slate-50/50 transition-colors">
                <td class="px-6 py-4">
                    <span class="font-bold text-slate-700">{{ $role->name }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1">
                        @foreach($role->permissions as $permission)
                        <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-semibold">
                            {{ $permission->name }}
                        </span>
                        @endforeach
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        @can('edit roles')
                        @if($role->name !== 'super_admin')
                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="تعديل">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        @endif
                        @endcan

                        @can('delete roles')
                        @if($role->name !== 'super_admin')
                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="حذف">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                        @endif
                        @endcan
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
