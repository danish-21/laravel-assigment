<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Link
 * 
 * @property int $id
 * @property int|null $blog_id
 * @property string|null $title
 * @property string|null $url
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Blog|null $blog
 *
 * @package App\Models
 */
class Link extends Model
{
	use SoftDeletes;
	protected $table = 'links';

	protected $casts = [
		'blog_id' => 'int'
	];

	protected $fillable = [
		'blog_id',
		'title',
		'url'
	];

	public function blog()
	{
		return $this->belongsTo(Blog::class);
	}
}
