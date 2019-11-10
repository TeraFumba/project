<?php

namespace App\Http\Controllers;

use App\ContactNumbers;
use App\Contacts;
use App\EmailAddresses;
use App\Http\Requests\ContactRequest;
use App\NumberTypes;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        return view('contacts.contacts_list');
    }

    public function getContactList(Request $request)
    {
        $columns = ['f_name', 'l_name'];
        $length = $request['length'];
        $column = $request['column'];
        $dir = $request['dir'];
        $searchValue = $request['search'];

        $query = \DB::table('contacts')->select('contacts.id','f_name', 'l_name',
            \DB::raw("(SELECT number FROM contact_numbers 
                    WHERE contact_numbers.contact_id = contacts.id
                    ORDER BY contact_numbers.id 
                    LIMIT 1) AS number")
            , \DB::raw("(SELECT email FROM email_addresses 
                    WHERE email_addresses.contact_id = contacts.id
                    ORDER BY email_addresses.id 
                    LIMIT 1) AS email"));


        if(array_key_exists($column, $columns)) {
            $query->orderBy($columns[$column], $dir);
        }
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('f_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('l_name', 'like', '%' . $searchValue . '%');
            });
        }
        $contacts = $query->paginate($length);
        return ['data' => $contacts, 'draw' =>  $request->params['draw']];
    }

    public function add(){
        $numberTypes = NumberTypes::all();
        $numberTypes  = json_encode($numberTypes);
        return view('contacts.contact_add')->with(compact('numberTypes'));
    }

    /**
     * return a edit view with json encoded data
     * @param $id
     * @return $this
     */
    public function edit($id){
        $contact = Contacts::find($id);
        $numberTypes = NumberTypes::all();

        $contact  = json_encode($contact);
        $numberTypes  = json_encode($numberTypes);

        return view('contacts.contact_edit')
            ->with(compact('contact'))
            ->with(compact('numberTypes'));
    }
    public function save(ContactRequest $request){
        if ($request->isMethod('put')){

            Contacts::where('id', $request['contacts']['id'])->update([
                'l_name' => $request['contacts']['l_name'],
                'f_name' => $request['contacts']['f_name']
            ]);

            foreach ($request['id_to_delete_number'] as $number)
            {
                ContactNumbers::find($number)->delete();
            }

            foreach ($request['contacts']['contact_numbers'] as $contact_numbers ){
                if (isset($contact_numbers['id'])) {
                    ContactNumbers::where('id', $contact_numbers['id'])->update([
                        'number'        =>  $contact_numbers['number'],
                        'number_type'   =>  $contact_numbers['number_type']
                    ]);
                }
                else
                    self::createContactNumber($contact_numbers, $request['contacts']['id']);
            }

            foreach ($request['id_to_delete_email'] as $email)
            {
                EmailAddresses::find($email)->delete();
            }
            foreach ($request['contacts']['email_addresses'] as $mail){
                if (isset($mail['id'])){
                    EmailAddresses::where('id', $mail['id'])->update([
                        'email'     => $mail['email']
                    ]);
                }
                else
                    self::createEmail($mail, $request['contacts']['id']);
            }

            return 'success';
        }
        else{
            $contact = Contacts::create([
                'l_name' => $request['contacts']['l_name'],
                'f_name' => $request['contacts']['f_name']
            ]);

            foreach ($request['contacts']['contact_numbers'] as $contact_numbers ){
                self::createContactNumber($contact_numbers, $contact->id);
            }

            foreach ($request['contacts']['email_addresses'] as $mail){
                self::createEmail($mail,$contact->id);
            }
            return 'success';
        }
    }

    /**
     * create Contact Number for each Contact
     * @param $contactNumber
     * @param $contactId
     */
    public function createContactNumber($contactNumber, $contactId)
    {
        ContactNumbers::create([
            'number'        =>  $contactNumber['number'],
            'number_type'   =>  $contactNumber['number_type'],
            'contact_id'    => $contactId
        ]);
    }

    /**
     * create email for each contact
     * @param $mail
     * @param $contactId
     */
    public function createEmail($mail, $contactId)
    {
        EmailAddresses::create([ 'email' => $mail['email'] , 'contact_id' => $contactId ]);
    }

    public function delete($id)
    {
        EmailAddresses::where('contact_id', $id)->delete();
        ContactNumbers::where('contact_id', $id)->delete();
        Contacts::find($id)->delete();
        return 'success';
    }
}
