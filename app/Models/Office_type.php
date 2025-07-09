<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class Office_type
 * 
 * @property int $office_type_id
 * @property string $divname
 * 
 * @property Collection|District[] $districts
 *
 * @package App\Models
 */
class Office_type extends Model
{
	protected $table = 'office_type';
	protected $primaryKey = 'office_type_id';
	public $incrementing = false;
	public $timestamps = false;
	use LogsActivity;
	protected $casts = [

	];

	protected $fillable = [
		'type_name'
	];
	protected static $logAttributes = ['*'];
}
