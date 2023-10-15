<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogTag
 * 
 * @property int $id
 * @property int $blog_id
 * @property int $tag_id
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Blog $blog
 * @property Tag $tag
 *
 * @package App\Models
 */
class BlogTag extends Model
{
	use SoftDeletes;
	protected $table = 'blog_tags';

	protected $casts = [
		'blog_id' => 'int',
		'tag_id' => 'int'
	];

	protected $fillable = [
		'blog_id',
		'tag_id'
	];

	public function blog()
	{
		return $this->belongsTo(Blog::class);
	}

	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}
}
