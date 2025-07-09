<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class Miller
 *
 * @property int $inspection_id
 *
 * @package App\Models
 */
class InspMiller extends Model
{
	use Sortable;
    use LogsActivity;

	protected $table = 'insp_miller';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
	];

	protected $dates = [
	];

	protected $fillable = [
		'owner_type_status',
		'owner_type_comment',
		'corporate_institute_id_status',
		'corporate_institute_id_comment',
		'mill_name_status',
		'mill_name_comment',
		'mill_address_status',
		'mill_address_comment',
		'owner_name_status',
		'owner_name_comment',
		'owner_address_status',
		'chal_type_id_status',
		'mill_type_id_status',
		'license_no_status',
		'date_license_status',
		'date_renewal_status',
        'date_last_renewal_status',
		'is_electricity_status',
		'meter_no_status',
		'last_billing_month_status',
		'min_load_capacity_status',
		'max_load_capacity_status',
		'paid_avg_bill_status',
		'boiller_num_status',
		'boiller_num_comment',
		'is_safty_vulve_status',
		'is_safty_vulve_comment',
		'chimney_height_status',
		'chimney_height_comment',
		'is_presser_machine_status',
		'is_presser_machine_comment',
		'chatal_num_status',
		'chatal_num_comment',
		'steeping_house_num_status',
		'steeping_house_num_comment',
		'motor_num_status',
		'motor_num_comment',
		'godown_num_status',
		'godown_num_comment',
		'is_rubber_solar_status',
		'is_rubber_solar_comment',
		'boiler_num_status',
		'boiler_num_comment',
		'dryer_num_status',
		'dryer_num_comment',
		'sheller_paddy_seperator_output_status',
		'sheller_paddy_seperator_output_comment',
		'whitener_grader_output_status',
		'whitener_grader_output_comment',
		'colour_sorter_output_status',
		'colour_sorter_output_comment',
		'millar_p_power_status',
		'millar_p_power_comment',
		'mobile_no_status',
		'bank_account_no_status',
		'nid_no_status',
		'photo_of_miller_status',
		'tax_file_of_miller_status',
		'license_file_of_miller_status',
        'electricity_file_of_miller_status',
		'owner_address_comment',
		'chal_type_id_comment',
		'mill_type_id_comment',
		'license_no_comment',
		'date_license_comment',
		'date_renewal_comment',
        'date_last_renewal_comment',
		'is_electricity_comment',
		'meter_no_comment',
		'last_billing_month_comment',
		'min_load_capacity_comment',
		'max_load_capacity_comment',
		'paid_avg_bill_comment',
		'mobile_no_comment',
		'bank_account_no_comment',
		'nid_no_comment',
		'photo_of_miller_comment',
		'tax_file_of_miller_comment',
		'license_file_of_miller_comment',
		'electricity_file_of_miller_comment',
		'miller_birth_place_status',
		'miller_birth_place_comment',
		'miller_nationality_status',
		'miller_nationality_comment',
		'miller_religion_status',
		'miller_religion_comment'
	];

	public $sortable = [
	];

    protected static $logAttributes = ['*'];

	public function inspection()
	{
		return $this->belongsTo(Inspection::class);
	}
}
