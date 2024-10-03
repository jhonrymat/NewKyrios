<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Orden;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class OrdenController extends Controller
{
    public function generarPDFpendientes($norden)
    {
        // Obtener los datos de la orden desde la base de datos
        $orden = Orden::where('codigo', $norden)->firstOrFail();
        $user = Auth::user();


        // Cargar la vista y pasar los datos de la orden
        $pdf = Pdf::loadView('ordenes.pdfpendientes', [
            'user' => $user,
            'orden' => $orden
        ]);

        // Descargar el PDF
        return $pdf->stream('Orden No ' . $norden . '.pdf');
    }

    public function generarPDFfinalizados($norden)
    {
        // Obtener los datos de la orden desde la base de datos
        $orden = Orden::where('codigo', $norden)->firstOrFail();
        $user = Auth::user();


        // Cargar la vista y pasar los datos de la orden
        $pdf = Pdf::loadView('ordenes.pdffinalizados', [
            'user' => $user,
            'orden' => $orden
        ]);

        // Descargar el PDF
        return $pdf->stream('Orden No ' . $norden . '.pdf');
    }



    public function pendientes(Request $request)
    {

        if ($request->ajax()) {
            $ordenes = Orden::where('estado', 'PENDIENTE')
                ->orderBy('codigo', 'desc')
                ->select(['codigo', 'nomcliente', 'marca', 'fecha', 'celcliente', 'tecnico', 'valor', 'modelo', 'notacliente', 'observaciones', 'reparado', 'product_image']);

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
                ->select(['codigo', 'fecha', 'nomcliente', 'celcliente', 'marca', 'modelo', 'tecnico', 'product_image']);

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
                ->select(['codigo', 'fecha', 'nomcliente', 'celcliente', 'marca', 'modelo', 'tecnico', 'product_image']);

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
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',

        ]);

        // Convertir el valor de 'fecha' a un objeto Carbon
        $fechaHora = Carbon::parse($request->fecha);
        $fecha = $fechaHora->toDateString();
        $hora = $fechaHora->toTimeString(); // Ejemplo: '14:30:00'
        $fechaFormateada = Carbon::createFromFormat('Y-m-d', $fecha)->format('d/m/Y'); // Convierte a 'DD/MM/YYYY'

        // Manejar la imagen si existe
        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('product_images', 'public'); // Guardar en 'storage/app/public/product_images'
        }

        $orden = Orden::create([
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
            'valor' => $request->valor,
            'reparado' => '',
            'product_image' => $imagePath, // Guardar la ruta de la imagen

        ]);

        return response()->json([
            'success' => true,
            'id' => $orden->codigo, // Enviar el ID generado de la nueva orden
        ]);
    }

    public function update(Request $request, $codigo)
    {
        $request->validate([
            'nomclienteE' => 'required|string|max:255',
            'celclienteE' => 'required|numeric',
            'equipoE' => 'required|string|max:255',
            'marcaE' => 'required|string|max:255',
            'modeloE' => 'required|string|max:255',
            'serialE' => 'required|string|max:255',
            'cargadorE' => 'required|string|max:255',
            'bateriaE' => 'required|string|max:255',
            'otrosE' => 'required|string|max:255',
            'notaclienteE' => 'required|string',
            'observacionesE' => 'nullable|string',
            'valorE' => 'nullable|numeric',
            'estadoE' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Encontrar la orden por el campo 'codigo', ya que es la llave primaria
        $orden = Orden::where('codigo', $codigo)->firstOrFail();

        // Manejar la imagen si se carga una nueva
        if ($request->hasFile('product_image')) {
            // Eliminar la imagen anterior si es necesario
            if ($orden->product_image) {
                Storage::disk('public')->delete($orden->product_image);
            }

            // Guardar la nueva imagen
            $imagePath = $request->file('product_image')->store('product_images', 'public');
            $orden->product_image = $imagePath;
        }

        // Actualizar la orden con los nuevos datos
        $orden->update([
            'nomcliente' => strtoupper($request->nomclienteE),
            'celcliente' => strtoupper($request->celclienteE),
            'equipo' => strtoupper($request->equipoE),
            'marca' => strtoupper($request->marcaE),
            'modelo' => strtoupper($request->modeloE),
            'serial' => strtoupper($request->serialE),
            'cargador' => strtoupper($request->cargadorE),
            'bateria' => strtoupper($request->bateriaE),
            'otros' => strtoupper($request->otrosE),
            'notacliente' => strtoupper($request->notaclienteE),
            'observaciones' => strtoupper($request->observacionesE),
            'valor' => $request->valorE,
            'estado' => $request->estadoE,
        ]);

        return response()->json(['success' => 'Orden actualizada correctamente.']);
    }

    //finalizar orden
    public function finalizar(Request $request, $codigo)
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
            'observaciones' => 'nullable|string',
            'valor' => 'required|numeric',
            'notatecnico' => 'required|string',
            'fechafin' => 'required|string',
        ]);

        // Encontrar la orden por el campo 'codigo', ya que es la llave primaria
        $orden = Orden::where('codigo', $codigo)->firstOrFail();

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
            'observaciones' => strtoupper($request->observaciones),
            'valor' => $request->valor,
            'notatecnico' => strtoupper($request->notatecnico),
            'fechafin' => $request->fechafin,
            'reparado' => 'reparado',
            'estado' => 'ENTREGADO',
        ]);

        return response()->json([
            'success' => 'Orden actualizada correctamente.'
        ]);
    }

    public function updateBodega(Request $request, $codigo)
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
            'estado' => 'nullable|string',
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
    public function updatefinalizadas(Request $request, $codigo)
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
            'notatecnico' => 'required|string',
            'observaciones' => 'nullable|string',
            'valor' => 'nullable|numeric',
            'fechafin' => 'required',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Encontrar la orden por el campo 'codigo', ya que es la llave primaria
        $orden = Orden::where('codigo', $codigo)->firstOrFail();

        // Convierte la fecha de 'd/m/Y' a 'Y-m-d' antes de guardarla en la base de datos
        $fechaOriginal = $request->fechafin; // Recibe la fecha en formato 'YYYY-MM-DD'
        $fechaFormateada = Carbon::createFromFormat('Y-m-d', $fechaOriginal)->format('d/m/Y'); // Convierte a 'DD/MM/YYYY'

        if ($request->hasFile('product_image')) {
            // Eliminar la imagen anterior si es necesario
            if ($orden->product_image) {
                Storage::disk('public')->delete($orden->product_image);
            }

            // Guardar la nueva imagen
            $imagePath = $request->file('product_image')->store('product_images', 'public');
            $orden->product_image = $imagePath;
        }

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
            'notatecnico' => strtoupper($request->notatecnico),
            'observaciones' => strtoupper($request->observaciones),
            'valor' => $request->valor,
            'fechafin' => $fechaFormateada,
        ]);

        return response()->json(['success' => 'Orden actualizada correctamente.']);
    }

    public function destroy($codigo)
    {
        // Encontrar la orden por el campo 'codigo'
        $orden = Orden::where('codigo', $codigo)->firstOrFail();

        // Verificar si la orden tiene una imagen asociada y eliminarla del almacenamiento
        if ($orden->product_image) {
            Storage::disk('public')->delete($orden->product_image);
        }

        // Eliminar la orden
        $orden->delete();

        // Retornar un mensaje de éxito
        return response()->json(['success' => 'Orden eliminada correctamente.']);
    }



    public function edit($id)
    {
        // Busca la orden por su código
        $orden = Orden::where('codigo', $id)->firstOrFail();

        // Retorna los datos de la orden en formato JSON para usarlos en el modal
        return response()->json($orden);
    }
    // ajax para obtener datos para finalizar orden
    public function Orden($id)
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
        $orden->reparado = $request->input('reparado') ? 'reparado' : '';

        $orden->save();

        $estado = $orden->reparado;

        // Crear enlace de WhatsApp
        $mensaje = "Hola " . strtoupper($orden->nomcliente) . ", tu equipo " . strtoupper($orden->equipo) . " ha sido reparado y está listo para ser entregado. Gracias por confiar en nosotros.";
        $mensajeCodificado = urlencode($mensaje);

        // Número de teléfono del cliente
        $numeroTelefono = '57' . $orden->celcliente; // Asegúrate de agregar el código de país
        $whatsappLink = "https://wa.me/{$numeroTelefono}?text={$mensajeCodificado}";

        return response()->json([
            'success' => 'Estado de reparación actualizado correctamente',
            'whatsapp_link' => $whatsappLink,
            'estado' => $estado,

        ]);
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
