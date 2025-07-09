<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class BoilerDetail
 *
 * @property int $boiler_id
 * @property int $miller_id
 * @property float $boiler_radius
 * @property float $cylinder_height
 * @property float $cone_height
 * @property float $boiler_volume
 * @property float $qty
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class BoilerDetail extends Model
{
	protected $table = 'boiler_detail';
	protected $primaryKey = 'boiler_id';
	public $timestamps = false;
	use LogsActivity;
	protected $casts = [
		'miller_id' => 'int',
		'boiler_radius' => 'float',
		'cylinder_height' => 'float',
		'cone_height' => 'float',
		'boiler_volume' => 'float',
		'qty' => 'int'
	];

	protected $fillable = [
		'boiler_radius',
		'cylinder_height',
		'cone_height',
		'boiler_volume',
		'qty'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}
	protected static $logAttributes = ['*'];
}
