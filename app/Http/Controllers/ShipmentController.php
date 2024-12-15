<?php

namespace App\Http\Controllers;

use App\Enums\ActivityType;
use App\Http\Requests\ShipmentStoreRequest;
use App\Http\Requests\ShipmentUpdateRequest;
use App\Jobs\SendShipmentDeliveredEmail;
use App\Mail\ShipmentDeliveredEmail;
use App\Mail\TestMail;
use App\Models\Shipment;
use App\Providers\ActivityLogged;
use App\Traits\SearchAndSort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ShipmentController extends Controller
{
    use SearchAndSort;
    public function index(Request $request)
    {
        $query = Auth::guard('admin') ? Shipment::query() : Auth::user()->shipments();
        $shipments = $this->applySearchAndSort($query, $request)->paginate(10);

        return view('shipments.index', compact('shipments'));
    }

    public function create()
    {
        $this->authorize('create', Shipment::class);

        return view('shipments.create');
    }

    public function store(ShipmentStoreRequest $request)
    {
        $this->authorize('create', Shipment::class);
        $validated = $request->validated();

        $shipment = Shipment::create([
            'cost' => $validated['cost'],
            'customer_id' => $request->user()->id,
            'tracking_number' => bin2hex(random_bytes(16)),
        ]);

        event(new ActivityLogged(ActivityType::SHIPMENT_CREATE, Auth::user()->name . " created shipment $shipment->tracking_number"));

        return redirect()->route('shipments.index')->with('success', 'Shipment created successfully!');
    }


    public function show(Shipment $shipment)
    {
        $this->authorize('view', $shipment);

        return view('shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        $this->authorize('update', $shipment);

        return view('shipments.edit', compact('shipment'));
    }

    public function update(ShipmentUpdateRequest $request, Shipment $shipment)
    {
        $this->authorize('update', $shipment);
        $validated = $request->validated();

        $shipment->update($validated);

        if ($shipment->status === 'delivered') {
             SendShipmentDeliveredEmail::dispatch($shipment);
        }

        event(new ActivityLogged(ActivityType::SHIPMENT_UPDATE, Auth::user()->name . " updated shipment $shipment->tracking_number ($shipment->status)"));

        return redirect()->route('admin.shipments.show', $shipment->id)->with('success', 'Shipment updated successfully!');
    }


    public function destroy(Shipment $shipment)
    {
        $this->authorize('delete', $shipment);
        $shipment->delete();
        event(new ActivityLogged(ActivityType::SHIPMENT_DELETE, Auth::user()->name . " deleted shipment $shipment->tracking_number"));
        return redirect()->route('admin.shipments.index')->with('success', 'Shipment deleted successfully!');
    }
}
