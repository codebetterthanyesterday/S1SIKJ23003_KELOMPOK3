<?php

namespace App\Http\Controllers\Seller;

use App\Exports\ProductsExport;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\ExportHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Export products to Excel
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportProducts(Request $request)
    {
        $user = Auth::user();
        $storeIds = $user->stores->pluck('id_store')->toArray();

        // Get filter from request, if any
        $filter = $request->query('filter');

        // Export products to Excel
        $fileName = 'products_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Create an export history record
        ExportHistory::create([
            'id_user' => $user->id,
            'export_type' => 'products',
            'file_name' => $fileName,
            'filter' => $filter ?? 'all'
        ]);

        return Excel::download(new ProductsExport($storeIds, $filter), $fileName);
    }

    /**
     * Export orders to Excel
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportOrders(Request $request)
    {
        $user = Auth::user();
        $storeIds = $user->stores->pluck('id_store')->toArray();

        // Get status filter from request, if any
        $status = $request->query('status');

        // Export orders to Excel
        $fileName = 'orders_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Create an export history record
        ExportHistory::create([
            'id_user' => $user->id_user,
            'export_type' => 'orders',
            'file_name' => $fileName,
            'filter' => $status ?? 'all'
        ]);

        return Excel::download(new OrdersExport($storeIds, $status), $fileName);
    }
}
