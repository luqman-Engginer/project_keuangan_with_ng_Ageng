<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $totalPemasukan = (float) $user->transactions()
            ->where('tipe', 'pemasukan')
            ->sum('jumlah');

        $totalPengeluaran = (float) $user->transactions()
            ->where('tipe', 'pengeluaran')
            ->sum('jumlah');

        $saldo = $user->saldo();

        $transactions = $user->transactions()
            ->with('category')
            ->latest()
            ->latest('id')
            ->take(10)
            ->get();

        return view('dashboard', [
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $saldo,
            'transactions' => $transactions,
        ]);
    }
}
