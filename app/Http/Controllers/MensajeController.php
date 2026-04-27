<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Storage;

class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mensajes = Mensaje::paginate(5);
        return view('mensajes', compact('mensajes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'texto'      => 'nullable|string',
            
        ]);

        $cliente = Cliente::findOrFail($validated['cliente_id']);
        $telefono = $cliente->codigo_pais.$cliente->telefono;
        

        $path = null;
        if ($request->hasFile('archivo')) {
            // Guarda la imagen en la carpeta 'archivo' dentro de storage/app/public
            $path = $request->file('archivo')->store('archivo', 'public');

            try {
                $this->enviarMultimedia($telefono, Storage::disk('public')->path($path));
            } catch (\Exception $e) {
                return response()->json(['ok' => false, 'error' => $e->getMessage()], 400);
            }
        }

        if (!empty($validated['texto'])) {
            try {
                $this->notificar($telefono, $validated['texto']);

                Mensaje::create([
                    'texto' => $validated['texto'],
                    'fecha' => now(),
                ])->clientes()->attach($validated['cliente_id']);

                return response()->json(['ok' => true]);

            } catch (\Exception $e) {
                return response()->json(['ok' => false, 'error' => $e->getMessage()], 400);
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Mensaje $mensaje)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mensaje $mensaje)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mensaje $mensaje)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mensaje $mensaje)
    {
        //
    }


    public function notificar(string $telefono, string $texto): void
    {
        $whatsapp = new WhatsAppService();
        $resultado = $whatsapp->sendTextMessage($telefono, $texto);

        //$resultado = $whatsapp->sendTemplate($telefono, 'hello_world', 'en_US');

        if (isset($resultado['error'])) {
            throw new \Exception($resultado['error']['message']);
        }
    }

    public function enviarMultimedia(string $telefono, string $media): void 
    {
        $whatsapp = new WhatsAppService();
        $mimeType = mime_content_type($media);

        $resultado = $whatsapp->uploadMedia($media, $mimeType);

        if (isset($resultado['error'])) {
            throw new \Exception($resultado['error']['message']);
        }

        $resultado2 = $whatsapp->sendUploadedMedia($telefono, $resultado['id'], $mimeType);

        if (isset($resultado2['error'])) {
            throw new \Exception($resultado2['error']['message']);
        }

    }
}
