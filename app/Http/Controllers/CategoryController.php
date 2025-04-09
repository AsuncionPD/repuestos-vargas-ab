<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = ProductCategory::all(); // Obtiene todas las categorías
        return view('extras.home', compact('categories')); // Pasa las categorías a la vista
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
