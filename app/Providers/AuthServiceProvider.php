<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Client;
use App\Models\Debt;
use App\Models\Seller;
use App\Models\Shop;
use App\Policies\ClientPolicy;
use App\Policies\DebtPolicy;
use App\Policies\SellerPolicy;
use App\Policies\ShopPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Shop::class => ShopPolicy::class,
        Seller::class => SellerPolicy::class,
        Client::class => ClientPolicy::class,
        Debt::class => DebtPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
