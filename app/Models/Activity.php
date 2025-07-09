<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 *
 * @property int $divid
 * @property string $divname
 *
 * @property Collection|District[] $districts
 *
 * @package App\Models
 */
class Activity extends Model
{
	protected $table = 'activity_log';
	protected $primaryKey = 'id';

	protected $casts = [
		'subject_id' => 'int',
		'causer_id' => 'int'
	];

	protected $fillable = [
    ];

	public function user()
	{
		return $this->belongsTo(\App\User::class, 'causer_id');
	}
}
