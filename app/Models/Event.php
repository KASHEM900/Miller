<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
class Event extends Model
{
	use LogsActivity;
	protected $table = 'event';
	protected $primaryKey = 'event_id';
	public $timestamps = false;

	protected $fillable = [
		'event_name',
		'is_timebased_perm_required'
	];
	protected static $logAttributes = ['*'];
}
