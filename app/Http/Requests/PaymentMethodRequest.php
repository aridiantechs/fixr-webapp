<?php

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
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
            'type' => ['required', 'string'],
            'card_holder_name' => ['required', 'string'],
            'card_number' => ['required', 'string'],
            'expiry_date' => ['required', 'string'],
            'cvv' => ['required', 'string'],
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

        $fields=new PaymentMethod;
        foreach ($fields as $key) 
        {
            $message="";
            if(isset($valid_errors[$key]))
            {
                $message= implode("|",$valid_errors[$key]);
            }
            $errors[] = ['key' => $key,'message' => $message];
        }
        throw new \Illuminate\Validation\ValidationException($validator, $this->validationError('Validation error',$errors,400 ));
    }
}
