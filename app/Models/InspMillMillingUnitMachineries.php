<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class InspMillMillingUnitMachineries
 *
 * @property int $id
 * @property int $inspection_id
 *
 * @property Inspection $inspection
 *
 * @package App\Models
 */
class InspMillMillingUnitMachineries extends Model
{
	use LogsActivity;
	protected $table = 'insp_mill_milling_unit_machineries';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'inspection_id' => 'int',
		'mill_milling_unit_machinery_id' => 'int',
	];

	protected $fillable = [
		'mill_milling_unit_machinery_id',
		'mill_milling_unit_machinery_status',
		'mill_milling_unit_machinery_comment'
	];
	protected static $logAttributes = ['*'];
	public function inspection()
	{
		return $this->belongsTo(Inspection::class);
	}
    public function mill_milling_unit_machinery()
	{
		return $this->belongsTo(MillMillingUnitMachineries::class,'mill_milling_unit_machinery_id');
	}
}
