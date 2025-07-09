<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class District
 *
 * @property int $id
 * @property int $miller_id
 * @property int $inspection_by
 *
 * @property InspMiller $areas_and_power
 * @property InspAutometicMiller $autometic_miller
 * @property Collection|InspChatalDetail[] $chatal_details
 * @property Collection|InspGodownDetail[] $godown_details
 * @property Collection|InspBoilerDetail[] $boiler_details
 * @property Collection|InspDryerDetail[] $dryer_details
 * @property Collection|InspMotorDetail[] $motor_details
 * @property Collection|InspSteepingHouseDetail[] $steeping_house_details
 *
 * @property Inspection $division
 * @property Collection|Upazilla[] $upazillas
 *
 * @package App\Models
 */
class Inspection extends Model
{
	use LogsActivity;
    use Sortable;

    protected $table = 'inspection';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'miller_id' => 'int',
		'inspection_by' => 'int',
		'inspection_period_id' => 'int',
		'blacklisted_period' => 'float'
	];

	protected $fillable = [
		'miller_id',
		'inspection_date',
		'inspection_by',
		'inspection_status',
        'inactive_reason',
		'inspection_comment',
		'approval_status',
		'not_approved_comment',
		'approved_by',
		'approval_date',
        'inspection_period_id',
        'inspection_document',
		'cause_of_inspection',
		'blacklisted_period'
    ];

    public function insp_miller()
	{
		return $this->hasOne(InspMiller::class, 'inspection_id','id');
	}

	public function insp_autometic_miller()
	{
		return $this->hasOne(InspAutometicMiller::class, 'inspection_id','id');
	}

	public function insp_chatal_details()
	{
		return $this->hasMany(InspChatalDetail::class, 'inspection_id','id');
	}

	public function insp_godown_details()
	{
		return $this->hasMany(InspGodownDetail::class, 'inspection_id','id');
	}

	public function insp_boiler_details()
	{
		return $this->hasMany(InspBoilerDetail::class, 'inspection_id','id');
	}

	public function insp_dryer_details()
	{
		return $this->hasMany(InspDryerDetail::class, 'inspection_id','id');
	}

	public function insp_mill_boiler_machineries()
	{
		return $this->hasMany(InspMillBoilerMachineries::class, 'inspection_id','id');
	}

	public function insp_mill_milling_unit_machineries()
	{
		return $this->hasMany(InspMillMillingUnitMachineries::class, 'inspection_id','id');
	}

	public function insp_motor_details()
	{
		return $this->hasMany(InspMotorDetail::class, 'inspection_id','id');
	}

	public function insp_steeping_house_details()
	{
		return $this->hasMany(InspSteepingHouseDetail::class, 'inspection_id','id');
    }

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}

	public function inspection_period()
	{
		return $this->belongsTo(Inspection_period::class, 'id');
	}
	protected static $logAttributes = ['*'];
}
