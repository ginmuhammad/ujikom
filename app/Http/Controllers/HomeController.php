<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\vwbulanan;
use App\Models\Customer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Order::with(['items', 'payments'])->get();
        $customers_count = Customer::count();
        $transaksiBulanan = vwbulanan::all(); // Mengambil semua data transaksi bulanan

        // Persiapkan array untuk xAxis (bulan) dan data series (pendapatan)
        $bulan = [];
        $pendapatan = [];
        
        foreach ($transaksiBulanan as $transaksi) {
            $bulan[] = $transaksi->bulan_order; // asumsikan ada atribut bulan
            $pendapatan[] = $transaksi->total; // asumsikan ada atribut total, casting ke float untuk memastikan tipe data
        }
        
        // Ubah array bulan menjadi format JSON untuk JavaScript
        $bulanJson = json_encode($bulan);
        $pendapatanJson = json_encode($pendapatan);
        
        return view('home', [
            'orders_count' => $orders->count(),
            'income' => $orders->map(function($i) {
                if($i->receivedAmount() > $i->total()) {
                    return $i->total();
                }
                return $i->receivedAmount();
            })->sum(),
            'income_today' => $orders->where('created_at', '>=', date('Y-m-d').' 00:00:00')->map(function($i) {
                if($i->receivedAmount() > $i->total()) {
                    return $i->total();
                }
                return $i->receivedAmount();
            })->sum(),
            'customers_count' => $customers_count,
            'bulanan' => $bulanJson,
            'pendapatan' => $pendapatanJson,

        ]);
    }
}
