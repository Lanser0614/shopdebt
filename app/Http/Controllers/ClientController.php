<?php

namespace App\Http\Controllers;

use App\Constants\ResponseConstants\ClientResponseEnum;
use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Exception;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Client::class, 'client');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateClientRequest $request)
    {
        return $this->execute(function () use ($request){
            $validated = $request->validated();
           if (!auth()->user()->checkShopId($validated['shop_id'])){
               throw new Exception('Can\'t create');
           };
            $client = Client::query()->create($validated);
            return ClientResource::make($client->load('shop'));
        }, ClientResponseEnum::CLIENT_CREATE);
    }
    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return $this->execute(function () use ($client){
            return ClientResource::make($client->load('shop'));
        }, ClientResponseEnum::CLIENT_SHOW);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        return $this->execute(function () use ($request, $client){
            $validated = $request->validated();
            $client->update($validated);
            return ClientResource::make($client->load('shop'));
        }, ClientResponseEnum::CLIENT_UPDATE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        return $this->execute(function () use ($client){
            if (!$client->delete()){
                throw new Exception('Can\'t delete');
            }
        }, ClientResponseEnum::CLIENT_DELETE);
    }
}
