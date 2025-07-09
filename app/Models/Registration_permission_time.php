<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Event
 * 
 * @property int $event_id
 * @property string $event_name
 *
 * @package App\Models
 */
class Registration_permission_time extends Model
{
	protected $table = 'registration_permission_time';
	protected $primaryKey = 'id';
	public $timestamps = false;
	use LogsActivity;
	protected $fillable = [
		'perm_start_time',
		'period_end_time'

	];
	protected $casts = [
		'perm_start_time' => 'datetime',
		'period_end_time' => 'datetime'
	
	];
	protected static $logAttributes = ['*'];
}
