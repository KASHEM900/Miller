<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class InspChatalDetail
 *
 * @property int $id
 * @property int $inspection_id
 *
 * @property Inspection $inspection
 *
 * @package App\Models
 */
class InspChatalDetail extends Model
{
	use LogsActivity;
	protected $table = 'insp_chatal_detail';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'inspection_id' => 'int',
		'chatal_id' => 'int',
	];

	protected $fillable = [
		'chatal_id',
		'chatal_long_status',
		'chatal_wide_status',
		'chatal_long_comment',
		'chatal_wide_comment'
	];
	protected static $logAttributes = ['*'];
	public function inspection()
	{
		return $this->belongsTo(Inspection::class);
	}

    public function chatal_detail()
	{
		return $this->belongsTo(ChatalDetail::class,'chatal_id');
	}
}
