<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\ApiResponser;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            //company profile
            'name' => ['required','string'],
            'company_email'=>['required','unique:company_profile,email','email:filter'],
            'contact'=>['required','string'],
            'location'=>['required','string'],
            'city'=>['required','string'],
            'state'=>['required','string'],
            'country'=>['required','string'],
            'logo'=>['required','image'],
            
            //company employee
            // 'user_name' => 'required|string|max:191',
            // 'date_of_birth' => 'required|date',
            // 'phone' => 'required|string|max:191',
            // 'profile_image' => 'nullable|image',
            // 'emp_email' => 'required|email',
            // 'nationality' => 'required|string|max:191',
            // 'lang' => 'required|string|max:191',

            // //company services
            // 'type'=> ['required','string'],
            // 'service'=>['required','string'],
            // 'price'=>['required','string'],
            // 'quantity'=>['required','string'],
            // 'workers'=>['required','integer'],
            // 'service_time'=>['required','string'],
            // 'visit_duration'=>['required','string'],
            // 'description'=>['required','string'],
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

    // protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    // {
    //     $valid_errors=$validator->getMessageBag()->toArray();
    //     $errors=[];

    //     $company_fields=new CompanyProfile;
    //     $category_fields=new User;
    //     $fields=array_merge($company_fields->getFillable(),$category_fields->getFillable());
    //     foreach ($fields as $key) 
    //     {
    //         $message="";
    //         if(isset($valid_errors[$key]))
    //         {
    //             $message= implode("|",$valid_errors[$key]);
    //         }
    //         $errors[] = ['key' => $key,'message' => $message];
    //     }
    //     throw new \Illuminate\Validation\ValidationException($validator, $this->validationError('Validation error',$errors,400 ));
    // }
}
