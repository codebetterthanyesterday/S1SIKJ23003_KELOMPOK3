<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $storeIds;
    protected $status;

    public function __construct($storeIds, $status = null)
    {
        $this->storeIds = $storeIds;
        $this->status = $status;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Get all product IDs for seller's stores
        $productIds = Product::whereIn('id_store', $this->storeIds)->pluck('id_product');

        // Get order IDs that contain seller's products
        $orderIds = OrderDetail::whereIn('id_product', $productIds)->pluck('id_order')->unique();

        // Base query
        $query = Order::with(['user', 'details.product', 'payments'])
            ->whereIn('id_order', $orderIds);

        // Apply status filter if provided
        if ($this->status && $this->status !== 'all') {
            $query->where('order_status', $this->status);
        }

        return $query->orderBy('order_date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Customer',
            'Order Date',
            'Products',
            'Total Amount',
            'Payment Method',
            'Payment Status',
            'Order Status',
        ];
    }

    public function map($order): array
    {
        // Filter products to only include those from seller's stores
        $sellerProducts = $order->details->filter(function ($detail) {
            return in_array($detail->product->id_store, $this->storeIds);
        });

        // Format the products as a string
        $productsStr = $sellerProducts->map(function ($detail) {
            return $detail->product->product_name . ' (x' . $detail->quantity . ')';
        })->join(', ');

        return [
            $order->id_order,
            $order->user->username ?? 'Unknown',
            $order->order_date,
            $productsStr,
            number_format($order->total_amount, 0, ',', '.'),
            $order->payments->first()->method ?? 'Unknown',
            $order->payments->first()->payment_status ?? 'Unknown',
            $order->order_status,
        ];
    }
}
