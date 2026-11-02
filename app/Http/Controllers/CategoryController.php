<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Services\AbExperimentService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request, AbExperimentService $experiment)
    {
        // El experimento se aplica únicamente a la portada canónica. La ruta
        // categories.index conserva su comportamiento original.
        if (!$request->routeIs('extras.home')) {
            return $this->homeView('extras.home', 'unknown', false);
        }

        $distinctId = (string) $request->attributes->get('posthog_distinct_id', '');
        $assignment = $distinctId !== '' ? $experiment->resolve($distinctId) : null;
        $variant = $assignment['variant'] ?? null;

        // La exposición oficial solo se registra al recibir la portada.
        if ($assignment !== null) {
            $experiment->expose($assignment, $distinctId);
        }

        $view = $variant === 'test' ? 'extras.home-redisenado' : 'extras.home';

        return $this->homeView($view, $variant ?? 'unknown', $variant !== null);
    }

    public function redisenado()
    {
        // Vista de comprobación visual: no evalúa la flag ni registra exposición.
        return $this->homeView('extras.home-redisenado', 'preview');
    }

    // Obtiene las categorías y las pasa a la vista de inicio indicada
    private function homeView(string $view, ?string $abVariant = null, bool $abEntry = false)
    {
        $categories = ProductCategory::all(); // Obtiene todas las categorías
        return view($view, compact('categories', 'abVariant', 'abEntry')); // Pasa las categorías a la vista
    }

    public function tableView()
    {
        $categories = ProductCategory::all(); // Trae todas las categorías
        return view('categories.category', compact('categories')); // Muestra la vista con la tabla
    }


    // Mostrar el formulario para agregar una categoría
    public function create()
    {
        return view('categories.create');
    }

    // Guardar la nueva categoría en la base de datos
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|unique:products_categories,name',
            'description' => 'nullable|string|max:255',
        ]);

        // Crear la categoría
        ProductCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.create')->with('success', 'Categoría creada exitosamente!');
    }

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $category = ProductCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.edit', $category->id)->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.table')->with('success', 'Categoría eliminada correctamente.');
    }



}
