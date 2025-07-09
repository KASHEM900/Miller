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
class Office extends Model
{
	use Sortable;
	use LogsActivity;

	protected $table = 'office';
	protected $primaryKey = 'office_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'division_id' => 'int',
		'district_id' => 'int',
		'upazilla_id' => 'int',
		'office_type_id' => 'int'
	];

	protected $fillable = [
		'office_name',
		'division_id',
		'office_address',
		'district_id',
		'upazilla_id',
		'office_type_id'
	];

	protected $sortable = [
		'office_name',
		'division_id',
		'office_address',
		'district_id',
		'upazilla_id',
		'office_type_id'
	];

	public function office_type()
	{
		return $this->belongsTo(Office_type::class, 'office_type_id');
	}

    public function upazilla()
    {		
	    return $this->belongsTo(Upazilla::class, 'upazilla_id');
	}
	
	public function district()
	{
		 return $this->belongsTo(District::class, 'district_id');
	}
	
	public function division()                                                               
	{
		 return $this->belongsTo(Division::class, 'division_id');
	}  
	protected static $logAttributes = ['*'];
}
