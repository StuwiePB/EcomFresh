<?php

namespace App\Http\Controllers;

use App\Models\Beef;
use Illuminate\Http\Request;

class BeefController extends Controller
{
    public function index()
    {
        $beefs = Beef::all();

    if ($beefs->count() === 0) {
        Beef::create(['name' => 'Ribeye', 'price' => 10.0, 'stock' => 5]);
        $beefs = Beef::all();
    }

    return view('admin.beef-crud', compact('beefs'));
    }

    public function create()
    {
        return view('admin.beef-create');
    }

    public function store(Request $request)
    {
        Beef::create($request->all());
        return redirect()->route('beefs.index')->with('success', 'Beef added successfully!');
    }

    public function edit($id)
    {
        $beef = Beef::findOrFail($id);
        return view('admin.beef-edit', compact('beef'));
    }

    public function update(Request $request, $id)
    {
        $beef = Beef::findOrFail($id);
        $beef->update($request->all());
        return redirect()->route('beefs.index')->with('success', 'Beef updated successfully!');
    }

    public function destroy($id)
    {
        $beef = Beef::findOrFail($id);
        $beef->delete();
        return redirect()->back()->with('success', 'Beef deleted successfully!');
    }
}
