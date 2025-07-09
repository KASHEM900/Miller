<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class UserType
 * 
 * @property int $id
 * @property string $name
 *
 * @package App\Models
 */
class UserType extends Model
{
	use LogsActivity;
	protected $table = 'user_type';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'id',
		'name'
	];
	protected static $logAttributes = ['*'];
}
