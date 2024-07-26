<?php

namespace App\Models;

use App\Observers\ProductObserver;
use App\Services\Contracts\FileServiceContract;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Kyslik\ColumnSortable\Sortable;

/**
 * @mixin IdeHelperProduct
 */
#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'id',
        'slug',
        'title',
        'SKU',
        'description',
        'price',
        'discount',
        'quantity',
        'thumbnail',
        'created_at',
        'updated_at'
    ];

    public $sortable = [
        'id',
        'title',
        'SKU',
        'price',
        'quantity',
        'discount',
        'created_at',
        'updated_at'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function setThumbnailAttribute($image)
    {
        $fileService = app(FileServiceContract::class);

        if (! empty($this->attributes['thumbnail'])) {
            $fileService->remove($this->attributes['thumbnail']);
        }

        $this->attributes['thumbnail'] = $fileService->upload(
            $image,
            $this->images_dir
        );
    }

    public function imagesDir(): Attribute
    {
        return Attribute::get(fn () => 'products/' . $this->attributes['slug']);
    }

    public function thumbnailUrl(): Attribute
    {
        return Attribute::get(fn () => Storage::url($this->attributes['thumbnail']));
    }
}
