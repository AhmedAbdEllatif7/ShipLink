@extends('layouts.admin')

@section('title', 'إدارة الصلاحيات (Permissions)')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">الصلاحيات المتاحة</h1>
        <p class="text-slate-500">عرض وإدارة جميع الصلاحيات المسجلة في النظام.</p>
    </div>
    <div class="bg-indigo-50 border border-indigo-100 text-indigo-600 px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        هذه الصلاحيات هي "قواعد عمل ثابتة" (Core Logic) يتم إدارتها برمجياً فقط.
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-right border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-sm font-bold">
                <th class="px-6 py-4 uppercase">اسم الصلاحية التقني</th>
                <th class="px-6 py-4">الحالة</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($permissions as $permission)
            <tr class="hover:bg-slate-50/50 transition-colors">
                <td class="px-6 py-4">
                    <code class="bg-slate-100 text-indigo-600 px-3 py-1 rounded-lg font-bold text-sm">
                        {{ $permission->name }}
                    </code>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-bold bg-green-100 text-green-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                        نشط برمجياً
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
        {{ $permissions->links() }}
    </div>
</div>
@if($permissions->isEmpty())
<div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
    <p class="text-slate-500">لا توجد صلاحيات مسجلة حالياً.</p>
</div>
@endif
@endsection
