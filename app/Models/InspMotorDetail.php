<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class InspMotorDetail
 *
 * @property int $id
 * @property int $inspection_id
 *
 * @property Inspection $inspection
 *
 * @package App\Models
 */
class InspMotorDetail extends Model
{
	use LogsActivity;
	protected $table = 'insp_motor_detail';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'inspection_id' => 'int',
		'motor_id' => 'int'
	];

	protected $fillable = [
		'motor_id',
		'motor_horse_power_status',
		'motor_holar_num_status',
		'motor_horse_power_comment',
		'motor_holar_num_comment'
	];

	public function inspection()
	{
		return $this->belongsTo(Inspection::class);
	}

    public function motor_detail()
	{
		return $this->belongsTo(MotorDetail::class,'motor_id');
	}
	protected static $logAttributes = ['*'];
}
