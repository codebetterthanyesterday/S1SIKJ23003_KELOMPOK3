@component('mail::message')
    # Order Status Update

    Dear {{ $order->user->username }},

    Your order #{{ $order->id_order }} has been updated to **{{ strtoupper($order->order_status) }}**.

    {{ $statusMessage }}

    ## Order Details:
    @component('mail::table')
        | Product | Quantity | Price |
        |:--------|:--------:| -----:|
        @foreach ($order->details as $detail)
            | {{ $detail->product->product_name }} | {{ $detail->quantity }} | Rp
            {{ number_format($detail->product->price * $detail->quantity, 0, ',', '.') }} |
        @endforeach
        | | **Total** | **Rp {{ number_format($order->total_amount, 0, ',', '.') }}** |
    @endcomponent

    @if ($order->order_status == 'shipped' && $order->tracking_number)
        ## Tracking Information:
        Tracking Number: **{{ $order->tracking_number }}**

        @if ($order->shipping_notes)
            Note: {{ $order->shipping_notes }}
        @endif
    @endif

    @component('mail::button', ['url' => route('customer.orders.history')])
        View Your Orders
    @endcomponent

    Thank you for shopping with Langsung-PO!

    Regards,<br>
    Langsung-PO Team
@endcomponent
