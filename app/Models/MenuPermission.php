<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * Class MenuPermission
 * 
 * @property int $menu_id
 * @property int $user_type_id
 * @property bool $is_allow
 * @property int $id
 *
 * @package App\Models
 */
class MenuPermission extends Model
{
	use LogsActivity;
	protected $table = 'menu_permission';
	public $timestamps = false;

	protected $casts = [
		'menu_id' => 'int',
		'user_type_id' => 'int',
		'is_allow' => 'bool'
	];

	protected $fillable = [
		'menu_id',
		'user_type_id',
		'is_allow'
	];

	public function menu()
	{
		return $this->belongsTo(Menu::class, 'menu_id');
	}
	protected static $logAttributes = ['*'];
}
