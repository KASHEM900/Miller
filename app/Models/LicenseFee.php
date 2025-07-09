<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class LicenseFee
 *
 * @property int $distid
 * @property string $distname
 * @property int $divid
 *
 * @property Division $division
 *
 * @package App\Models
 */
class LicenseFee extends Model
{
	use LogsActivity;

	protected $table = 'license_fee';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'license_type_id' => 'int'
	];

	protected $dates = [
		'effective_todate' => 'date'
	];

    protected $fillable = [
		'name',
		'license_type_id',
		'effective_todate',
		'license_fee'
	];

	public function license_type()
	{
		return $this->belongsTo(LicenseType::class, 'license_type_id');
	}

    protected static $logAttributes = ['*'];
}
