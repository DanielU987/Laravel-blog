<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Eloquent;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $snippet
 * @property-read Collection|Image[] $images
 * @property-read int|null $images_count
 * @method static PostFactory factory(...$parameters)
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereBody($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Post extends Model
{
    use HasFactory;

    public $image = null;
    protected $fillable = ['title', 'body'];

    public function getSnippetAttribute()
    {
        return substr($this->body, 0, 200) . '...';
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function image(): Attribute
    {
        return Attribute::set(function ($image) {
            /**@var UploadedFile $image */
            $image->store();
        }
        );
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function authHasLiked(): Attribute
    {
        return Attribute::get(function () {
            return $this->likes()->where('user_id', Auth::user()->id)->exists();
        });
    }

    public function Likes()
    {
        return $this->hasMany(Like::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}
