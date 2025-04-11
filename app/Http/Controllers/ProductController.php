<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory; // Asegúrate de importar el modelo de categorías
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary; // Asegúrate de incluir esto

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.home', compact('products'));
    }

    public function adminTable()
    {
        $products = Product::with('category')->get();
        return view('products.product', compact('products'));
    }
    

    public function create()
    {
        $categories = ProductCategory::all(); // Obtener todas las categorías
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'location' => 'nullable|string',
            'units' => 'required|integer|min:0',
            'category_id' => 'required|exists:products_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            // Subir imagen a Cloudinary
            $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath());
            $imageUrl = $uploadedFile->getSecurePath(); // Obtener la URL segura de la imagen
        }

        // Obtener el último código de producto y generar el siguiente
        $lastProduct = Product::orderBy('id', 'desc')->first();
        $lastCode = $lastProduct ? intval($lastProduct->product_code) : 0;
        $newCode = str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT); // Ejemplo: 0001

        Product::create([
            'product_code' => $newCode,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'location' => $request->location,
            'units' => $request->units,
            'category_id' => $request->category_id,
            'image' => $imageUrl, // Guardar la URL de la imagen en lugar de la ruta local
        ]);

        return redirect()->route('products.create')->with('success', 'Producto creado correctamente');
    }
    
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'location' => 'nullable|string',
            'units' => 'required|integer|min:0',
            'category_id' => 'required|exists:products_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Si ya tiene una imagen, podemos eliminarla de Cloudinary (opcional)
            if ($product->image) {
                $publicId = last(explode('/', parse_url($product->image, PHP_URL_PATH)));
                Cloudinary::destroy($publicId); // Eliminar la imagen anterior de Cloudinary
            }

            // Subir la nueva imagen a Cloudinary
            $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath());
            $product->image = $uploadedFile->getSecurePath(); // Obtener la URL segura
        }

        $product->update($request->except('image') + ['image' => $product->image]);

        return redirect()->route('products.edit', $product->id)->with('success', 'Producto actualizado correctamente');
    }

    public function show(Product $product)
    {
        $randomProducts = Product::where('id', '!=', $product->id)
                                ->inRandomOrder()
                                ->take(4)
                                ->get();
    
        return view('products.show', compact('product', 'randomProducts'));
    }
    

    public function destroy(Product $product)
    {
        // Si el producto tiene una imagen en Cloudinary, eliminarla
        if ($product->image) {
            $publicId = pathinfo(parse_url($product->image, PHP_URL_PATH), PATHINFO_FILENAME);
            Cloudinary::destroy($publicId);
        }

        // Eliminar el producto de la base de datos
        $product->delete();

        return redirect()->route('products.adminTable')->with('success', 'Producto eliminado correctamente');
    }


    public function decreaseUnits(Request $request, Product $product)
    {
        if ($product->units > 0) {
            $product->decrement('units');
            return response()->json(['success' => true, 'units' => $product->units]);
        }
        return response()->json(['success' => false]);
    }

    public function byCategory($id)
    {
        $category = ProductCategory::findOrFail($id);
        $products = Product::where('category_id', $id)->get();
    
        return view('products.index', compact('products', 'category'));
    }
    

}
