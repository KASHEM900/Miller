<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserEvent;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\UserType;
use Spatie\Activitylog\Traits\LogsActivity;
use Kyslik\ColumnSortable\Sortable;
/**
 * Class User
 *
 * @property int $a_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int $division_id
 * @property int $district_id
 * @property int $upazila_id
 * @property int $user_type
 * @property int $signature_file
 * @property int $active_status
 * @property string $allowed_divisions
 *
 * @property Collection|UserEvent[] $user_events
 */
class User extends Authenticatable
{
    use Sortable;
    use LogsActivity;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
		'division_id',
		'district_id',
		'upazila_id',
		'user_type',
        'signature_file',
        'active_status',
        'current_office_id',
        'allowed_divisions'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'division_id' => 'int',
		'district_id' => 'int',
		'upazila_id' => 'int',
		'user_type' => 'int',
		'active_status' => 'int'
    ];

    // public static function uploadAvatar($image)
    // {
    //     $filename = $image->getClientOriginalName();
    //     (new self())->deleteOldImage();
    //     $image->storeAs('images', $filename, 'public');
    //     auth()->user()->update(['avatar' => $filename]);
    // }

    // protected function deleteOldImage()
    // {
    //     if ($this->avatar) {
    //         Storage::delete('/public/images/' . $this->avatar);
    //     }
    // }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function user_events()
	{
		return $this->hasMany(UserEvent::class, 'a_id');
    }

    public function getDivisionNameAttribute()
	{
        if($this->division_id>0){
            return Division::where('divid', $this->division_id)->first()->divname;
        }else{
            return "ALL";
        }
	}

    public function getDistrictNameAttribute()
	{
        if($this->district_id>0){
            return District::where('distid', $this->district_id)->first()->distname;
        }else{
            return "ALL";
        }
	}

    public function getUpazillaNameAttribute()
	{
        if($this->upazila_id>0){
            return Upazilla::where('upazillaid', $this->upazila_id)->first()->upazillaname;
        }else{
            return "ALL";
        }
    }

    public function getUserNameAttribute()
    {
         if($this->id>0){
             return User::where('id', $this->id)->first()->username;
         }else{
             return "ALL";
         }
    }

    public function getUserStatusAttribute()
	{
        $userStatus=$this->active_status;
        if($userStatus==1){
            return "একটিভ";
        }else {
            return "ইন-একটিভ";
        }
    }
    
    public function getAllowedDivisionListAttribute()
	{
        if($allowed_divisions){
            return explode(',', $allowed_divisions);
        }else {
            return [];
        }
    }

    public function setpasswordAttribute($value)
	{
        $this->attributes['password'] = md5($value);
    }

    public function upazilla()
    {
	    return $this->belongsTo(Upazilla::class, 'upazila_id');
    }
    public function district()
    {
	    return $this->belongsTo(District::class, 'district_id');
    }
    public function division()
    {
	    return $this->belongsTo(Division::class, 'division_id');
    }
    public function user()
    {
       return $this->belongsTo(User::class, 'id');
    }
    public function usertype()
    {
       return $this->belongsTo(UserType::class, 'user_type');
    }
    protected static $logAttributes = ['*'];
}
