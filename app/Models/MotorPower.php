<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class MotorPower
 * 
 * @property int $motorid
 * @property float $motor_power
 * @property int $holar_num
 * @property float $power_per_hour
 *
 * @package App\Models
 */
class MotorPower extends Model
{
	use LogsActivity;
	protected $table = 'motor_powers';
	protected $primaryKey = 'motorid';
	public $timestamps = false;

	protected $casts = [
		'motor_power' => 'float',
		'holar_num' => 'int',
		'power_per_hour' => 'float'
	];

	protected $fillable = [
		'motor_power',
		'holar_num',
		'power_per_hour'
	];
	protected static $logAttributes = ['*'];

	public function getMotorPowerDescAttribute()
	{
        return $this->motor_power . " ও " . $this->holar_num;
	}
}
