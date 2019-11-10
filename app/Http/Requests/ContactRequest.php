<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'contacts.l_name.required' => 'The last name field is required.',
            'contacts.f_name.required' => 'The first name field is required.',
            'contacts.contact_numbers.*.number.required'   => 'The contact number field is required.',
            'contacts.contact_numbers.*.number_type.required'   => 'The contact number type field is required.',
            'contacts.email_addresses.*.email.required'   => 'The contact email field is required.',
            'contacts.email_addresses.*.email.regex'   => 'The contact email  format is invalid.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contacts.l_name' => 'required',
            'contacts.f_name' => 'required',

            'contacts.contact_numbers.*.number' => 'required',
            'contacts.contact_numbers.*.number_type' => 'required',

            'contacts.email_addresses.*.email' => 'required|regex:/^.+@.+$/i',
        ];
    }
}
