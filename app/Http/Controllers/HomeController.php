<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

        // Tiempo de caché en minutos (5 minutos = 300 segundos)
        $cacheTime = 300;
        // Cachear el conteo total de órdenes
        $numeroDeOrdenes = Cache::remember('total_ordenes_count', $cacheTime, function () {
            return Orden::count();
        });

        // Cachear el conteo de órdenes "ENTREGADO"
        $entregados = Cache::remember('entregados_count', $cacheTime, function () {
            return Orden::where('estado', 'ENTREGADO')->count();
        });

        // Cachear el conteo de órdenes "PENDIENTE"
        $pendientes = Cache::remember('pendientes_count', $cacheTime, function () {
            return Orden::where('estado', 'PENDIENTE')->count();
        });


        return view('home', [
            'numeroDeOrdenes' => $numeroDeOrdenes,
            'entregados' => $entregados,
            'pendientes' => $pendientes

        ]);
    }
}
