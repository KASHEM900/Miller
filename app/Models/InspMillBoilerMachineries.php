<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class InspMillBoilerMachineries
 *
 * @property int $id
 * @property int $inspection_id
 *
 * @property Inspection $inspection
 *
 * @package App\Models
 */
class InspMillBoilerMachineries extends Model
{
	use LogsActivity;
	protected $table = 'insp_mill_boiler_machineries';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'inspection_id' => 'int',
		'mill_boiler_machinery_id' => 'int',
	];

	protected $fillable = [
		'mill_boiler_machinery_id',
		'mill_boiler_machinery_status',
		'mill_boiler_machinery_comment'
	];
	protected static $logAttributes = ['*'];
	public function inspection()
	{
		return $this->belongsTo(Inspection::class);
	}
    public function mill_boiler_machinery()
	{
		return $this->belongsTo(MillBoilerMachineries::class,'mill_boiler_machinery_id');
	}
}
