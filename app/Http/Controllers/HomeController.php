<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the welcome/landing page.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Handle public shipment tracking request.
     */
    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
        ], [
            'tracking_number.required' => 'يرجى إدخال رقم التتبع الخاص بك.',
            'tracking_number.max' => 'رقم التتبع غير صالح.',
        ]);

        $shipment = Shipment::with(['statusHistories' => function ($query) {
            // Get histories from oldest to newest for timeline display
            $query->orderBy('created_at', 'asc');
        }])->where('tracking_number', $request->tracking_number)->first();

        if (!$shipment) {
            return redirect()->route('home')->with('error', 'عفواً، لم نتمكن من العثور على شحنة بهذا الرقم. يرجى التأكد من الرقم والمحاولة مرة أخرى.')->withInput();
        }

        // Return to home page but flash the shipment data
        return redirect()->route('home')->with('shipment', $shipment)->withInput();
    }
}
