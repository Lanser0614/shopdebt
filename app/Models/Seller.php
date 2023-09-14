<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'label',
        'activation_code',
        'is_activated'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shop():BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
