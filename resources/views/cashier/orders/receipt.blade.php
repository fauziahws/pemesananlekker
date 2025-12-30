<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->order_code }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
        }
        .order-info {
            margin-bottom: 10px;
        }
        .order-info div {
            margin-bottom: 5px;
        }
        .items {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 10px 0;
            margin-bottom: 10px;
        }
        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .item-name {
            flex: 1;
        }
        .item-qty {
            width: 30px;
            text-align: center;
        }
        .item-price {
            width: 50px;
            text-align: right;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 10px;
        }
        @media print {
            body {
                width: auto;
                margin: 0;
                padding: 10px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Lekker</h1>
        <p>Delicious Food & Beverages</p>
        <p>Order Receipt</p>
    </div>

    <div class="order-info">
        <div><strong>Order Code:</strong> {{ $order->order_code }}</div>
        <div><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</div>
        <div><strong>Customer:</strong> {{ $order->customer_name }}</div>
        <div><strong>Type:</strong> {{ ucfirst($order->order_type) }}</div>
        <div><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
        <div><strong>Payment:</strong> {{ $order->paid ? 'Paid' : 'Unpaid' }}</div>
    </div>

    <div class="items">
        @foreach($order->orderItems as $item)
        <div class="item">
            <div class="item-name">{{ $item->product->name }}</div>
            <div class="item-qty">{{ $item->quantity }}</div>
            <div class="item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
        </div>
        @endforeach
    </div>

    <div class="total">
        <div>Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
    </div>

    <div class="footer">
        <p>Thank you for your order!</p>
        <p>Visit us again at Lekker</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #7B542F; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Print Receipt
        </button>
        <br><br>
        <a href="{{ route('cashier.orders.show', $order) }}" style="color: #7B542F; text-decoration: none;">Back to Order</a>
    </div>

    <script>
        // Auto print when loaded, but user can cancel
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html>