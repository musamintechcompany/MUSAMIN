<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetOrder;
use Illuminate\Http\Request;

class AssetOrderController extends Controller
{
    public function index()
    {
        $orders = AssetOrder::with(['user', 'asset'])->latest()->paginate(15);
        return view('management.portal.admin.asset-orders.index', compact('orders'));
    }

    public function show(AssetOrder $assetOrder)
    {
        $assetOrder->load(['user', 'asset']);
        return view('management.portal.admin.asset-orders.view', compact('assetOrder'));
    }
}