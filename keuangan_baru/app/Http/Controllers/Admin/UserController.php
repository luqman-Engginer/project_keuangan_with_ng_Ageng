<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->toString();

        $users = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'q' => $search,
        ]);
    }

    public function toggleStatus(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->withErrors(['user' => 'Anda tidak bisa menonaktifkan akun sendiri.']);
        }

        $user->status = $user->isAktif() ? User::STATUS_NONAKTIF : User::STATUS_AKTIF;
        $user->save();

        $aksi = $user->isAktif() ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.users.index')->with('success', "Akun {$user->nama} berhasil {$aksi}.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->withErrors(['user' => 'Anda tidak bisa menghapus akun sendiri.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun {$user->nama} beserta seluruh datanya berhasil dihapus.");
    }
}
