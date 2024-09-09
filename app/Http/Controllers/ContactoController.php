<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use DataTables;
use App\Models\Tag;
use App\Models\Contacto;
use App\Models\CustomField;
use App\Models\UserContact;
use Illuminate\Http\Request;
use App\Imports\ContactosImport;
use App\Models\CustomFieldValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $customFields = $user->customFields;
        if ($request->ajax()) {

            $data = $user->contactos()->with([
                'tags' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);  // Filtrar los tags por el usuario actual
                }
            ])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tags', function ($contacto) {
                    return $contacto->tags->map(function ($tag) {
                        return '<span style="background-color: ' . $tag->color . '; padding: 5px; border-radius: 4px;">' . $tag->nombre . '</span>';
                    })->implode(' ');
                })
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm" style="margin-right: 8px;"> <i class="fa fa-edit"></i></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"> <i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['tags', 'action'])
                ->make(true);
        }

        // Solo tags asociados al usuario
        $tags = $user->tags()->get();
        return view('contactos.index', compact(['tags', 'customFields']));
    }




    public function store(Request $request)
    {
        try {

            $user = Auth::user();  // Asegúrate de tener el usuario actual
            // Validar la entrada
            $data = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'sometimes|string|max:255',
                'correo' => 'sometimes|email|max:255',
                'telefono' => 'required|string',
                'notas' => 'nullable|string',
                'etiqueta' => 'sometimes|array',
                'etiqueta.*' => 'integer|exists:tags,id,user_id,' . $user->id,  // Asegura que los tags existen y pertenecen al usuario
            ]);


            // Verificar si existe un contacto con el mismo teléfono
            $contacto = Contacto::where('telefono', $data['telefono'])->first();

            if ($contacto) {
                // Si el contacto ya existe, verificar si el usuario actual ya lo tiene asociado
                if (!$user->contactos->contains($contacto->id)) {
                    // Asociar el contacto existente con el usuario actual en user_contacts
                    $userContact = new UserContact();
                    $userContact->user_id = $user->id;
                    $userContact->contacto_id = $contacto->id;
                    $userContact->save();
                }
            } else {
                // Si no existe, crear un nuevo contacto
                $contacto = new Contacto();
                $contacto->fill($data);
                $contacto->save();

                // Asociar el nuevo contacto con el usuario autenticado en user_contacts
                $userContact = new UserContact();
                $userContact->user_id = $user->id;
                $userContact->contacto_id = $contacto->id;
                $userContact->save();
            }

            // Asociar tags si se proporcionan, tanto para contactos nuevos como existentes
            if (!empty($data['etiqueta'])) {
                $contacto->tags()->syncWithoutDetaching($data['etiqueta']);
            }

            if (isset($data['custom_fields'])) {
                // Guardar los valores de los campos personalizados
                foreach ($request->custom_fields as $fieldId => $value) {
                    CustomFieldValue::create([
                        'contacto_id' => $contacto->id,
                        'custom_field_id' => $fieldId,
                        'value' => $value,
                    ]);
                }
            }



            return response()->json([
                'success' => true,
                'data' => $contacto
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        if (request()->ajax()) {
            try {
                $user = Auth::user(); // Obtener el usuario autenticado
                $customFields = $user->customFields;


                // Cargar el contacto junto con sus tags asociados
                $data = $user->contactos()->where('contactos.id', $id)
                    ->with(['tags', 'customFieldValues.customField'])
                    ->first();

                if (!$data) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Contacto no encontrado o no tienes permiso para editarlo.'
                    ], 404);
                }

                // Preparar los valores de los campos personalizados
                $customFieldValues = $data->customFieldValues->pluck('value', 'custom_field_id');


                return response()->json([
                    'result' => $data,
                    'customFields' => $customFields,
                    'customFieldValues' => $customFieldValues
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }


    public function update(Request $request)
    {
        if (request()->ajax()) {
            try {
                $user = Auth::user(); // Obtener el usuario autenticado

                $contacto = $user->contactos()->where('contactos.id', $request->hidden_id)->with([
                    'tags' => function ($query) use ($user) {
                        $query->where('user_id', $user->id); // Cargar solo tags del usuario
                    },
                    'customFieldValues'
                ])->first();

                if (!$contacto) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Contacto no encontrado o no tienes permiso para actualizarlo.'
                    ], 404);
                }

                // Validar la entrada
                $data = $request->validate([
                    'nombre' => 'sometimes|string|max:255',
                    'apellido' => 'sometimes|string|max:255',
                    'correo' => 'sometimes|email|max:255',
                    'telefono' => 'sometimes|string|max:255|unique:contactos,telefono,' . $contacto->id,
                    'notas' => 'nullable|string',
                    'etiqueta' => 'sometimes|array',
                    'etiqueta.*' => 'integer|exists:tags,id,user_id,' . $user->id,
                ]);

                // Actualizar el contacto
                $contacto->update($data);

                // Sincronizar tags específicamente para este usuario
                if (isset($data['etiqueta'])) {
                    // Encontrar todos los tags actuales del usuario para este contacto
                    $currentTags = $contacto->tags()->where('user_id', $user->id)->pluck('tags.id')->toArray();

                    // Determinar los tags para agregar y los tags para quitar
                    $tagsToAdd = array_diff($data['etiqueta'], $currentTags);
                    $tagsToRemove = array_diff($currentTags, $data['etiqueta']);

                    // Sincronizar los cambios
                    $contacto->tags()->syncWithoutDetaching($tagsToAdd);    // Añadir nuevos tags
                    $contacto->tags()->detach($tagsToRemove);                // Eliminar tags no deseados
                }

                // Actualizar los valores de los campos personalizados
                if (isset($data['custom_fields'])) {

                    foreach ($request->custom_fields as $fieldId => $value) {
                        $customFieldValue = $contacto->customFieldValues()->where('custom_field_id', $fieldId)->first();
                        if ($customFieldValue) {
                            $customFieldValue->update(['value' => $value]);
                        } else {
                            CustomFieldValue::create([
                                'contacto_id' => $contacto->id,
                                'custom_field_id' => $fieldId,
                                'value' => $value,
                            ]);
                        }
                    }
                }

                return response()->json([
                    'success' => true,
                    'data' => $contacto
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }





    public function destroy($id)
    {
        if (request()->ajax()) {
            try {
                $user = Auth::user(); // Obtener el usuario autenticado

                // Encontrar el contacto asegurándose de que el usuario tiene permiso para eliminarlo
                $contacto = $user->contactos()->where('contactos.id', $id)->first();

                if (!$contacto) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Contacto no encontrado o no tienes permiso para eliminarlo.'
                    ], 404);
                }

                // Eliminar las relaciones de tags antes de eliminar el contacto
                $contacto->tags()->detach();

                // Eliminar las relaciones de campos personalizados antes de eliminar el contacto
                $contacto->customFieldValues()->delete();

                // Eliminar el contacto
                $contacto->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Contacto eliminado exitosamente.'
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function uploadUsers(Request $request)
    {
        try {
            Excel::import(new ContactosImport, $request->file);
            return redirect()->route('contactos.index')->with('success', 'Contactos importados con éxito');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Obtener los errores de validación del CSV
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Fila " . $failure->row() . ": " . $failure->errors()[0];
            }
            // Redireccionar de vuelta con los errores
            return redirect()->back()->withErrors($errors)->withInput();
        } catch (Exception $e) {
            // Registrar el error general en el log
            Log::error('Ha ocurrido un error al importar los contactos: ' . $e->getMessage(), ['exception' => $e]);
            // Otro tipo de errores
            return redirect()->back()->withErrors(['error' => 'Ha ocurrido un error al importar los contactos.'])->withInput();
        }
    }


    public function exportar()
    {
        $user = Auth::user(); // Asegúrate de usar Auth para obtener el usuario actual

        // Cargar anticipadamente las etiquetas de los contactos asociados al usuario
        $contactos = $user->contactos()->with('tags')->get();
        $nombreArchivo = 'contactos.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$nombreArchivo",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columnas = array('ID', 'Nombre', 'Apellido', 'Correo', 'Teléfono', 'Etiquetas'); // Considera incluir otros campos útiles

        $callback = function () use ($contactos, $columnas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columnas);

            foreach ($contactos as $contacto) {
                // Concatenar todas las etiquetas en una cadena separada por comas
                $etiquetas = $contacto->tags->pluck('nombre')->implode(', ');

                // Asegúrate de incluir todos los campos necesarios
                fputcsv($file, [
                    $contacto->id,
                    $contacto->nombre,
                    $contacto->apellido,  // Asumiendo que también quieres incluir el apellido
                    $contacto->correo,    // y el correo electrónico
                    $contacto->telefono,
                    $etiquetas
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function descargarPlantilla()
    {
        $user = Auth::user();
        $customFields = $user->customFields;

        // Definir los encabezados básicos
        $headers = ['nombre', 'apellido', 'correo', 'telefono', 'notas', 'tags'];

        // Agregar los campos personalizados a los encabezados
        foreach ($customFields as $field) {
            $headers[] = $field->name;
        }

        // Crear el contenido del CSV
        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);
        };

        // Enviar el CSV al cliente para su descarga
        return Response::stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=plantilla_contactos.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }

}
