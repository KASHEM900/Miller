<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class AreasAndPower
 *
 * @property int $miller_id
 * @property float $boiler_number_total
 * @property float $boiler_volume_total
 * @property float $boiler_power
 * @property float $dryer_volume_total
 * @property float $dryer_power
 * @property float $chatal_area_total
 * @property float $chatal_power
 * @property float $godown_area_total
 * @property float $godown_power
 * @property float $steping_area_total
 * @property float $steping_power
 * @property float $milling_unit_output
 * @property float $milling_unit_power
 * @property float $motor_area_total
 * @property float $motor_power
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class AreasAndPower extends Model
{
	use LogsActivity;

	protected $table = 'areas_and_powers';
	protected $primaryKey = 'miller_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'miller_id' => 'int',
		'boiler_number_total' => 'int',
		'boiler_volume_total' => 'float',
		'boiler_power' => 'float',
		'dryer_volume_total' => 'float',
		'dryer_power' => 'float',
		'chatal_area_total' => 'float',
		'chatal_power' => 'float',
		'godown_area_total' => 'float',
		'godown_power' => 'float',
		'steping_area_total' => 'float',
		'steping_power' => 'float',
		'milling_unit_output' => 'float',
		'milling_unit_power' => 'float',
		'motor_area_total' => 'float',
		'motor_power' => 'float'
	];

	protected $fillable = [
		'boiler_number_total',
		'boiler_volume_total',
		'boiler_power',
		'dryer_volume_total',
		'dryer_power',
		'chatal_area_total',
		'chatal_power',
		'godown_area_total',
		'godown_power',
		'steping_area_total',
		'steping_power',
		'milling_unit_output',
		'milling_unit_power',
		'motor_area_total',
		'motor_power'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}

	
    protected static $logAttributes = ['*'];
}
