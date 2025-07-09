<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class District
 *
 * @property int $distid
 * @property string $distname
 * @property int $divid
 *
 * @property Division $division
 * @property Collection|Upazilla[] $upazillas
 *
 * @package App\Models
 */
class District extends Model
{
	use LogsActivity;

	protected $table = 'district';
	protected $primaryKey = 'distid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'distid' => 'int',
		'divid' => 'int'
	];

	protected $fillable = [
		'name',
		'distname',
		'divid'
	];

	public function division()
	{
		return $this->belongsTo(Division::class, 'divid');
	}

	public function upazillas()
	{
		return $this->hasMany(Upazilla::class, 'distid');
	}


    protected static $logAttributes = ['*'];
}
