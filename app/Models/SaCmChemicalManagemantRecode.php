<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaCmChemicalManagemantRecode extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNumber',
        'commercialName',
        'substanceName',
        'reachRegistrationNumber',
        'molecularFormula',
        'requestQuantity',
        'requestUnit',
        'zdhcCategory',
        'chemicalFormType',
        'whareAndWhyUse',
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
        'status',
        'createdByUser',
        'updatedBy',
        'approvedBy',
        'rejectedBy',
        'responsibleSection',
        'assigneeLevel',
    ];

    protected $casts = [
        'doYouHaveMSDSorSDS' => 'boolean',
        'documents' => 'array',
    ];

    protected static function booted()
    {
        static::created(function ($model) {
            $model->referenceNumber = 'CHE-' . $model->id;

            $model->save();
        });
    }
}
