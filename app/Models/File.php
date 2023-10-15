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
 * Class File
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Blog[] $blogs
 *
 * @package App\Models
 */
class File extends Model
{
    use SoftDeletes;
    protected $table = 'files';
    protected $appends = ['url'];


    public function getUrlAttribute()
    {
        $type = config('file')['types'][$this->type];
        $acl = $type['acl'] ?? 'public';
        if ($this->local_path) {
            return url($this->local_path);
        }
        return $acl === 'public';
    }
    const TYPE_PROFILE_IMAGE = "PROFILE";
    const TYPE_BLOG_IMAGE = "BLOG";


    protected $fillable = [
        'name',
        's3_key',
        'local_path',
        'type'
    ];

	public function blogs()
	{
		return $this->hasMany(Blog::class);
	}
}
