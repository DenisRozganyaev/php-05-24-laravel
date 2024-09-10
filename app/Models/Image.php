<?php

namespace App\Models;

use App\Observers\ImageObserver;
use App\Services\Contracts\FileServiceContract;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperImage
 */
#[ObservedBy([ImageObserver::class])]
class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'path',
        'imageable_id',
        'imageable_type',
        'created_at',
        'updated_at',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function setPathAttribute($path)
    {
        $this->attributes['path'] = app(FileServiceContract::class)->upload(
            $path['image'],
            $path['directory'] ?? null
        );
    }

    public function url(): Attribute
    {

        return Attribute::get(function() {
            $key = 'products.images.' . $this->attributes['path'];

            if (Storage::disk('public')->exists($this->path)) {
                return Storage::disk('public')->url($this->path);
            }

            if (! cache()->has($key)) {
                $temporaryUrl = Storage::temporaryUrl($this->attributes['path'], now()->addMinutes(10));
                cache()->put($key, $temporaryUrl, 590);
            }

            return cache()->get($key);
        });
    }
}
