<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class LicenseHistory
 *
 * @property int $distid
 * @property string $distname
 * @property int $divid
 *
 * @property Division $division
 *
 * @package App\Models
 */
class LicenseHistory extends Model
{
	use LogsActivity;

	protected $table = 'license_history';

	protected $casts = [
		'miller_id' => 'int',
		'license_fee_id' => 'int',
		'date_license' => 'date',
		'date_renewal' => 'date',
        'date_last_renewal' => 'date',
		'license_deposit_date' => 'date'
	];

	protected $fillable = [
		'miller_id',
		'license_no',
		'date_license',
		'date_renewal',
        'date_last_renewal',
		'license_fee_id',
		'license_deposit_amount',
		'license_deposit_date',
		'license_deposit_bank',
		'license_deposit_branch',
		'license_deposit_chalan_no',
		'license_deposit_chalan_image',
		'vat_file',
		'signature_file'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}

	public function license_fee()
	{
		return $this->belongsTo(LicenseFee::class, 'license_fee_id');
	}

    protected static $logAttributes = ['*'];
}
