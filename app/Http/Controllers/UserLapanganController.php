<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;


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


        // Check if the request is AJAX
        $validator = Validator::make($request->all(), [
            'jam_main' => 'required',
            'lama_sewa' => 'required',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $user = Auth::user();

        $convert = Carbon::parse($request->jam_main)->format('Y-m-d H:i:s');

        $order = Order::where('lapangan_id', $request->lapangan_id)
            ->where(function ($query) use ($convert) {
                $query->where('jam_pesan', '<=', $convert)
                    ->where('lama_habis', '>=', $convert);
            })
            ->get();


        if (count($order) > 0) {
            return response()->json([
                'errors' => ["Jadwal sudah ada yang booking"],
            ], 422);
        }


        $filePath = $request->file('bukti_transfer')->store('images', 'public');


        $lama_habis = addTime($request->jam_main, $request->lama_sewa);

        $currentDateTime = now();


        // Save order details to database (Example)
        Order::create([
            'user_id' => $user->id,
            'lapangan_id' => $request->lapangan_id,
            'tanggal_pesan' => $currentDateTime,
            'jam_pesan' => $request->jam_main,
            'lama_sewa' => $request->lama_sewa,
            'lama_habis' => $lama_habis,
            'total_harga' => formatCurrency($request->total),
            'konfirmasi' => "Belum konfirmasi",
            'bukti_transfer' => $filePath ?? null,
        ]);

        return response()->json([
            'redirect' => route('pembayaran'),
            'message' => 'Order successful!',
        ]);
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
