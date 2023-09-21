<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
        'user_id',
        'client_id',
        'comment',
        'amount',
        'deadline'
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function seller(): HasOne
    {
        return $this->hasOne(Seller::class);
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'debt_products', 'debt_id', 'product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $query, array $params)
    {
        $query->where(function (Builder $q) use ($params){
            $q->when(isset($params['user_id']), function (Builder $q) use ($params){
                $q->where('user_id', $params['user_id']);
            });

            $q->when(isset($params['shop_id']), function (Builder $q) use ($params){
               $q->where('shop_id', $params['shop_id']);
            });

            $q->when(isset($params['client_id']), function (Builder $q) use ($params){
               $q->where('client_id', $params['client_id']);
            });

            $q->when(isset($params['amount']), function (Builder $q) use ($params){
               $q->where('amount', $params['amount']);
            });

            $q->when(isset($params['deadline']), function (Builder $q) use ($params){
                $date = Carbon::make($params['deadline']);
               $q->where('deadline', $date);
            });
        });
    }
}
