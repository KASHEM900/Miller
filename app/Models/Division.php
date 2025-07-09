<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class Division
 *
 * @property int $divid
 * @property string $divname
 *
 * @property Collection|District[] $districts
 *
 * @package App\Models
 */
class Division extends Model
{
    use LogsActivity;

	protected $table = 'division';
	protected $primaryKey = 'divid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'divid' => 'int'
	];

	protected $fillable = [
		'name',
        'divid',
        'divname'
    ];

    protected static $logAttributes = ['*'];

	public function districts()
	{
		return $this->hasMany(District::class, 'divid');
	}
}
