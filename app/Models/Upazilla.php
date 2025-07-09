<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class Upazilla
 *
 * @property int $upazillaid
 * @property string $upazillaname
 * @property int $distid
 *
 * @property District $district
 *
 * @package App\Models
 */
class Upazilla extends Model
{
	use Sortable;
	use LogsActivity;
	protected $table = 'upazilla';
	protected $primaryKey = 'upazillaid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'upazillaid' => 'int',
        'distid' => 'int',
        'last_miller_sl' => 'int'
	];

	protected $fillable = [
		'name',
		'upazillaname',
        'distid',
        'last_miller_sl'
	];

	public function district()
	{
		return $this->belongsTo(District::class, 'distid');
	}
	protected static $logAttributes = ['*'];
}
