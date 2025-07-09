<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;
use App\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class Miller
 *
 * @property int $miller_id
 * @property string $mill_name
 * @property string $mill_address
 * @property int $mill_upazila_id
 * @property string $owner_name
 * @property string $owner_address
 * @property string $miller_birth_place
 * @property string $miller_nationality 
 * @property string $miller_religion
 * @property int $district_id
 * @property int $division_id
 * @property int $chal_type_id
 * @property int $mill_type_id
 * @property string $license_no
 * @property Carbon $date_license
 * @property Carbon $date_renewal
 * @property Carbon $date_last_renewal
 * @property string $is_electricity
 * @property string $meter_no
 * @property Carbon $last_billing_month
 * @property string $min_load_capacity
 * @property string $max_load_capacity
 * @property string $paid_avg_bill
 * @property int $boiller_num
 * @property string $is_safty_vulve
 * @property string $is_presser_machine
 * @property int $chimney_height
 * @property int $chatal_num
 * @property int $steeping_house_num
 * @property int $godown_num
 * @property int $motor_num
 * @property string $is_rubber_solar
 * @property int $boiler_num
 * @property int $dryer_num
 * @property float $sheller_paddy_seperator_output
 * @property float $whitener_grader_output
 * @property float $colour_sorter_output
 * @property float $milling_unit_comment
 * @property float $millar_p_power
 * @property float $millar_p_power_chal
 * @property int $u_id
 * @property int $cmp_status
 * @property int $approver_silo_user_id
 * @property Carbon $approver_silo_user_date
 * @property int $approver_rc_user_id
 * @property Carbon $approver_rc_user_date
 * @property int $approver_dc_user_id
 * @property Carbon $approver_dc_user_date
 * @property int $approver_mms_user_id
 * @property Carbon $approver_mms_user_date
 *
 * @property AreasAndPower $areas_and_power
 * @property AutometicMiller $autometic_miller
 * @property AutometicMillerNew $autometic_miller_new
 * @property Collection|Inspection[] $inspections
 * @property Collection|ChatalDetail[] $chatal_details
 * @property Collection|GodownDetail[] $godown_details
 * @property Collection|MotorDetail[] $motor_details
 * @property Collection|SteepingHouseDetail[] $steeping_house_details
 * @property Collection|BoilerDetail[] $boiler_details
 * @property Collection|DryerDetail[] $dryer_details
 * @property Collection|SiloDetail[] $silo_details
 *
 * @package App\Models
 */
class Miller extends Model
{
	use Sortable;
    use LogsActivity;

	protected $table = 'miller';
	protected $primaryKey = 'miller_id';
	public $timestamps = false;

	protected $casts = [
        'corporate_institute_id' => 'int',
		'mill_upazila_id' => 'int',
		'district_id' => 'int',
		'miller_birth_place' => 'int',
		'division_id' => 'int',
		'chal_type_id' => 'int',
        'mill_type_id' => 'int',
		'changed_mill_type' => 'boolean',
        'license_fee_id' => 'int',
		'boiller_num' => 'int',
		'chimney_height' => 'int',
		'chatal_num' => 'int',
		'steeping_house_num' => 'int',
		'godown_num' => 'int',
		'motor_num' => 'int',
		'boiler_num' => 'int',
		'dryer_num' => 'int',
		'sheller_paddy_seperator_output' => 'float',
		'whitener_grader_output' => 'float',
		'colour_sorter_output' => 'float',
		'millar_p_power' => 'float',
		'millar_p_power_chal' => 'float',
		'u_id' => 'int',
		'cmp_status' => 'int',
		'approver_silo_user_id' => 'int',
		'approver_rc_user_id' => 'int',
		'approver_dc_user_id' => 'int',
		'approver_mms_user_id' => 'int',
		'form_no' => 'int'
	];

	protected $dates = [
		'birth_date',
		'date_license',
		'date_renewal',
		'date_last_renewal',
		'license_deposit_date',
		'last_billing_month',
		'approver_silo_user_date',
		'approver_rc_user_date',
		'approver_dc_user_date',
		'approver_mms_user_date'
	];

	protected $fillable = [
		'form_no',
		'owner_type',
        'corporate_institute_id',
		'mill_name',
		'mill_address',
		'mill_upazila_id',
		'owner_name',
		'father_name',
		'mother_name',
		'owner_name_english',
		'gender',
		'birth_date',
		'owner_address',
		'miller_birth_place',
		'miller_nationality',
		'miller_religion',
		'district_id',
		'division_id',
		'chal_type_id',
		'mill_type_id',
		'changed_mill_type',
		'license_no',
		'date_license',
		'date_renewal',
		'date_last_renewal',
		'license_fee_id',
		'license_deposit_amount',
		'license_deposit_date',
		'license_deposit_bank',
		'license_deposit_branch',
		'license_deposit_chalan_no',
		'license_deposit_chalan_image',
		'vat_file',
		'signature_file',
		'is_electricity',
		'meter_no',
		'last_billing_month',
		'min_load_capacity',
		'max_load_capacity',
		'paid_avg_bill',
		'boiller_num',
		'is_safty_vulve',
		'is_presser_machine',
		'chimney_height',
		'chatal_num',
		'steeping_house_num',
		'godown_num',
		'motor_num',
		'is_rubber_solar',
		'boiler_num',
		'dryer_num',
		'sheller_paddy_seperator_output',
		'whitener_grader_output',
		'colour_sorter_output',
		'milling_unit_comment',
		'millar_p_power',
		'millar_p_power_chal',
		'miller_p_power_approval_file',
		'u_id',
		'cmp_status',
		'miller_status',
		'mobile_no',
		'bank_account_no',
		'bank_account_name',
		'bank_name',
		'bank_branch_name',
		'nid_no',
		'photo_of_miller',
		'tax_file_of_miller',
		'license_file_of_miller',
		'electricity_file_of_miller',
		'pass_code',
        'miller_stage',
        'last_inactive_reason',
		'approver_silo_user_id',
		'approver_rc_user_id',
		'approver_dc_user_id',
		'approver_mms_user_id',
		'approver_silo_user_date',
		'approver_rc_user_date',
		'approver_dc_user_date',
		'approver_mms_user_date'
    ];

	public $sortable = [
		'form_no',
		'mill_name',
		'mill_upazila_id',
		'owner_name',
		'district_id',
		'division_id',
		'chal_type_id',
		'mill_type_id',
		'license_no',
		'millar_p_power',
		'cmp_status',
		'millar_p_power_chal'
	];

    protected static $logAttributes = ['*'];

	public function corporate_institute()
	{
		return $this->belongsTo(CorporateInstitute::class, 'corporate_institute_id');
	}

	public function license_fee()
	{
		return $this->belongsTo(LicenseFee::class, 'license_fee_id');
	}

	public function license_histories()
	{
		return $this->hasMany(LicenseHistory::class, 'miller_id','miller_id');
	}

	public function inspections()
	{
		return $this->hasMany(Inspection::class, 'miller_id','miller_id');
	}

	public function areas_and_power()
	{
		return $this->hasOne(AreasAndPower::class, 'miller_id','miller_id');
	}

	public function autometic_miller()
	{
		return $this->hasOne(AutometicMiller::class, 'miller_id','miller_id');
	}
	
	public function autometic_miller_new()
	{
		return $this->hasOne(AutometicMillerNew::class, 'miller_id','miller_id');
	}

	public function mill_boiler_machineries()
	{
		return $this->hasMany(MillBoilerMachineries::class, 'miller_id','miller_id');
	}

	public function mill_milling_unit_machineries()
	{
		return $this->hasMany(MillMillingUnitMachineries::class, 'miller_id','miller_id');
	}

	public function chatal_details()
	{
		return $this->hasMany(ChatalDetail::class, 'miller_id','miller_id');
	}

	public function silo_details()
	{
		return $this->hasMany(SiloDetail::class, 'miller_id','miller_id');
	}

	public function godown_details()
	{
		return $this->hasMany(GodownDetail::class, 'miller_id','miller_id');
	}

	public function motor_details()
	{
		return $this->hasMany(MotorDetail::class, 'miller_id','miller_id');
	}

	public function steeping_house_details()
	{
		return $this->hasMany(SteepingHouseDetail::class, 'miller_id','miller_id');
    }

	public function boiler_details()
	{
		return $this->hasMany(BoilerDetail::class, 'miller_id','miller_id');
    }

	public function dryer_details()
	{
		return $this->hasMany(DryerDetail::class, 'miller_id','miller_id');
    }

	public function upazilla()
	{
		return $this->belongsTo(Upazilla::class, 'mill_upazila_id')->withDefault();
    }

	public function district()
	{
		return $this->belongsTo(District::class, 'district_id');
    }
	
	public function district_bplace()
	{
		return $this->belongsTo(District::class, 'miller_birth_place');
    }

	public function division()
	{
		return $this->belongsTo(Division::class, 'division_id');
	}

    public function chaltype()
	{
		return $this->belongsTo(ChalType::class, 'chal_type_id');
    }

	public function milltype()
	{
		return $this->belongsTo(MillType::class, 'mill_type_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'u_id');
	}

	public function approver_silo_user()
	{
		return $this->belongsTo(User::class, 'approver_silo_user_id');
	}

	public function approver_rc_user()
	{
		return $this->belongsTo(User::class, 'approver_rc_user_id');
	}

	public function approver_dc_user()
	{
		return $this->belongsTo(User::class, 'approver_dc_user_id');
	}

	public function approver_mms_user()
	{
		return $this->belongsTo(User::class, 'approver_ms_user_id');
	}
}
