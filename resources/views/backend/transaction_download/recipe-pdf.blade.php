<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recipe Report from {{$request->order_date_from}} to {{$request->order_date_to}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f0f0f0;
            padding: 8px;
            font-weight: bold;
            font-size: 14px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
        .transaction-item {
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #fafafa;
        }
        .transaction-header {
            font-weight: bold;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        .product-list {
            margin-top: 10px;
        }
        .product-item {
            padding: 3px 0;
            border-bottom: 1px dotted #ccc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .ingredient-total {
            background-color: #e8f5e8;
        }
        .notes {
            background-color: yellow;
            padding: 2px 4px;
            display: inline-block;
        }
        .page-break {
            page-break-before: always;
        }
        .summary-stats {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Recipe Report</h1>
        <h3>Period: {{date('d M Y', strtotime($request->order_date_from))}} - {{date('d M Y', strtotime($request->order_date_to))}}</h3>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-stats">
        <strong>Summary:</strong><br>
        Total Transactions: {{ count($data['transactions']) }}<br>
        Total Products: {{ $data['product_ingredients']->groupBy('product_name')->count() }}<br>
        Total Unique Ingredients: {{ count($data['total_ingredients']) }}
    </div>

    <!-- SECTION 1: ALL TRANSACTIONS -->
    <div class="section">
        <div class="section-title">SECTION 1: ALL TRANSACTIONS</div>
        
        @forelse($data['transactions'] as $transaction)
            <div class="transaction-item">
                <div class="transaction-header">
                    Transaction #{{ $loop->iteration }} - {{ date('d M Y', strtotime($transaction->date)) }} at {{ $transaction->time }}
                </div>
                
                <div style="margin: 10px 0;">
                    <strong>Customer:</strong> {{ $transaction->customer_name }} ({{ $transaction->customer->phone ?? '-' }})<br>
                    <strong>Recipient:</strong> {{ $transaction->recipient_name }} ({{ $transaction->recipient_phone }})<br>
                    <strong>Address:</strong> {{ $transaction->address }}<br>
                    <strong>Delivery:</strong> {{ $transaction->delivery_transport }}
                    @if($transaction->actual_ongkir_price > 0)
                        + Rp {{ number_format($transaction->actual_ongkir_price, 0, ',', '.') }}
                    @endif<br>
                    <strong>Staff:</strong> {{ $transaction->user->name ?? '-' }}
                </div>

                <div class="product-list">
                    <strong>Products Ordered:</strong>
                    @forelse($transaction->transaction_product as $product)
                        <div class="product-item">
                            • {{ $product->qty }} {{ $product->unit }} {{ $product->name }}
                            @if($product->notes)
                                <span class="notes">({{ $product->notes }})</span>
                            @endif
                        </div>
                    @empty
                        <div class="product-item">No products</div>
                    @endforelse
                </div>

                @if($transaction->notes)
                    <div style="margin-top: 10px;">
                        <strong>Transaction Notes:</strong> <span class="notes">{{ $transaction->notes }}</span>
                    </div>
                @endif
            </div>
        @empty
            <p>No transactions found for the selected period.</p>
        @endforelse
    </div>

    <!-- Page break before section 2 -->
    <div class="page-break"></div>

    <!-- SECTION 2: LIST OF ALL PRODUCTS AND INGREDIENTS -->
    <div class="section">
        <div class="section-title">SECTION 2: PRODUCTS AND INGREDIENTS</div>
        
        <table>
            <thead>
                <tr>
                    <th style="text-align: center;">Date</th>
                    <th style="text-align: center;">Product</th>
                    <th style="text-align: center;">Qty Ordered</th>
                    <th style="text-align: center;">Ingredient</th>
                    <th style="text-align: center;">Qty per Product</th>
                    <th style="text-align: center;">Total Ingredient Needed</th>
                    <th style="text-align: center;">Unit</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedData = $data['product_ingredients']->groupBy(function($item) {
                        return $item['transaction_date'] . '|' . $item['product_name'];
                    });
                    $currentGroup = null;
                @endphp
                
                @forelse($groupedData as $groupKey => $productItems)
                    @php
                        $keyParts = explode('|', $groupKey);
                        $date = $keyParts[0];
                        $productName = $keyParts[1];
                        $totalProductQty = $productItems->first()['product_qty'];
                    @endphp
                    
                    @foreach($productItems as $index => $item)
                        <tr style="{{ $index === 0 ? 'border-top: 3px solid #666;' : '' }}">
                            <td style="background-color: {{ $index === 0 ? '#f0f0f0' : '#f9f9f9' }}; font-weight: {{ $index === 0 ? 'bold' : 'normal' }}; border-right: 2px solid #ddd;">
                                {{ $index === 0 ? date('d M Y', strtotime($date)) : '' }}
                            </td>
                            <td style="background-color: {{ $index === 0 ? '#f0f0f0' : '#f9f9f9' }}; font-weight: {{ $index === 0 ? 'bold' : 'normal' }}; border-right: 2px solid #ddd;">
                                {{ $index === 0 ? $productName : '' }}
                            </td>
                            <td style="background-color: {{ $index === 0 ? '#f0f0f0' : '#f9f9f9' }}; font-weight: {{ $index === 0 ? 'bold' : 'normal' }}; text-align: center; border-right: 2px solid #ddd;">
                                {{ $index === 0 ? number_format($totalProductQty, 0) : '' }}
                            </td>
                            <td style="font-weight: bold;">{{ $item['ingredient_name'] }}</td>
                            <td style="text-align: center;">{{ $item['ingredient_qty_per_product'] }}</td>
                            <td style="text-align: right; font-weight: bold; color: #333;">{{ $item['total_ingredient_qty'] }}</td>
                            <td style="text-align: center;">{{ $item['ingredient_unit'] }}</td>
                        </tr>
                    @endforeach
                    
                    @if(!$loop->last)
                        <tr>
                            <td colspan="7" style="height: 8px; background-color: #ffffff; border: none; padding: 0;"></td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">No product ingredients data found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Page break before section 3 -->
    <div class="page-break"></div>

    <!-- SECTION 3: INGREDIENTS TOTAL -->
    <div class="section" style="page-break-inside: auto;">
        <div class="section-title">SECTION 3: TOTAL INGREDIENTS SUMMARY</div>
        
        <table style="margin-top: 0px;">
            <thead>
                <tr>
                    <th style="width: 10%;text-align: center;">#</th>
                    <th style="width: 50%;text-align: center;">Ingredient Name</th>
                    <th style="width: 20%;text-align: center;">Total Quantity</th>
                    <th style="width: 20%;text-align: center;">Unit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['total_ingredients'] as $ingredient)
                    <tr class="ingredient-total">
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td><strong>{{ $ingredient['ingredient_name'] }}</strong></td>
                        <td style="text-align: center;"><strong>{{ $ingredient['total_qty'] }}</strong></td>
                        <td style="text-align: center;">{{ $ingredient['ingredient_unit'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">No ingredients summary available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Total Ingredients Summary -->
        <div style="margin-top: 20px; padding: 10px; background-color: #f0f8ff; border: 1px solid #0066cc;">
            <strong>Shopping List Summary:</strong><br>
            This section shows the total quantity of each ingredient needed to fulfill all orders in this period.
            Use this list for procurement and inventory planning.
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 10px;">
        Generated on {{ date('d M Y H:i:s') }} | Kaya Bumbu Recipe Report
    </div>
</body>
</html>
