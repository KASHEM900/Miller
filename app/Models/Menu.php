<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class Menu
 * 
 * @property int $id
 * @property int $num
 * @property string $name
 * @property bool $is_sub_menu
 * @property int $is_sub_sub_menu
 *
 * @package App\Models
 */
class Menu extends Model
{
	use LogsActivity;
	protected $table = 'menu';
	public $timestamps = false;

	protected $casts = [
		'num' => 'int',
		'is_sub_menu' => 'bool',
		'is_sub_sub_menu' => 'bool',
		'data_level' => 'int'
	];

	protected $fillable = [
		'num',
		'name',
		'is_sub_menu',
		'is_sub_sub_menu',
		'data_level'
	];
	protected static $logAttributes = ['*'];
}
