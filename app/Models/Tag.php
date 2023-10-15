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
 * Class Tag
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Blog[] $blogs
 *
 * @package App\Models
 */
class Tag extends Model
{
	use SoftDeletes;
	protected $table = 'tags';

	protected $fillable = [
		'name'
	];

	public function blogs()
	{
		return $this->belongsToMany(Blog::class, 'blog_tags')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}
}
