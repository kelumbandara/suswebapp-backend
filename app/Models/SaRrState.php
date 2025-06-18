<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaRrState extends Model
{
    use HasFactory;

    protected $primaryKey = 'legalAdvisorId';

    protected $fillable = [
        'stateName',
        'countryId',
    ];
 public function impact()
    {
        return $this->belongsTo(SaRrCountryName::class, 'countryId');
    }
}
