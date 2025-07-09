<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class license_type
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|LicenseFee[] $districts
 *
 * @package App\Models
 */
class LicenseType extends Model
{
    use LogsActivity;

	protected $table = 'license_type';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'name'
    ];

    protected static $logAttributes = ['*'];

}
