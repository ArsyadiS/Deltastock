<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
        // return $categories;
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
        $request->validate([
            'division_id'   => 'required|exists:divisions,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'active'        => 'boolean',
        ]);

        Category::create([
            'division_id'   => $request->division_id,
            'name'          => $request->name,
            'description'   => $request->description,
            'active'        => $request->active,
        ]);

        return redirect()->route('categories.index')
        ->with('success', 'Kategori berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'division_id'   => 'required|exists:divisions,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'active'        => 'boolean',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'division_id'   => $request->division_id,
            'name'          => $request->name,
            'description'   => $request->description,
            'active'        => $request->active,
        ]);

        return redirect()->route('categories.index')
        ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if (!$category->canBeDeleted()) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki item terkait.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
