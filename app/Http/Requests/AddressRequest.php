<?php

namespace App\Http\Requests;

use App\Models\Address;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    use ApiResponser;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'city' => ['required', 'string', 'max:100'],
            // 'state' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'], 
            // 'zipcode' => ['required', 'string', 'max:100'],  
            'address' => ['required', 'string', 'max:100'], 
            'lat' => ['required', 'string'],
            'lng' => ['required', 'string'],
            'name' =>  ['required', 'string'],
            'icon' =>  ['required', 'string'],
            'description' =>  ['nullable', 'string'],
        ];

        $requestWise = [];

        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                break;
            }
            case 'PATCH':
            case 'PUT':
            case 'POST':
            {
                $requestWise = $rules;
                break;
            }
            default:break;
        }

        // rules
        return $requestWise;
    }


    public function attributes()
    {
        return [
            
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $valid_errors=$validator->getMessageBag()->toArray();
        $errors=[];

        $addr_fields=new Address;
        $fields=$addr_fields->getFillable();
        foreach ($fields as $key) 
        {
            $message="";
            if(isset($valid_errors[$key]))
            {
                $message= implode("|",$valid_errors[$key]);
            }
            $errors[] = ['key' => $key,'message' => $message];
        }
        throw new \Illuminate\Validation\ValidationException($validator, $this->validationError('Fields are Missing',$errors,400 ));
    }
}
