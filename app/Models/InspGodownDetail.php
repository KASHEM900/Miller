<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class InspGodownDetail
 *
 * @property int $id
 * @property int $inspection_id
 *
 * @property Inspection $inspection
 *
 * @package App\Models
 */
class InspGodownDetail extends Model
{ 
	use LogsActivity;
	protected $table = 'insp_godown_detail';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'inspection_id' => 'int',
		'godown_id' => 'int',
	];

	protected $fillable = [
		'godown_id',
		'godown_long_status',
		'godown_wide_status',
		'godown_height_status',
		'godown_long_comment',
		'godown_wide_comment',
		'godown_height_comment'
	];

	public function inspection()
	{
		return $this->belongsTo(Inspection::class);
	}

    public function godown_detail()
	{
		return $this->belongsTo(GodownDetail::class,'godown_id');
	}
	protected static $logAttributes = ['*'];
}
