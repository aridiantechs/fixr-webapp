<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Contract;
use App\Models\OrderItem;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
  	public function index() 
  	{
		$revenue=Contract::sum('contract_value_usd');
		$orders=Contract::count();

		$recent_contracts=Contract::latest()->limit(10)->get();
		
		$graph=Contract::select(
            DB::raw('sum(contract_value_usd) as `revenue`'), 
            DB::raw("DATE_FORMAT(created_at,'%b %Y') as months")
  		)->groupBy('months')->get();
		// dd($graph->pluck('months')->toArray());
		$data=[
			'revenue'=>$revenue,
			'orders'=>$orders,
		];
		// dd($data);
	    return view('backend.index',compact('data','recent_contracts','graph'));
  	}
	  
  	public function terms_and_condition(Request $request) 
  	{
		if(request()->isMethod('post')) {
			//validaitons
			$validator = Validator::make(request()->all(), [
				'title' => 'required',
				'description' => 'required',
			]);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			//createOrUpdate
			$terms_and_condition=\App\Models\TermsCondition::first();
			$terms_and_condition->fill(request()->except('_token','files'));
			$terms_and_condition->save();
			//redirect
			return redirect()->back()->with('success','Terms and condition updated successfully');
		}else{
			$terms=\App\Models\TermsCondition::first();
			return view('backend.pages.terms_and_condition',compact('terms'));
		}
  	}

  	public function options(Request $request) 
  	{
		if (in_array($request->query('type'),['customer','vendor'])) {
			$user=User::where('id',$request->id)->first();
			if ($user) {
				$options=$user->getAssociation();
				return response()->json([
					"status"=>true,
					"options"=>view('backend.components.options',compact('options'))->render()
				],200);
			}
			
		}

		return response()->json([
			"status"=>false,
		],400);
		
  	}

	public function updatePassword(Request $request)
	{
		if (request()->isMethod('get')) {
			return view('backend.profile');
			
		} elseif (request()->isMethod('post')) {
			$validator = Validator::make($request->all(),
	            [
	            	'old_pass' => 'required',
	            	'password' => 'required|max:30|confirmed',
	        	]
	        );

	        if ($validator->fails()) {
	            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
	        }

	        $user = User::find(auth()->user()->id);
	        if(!Hash::check($request->old_pass, $user->password)){

	        	return redirect()->back()
	             		->with(['password_error' => "Old Password doesn't matched."]);

	        }
			
			$user->password =  Hash::make($request->password);
			$user->save();

			return redirect()->back()->with('status','Password Updated Successfully.');
		}
	}

  	public function profile() 
  	{
	      return view('backend.profile.index');
  	}

  	public function publications() 
  	{
	      return view('backend.publications.index');
  	}

	public function search() 
	{
	return view('backend.search');
	}

}
