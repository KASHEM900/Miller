<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class AutometicMillerNew
 *
 * @property int $miller_id
 * @property string $origin
 * @property string $pro_flowdiagram
 *
 * @property Miller $miller
 *
 * @package App\Models
 */
class AutometicMillerNew extends Model
{
	use LogsActivity;

	protected $table = 'autometic_miller_new';
	protected $primaryKey = 'miller_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'miller_id' => 'int'
	];

	protected $fillable = [
		'origin',
		'pro_flowdiagram',
		'milling_parts_manufacturer',
		'milling_parts_manufacturer_type',
		'parameter1_name',
		'parameter1_brand',
		'parameter1_manufacturer_country',
		'parameter1_import_date',
		'parameter1_join_type',
		'parameter1_num',
		'parameter1_power',
		'parameter1_topower',
		'parameter1_horse_power',
		'parameter2_name',
		'parameter2_brand',
		'parameter2_manufacturer_country',
		'parameter2_import_date',
		'parameter2_join_type',
		'parameter2_num',
		'parameter2_power',
		'parameter2_topower',
		'parameter2_horse_power',
		'parameter3_name',
		'parameter3_brand',
		'parameter3_manufacturer_country',
		'parameter3_import_date',
		'parameter3_join_type',
		'parameter3_num',
		'parameter3_power',
		'parameter3_topower',
		'parameter3_horse_power',
		'parameter4_name',
		'parameter4_brand',
		'parameter4_manufacturer_country',
		'parameter4_import_date',
		'parameter4_join_type',
		'parameter4_num',
		'parameter4_power',
		'parameter4_topower',
		'parameter4_horse_power',
		'parameter5_name',
		'parameter5_brand',
		'parameter5_manufacturer_country',
		'parameter5_import_date',
		'parameter5_join_type',
		'parameter5_num',
		'parameter5_power',
		'parameter5_topower',
		'parameter5_horse_power',
		'parameter6_name',
		'parameter6_brand',
		'parameter6_manufacturer_country',
		'parameter6_import_date',
		'parameter6_join_type',
		'parameter6_num',
		'parameter6_power',
		'parameter6_topower',
		'parameter6_horse_power',
		'parameter7_name',
		'parameter7_brand',
		'parameter7_manufacturer_country',
		'parameter7_import_date',
		'parameter7_join_type',
		'parameter7_num',
		'parameter7_power',
		'parameter7_topower',
		'parameter7_horse_power',
		'parameter8_name',
		'parameter8_brand',
		'parameter8_manufacturer_country',
		'parameter8_import_date',
		'parameter8_join_type',
		'parameter8_num',
		'parameter8_power',
		'parameter8_topower',
		'parameter8_horse_power',
		'parameter9_name',
		'parameter9_brand',
		'parameter9_manufacturer_country',
		'parameter9_import_date',
		'parameter9_join_type',
		'parameter9_num',
		'parameter9_power',
		'parameter9_topower',
		'parameter9_horse_power',
		'parameter10_name',
		'parameter10_brand',
		'parameter10_manufacturer_country',
		'parameter10_import_date',
		'parameter10_join_type',
		'parameter10_num',
		'parameter10_power',
		'parameter10_topower',
		'parameter10_horse_power'
	];

	public function miller()
	{
		return $this->belongsTo(Miller::class, 'miller_id','miller_id');
	}
	
    protected static $logAttributes = ['*'];
}
