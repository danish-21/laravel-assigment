<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $mobile
 * @property Carbon $dob
 * @property string $gender
 * @property int|null $profile_image
 * @property string $status
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Blog[] $blogs
 *
 * @package App\Models
 */


class User extends Authenticatable
{
    use HasFactory, Notifiable;

	use SoftDeletes;
    use HasApiTokens;
	protected $table = 'users';

	protected $casts = [
		'dob' => 'datetime',
        'profile_image' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'email',
		'password',
		'mobile',
		'dob',
		'gender',
		'profile_image',
		'status'
	];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }
    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
