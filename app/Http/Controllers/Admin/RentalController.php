<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rental;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('user', 'rentableProject')
            ->latest()
            ->paginate(15);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load('user', 'rentableProject');
        return view('admin.rentals.show', compact('rental'));
    }

    public function cancel(Rental $rental)
    {
        $rental->update(['status' => 'cancelled']);
        return redirect()->route('admin.rentals.show', $rental)->with('success', 'Rental cancelled successfully');
    }

    public function suspend(Rental $rental)
    {
        $rental->update(['status' => 'suspended']);
        return redirect()->route('admin.rentals.show', $rental)->with('success', 'Rental suspended successfully');
    }

    public function activate(Rental $rental)
    {
        $rental->update(['status' => 'active']);
        return redirect()->route('admin.rentals.show', $rental)->with('success', 'Rental activated successfully');
    }
}
