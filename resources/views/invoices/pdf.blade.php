<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $sale->sale_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        .header { display: table; width: 100%; margin-bottom: 15px; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
        .header > div { display: table-cell; vertical-align: middle; }
        .header .logo-cell { width: 80px; }
        .header .logo { width: 60px; height: 60px; border-radius: 50%; display: block; }
        .header .title { text-align: center; }
        .header h1 { color: #667eea; margin: 0; font-size: 24px; }
        .header .consultant-info { text-align: right; font-size: 11px; color: #666; line-height: 1.3; width: 200px; }
        .info-section { margin-bottom: 30px; }
        .info-section table { width: 100%; }
        .info-section td { padding: 5px 0; }
        .info-section .label { font-weight: bold; width: 120px; }
        .items-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .items-table th { background: #667eea; color: white; padding: 10px; text-align: left; }
        .items-table td { padding: 10px; border-bottom: 1px solid #ddd; }
        .items-table tr:last-child td { border-bottom: none; }
        .totals { margin-top: 20px; text-align: right; }
        .totals table { margin-left: auto; width: 300px; }
        .totals td { padding: 5px 10px; }
        .totals .total-row { font-size: 18px; font-weight: bold; border-top: 2px solid #333; }
        .footer { margin-top: 50px; text-align: center; color: #666; font-size: 12px; border-top: 1px solid #ddd; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-cell">
            @if($sale->user->business_logo)
                <img src="{{ public_path('storage/' . $sale->user->business_logo) }}" alt="Logo" class="logo">
            @else
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold; font-family: Arial, sans-serif;">
                    {{ strtoupper(substr($sale->user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $sale->user->name)[1] ?? '', 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="title">
            <h1>INVOICE</h1>
        </div>
        <div class="consultant-info">
            <div><strong>{{ $sale->user->name }}</strong></div>
            @if($sale->user->phone)
                <div>{{ $sale->user->phone }}</div>
            @endif
            @if($sale->user->email)
                <div>{{ $sale->user->email }}</div>
            @endif
        </div>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td class="label">Invoice #:</td>
                            <td><strong>{{ $sale->sale_number }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label">Date:</td>
                            <td>{{ $sale->created_at->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Payment:</td>
                            <td>{{ ucfirst($sale->payment_method) }}</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <table style="margin-left: auto;">
                        <tr>
                            <td class="label">Bill To:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>{{ $sale->customer->full_name }}</strong></td>
                        </tr>
                        @if($sale->customer->email)
                            <tr>
                                <td colspan="2">{{ $sale->customer->email }}</td>
                            </tr>
                        @endif
                        @if($sale->customer->phone)
                            <tr>
                                <td colspan="2">{{ $sale->customer->phone }}</td>
                            </tr>
                        @endif
                        @if($sale->customer->city || $sale->customer->state)
                            <tr>
                                <td colspan="2">{{ $sale->customer->city }}{{ $sale->customer->city && $sale->customer->state ? ', ' : '' }}{{ $sale->customer->state }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right;">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td style="text-align: right;">${{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Tax:</td>
                <td style="text-align: right;">${{ number_format($sale->tax_amount, 2) }}</td>
            </tr>
            @if($sale->shipping_amount > 0)
                <tr>
                    <td>Shipping:</td>
                    <td style="text-align: right;">${{ number_format($sale->shipping_amount, 2) }}</td>
                </tr>
            @endif
            <tr class="total-row">
                <td>TOTAL:</td>
                <td style="text-align: right;">${{ number_format($sale->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>Questions? Contact {{ $sale->user->name }} at {{ $sale->user->email ?? $sale->user->phone }}</p>
    </div>
</body>
</html>
