<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Client\Request;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'company',
        'phone_number'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'contact_clients', 'contact_id', 'client_id');
    }

    public function scopeSearch(Builder $query, array $params)
    {
        $query->where(function (Builder $q) use ($params){
           $q->when(isset($params['user_id']), function (Builder $q) use ($params){
               $q->where('user_id', $params['user_id']);
           });

           $q->when(isset($params['first_name']), function (Builder $q) use ($params){
               $q->where('first_name', $params['first_name']);
           });

           $q->when(isset($params['last_name']), function (Builder $q) use ($params){
               $q->where('last_name', $params['last_name']);
           });

           $q->when(isset($params['company']), function (Builder $q) use ($params){
               $q->where('company', $params['company']);
           });

           $q->when(isset($params['phone_number']), function (Builder $q) use ($params){
               $q->where('phone_number', $params['phone_number']);
           });
        });
    }
}
