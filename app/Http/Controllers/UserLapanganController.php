<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

function formatCurrency($amount)
{
    return str_replace(['Rp', '.', ' '], '', $amount);
}


function addTime($datetime, $hours = 0, $minutes = 0, $seconds = 0)
{
    // Convert the given datetime to a Carbon instance
    $date = Carbon::parse($datetime);

    $hoursToAdd = floatval($hours);

    // Add hours, minutes, and seconds
    $date->addHours($hoursToAdd)->addMinutes($minutes)->addSeconds($seconds);

    return $date->toDateTimeString();
}

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




    public function postOrder(Request $request)
    {

        $user = Auth::user();

        $filePath = $request->file('bukti_transfer')->store('images', 'public');


        $lama_habis = addTime($request->tanggal_pesan, $request->lama_sewa);

        $currentDateTime = now();


        // Save order details to database (Example)
        Order::create([
            'user_id' => $user->id,
            'lapangan_id' => $request->lapangan_id,
            'tanggal_pesan' => $currentDateTime,
            'jam_pesan' => $request->tanggal_pesan,
            'lama_sewa' => $request->lama_sewa,
            'lama_habis' => $lama_habis,
            'total_harga' => formatCurrency($request->total),
            'konfirmasi' => "Belum konfirmasi",
            'bukti_transfer' => $filePath ?? null,
        ]);

        // Redirect or return a response
        return redirect()->route('pembayaran')->with('message', 'Order successful!');
    }

    public function get_jadwal(Request $request)
    {

        $user = Auth::user();
        $order = Order::with(['users', 'lapangans'])->where('lapangan_id', $request->id)->get();
        return $order;
    }

    public function get_order(Request $request)
    {

        $user = Auth::user();
        $order = Order::with(['users', 'lapangans'])
            ->where('user_id', $user->id) // Filter by user ID
            ->get(); // Use get() to retrieve all matching orders
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
