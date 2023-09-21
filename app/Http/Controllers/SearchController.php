<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function main_search(Request $request)
    {
        $params = $request->all();
        if ($request->has('user_id')){
            $query1 = [];
        }else{
            $query1 = Client::query()->where(function ($q) use ($params){

                $q->when(isset($params['shop_id']), function ($q) use ($params){
                    $q->where('shop_id', $params['shop_id']);
                });

                $q->when(isset($params['name']), function ($q) use ($params){
                    $q->where('name', $params['name']);
                });

                $q->when(isset($params['phone_number']), function ($q) use ($params){
                    $q->where('phone_number', $params['phone_number']);
                });
            })->get()->toArray();
        }

            if ($request->has('shop_id')){
                $query2 = [];
            }else{
                $query2 = Contact::query()->where(function ($q) use ($params){

                    $q->when(isset($params['user_id']), function ($q) use ($params){
                        $q->where('user_id', $params['user_id']);
                    });

                    $q->when(isset($params['name']), function ($q) use ($params){
                        $q->where('first_name', 'like', $params['name'])
                            ->orwhere('last_name', 'like', $params['name']);
                    });

                    $q->when(isset($params['phone_number']), function ($q) use ($params){
                        $q->where('phone_number', $params['phone_number']);
                    });
                })->get()->toArray();
            }

        $collection = array_merge($query1, $query2);

        return response([
            'data' => $collection,
            'message' => 'Search results by params',
            'success' => true
        ]);
    }
}
