<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    protected $casts = [
        'name' => OrderStatusEnum::class,
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('name', OrderStatusEnum::InProcess->value);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('name', OrderStatusEnum::Paid->value);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('name', OrderStatusEnum::Completed->value);
    }

    public function scopeCanceled(Builder $query): Builder
    {
        return $query->where('name', OrderStatusEnum::Canceled->value);
    }
}
