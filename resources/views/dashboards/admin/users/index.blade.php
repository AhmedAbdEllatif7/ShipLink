@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">إدارة المستخدمين</h1>
        <p class="text-slate-500">إضافة وتعديل بيانات المستخدمين وتعيين الأدوار لهم.</p>
    </div>
    @can('create users')
    <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        إضافة مستخدم جديد
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
                <th class="px-6 py-4">المستخدم</th>
                <th class="px-6 py-4">البريد الإلكتروني</th>
                <th class="px-6 py-4">الأدوار</th>
                <th class="px-6 py-4">تاريخ الانضمام</th>
                <th class="px-6 py-4">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($users as $user)
            <tr class="hover:bg-slate-50/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <span class="font-bold text-slate-700">{{ $user->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1">
                        @foreach($user->roles as $role)
                        <span class="px-2 py-0.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-semibold">
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-500 text-sm">{{ $user->created_at->format('Y/m/d') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        @can('edit users')
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="تعديل">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        @endcan

                        @can('delete users')
                        @if(!$user->hasRole('super_admin'))
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
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

    {{-- Pagination --}}
    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
        {{ $users->links() }}
    </div>
</div>
@endsection
