<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'birthdate',
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function wishes(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'wish_list',
            'user_id',
            'product_id'
        )->withPivot(['price', 'exist']);
    }

    public function addToWish(Product $product, string $type = 'price'): void
    {
        $wished = $this->wishes()->find($product); // row from wish_list
        if ($wished) {
            $this->wishes()->updateExistingPivot($wished, [$type => true]);
        } else {
            $this->wishes()->attach($product, [$type => true]);
        }
    }

    public function removeFromWish(Product $product, string $type = 'price'): void
    {
        $this->wishes()->updateExistingPivot($product, [$type => false]);
        $product = $this->wishes()->find($product);

        if (!$product->pivot->exist && !$product->pivot->price) {
            $this->wishes()->detach($product);
        }
    }

    public function isWishedProduct(Product $product, string $type = 'price'): bool
    {
        return $this->wishes()
            ->where('product_id', $product->id)
            ->wherePivot($type, true)
            ->exists();
    }
}
