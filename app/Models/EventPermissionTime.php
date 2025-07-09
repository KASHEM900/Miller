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
class EventPermissionTime extends Model
{
	use LogsActivity;
	protected $table = 'eventpermissiontime';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'event_id',
		'perm_start_time',
		'perm_end_time'

	];
	protected $casts = [
		'event_id' => 'int',
		'perm_start_time' => 'datetime',
		'perm_end_time' => 'datetime'
	
	];

	public function event()
	{
		return $this->belongsTo(Event::class, 'event_id');
	}
	protected static $logAttributes = ['*'];
}
