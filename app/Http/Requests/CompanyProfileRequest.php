<?php

namespace App\Http\Requests;

use App\Traits\ApiResponser;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Http\FormRequest;

class CompanyProfileRequest extends FormRequest
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
            'shop_name' => 'required|string|max:191',
            'shop_contact' => 'nullable|string|max:191',
            'shop_location' => 'nullable|string|max:191',
            'additional_info' => 'nullable|string|max:500',
            'shop_logo' => 'nullable|image',
            'reg_certificate' => 'required|mimes:jpeg,jpg,png,pdf',
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

        $car_fields=new CompanyProfile;
        $fields=$car_fields->getFillable();
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
