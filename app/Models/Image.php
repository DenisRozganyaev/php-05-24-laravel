<?php

namespace App\Models;

use App\Services\Contracts\FileServiceContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperImage
 */
class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'path',
        'imageable_id',
        'imageable_type',
        'created_at',
        'updated_at'
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
}
