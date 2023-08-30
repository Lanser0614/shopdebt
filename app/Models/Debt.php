<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'client_id',
        'comment',
        'amount',
        'deadline'
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'debt_products', 'debt_id', 'product_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
