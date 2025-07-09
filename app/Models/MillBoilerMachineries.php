<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class MillBoilerMachineries
 *
 * @property int $miller_id
 * @property string $origin
 * @property string $pro_flowdiagram
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class MillBoilerMachineries extends Model
{
	use LogsActivity;

	protected $table = 'mill_boiler_machineries';
	protected $primaryKey = 'mill_boiler_machinery_id';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'mill_boiler_machinery_id' => 'int',
		'num' => 'int',
		'pressure' => 'float',
		'power' => 'float',
		'topower' => 'float',
		'horse_power' => 'float'
	];

	protected $fillable = [
		'name',
		'brand',
		'manufacturer_country',
		'import_date',
		'num',
		'pressure',
		'power',
		'topower',
		'horse_power'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}
	
    protected static $logAttributes = ['*'];
}
