<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class ChatalDetail
 *
 * @property int $chatal_id
 * @property int $miller_id
 * @property float $chatal_long
 * @property float $chatal_wide
 * @property float $chatal_area
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class ChatalDetail extends Model
{
	use LogsActivity;

	protected $table = 'chatal_detail';
	protected $primaryKey = 'chatal_id';
	public $timestamps = false;

	protected $casts = [
		'miller_id' => 'int',
		'chatal_long' => 'float',
		'chatal_wide' => 'float',
		'chatal_area' => 'float'
	];

	protected $fillable = [
		'chatal_long',
		'chatal_wide',
		'chatal_area'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}

    protected static $logAttributes = ['*'];
}
