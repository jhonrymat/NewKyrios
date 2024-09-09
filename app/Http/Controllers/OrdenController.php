<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Orden;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class OrdenController extends Controller
{
    public function generarPDFpendientes($norden)
    {
        // Obtener los datos de la orden desde la base de datos
        $orden = Orden::where('codigo', $norden)->firstOrFail();


        // Cargar la vista y pasar los datos de la orden
        $pdf = Pdf::loadView('ordenes.pdfpendientes', compact('orden'));

        // Descargar el PDF
        return $pdf->stream('Orden No ' . $norden . '.pdf');
    }

    public function generarPDFfinalizados($norden)
    {
        // Obtener los datos de la orden desde la base de datos
        $orden = Orden::where('codigo', $norden)->firstOrFail();


        // Cargar la vista y pasar los datos de la orden
        $pdf = Pdf::loadView('ordenes.pdffinalizados', compact('orden'));

        // Descargar el PDF
        return $pdf->stream('Orden No ' . $norden . '.pdf');
    }



    public function pendientes()
    {
        // Obtener las órdenes con estado "PENDIENTE"
        $OrdenPen = Orden::where('estado', 'PENDIENTE')
            ->orderBy('codigo', 'desc')
            ->get();

        // Obtener el último código de la orden
        $ultimaOrden = Orden::orderBy('codigo', 'desc')->first();
        $nuevoCodigo = $ultimaOrden ? $ultimaOrden->codigo + 1 : 1; // Si no hay ninguna orden, empezar en 1

        $equipos = Orden::distinct()->pluck('equipo'); // Obtener la lista de equipos
        $marcas = Orden::distinct()->pluck('marca');   // Obtener la lista de marcas
        $modelos = Orden::distinct()->pluck('modelo'); // Obtener la lista de modelos
        $clientes = Orden::distinct()->pluck('nomcliente'); // Obtener la lista de usuarios
        $telefonos = Orden::distinct()->pluck('celcliente'); // Obtener la lista de usuarios



        return view('ordenes/pendientes/index', [
            'OrdenPen' => $OrdenPen,
            'equipos' => $equipos,
            'marcas' => $marcas,
            'modelos' => $modelos,
            'clientes' => $clientes,
            'telefonos' => $telefonos,
            'nuevoCodigo' => $nuevoCodigo,
        ]);
    }

    public function finalizadas(Request $request)
    {
        if ($request->ajax()) {
            $ordenes = Orden::where('estado', 'ENTREGADO')
                ->orderBy('codigo', 'desc')
                ->select(['codigo','fecha', 'nomcliente', 'celcliente', 'marca', 'modelo','tecnico']);

            return DataTables::of($ordenes)
                ->make(true);
        }

        return view('ordenes/finalizadas/index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required',
            'nomcliente' => 'required|string|max:255',
            'celcliente' => 'required|numeric',
            'equipo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'tecnico' => 'required|string|max:255',
            'cargador' => 'required',
            'bateria' => 'required',
            'otros' => 'required',
            'notacliente' => 'required|string',

        ]);

        // Convertir el valor de 'fecha' a un objeto Carbon
        $fechaHora = Carbon::parse($request->fecha);

        // Extraer solo la fecha
        $fecha = $fechaHora->toDateString(); // Ejemplo: '2024-09-05'

        // Extraer solo la hora
        $hora = $fechaHora->toTimeString(); // Ejemplo: '14:30:00'

        Orden::create([
            'fecha' => $fecha,
            'nomcliente' => strtoupper($request->nomcliente),
            'celcliente' => strtoupper($request->celcliente),
            'equipo' => strtoupper($request->equipo),
            'marca' => strtoupper($request->marca),
            'modelo' => strtoupper($request->modelo),
            'serial' => strtoupper($request->serial),
            'tecnico' => strtoupper($request->tecnico),
            'cargador' => strtoupper($request->cargador),
            'bateria' => strtoupper($request->bateria),
            'otros' => strtoupper($request->otros),
            'notacliente' => strtoupper($request->notacliente),
            'observaciones' => strtoupper($request->observaciones),
            'estado' => 'PENDIENTE', // Puedes establecer un estado por defecto si es necesario
            'horainicio' => $hora,
            'valor' => $request->valor

        ]);

        return response()->json(['success' => 'Orden creada correctamente.']);
    }

    public function update(Request $request, $codigo)
    {
        $request->validate([
            'nomcliente' => 'required|string|max:255',
            'celcliente' => 'required|numeric',
            'equipo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'serial' => 'required|string|max:255',
            'cargador' => 'required|string|max:255',
            'bateria' => 'required|string|max:255',
            'otros' => 'required|string|max:255',
            'notacliente' => 'required|string',
            'observaciones' => 'nullable|string',
            'valor' => 'nullable|numeric',
        ]);

        // Encontrar la orden por el campo 'codigo', ya que es la llave primaria
        $orden = Orden::where('codigo', $codigo)->firstOrFail();

        // Actualizar la orden con los nuevos datos
        $orden->update([
            'nomcliente' => strtoupper($request->nomcliente),
            'celcliente' => strtoupper($request->celcliente),
            'equipo' => strtoupper($request->equipo),
            'marca' => strtoupper($request->marca),
            'modelo' => strtoupper($request->modelo),
            'serial' => strtoupper($request->serial),
            'cargador' => strtoupper($request->cargador),
            'bateria' => strtoupper($request->bateria),
            'otros' => strtoupper($request->otros),
            'notacliente' => strtoupper($request->notacliente),
            'observaciones' => strtoupper($request->observaciones),
            'valor' => $request->valor,
        ]);

        return response()->json(['success' => 'Orden actualizada correctamente.']);
    }

    public function destroy($codigo)
    {
        // Encontrar la orden por el campo 'codigo'
        $orden = Orden::where('codigo', $codigo)->firstOrFail();

        // Eliminar la orden
        $orden->delete();

        // Retornar un mensaje de éxito
        return response()->json(['success' => 'Orden eliminada correctamente.']);
    }


    //obtener el ultimo id, para la factura
    public function getLatestOrderId()
    {
        $ultimaOrden = Orden::orderBy('codigo', 'desc')->first();
        $nuevoCodigo = $ultimaOrden ? $ultimaOrden->codigo + 1 : 1; // Si no hay ninguna orden, empezar en 1

        return response()->json(['nuevoCodigo' => $nuevoCodigo]);
    }



}
