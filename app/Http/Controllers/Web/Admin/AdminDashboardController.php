<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Valeurs par défaut (comme sur ta maquette)
        $kpis = [
            'clients' => 53,
            'orders_today' => 33,
            'reservations' => 15,
        ];

        // Si tes tables existent, on branche des vrais chiffres (sans casser si pas encore créé)
        if (Schema::hasTable('orders')) {
            $kpis['orders_today'] = (int) DB::table('orders')
                ->whereDate('opened_at', now()->toDateString())
                ->count();
        }

        if (Schema::hasTable('customers')) {
            $kpis['clients'] = (int) DB::table('customers')->count();
        }

        if (Schema::hasTable('reservations')) {
            $kpis['reservations'] = (int) DB::table('reservations')
                ->whereDate('reserved_at', now()->toDateString())
                ->count();
        }

        // Activités récentes (ex: dernières commandes)
        $activities = [];
        if (Schema::hasTable('orders')) {
            $activities = DB::table('orders')
                ->select('order_number', 'channel', 'status', 'opened_at')
                ->orderByDesc('opened_at')
                ->limit(5)
                ->get()
                ->map(function ($o) {
                    return [
                        'type' => $o->channel, // TAKEAWAY/DELIVERY/DINE_IN
                        'label' => "Commande {$o->order_number}",
                        'when' => $o->opened_at,
                    ];
                })
                ->toArray();
        }

        return view('admin.dashboard', [
            'user' => session('user'),
            'kpis' => $kpis,
            'activities' => $activities,
        ]);
    }
}
