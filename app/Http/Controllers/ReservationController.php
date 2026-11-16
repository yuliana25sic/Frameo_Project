<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Branch;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\ReservationAddon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    // Menampilkan form pemesanan paket
    public function create(Package $package)
    {
        $branches = Branch::where('is_active', true)->get();
        $addons = Addon::where('is_active', true)->get();

        return view('reservations.create', compact('package', 'branches', 'addons'));
    }

    // Menyimpan data reservasi baru
    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'branch_id' => 'required|exists:branches,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'total_people' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $package = Package::findOrFail($request->package_id);
        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addMinutes($package->duration_minutes);

        // Cek apakah jadwal di cabang & tanggal tersebut sudah dibooking orang lain
        $isBooked = Reservation::where('branch_id', $request->branch_id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime->format('H:i:s'), $endTime->format('H:i:s')])
                      ->orWhereBetween('end_time', [$startTime->format('H:i:s'), $endTime->format('H:i:s')]);
            })
            ->exists();

        if ($isBooked) {
            return back()->withErrors(['start_time' => 'Maaf, jam tersebut sudah terisi di cabang pilihan Anda. Silakan pilih jam lain.'])->withInput();
        }

        DB::transaction(function () use ($request, $package, $startTime, $endTime) {
            $totalPrice = $package->price;

            // Buat kode booking unik: FRM-YYYYMMDD-XXXX
            $bookingCode = 'FRM-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            $reservation = Reservation::create([
                'booking_code' => $bookingCode,
                'user_id' => Auth::id(),
                'branch_id' => $request->branch_id,
                'package_id' => $package->id,
                'booking_date' => $request->booking_date,
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $endTime->format('H:i:s'),
                'total_people' => $request->total_people,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Hitung dan simpan Add-ons jika ada yang dipilih
            if ($request->has('addons')) {
                foreach ($request->addons as $addonId => $qty) {
                    if ($qty > 0) {
                        $addon = Addon::find($addonId);
                        if ($addon) {
                            $subtotal = $addon->price * $qty;
                            $totalPrice += $subtotal;

                            ReservationAddon::create([
                                'reservation_id' => $reservation->id,
                                'addon_id' => $addon->id,
                                'quantity' => $qty,
                                'subtotal' => $subtotal,
                            ]);
                        }
                    }
                }
                // Update total harga akhir setelah ditambah add-ons
                $reservation->update(['total_price' => $totalPrice]);
            }

            // Buat tagihan pembayaran awal
            Payment::create([
                'reservation_id' => $reservation->id,
                'payment_method' => $request->payment_method,
                'amount' => $totalPrice,
                'payment_status' => 'unpaid',
            ]);
        });

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dibuat! Silakan unggah bukti pembayaran Anda.');
    }

    // Menampilkan daftar riwayat reservasi customer
    public function index()
    {
        $reservations = Reservation::with(['branch', 'package', 'payment', 'reservationAddons.addon'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    // Upload bukti pembayaran
    public function uploadPayment(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'proof_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('proof_image')->store('payments', 'public');

        $reservation->payment->update([
            'proof_image' => $path,
            'payment_status' => 'pending_verification',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi Admin.');
    }
}
