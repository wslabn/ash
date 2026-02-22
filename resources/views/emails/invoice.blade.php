<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px 0; border-bottom: 2px solid #667eea; }
        .content { padding: 20px 0; }
        .footer { text-align: center; padding: 20px 0; border-top: 1px solid #ddd; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #667eea; margin: 0;">Invoice from {{ $sale->user->name }}</h2>
        </div>
        
        <div class="content">
            <p>Hi {{ $sale->customer->full_name }},</p>
            
            <p>Thank you for your purchase! Please find your invoice attached.</p>
            
            <p><strong>Invoice #:</strong> {{ $sale->sale_number }}<br>
            <strong>Date:</strong> {{ $sale->created_at->format('F d, Y') }}<br>
            <strong>Total:</strong> ${{ number_format($sale->total_amount, 2) }}</p>
            
            <p>If you have any questions, please don't hesitate to reach out.</p>
            
            <p>Best regards,<br>
            {{ $sale->user->name }}</p>
        </div>
        
        <div class="footer">
            <p>This is an automated email. Please do not reply directly to this message.</p>
        </div>
    </div>
</body>
</html>
