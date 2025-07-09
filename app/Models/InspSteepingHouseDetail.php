<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class InspSteepingHouseDetail
 *
 * @property int $id
 * @property int $inspection_id
 *
 * @property Inspection $inspection
 *
 * @package App\Models
 */
class InspSteepingHouseDetail extends Model
{
	use LogsActivity;
	protected $table = 'insp_steeping_house_detail';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'inspection_id' => 'int',
		'steeping_house_id' => 'int',
	];

	protected $fillable = [
		'steeping_house_id',
		'steeping_house_long_status',
		'steeping_house_wide_status',
		'steeping_house_height_status',
		'steeping_house_long_comment',
		'steeping_house_wide_comment',
		'steeping_house_height_comment'
	];
	protected static $logAttributes = ['*'];
	public function inspection()
	{
		return $this->belongsTo(Inspection::class);
	}
    public function steeping_house_detail()
	{
		return $this->belongsTo(SteepingHouseDetail::class,'steeping_house_id');
	}
}
