<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Blog
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $user_id
 * @property int $file_id
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property File $file
 * @property User $user
 * @property Collection|Tag[] $tags
 * @property Collection|Link[] $links
 *
 * @package App\Models
 */
class Blog extends Model
{
	use SoftDeletes;
	protected $table = 'blogs';

	protected $casts = [
		'user_id' => 'int',
		'file_id' => 'int'
	];

	protected $fillable = [
		'title',
		'description',
		'user_id',
		'file_id'
	];

	public function file()
	{
		return $this->belongsTo(File::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class, 'blog_tags')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}

	public function links()
	{
		return $this->hasMany(Link::class);
	}
}
