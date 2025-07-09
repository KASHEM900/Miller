<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class InspAutometicMiller
 *
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class InspAutometicMiller extends Model
{
	use LogsActivity;
	protected $table = 'insp_autometic_miller';
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'inspection_id' => 'int'
	];

	protected $dates = [
	];

	protected $fillable = [
		'origin_status',
		'visited_date_status',
		'pro_flowdiagram_status',
		'machineries_a_status',
		'machineries_b_status',
		'machineries_c_status',
		'machineries_d_status',
		'machineries_e_status',
		'machineries_f_status',
		'parameter1_name_status',
		'parameter1_num_status',
		'parameter1_power_status',
		'parameter1_topower_status',
		'parameter2_name_status',
		'parameter2_num_status',
		'parameter2_power_status',
		'parameter2_topower_status',
		'parameter3_name_status',
		'parameter3_num_status',
		'parameter3_power_status',
		'parameter3_topower_status',
		'parameter4_name_status',
		'parameter4_num_status',
		'parameter4_power_status',
		'parameter4_topower_status',
		'parameter5_name_status',
		'parameter5_num_status',
		'parameter5_power_status',
		'parameter5_topower_status',
		'parameter6_name_status',
		'parameter6_num_status',
		'parameter6_power_status',
		'parameter6_topower_status',
		'parameter7_name_status',
		'parameter7_num_status',
		'parameter7_power_status',
		'parameter7_topower_status',
		'parameter8_name_status',
		'parameter8_num_status',
		'parameter8_power_status',
		'parameter8_topower_status',
		'parameter9_name_status',
		'parameter9_num_status',
		'parameter9_power_status',
		'parameter9_topower_status',
		'parameter10_name_status',
		'parameter10_num_status',
		'parameter10_power_status',
		'parameter10_topower_status',
		'parameter11_name_status',
		'parameter11_num_status',
		'parameter11_power_status',
		'parameter11_topower_status',
		'parameter12_name_status',
		'parameter12_num_status',
		'parameter12_power_status',
		'parameter12_topower_status',
		'parameter13_name_status',
		'parameter13_num_status',
		'parameter13_power_status',
		'parameter13_topower_status',
		'parameter14_name_status',
		'parameter14_num_status',
		'parameter14_power_status',
		'parameter14_topower_status',
		'parameter15_name_status',
		'parameter15_num_status',
		'parameter15_power_status',
		'parameter15_topower_status',
		'parameter16_name_status',
		'parameter16_num_status',
		'parameter16_power_status',
		'parameter16_topower_status',
		'parameter17_name_status',
		'parameter17_num_status',
		'parameter17_power_status',
		'parameter17_topower_status',
		'parameter18_name_status',
		'parameter18_num_status',
		'parameter18_power_status',
		'parameter18_topower_status',
		'parameter19_name_status',
        'parameter19_topower_status',
		'origin_comment',
		'visited_date_comment',
		'pro_flowdiagram_comment',
		'machineries_a_comment',
		'machineries_b_comment',
		'machineries_c_comment',
		'machineries_d_comment',
		'machineries_e_comment',
		'machineries_f_comment',
		'parameter1_name_comment',
		'parameter1_num_comment',
		'parameter1_power_comment',
		'parameter1_topower_comment',
		'parameter2_name_comment',
		'parameter2_num_comment',
		'parameter2_power_comment',
		'parameter2_topower_comment',
		'parameter3_name_comment',
		'parameter3_num_comment',
		'parameter3_power_comment',
		'parameter3_topower_comment',
		'parameter4_name_comment',
		'parameter4_num_comment',
		'parameter4_power_comment',
		'parameter4_topower_comment',
		'parameter5_name_comment',
		'parameter5_num_comment',
		'parameter5_power_comment',
		'parameter5_topower_comment',
		'parameter6_name_comment',
		'parameter6_num_comment',
		'parameter6_power_comment',
		'parameter6_topower_comment',
		'parameter7_name_comment',
		'parameter7_num_comment',
		'parameter7_power_comment',
		'parameter7_topower_comment',
		'parameter8_name_comment',
		'parameter8_num_comment',
		'parameter8_power_comment',
		'parameter8_topower_comment',
		'parameter9_name_comment',
		'parameter9_num_comment',
		'parameter9_power_comment',
		'parameter9_topower_comment',
		'parameter10_name_comment',
		'parameter10_num_comment',
		'parameter10_power_comment',
		'parameter10_topower_comment',
		'parameter11_name_comment',
		'parameter11_num_comment',
		'parameter11_power_comment',
		'parameter11_topower_comment',
		'parameter12_name_comment',
		'parameter12_num_comment',
		'parameter12_power_comment',
		'parameter12_topower_comment',
		'parameter13_name_comment',
		'parameter13_num_comment',
		'parameter13_power_comment',
		'parameter13_topower_comment',
		'parameter14_name_comment',
		'parameter14_num_comment',
		'parameter14_power_comment',
		'parameter14_topower_comment',
		'parameter15_name_comment',
		'parameter15_num_comment',
		'parameter15_power_comment',
		'parameter15_topower_comment',
		'parameter16_name_comment',
		'parameter16_num_comment',
		'parameter16_power_comment',
		'parameter16_topower_comment',
		'parameter17_name_comment',
		'parameter17_num_comment',
		'parameter17_power_comment',
		'parameter17_topower_comment',
		'parameter18_name_comment',
		'parameter18_num_comment',
		'parameter18_power_comment',
		'parameter18_topower_comment',
		'parameter19_name_comment',
		'parameter19_topower_comment'
	];

	public function inspection()
	{
		return $this->belongsTo(Inspection::class);
	}
	protected static $logAttributes = ['*'];
}
