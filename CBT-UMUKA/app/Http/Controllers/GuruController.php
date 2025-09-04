<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $Guru = Guru::all();
        return view('Guru.index', compact('Guru'));
    }

    public function create()
    {
        return view('Gurur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:Guru',
            'subject' => 'required',
        ]);

        Guru::create($request->all());
        return redirect()->route('Guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        return view('Guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:guru,email,' . $guru->id,
            'subject' => 'required',
        ]);

        $guru->update($request->all());
        return redirect()->route('guru$guru.index')->with('success', 'data guru berhasil diupdate.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'data guru berhasil dihapus.');
    }
}
