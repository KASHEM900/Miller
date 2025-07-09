<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class SiloDetail
 *
 * @property int $silo_id
 * @property int $miller_id
 * @property float $silo_radius
 * @property float $silo_height
 * @property float $silo_volume
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class SiloDetail extends Model
{
	use LogsActivity;
	protected $table = 'silo_detail';
	protected $primaryKey = 'silo_id';
	public $timestamps = false;

	protected $casts = [
		'miller_id' => 'int',
		'silo_radius' => 'float',
		'silo_height' => 'float',
		'silo_volume' => 'float'
	];

	protected $fillable = [
		'silo_radius',
		'silo_height',
		'silo_volume'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}

	protected static $logAttributes = ['*'];
}
