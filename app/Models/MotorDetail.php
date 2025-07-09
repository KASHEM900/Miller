<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class MotorDetail
 *
 * @property int $motor_id
 * @property int $miller_id
 * @property int $motor_horse_power
 * @property int $motor_holar_num
 * @property float $motor_filter_power
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class MotorDetail extends Model
{
	use LogsActivity;
	protected $table = 'motor_detail';
	protected $primaryKey = 'motor_id';
	public $timestamps = false;

	protected $casts = [
		'miller_id' => 'int',
		'motor_horse_power' => 'int',
		'motor_holar_num' => 'int',
		'motor_filter_power' => 'float'
	];

	protected $fillable = [
		'motor_horse_power',
		'motor_holar_num',
		'motor_filter_power'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}
	protected static $logAttributes = ['*'];
}
