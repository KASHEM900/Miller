<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class ChalType
 * 
 * @property int $chal_type_id
 * @property string $chal_type_name
 *
 * @package App\Models
 */
class ChalType extends Model
{
	use LogsActivity;

	protected $table = 'chal_type';
	protected $primaryKey = 'chal_type_id';
	public $timestamps = false;

	protected $fillable = [
		'chal_type_name'
	];

    protected static $logAttributes = ['*'];
}
