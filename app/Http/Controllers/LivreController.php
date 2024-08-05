<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Http\Requests\StoreLivreRequest;
use App\Http\Requests\UpdateLivreRequest;
use Illuminate\Support\Facades\File;

class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livres = Livre::all();
        return $this->customJsonResponse("Liste des livres", $livres);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLivreRequest $request)
    {
        $livre = new Livre();
        $livre->fill($request->validated());
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $livre->image = $image->store('livres', 'public');
        }
        $livre->save();
        return $this->customJsonResponse("Livre créé avec succès", $livre, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Livre $livre)
    {
        return $this->customJsonResponse("Livre récupéré avec succès", $livre);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLivreRequest $request, Livre $livre)
    {
        $livre->fill($request->validated());
        if ($request->hasFile('image')) {
            if (File::exists($livre->image)) {
                File::delete($livre->image);
            }
            $image = $request->file('image');
            $livre->image = $image->store('livres', 'public');
        }
        if ($livre->quantite > 0) {
            $livre->update(['disponible' => true]);
        }
        $livre->update();
        return $this->customJsonResponse("Livre modifié avec succès", $livre);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livre $livre)
    {
        //
    }
}
