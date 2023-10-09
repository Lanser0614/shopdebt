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
                $data['phone_number'] = $this->phoneCorrection($data['phone_number']);
                if (!empty($data['phone_number'])){
                    $data['user_id'] = auth()->id();
                    $contact = Contact::query()->create($data);
                    $collection->add($contact);
                }
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

    public function phoneCorrection(string $phone): string
    {
        if (strlen($phone) === 13 && str_starts_with($phone, '+998')){
            return $phone;
            }
        elseif (strlen($phone) === 9 && (!str_starts_with($phone, '+998')) && $this->checkSubstr($phone)){
                return '+998'.$phone;
        }
        else {
            return '';
        }
    }

    public function checkSubstr(string $phone):bool
    {
        $substr = ['90','91','93','94','95','97','98','99','50','88','77','33','20'];
        return in_array(substr($phone,0 ,2), $substr);
    }
}
