<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::latest()->paginate(10);
        return view('divisions.index', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:10|unique:divisions,code',
            'description'   => 'nullable|string',
            'active'        => 'boolean',
        ]);

        Division::create([
            'name'          => $request->name,
            'code'          => strtoupper($request->code),
            'description'   => $request->description,
            'active'        => $request->boolean('active'),
        ]);

        return redirect()->route('divisions.index')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        return view('divisions.show', compact('division'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:10|unique:divisions,code,' . $division->id,
            'description'   => 'nullable|string',
            'active'        => 'boolean',
        ]);

        $division->update([
            'name'          => $request->name,
            'code'          => strtoupper($request->code),
            'description'   => $request->description,
            'active'        => $request->boolean('active'),
        ]);

        return redirect()->route('divisions.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        if ($division->items()->count() > 0) {
            return back()->with('error', 'Divisi tidak dapat dihapus karena masih memiliki item.');
        }

        $division->delete();

        return redirect()->route('divisions.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }
}