<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class MillerInactiveReasons
 * 
 * @property int $reason_id
 * @property string $reason_name
 *
 * @package App\Models
 */
class MillerInactiveReasons extends Model
{
	use LogsActivity;

	protected $table = 'miller_inactive_reasons';
	protected $primaryKey = 'reason_id';
	public $timestamps = false;

	protected $fillable = [
		'reason_name'
	];

    protected static $logAttributes = ['*'];
}
