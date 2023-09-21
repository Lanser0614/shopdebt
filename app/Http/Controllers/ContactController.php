<?php

namespace App\Http\Controllers;

use App\Constants\ResponseConstants\ContactResponseEnum;
use App\Http\Requests\ImportContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function import(ImportContactRequest $request)
    {
        return $this->execute(function () use ($request){
            $validated = $request->validated();
            $collection = collect();
            foreach ($validated as $data){
                $data['user_id'] = auth()->id();
                $contact = Contact::query()->create($data);
                $collection->add($contact);
            }
            return ContactResource::collection($collection);
        }, ContactResponseEnum::CONTACT_IMPORT);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        return $this->execute(function () use ($request, $contact){
            $validated = $request->validated();
            $contact->update($validated);
            return ContactResource::make($validated);
        }, ContactResponseEnum::CONTACT_UPDATE);
    }


    public function delete(Contact $contact)
    {
        return $this->execute(function () use ($contact){
            if (!$contact->delete()){
                throw new \Exception('Can\'t delete');
            }
        }, ContactResponseEnum::CONTACT_DELETE);
    }

    public function search_contact(Request $request)
    {
        return $this->execute(function () use ($request){
            $contacts = Contact::search($request->all())->get();
            return ContactResource::collection($contacts);
        }, ContactResponseEnum::CONTACT_SEARCH);
    }
}
