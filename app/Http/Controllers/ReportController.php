<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $today = Carbon::today();

        // Total shipments
        $totalShipments = Shipment::count();

        // Today's shipments
        $todaysShipments = Shipment::whereDate('created_at', $today)->count();

        // Delivered shipments
        $deliveredShipments = Shipment::where('status', 'delivered')->count();

        // Delayed shipments
        $delayedShipments = Shipment::where('status', 'delayed')->count();

        // Total profit/loss
        $totalProfitLoss = Shipment::whereIn('status', ['delivered', 'delayed'])
            ->selectRaw('SUM(CASE WHEN status = "delivered" THEN cost ELSE -cost END) AS total_profit_loss')
            ->value('total_profit_loss');

        // Today's profit/loss
        $todaysProfitLoss = Shipment::whereDate('created_at', $today)
            ->whereIn('status', ['delivered', 'delayed'])
            ->selectRaw('SUM(CASE WHEN status = "delivered" THEN cost ELSE -cost END) AS total_profit_loss')
            ->value('total_profit_loss');

        // Profit/loss percentages
        $totalCost = Shipment::whereIn('status', ['delivered', 'delayed'])->sum('cost');
        $netProfitLossPercentage = $totalCost > 0 ? ($totalProfitLoss / $totalCost) * 100 : 0;

        $todaysCost = Shipment::whereDate('created_at', $today)
            ->whereIn('status', ['delivered', 'delayed'])
            ->sum('cost');
        $todaysProfitLossPercentage = $todaysCost > 0 ? ($todaysProfitLoss / $todaysCost) * 100 : 0;

        return view('admin.report', compact('totalShipments', 'todaysShipments', 'deliveredShipments', 'delayedShipments', 'totalProfitLoss', 'todaysProfitLoss', 'netProfitLossPercentage', 'todaysProfitLossPercentage'));
    }
}
