<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required"
        ]);
        if ($validator->fails()){
            return api_response((Object)[], 400, "validation errors", requestFormatErrors($validator->errors()));
        }
        if(\Auth::attempt(["email"=> $request->email,"password"=> $request->password])){
            $user = auth()->user();
            $token = $user->createToken("personal_access_token")->plainTextToken;
            $data = [
                "personal_access_token" => $token
            ];
            return api_response((Object)$data, 200, "Authetication successfull");

        }
        return api_response((Object)[], 400,"Invalid credentials");
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            "first_name" =>"required|alpha|max:255",
            "last_name" => "required|alpha|max:255",
            // 'phone' => [
            //     'required', 'string', 'regex:/^\+(\d+)$/'
            // ],
            // "city" => "required|string",
            // "gender" => [
            //     "required",
            //     Rule::in(["male", "female", "other"])
            // ],
            "email"=> "required|email|max:191|unique:users,email",
            "password" =>
            [
                "required",
                Password::min(8)
                /* ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols() */
            ],
            "date_of_birth" => "required|date_format:Y-m-d",
            // "profile_image" => "nullable|mimes:jpeg,jpg,png,gif|max:10000"
        ]);
        if($validator->fails()){
            return api_response((Object)[], 400, "validation errors", requestFormatErrors($validator->errors()));
        }
        $request->merge([
            "password" => bcrypt($request->input("password")),
            "email" => strtolower($request->input("email")),
            "first_name" => ucfirst(strtolower($request->input("first_name"))),
            "last_name"=> ucfirst(strtolower($request->input("last_name"))),
            "city" => ucfirst(strtolower($request->input("city"))),
        ]);
        $user = User::create($request->all());
        if($user){
                if($request->hasFile("profile_image")){
                    $file = $request->file("profile_image");
                    $file_path = custom_file_upload($file, "public/uploads/users", "user");
                    if(!$file_path){
                        return api_response((Object)[],400,"Something went wrong");
                    }else{
                        $user->profile_image = $file_path;
                        $user->save();
                    }
                }
                $token = $user->createToken("personal_access_token")->plainTextToken;
                return api_response([
                    'user' => new UserResource( $user ),
                    'personal_access_token' => $token
                ], 200, "User successfully created");
        }
        return api_response((Object)[], 400,"An error occurred while registering user") ;

    }
}
