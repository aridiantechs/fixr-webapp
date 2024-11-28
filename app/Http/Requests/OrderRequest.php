<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RequestMedia;
use App\Traits\ApiResponser;
use App\Models\RequestCategory;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'user_address_id' => ['required', 'numeric', 'exists:addresses,id,user_id,'.auth()->user()->id],
            // 'user_pm_id' => ['required', 'numeric', 'exists:payment_methods,id,user_id,'.auth()->user()->id],
            // 'total_amount' => ['required', 'numeric'],
            'company_id' => ['required', 'numeric', 'exists:company_profile,id'],
            'service_id' => ['required', 'numeric', 'exists:company_services,id,company_id,'.$this->company_id],
            'duration'=>['required', 'numeric'],
            // 'se_id' => ['required', 'numeric', 'exists:service_employees,id,cs_id,'.$this->service_id],
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
            "user_pm_id"=>"Payment Method",
            "user_address_id"=>"Address",
            "se_id"=>"Service Employee",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $valid_errors=$validator->getMessageBag()->toArray();
        $errors=[];

        $fields1=new Order;
        $fields2=new OrderItem;
        $fields=array_merge($fields1->getFillable(),$fields2->getFillable());
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
