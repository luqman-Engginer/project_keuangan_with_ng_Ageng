@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="mb-5">
    <h1 class="text-xl font-semibold">Kelola User</h1>
    <p class="text-sm text-slate-500">Lihat, aktifkan/nonaktifkan, atau hapus akun pengguna.</p>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-end gap-3 border-b border-slate-200 px-5 py-4">
        <div class="min-w-56 flex-1">
            <label for="q" class="mb-1 block text-sm font-medium">Cari nama atau email</label>
            <input id="q" type="text" name="q" value="{{ $q }}" placeholder="Ketik untuk mencari..."
                   class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>
        <button type="submit" class="rounded-md bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Cari</button>
        @if ($q !== '')
            <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:underline">Reset</a>
        @endif
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-5 py-3 font-medium">#</th>
                    <th class="px-5 py-3 font-medium">Nama</th>
                    <th class="px-5 py-3 font-medium">Email</th>
                    <th class="px-5 py-3 font-medium">Role</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Terdaftar</th>
                    <th class="px-5 py-3 text-right font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-5 py-3 text-slate-400">{{ $user->id }}</td>
                        <td class="px-5 py-3 font-medium">{{ $user->nama }}</td>
                        <td class="px-5 py-3">{{ $user->email }}</td>
                        <td class="px-5 py-3">
                            <span class="rounded-full px-2 py-0.5 text-xs font-medium {{ $user->isAdmin() ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="rounded-full px-2 py-0.5 text-xs font-medium {{ $user->isAktif() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-5 py-3">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                        <td class="whitespace-nowrap px-5 py-3 text-right">
                            @if ($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm font-medium {{ $user->isAktif() ? 'text-amber-600 hover:underline' : 'text-green-600 hover:underline' }}">
                                        {{ $user->isAktif() ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="ml-3 inline"
                                      onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->nama }}? Seluruh datanya ikut terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Hapus</button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400">Akun Anda</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-slate-400">Tidak ada user yang cocok.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-5 py-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
