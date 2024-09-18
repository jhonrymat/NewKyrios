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



    public function pendientes(Request $request)
    {

        if ($request->ajax()) {
            $ordenes = Orden::where('estado', 'PENDIENTE')
                ->orderBy('codigo', 'desc')
                ->select(['codigo', 'nomcliente', 'marca', 'fecha', 'celcliente', 'tecnico', 'valor', 'modelo', 'notacliente', 'observaciones', 'reparado']);

            return DataTables::of($ordenes)
                ->make(true);
        }

        // Obtener el último código de la orden
        $ultimaOrden = Orden::orderBy('codigo', 'desc')->first();
        $nuevoCodigo = $ultimaOrden ? $ultimaOrden->codigo + 1 : 1; // Si no hay ninguna orden, empezar en 1



        return view('ordenes/pendientes/index', [
            'nuevoCodigo' => $nuevoCodigo,
        ]);
    }

    public function finalizadas(Request $request)
    {
        if ($request->ajax()) {
            $ordenes = Orden::where('estado', 'ENTREGADO')
                ->orderBy('codigo', 'desc')
                ->select(['codigo', 'fecha', 'nomcliente', 'celcliente', 'marca', 'modelo', 'tecnico']);

            return DataTables::of($ordenes)
                ->make(true);
        }

        return view('ordenes/finalizadas/index');
    }

    public function bodega(Request $request)
    {
        if ($request->ajax()) {
            $ordenes = Orden::where('estado', 'EN BODEGA')
                ->orderBy('codigo', 'desc')
                ->select(['codigo', 'fecha', 'nomcliente', 'celcliente', 'marca', 'modelo', 'tecnico']);

            return DataTables::of($ordenes)
                ->make(true);
        }

        return view('ordenes/bodega/index');
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
            'valor' => 'required|numeric',

        ]);

        // Convertir el valor de 'fecha' a un objeto Carbon
        $fechaHora = Carbon::parse($request->fecha);

        // Extraer solo la fecha
        $fecha = $fechaHora->toDateString(); // Ejemplo: '2024-09-05'

        // Extraer solo la hora
        $hora = $fechaHora->toTimeString(); // Ejemplo: '14:30:00'
        $fechaOriginal = $fecha; // Recibe la fecha en formato 'YYYY-MM-DD'
        $fechaFormateada = Carbon::createFromFormat('Y-m-d', $fechaOriginal)->format('d/m/Y'); // Convierte a 'DD/MM/YYYY'


        Orden::create([
            'fecha' => $fechaFormateada,
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
            'estado' => 'required|string',
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
            'estado' => $request->estado,
        ]);

        return response()->json(['success' => 'Orden actualizada correctamente.']);
    }

    //finalizar orden
    public function finalizar(Request $request, $codigo)
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
            'valor' => 'required|numeric',
            'notatecnico' => 'required|string',
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
            'estado' => 'ENTREGADO',
        ]);

        return response()->json(['success' => 'Orden actualizada correctamente.']);
    }

    public function updatefinalizadas(Request $request, $codigo)
    {
        $request->validate([
            'nomclienteFin' => 'required|string|max:255',
            'celcliente' => 'required|numeric',
            'equipoFin' => 'required|string|max:255',
            'marcaFin' => 'required|string|max:255',
            'modeloFin' => 'required|string|max:255',
            'serial' => 'required|string|max:255',
            'cargador' => 'required|string|max:255',
            'bateria' => 'required|string|max:255',
            'otros' => 'required|string|max:255',
            'notacliente' => 'required|string',
            'notatecnico' => 'required|string',
            'observaciones' => 'nullable|string',
            'valor' => 'nullable|numeric',
            'fechafin' => 'required'
        ]);

        // Encontrar la orden por el campo 'codigo', ya que es la llave primaria
        $orden = Orden::where('codigo', $codigo)->firstOrFail();

        // Convierte la fecha de 'd/m/Y' a 'Y-m-d' antes de guardarla en la base de datos
        $fechaOriginal = $request->fechafin; // Recibe la fecha en formato 'YYYY-MM-DD'
        $fechaFormateada = Carbon::createFromFormat('Y-m-d', $fechaOriginal)->format('d/m/Y'); // Convierte a 'DD/MM/YYYY'



        // Actualizar la orden con los nuevos datos
        $orden->update([
            'nomcliente' => strtoupper($request->nomclienteFin),
            'celcliente' => strtoupper($request->celcliente),
            'equipo' => strtoupper($request->equipoFin),
            'marca' => strtoupper($request->marcaFin),
            'modelo' => strtoupper($request->modeloFin),
            'serial' => strtoupper($request->serial),
            'cargador' => strtoupper($request->cargador),
            'bateria' => strtoupper($request->bateria),
            'otros' => strtoupper($request->otros),
            'notacliente' => strtoupper($request->notacliente),
            'notatecnico' => strtoupper($request->notatecnico),
            'observaciones' => strtoupper($request->observaciones),
            'valor' => $request->valor,
            'fechafin' => $fechaFormateada,
        ]);

        return redirect()->route('ordenes.finalizadas')->with('success', 'Orden actualizada correctamente.');
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

    public function edit($id)
    {
        // Busca la orden por su código
        $orden = Orden::where('codigo', $id)->firstOrFail();

        // Retorna los datos de la orden en formato JSON para usarlos en el modal
        return response()->json($orden);
    }
    // ajax para obtener datos para finalizar orden
    public function finalizarOrden($id)
    {
        // Busca la orden por su código
        $orden = Orden::where('codigo', $id)->firstOrFail();

        // Retorna los datos de la orden en formato JSON para usarlos en el modal
        return response()->json($orden);
    }


    public function buscar(Request $request)
    {
        // Validar que el código fue ingresado
        $request->validate([
            'codigo' => 'required|string'
        ]);

        $orden = Orden::where('codigo', $request->codigo)->first();

        if ($orden) {
            return response()->json(['orden' => $orden]);
        } else {
            return response()->json(['error' => 'No se encontró la orden.']);
        }
    }

    // modificar columna reparado
    public function updateReparado(Request $request, $id)
    {
        $orden = Orden::findOrFail($id);

        // Actualizar solo el campo 'reparado'
        $orden->reparado = $request->input('reparado') ? 'reparado' : null;

        $orden->save();

        return response()->json(['success' => 'Estado de reparación actualizado correctamente']);
    }


    // buscar equipo
    public function buscarEquipo(Request $request)
    {
        // Obtener el término de búsqueda que el usuario está escribiendo
        $search = $request->input('q');

        // Si hay una búsqueda, filtrar los clientes por ese término
        $equipo = Orden::distinct()
            ->where('equipo', 'LIKE', "%{$search}%")
            ->pluck('equipo')
            ->take(5); // Limitar los resultados a 10 para evitar sobrecarga

        // Retornar los resultados en formato JSON
        return response()->json($equipo);
    }

    public function buscarDatos(Request $request)
    {
        $tipo = $request->get('tipo');
        $search = $request->get('q');

        $resultados = [];

        switch ($tipo) {
            case 'cliente':
                $resultados = Orden::where('nomcliente', 'like', '%' . $search . '%')->distinct()->pluck('nomcliente');
                break;
            case 'equipo':
                $resultados = Orden::where('equipo', 'like', '%' . $search . '%')->distinct()->pluck('equipo');
                break;
            case 'marca':
                $resultados = Orden::where('marca', 'like', '%' . $search . '%')->distinct()->pluck('marca');
                break;
            case 'modelo':
                $resultados = Orden::where('modelo', 'like', '%' . $search . '%')->distinct()->pluck('modelo');
                break;
            default:
                return response()->json(['error' => 'Tipo no válido'], 400);
        }

        return response()->json($resultados);
    }



}
