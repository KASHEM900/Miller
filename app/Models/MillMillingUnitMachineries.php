<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class MillMillingUnitMachineries
 *
 * @property int $miller_id
 * @property string $origin
 * @property string $pro_flowdiagram
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class MillMillingUnitMachineries extends Model
{
	use LogsActivity;

	protected $table = 'mill_milling_unit_machineries';
	protected $primaryKey = 'mill_milling_unit_machinery_id';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'mill_milling_unit_machinery_id' => 'int',
		'num' => 'int',
		'power' => 'float',
		'topower' => 'float',
		'horse_power' => 'float'
	];

	protected $fillable = [
		'machinery_id',
		'name',
		'brand',
		'manufacturer_country',
		'import_date',
		'join_type',
		'num',
		'power',
		'topower',
		'horse_power'
	];

	public function milling_unit_machinery()
	{
		return $this->belongsTo(MillingUnitMachinery::class, 'machinery_id','machinery_id');
	}
	
	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}
	
    protected static $logAttributes = ['*'];
}
