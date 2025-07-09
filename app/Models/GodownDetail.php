<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class GodownDetail
 *
 * @property int $godown_id
 * @property int $miller_id
 * @property float $godown_long
 * @property float $godown_wide
 * @property float $godown_height
 * @property float $godown_valume
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class GodownDetail extends Model
{
	use LogsActivity;
	protected $table = 'godown_detail';
	protected $primaryKey = 'godown_id';
	public $timestamps = false;

	protected $casts = [
		'miller_id' => 'int',
		'godown_long' => 'float',
		'godown_wide' => 'float',
		'godown_height' => 'float',
		'godown_valume' => 'float'
	];

	protected $fillable = [
		'godown_long',
		'godown_wide',
		'godown_height',
		'godown_valume'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}

	protected static $logAttributes = ['*'];
}
