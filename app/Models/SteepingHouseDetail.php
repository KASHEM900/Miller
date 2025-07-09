<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class SteepingHouseDetail
 *
 * @property int $steeping_house_id
 * @property int $miller_id
 * @property float $steeping_house_long
 * @property float $steeping_house_wide
 * @property float $steeping_house_height
 * @property float $steeping_house_volume
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class SteepingHouseDetail extends Model
{
	protected $table = 'steeping_house_detail';
	protected $primaryKey = 'steeping_house_id';
	public $timestamps = false;
	use LogsActivity;
	protected $casts = [
		'miller_id' => 'int',
		'steeping_house_long' => 'float',
		'steeping_house_wide' => 'float',
		'steeping_house_height' => 'float',
		'steeping_house_volume' => 'float'
	];

	protected $fillable = [
		'steeping_house_long',
		'steeping_house_wide',
		'steeping_house_height',
		'steeping_house_volume'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}
	protected static $logAttributes = ['*'];
}
