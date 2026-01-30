<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact($categories));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string'
        ]); 

        // auto generate slug dari name
        $validated['slug'] = Str::slug($validated['name']);

        // simpan ke database
        Category::create($validated);

        // redirect dengan alert success
        return redirect()->route('categories.index')->with( 'success', 'Category created successfully. ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // tampilkan data
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return redirect('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name.' . $category->id,
            'description' => 'nullable|string'
        ]);

        // auto generate slug dari name
        $validated['slug'] = Str::slug($validated['name']);

        // udpate database
        $category->update($validated);

        // redirect dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {   
        // cek apakah kategori ini tersedia produknnya
        if($category->products()->count() > 0){
            return redirect()->route('categories.index')->with('error', 'Cannot delete category with existing products.');
        }

        // hapus kategori
        $category->delete();

        // redirect dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Category deleted succesfully');
    }
}
