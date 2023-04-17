<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property integer $id
 * @property string $name
 * @property integer $quantity
 * @property integer $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'price',
    ];

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
