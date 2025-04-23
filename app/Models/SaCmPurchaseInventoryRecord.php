<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaCmPurchaseInventoryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'inventoryNumber',
        'commercialName',
        'substanceName',
        'reachRegistrationNumber',
        'molecularFormula',
        'requestQuantity',
        'requestUnit',
        'zdhcCategory',
        'chemicalFormType',
        'whereAndWhyUse',
        'productStandard',
        'doYouHaveMSDSorSDS',
        'documents',
        'msdsorsdsIssuedDate',
        'msdsorsdsExpiryDate',
        'division',
        'requestedCustomer',
        'requestedMerchandiser',
        'requestDate',
        'reviewerId',
        'approverId',
        'hazardType',
        'useOfPPE',
        'ghsClassification',
        'zdhcLevel',
        'casNumber',
        'colourIndex',
        'status',
        'createdByUser',
        'updatedBy',
        'approvedBy',
        'rejectedBy',
        'responsibleSection',
        'assigneeLevel',
        'type',
        'name',
        'manufactureName',
        'contactNumber',
        'emailId',
        'location',
        'compliantWithTheLatestVersionOfZDHCandMRSL',
        'apeoOrNpeFreeComplianceStatement',
        'manufacturingDate',
        'expiryDate',
        'deliveryDate',
        'deliveryQuantity',
        'deliveryUnit',
        'purchaseAmount',
        'thresholdLimit',
        'invoiceDate',
        'invoiceReference',
        'hazardStatement',
        'storageConditionRequirements',
        'storagePlace',
        'lotNumber',
    ];
    protected $casts = [
        'doYouHaveMSDSorSDS' => 'boolean',
        'documents'          => 'array',
        'hazardType'         => 'array',
        'useOfPPE'           => 'array',
        'compliantWithTheLatestVersionOfZDHCandMRSL' => 'boolean',
        'apeoOrNpeFreeComplianceStatement' => 'boolean',

    ];

}
