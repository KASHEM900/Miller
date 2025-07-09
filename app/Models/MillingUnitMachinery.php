<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class MillingUnitMachinery
 *
 * @property int $mill_type_id
 * @property string $mill_type_name
 *
 * @package App\Models
 */
class MillingUnitMachinery extends Model
{
	use LogsActivity;
	protected $table = 'milling_unit_machinery';
	protected $primaryKey = 'machinery_id';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'ordering'
	];
	protected static $logAttributes = ['*'];
}
