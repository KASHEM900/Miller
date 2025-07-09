<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class DryerDetail
 *
 * @property int $dryer_id
 * @property int $miller_id
 * @property float $dryer_length
 * @property float $dryer_width
 * @property float $cube_height
 * @property float $pyramid_height
 * @property float $dryer_volume
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class DryerDetail extends Model
{
	protected $table = 'dryer_detail';
	protected $primaryKey = 'dryer_id';
	public $timestamps = false;
	use LogsActivity;
	protected $casts = [
		'miller_id' => 'int',
		'dryer_length' => 'float',
		'dryer_width' => 'float',
		'cube_height' => 'float',
		'pyramid_height' => 'float',
		'dryer_volume' => 'float'
	];

	protected $fillable = [
		'dryer_length',
		'dryer_width',
		'cube_height',
		'pyramid_height',
		'dryer_volume'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}
	protected static $logAttributes = ['*'];
}
