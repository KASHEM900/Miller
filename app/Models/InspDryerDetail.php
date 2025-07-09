<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class InspDryerDetail
 *
 * @property int $id
 * @property int $inspection_id
 *
 * @property Inspection $inspection
 *
 * @package App\Models
 */
class InspDryerDetail extends Model
{
	use LogsActivity;
	protected $table = 'insp_dryer_detail';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'inspection_id' => 'int',
		'dryer_id' => 'int',
	];

	protected $fillable = [
		'dryer_id',
		'dryer_detail_status',
		'dryer_detail_comment'
	];
	protected static $logAttributes = ['*'];
	public function inspection()
	{
		return $this->belongsTo(Inspection::class);
	}
    public function dryer_detail()
	{
		return $this->belongsTo(DryerDetail::class,'dryer_id');
	}
}
