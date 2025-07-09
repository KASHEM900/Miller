<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class InspBoilerDetail
 *
 * @property int $id
 * @property int $inspection_id
 *
 * @property Inspection $inspection
 *
 * @package App\Models
 */
class InspBoilerDetail extends Model
{
	use LogsActivity;
	protected $table = 'insp_boiler_detail';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'inspection_id' => 'int',
		'boiler_id' => 'int',
	];

	protected $fillable = [
		'boiler_id',
		'boiler_detail_status',
		'boiler_detail_comment'
	];
	protected static $logAttributes = ['*'];
	public function inspection()
	{
		return $this->belongsTo(Inspection::class);
	}
    public function boiler_detail()
	{
		return $this->belongsTo(BoilerDetail::class,'boiler_id');
	}
}
