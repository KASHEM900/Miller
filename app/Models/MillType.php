<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class MillType
 *
 * @property int $mill_type_id
 * @property string $mill_type_name
 *
 * @package App\Models
 */
class MillType extends Model
{
	use LogsActivity;
	protected $table = 'mill_type';
	protected $primaryKey = 'mill_type_id';
	public $timestamps = false;

	protected $fillable = [
		'mill_type_name',
		'ordering'
	];
	protected static $logAttributes = ['*'];
}
