<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'phone_number',
        'address'
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'contact_clients');
    }

    public function scopeSearch(Builder $query, array $params)
    {
        $query->where(function (Builder $q) use ($params){
           $q->when(isset($params['shop_id']), function (Builder $q) use ($params){
              $q->where('shop_id', $params['shop_id']);
           });
           $q->when(isset($params['name']), function (Builder $q) use ($params){
              $q->where('name', $params['name']);
           });
           $q->when(isset($params['phone_number']), function (Builder $q) use ($params){
              $q->where('phone_number', $params['phone_number']);
           });
        });
    }
}
