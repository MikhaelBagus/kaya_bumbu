<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Warehouse Purchase Info
            'purchase_date' => 'required|date',

            // Supplier
            'supplier_id' => 'required|exists:supplier,id',
            'supplier_account_id' => 'required|exists:supplier_accounts,id',
            
            'payment_method_id' => 'required|exists:payment_method,id',

            // Instalment
            'down_payment' => 'nullable|numeric|min:0',
            'down_payment_date' => 'nullable|date',
            'full_payment_date' => 'nullable|date',
            'instalment_count' => 'nullable|integer|min:1',
            'instalments' => 'nullable|array',
            'instalments.*.due_date' => 'nullable|date',
            'instalments.*.amount' => 'nullable|numeric|min:0',
            'instalments.*.paid_date' => 'nullable|date',

            // Wallet
            'wallet_id' => 'required|exists:wallet,id',

            // Ingredients (Items)
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:ingredient_masters,id',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.unit' => 'required|string|max:50',
            'items.*.stock' => 'nullable|numeric|min:0',
            'items.*.po_qty' => 'required|numeric|min:1',
            'items.*.last_price' => 'nullable|numeric|min:0',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.expenditure_type_id' => 'required|exists:expenditure_type,id',
            'items.*.warehouse_id' => 'required|exists:warehouse,id',

            // Cash Purchase Costs
            'costs' => 'nullable|array',
            'costs.*.cost_name' => 'required_with:costs|string|max:255',
            'costs.*.amount' => 'required_with:costs|numeric|min:0',
            'costs.*.notes' => 'nullable|string|max:500',

            // Cash Purchase Costs
            'discounts' => 'nullable|array',
            'discounts.*.discount_name' => 'required_with:discounts|string|max:255',
            'discounts.*.amount' => 'required_with:discounts|numeric|min:0',
            'discounts.*.notes' => 'nullable|string|max:500',

            // Additional Info
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:draft,submitted',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // Branch Purchase Info
            'purchase_date.required' => 'Purchase date is required',
            'purchase_date.date' => 'Purchase date must be a valid date',

            // Supplier
            'supplier_id.required' => 'Supplier is required',
            'supplier_id.exists' => 'Selected supplier is invalid',
            'supplier_account_id.required' => 'Supplier account is required',
            'supplier_account_id.exists' => 'Selected supplier account is invalid',
            'payment_method_id.required' => 'Payment method is required',
            'payment_method_id.exists' => 'Selected payment method is invalid',

            // Wallet
            'wallet_id.required' => 'Wallet is required',
            'wallet_id.exists' => 'Selected wallet is invalid',

            // Ingredients
            'items.required' => 'At least one ingredient is required',
            'items.min' => 'At least one ingredient is required',
            'items.*.product_id.required' => 'Ingredient is required',
            'items.*.product_id.exists' => 'Selected ingredient is invalid',
            'items.*.product_name.required' => 'Ingredient name is required',
            'items.*.unit.required' => 'Unit is required',
            'items.*.po_qty.required' => 'PO Quantity is required',
            'items.*.po_qty.min' => 'PO Quantity must be at least 1',
            'items.*.price.required' => 'Price is required',
            'items.*.price.min' => 'Price must be at least 0',
            'items.*.expenditure_type_id.required' => 'Expenditure type is required',
            'items.*.expenditure_type_id.exists' => 'Selected expenditure type is invalid',
            'items.*.warehouse_id.required' => 'Warehouse is required',
            'items.*.warehouse_id.exists' => 'Selected warehouse is invalid',

            // Costs
            'costs.*.cost_name.required_with' => 'Cost name is required',
            'costs.*.amount.required_with' => 'Cost amount is required',
            'costs.*.amount.min' => 'Cost amount must be at least 0',

            // Discounts
            'discounts.*.cost_name.required_with' => 'Discount name is required',
            'discounts.*.amount.required_with' => 'Discount amount is required',
            'discounts.*.amount.min' => 'Discount amount must be at least 0',

            // Status
            'status.required' => 'Status is required',
            'status.in' => 'Status must be either draft or submitted',
        ];
    }
}
