<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class UserEvent
 * 
 * @property int $id
 * @property int $a_id
 * @property int $event_id
 * @property int $view_per
 * @property int $add_per
 * @property int $delete_per
 * @property int $edit_per
 * @property int $apr_per
 * 
 * @property User $user
 *
 * @package App\Models
 */
class UserEvent extends Model
{
	use LogsActivity;
	protected $table = 'user_event';
	public $timestamps = false;

	protected $casts = [
		'a_id' => 'int',
		'event_id' => 'int',
		'view_per' => 'int',
		'add_per' => 'int',
		'delete_per' => 'int',
		'edit_per' => 'int',
		'apr_per' => 'int'
	];

	protected $fillable = [
		'a_id',
		'event_id',
		'view_per',
		'add_per',
		'delete_per',
		'edit_per',
		'apr_per'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'a_id');
	}
	protected static $logAttributes = ['*'];
}
