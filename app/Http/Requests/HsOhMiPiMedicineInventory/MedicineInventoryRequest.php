<?php
namespace App\Http\Requests\HsOhMiPiMedicineInventory;

use Illuminate\Foundation\Http\FormRequest;

class MedicineInventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'requestQuantity'               => 'nullable|integer',
            'approverId'                    => 'nullable|string',
            'inventoryNumber'               => 'nullable|string',
            'requestedBy'                   => 'nullable|string',
            'medicineName'                  => 'nullable|string',
            'genericName'                   => 'required|string',
            'dosageStrength'                => 'nullable|string',
            'form'                          => 'nullable|string',
            'medicineType'                  => 'nullable|string',
            'supplierName'                  => 'required|string',
            'supplierContactNumber'         => 'nullable|numeric',
            'supplierEmail'                 => 'nullable|string',
            'supplierType'                  => 'nullable|string',
            'location'                      => 'nullable|string',
            'manufacturingDate'             => 'nullable|string',
            'expiryDate'                    => 'nullable|string',
            'deliveryDate'                  => 'nullable|string',
            'deliveryQuantity'              => 'nullable|numeric',
            'deliveryUnit'                  => 'nullable|string',
            'purchaseAmount'                => 'nullable|numeric',
            'thresholdLimit'                => 'nullable|numeric',
            'invoiceDate'                   => 'nullable|string',
            'invoiceReference'              => 'nullable|string',
            'manufacturerName'              => 'nullable|string',
            'batchNumber'                   => 'nullable|numeric',
            'reorderThreshold'              => 'nullable|string',
            'usageInstruction'              => 'nullable|string',
            'division'                      => 'nullable|string',
            'status'                        => 'nullable|in:Draft,Approved,Shipped,pending,rejected,published',
            'approvedBy'                    => 'nullable|string',
            'disposals'                     => 'nullable|array',
            'disposals.*.disposalDate'      => 'nullable|string',
            'disposals.*.availableQuantity' => 'nullable|string',
            'disposals.*.disposalQuantity'  => 'nullable|string',
            'disposals.*.contractor'        => 'nullable|string',
            'disposals.*.cost'              => 'nullable|string',
            'disposals.*.balanceQuantity'   => 'nullable|string',

        ];
    }
}
