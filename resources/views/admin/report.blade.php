@extends('layouts.layout')

@section('title', 'Reports')

@section('content')
<div class="container mt-4">
    <h2>Profit Report</h2>
    <ul>
        <li>Total Shipments: {{ $totalShipments }}</li>
        <li>Today's Shipments: {{ $todaysShipments }}</li>
        <li>Delivered Shipments: {{ $deliveredShipments }}</li>
        <li>Delayed Shipments: {{ $delayedShipments }}</li>
        <li>Total Profit/Loss: ${{ number_format($totalProfitLoss, 2) }}</li>
        <li>Today's Profit/Loss: ${{ number_format($todaysProfitLoss, 2) }}</li>
        <li>Total Profit/Loss Percentage: {{ number_format($netProfitLossPercentage, 2) }}%</li>
        <li>Today's Profit/Loss Percentage: {{ number_format($todaysProfitLossPercentage, 2) }}%</li>
    </ul>
</div>
@endsection
