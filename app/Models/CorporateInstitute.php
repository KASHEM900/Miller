<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class corporate_institute
 *
 * @property int $id
 * @property string $name
 * @property string $address
 *
 * @package App\Models
 */
class CorporateInstitute extends Model
{
    use LogsActivity;

	protected $table = 'corporate_institute';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'name',
		'address'
    ];

    protected static $logAttributes = ['*'];

}
