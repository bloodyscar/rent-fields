<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $courts = Lapangan::all();

        return view('lapangan.index', compact('courts'));
    }


    public function get_jadwal(Request $request)
    {

        $user = Auth::user();
        $order = Order::with(['users', 'lapangans'])->where('lapangan_id', $request->id)->find($user);
        return $order;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
