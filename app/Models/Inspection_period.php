<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class District
 * 
 * @property int $distid
 * @property string $distname
 * @property int $divid
 * 
 * @property Inspection_period $division
 * @property Collection|Upazilla[] $upazillas
 *
 * @package App\Models
 */
class Inspection_period extends Model
{   
     use LogsActivity;
	protected $table = 'inspection_period';
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'period_start_time' => 'datetime',
		'period_end_time' => 'datetime'
	];

	protected $fillable = [
		'period_name',
		'period_start_time',
		'period_end_time',
		'isActive'

	];

	protected static $logAttributes = ['*'];
}
