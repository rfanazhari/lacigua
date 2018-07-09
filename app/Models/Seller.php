<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Seller
 */
class Seller extends Model
{
    protected $table = 'seller';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'SellerUniqueID',
        'FullName',
        'Phone',
        'Email',
        'Website',
        'CompanyName',
        'LegalType',
        'CountryID',
        'ProvinceID',
        'CityID',
        'DistrictID',
        'ZipcodeID',
        'Address1',
        'Address2',
        'SupplyGeo',
        'SellerFetured',
        'PIC',
        'BusinessRegNumber',
        'VATReg',
        'SellerVAT',
        'VATInfoFile',
        'BankName',
        'BankAccountNumber',
        'BankBeneficiaryName',
        'BankBranch',
        'PickupCountryID',
        'PickupProvinceID',
        'PickupCityID',
        'PickupDistrictID',
        'PickupZipcodeID',
        'PickupAddress1',
        'PickupPhone',
        'PickupPIC',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy',
        'permalink',
        'idGroup',
        'SellerPartnerID'
    ];

    protected $guarded = [];
}