<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class AutometicMiller
 *
 * @property int $miller_id
 * @property string $origin
 * @property Carbon $visited_date
 * @property string $pro_flowdiagram
 * @property string $machineries_a
 * @property string $machineries_b
 * @property string $machineries_c
 * @property string $machineries_d
 * @property string $machineries_e
 * @property string $machineries_f
 * @property string $parameter1_name
 * @property string $parameter1_num
 * @property string $parameter1_power
 * @property string $parameter1_topower
 * @property string $parameter2_name
 * @property string $parameter2_num
 * @property string $parameter2_power
 * @property string $parameter2_topower
 * @property string $parameter3_name
 * @property string $parameter3_num
 * @property string $parameter3_power
 * @property string $parameter3_topower
 * @property string $parameter4_name
 * @property string $parameter4_num
 * @property string $parameter4_power
 * @property string $parameter4_topower
 * @property string $parameter5_name
 * @property string $parameter5_num
 * @property string $parameter5_power
 * @property string $parameter5_topower
 * @property string $parameter6_name
 * @property string $parameter6_num
 * @property string $parameter6_power
 * @property string $parameter6_topower
 * @property string $parameter7_name
 * @property string $parameter7_num
 * @property string $parameter7_power
 * @property string $parameter7_topower
 * @property string $parameter8_name
 * @property string $parameter8_num
 * @property string $parameter8_power
 * @property string $parameter8_topower
 * @property string $parameter9_name
 * @property string $parameter9_num
 * @property string $parameter9_power
 * @property string $parameter9_topower
 * @property string $parameter10_name
 * @property string $parameter10_num
 * @property string $parameter10_power
 * @property string $parameter10_topower
 * @property string $parameter11_name
 * @property string $parameter11_num
 * @property string $parameter11_power
 * @property string $parameter11_topower
 * @property string $parameter12_name
 * @property string $parameter12_num
 * @property string $parameter12_power
 * @property string $parameter12_topower
 * @property string $parameter13_name
 * @property string $parameter13_num
 * @property string $parameter13_power
 * @property string $parameter13_topower
 * @property string $parameter14_name
 * @property string $parameter14_num
 * @property string $parameter14_power
 * @property string $parameter14_topower
 * @property string $parameter15_name
 * @property string $parameter15_num
 * @property string $parameter15_power
 * @property string $parameter15_topower
 * @property string $parameter16_name
 * @property string $parameter16_num
 * @property string $parameter16_power
 * @property string $parameter16_topower
 * @property string $parameter17_name
 * @property string $parameter17_num
 * @property string $parameter17_power
 * @property string $parameter17_topower
 * @property string $parameter18_name
 * @property string $parameter18_num
 * @property string $parameter18_power
 * @property string $parameter18_topower
 * @property string $parameter19_name
 * @property string $parameter19_topower
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class AutometicMiller extends Model
{
	use LogsActivity;

	protected $table = 'autometic_miller';
	protected $primaryKey = 'miller_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'miller_id' => 'int'
	];

	protected $dates = [
		'visited_date'
	];

	protected $fillable = [
		'origin',
		'visited_date',
		'pro_flowdiagram',
		'machineries_a',
		'machineries_b',
		'machineries_c',
		'machineries_d',
		'machineries_e',
		'machineries_f',
		'parameter1_name',
		'parameter1_num',
		'parameter1_power',
		'parameter1_topower',
		'parameter2_name',
		'parameter2_num',
		'parameter2_power',
		'parameter2_topower',
		'parameter3_name',
		'parameter3_num',
		'parameter3_power',
		'parameter3_topower',
		'parameter4_name',
		'parameter4_num',
		'parameter4_power',
		'parameter4_topower',
		'parameter5_name',
		'parameter5_num',
		'parameter5_power',
		'parameter5_topower',
		'parameter6_name',
		'parameter6_num',
		'parameter6_power',
		'parameter6_topower',
		'parameter7_name',
		'parameter7_num',
		'parameter7_power',
		'parameter7_topower',
		'parameter8_name',
		'parameter8_num',
		'parameter8_power',
		'parameter8_topower',
		'parameter9_name',
		'parameter9_num',
		'parameter9_power',
		'parameter9_topower',
		'parameter10_name',
		'parameter10_num',
		'parameter10_power',
		'parameter10_topower',
		'parameter11_name',
		'parameter11_num',
		'parameter11_power',
		'parameter11_topower',
		'parameter12_name',
		'parameter12_num',
		'parameter12_power',
		'parameter12_topower',
		'parameter13_name',
		'parameter13_num',
		'parameter13_power',
		'parameter13_topower',
		'parameter14_name',
		'parameter14_num',
		'parameter14_power',
		'parameter14_topower',
		'parameter15_name',
		'parameter15_num',
		'parameter15_power',
		'parameter15_topower',
		'parameter16_name',
		'parameter16_num',
		'parameter16_power',
		'parameter16_topower',
		'parameter17_name',
		'parameter17_num',
		'parameter17_power',
		'parameter17_topower',
		'parameter18_name',
		'parameter18_num',
		'parameter18_power',
		'parameter18_topower',
		'parameter19_name',
		'parameter19_topower'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}
	
    protected static $logAttributes = ['*'];
}
