<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::factory(30)->create();

        foreach (Client::all() as $client){
            $contact = Contact::query()->inRandomOrder()->take(rand(1,2))->pluck('id');
            $client->contacts()->attach($contact);
        }
    }
}
