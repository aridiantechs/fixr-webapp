<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Category;

use App\Models\Contract;
use App\Models\UserCompany;
use App\Models\UserRequest;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ContractMedia;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\ContractProductCategory;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories=Category::where('category_type','product')->get();
        $contracts=Contract::when($request->query('type'),function($q)use($request){
            $q->where('user_type',$request->type);
        })
        ->when($request->query('search_text'),function($q)use($request){
            $search=$request->query('search_text');
            $q->where(function($q)use($search){
                $q->where('user_type',$search)
                    ->orWhereHas('user',function($q)use($search){
                        $q->where('first_name','LIKE','%'.$search.'%')->orWhere('last_name','LIKE','%'.$search.'%');
                    })
                    ->orWhereHas('association',function($q)use($search){
                        $q->where('first_name','LIKE','%'.$search.'%')->orWhere('last_name','LIKE','%'.$search.'%');
                    })
                    ->orWhere('start_date',$search)
                    ->orWhere('end_date',$search)
                    ->orWhere('renewal_date',$search)
                    ->orWhere('renewal_reminder_date',$search)
                    ->orWhere('contract_value',$search)
                    ->orWhere('contract_type',$search)
                    ->orWhere('extension',$search)
                    ->orWhere('extension_period',$search)
                    ->orWhere('performance_delivery_degree',$search)
                    ->orWhere('performance_delivery_time',$search)
                    ->orWhere('performance_quality',$search)
                    ->orWhere('element_delivery_degree',$search)
                    ->orWhere('element_delivery_time',$search)
                    ->orWhere('element_quality',$search)
                    ->orWhere('delivery_instructions','LIKE','%'.$search.'%');
            });
        })
        ->when($request->query('product_category'),function($q)use($request){
            $q->whereHas('product_categories',function($q)use($request){
                $q->where('product_category_id',$request->query('product_category'));
            });
        })
        ->when($request->query('contract_type'),function($q)use($request){
            $q->where('contract_type',$request->contract_type);
        })
        ->when($request->query('extension'),function($q)use($request){
            $q->where('extension',$request->extension);
        })
        ->when($request->query('extension_period'),function($q)use($request){
            $q->where('extension_period',$request->extension_period);
        })->latest()->paginate(15);

        return view('backend.contract.list',compact('contracts','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $customers=User::customer()->get();
        
        $vendors=User::vendor()->get();

        $salesperson=User::salesperson()->get();

        $categories=Category::where('category_type','product')->get();
        return view('backend.contract.create',compact('customers','salesperson','vendors','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            "user_type" => ['required', 'in:customer,vendor'],
            "customer" => ['required_if:user_type,==,customer'],
            "vendor" => ['required_if:user_type,==,vendor'],
            "start_date" => ['required', 'date'],
            "end_date" => ['required', 'date','after:start_date'],
            "renewal_interval" => ['nullable', 'in:one_time,unlimited'],
            "renewal_reminder_date" => ['required', 'date','after:start_date','before:end_date'],
            "contract_value" =>['required', 'string'],
            "contract_file" => ['nullable', 'array'],
            "contract_file.*" => ['required', 'mimes:pdf'],
            "purchaser_id" => ['required_if:user_type,==,vendor'],
            "salesperson_id" => ['required_if:user_type,==,customer'],
        ];

        if ($request->user_type=='customer') {
            $rules = array_merge($rules, [
                "contract_type" => ['required', 'string'],
                "extension" => ['required', 'in:none,automatic'],
                "extension_period" => ['required', 'string'],
                "performance_delivery_degree" => ['required', 'string'],
                "performance_delivery_time" => ['required', 'string'],
                "performance_quality" => ['required', 'string'],
                "element_delivery_degree" => ['required', 'string'],
                "element_delivery_time" => ['required', 'string'],
                "element_quality" => ['required', 'string'],
                "delivery_instructions" => ['required', 'string'],
                "product_category" => ['required', 'array'],
                "product_category.*" => ['required', 'integer'],
                "status_meeting" => ['required', 'string'],
                "meeting_date" => ['required', 'date','after:start_date','before:end_date']
            ]);
        }
        
        $validator = Validator::make($request->all(),$rules);
        
        if ($validator->fails()) {
            // dd(222);
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error','validation error');
        }
        // dd($request->all());
        $contract = new Contract;
        $contract->order_id = uniqid();
        $contract->user_type = $request->user_type;
        $contract->user_id = $request->input($request->user_type);
        $contract->association_id = $request->user_type== 'customer' ? $request->salesperson_id : $request->purchaser_id;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;
        $contract->renewal_date = $request->end_date;
        $contract->renewal_interval = $request->renewal_interval ?? null;
        $contract->renewal_reminder_date = $request->renewal_reminder_date;
        $contract->contract_value = $request->contract_value;

        $val__=str_replace(".","",$request->contract_value);
        $val__=str_replace(",",".",$val__);
        $contract->contract_value_usd = $val__;

        if ($request->user_type=='customer') {
            $contract->contract_type = $request->contract_type;
            $contract->extension = $request->extension;
            $contract->extension_period = $request->extension_period;
            $contract->performance_delivery_degree = $request->performance_delivery_degree;
            $contract->performance_delivery_time = $request->performance_delivery_time;
            $contract->performance_quality = $request->performance_quality;
            $contract->element_delivery_degree = $request->element_delivery_degree;
            $contract->element_delivery_time = $request->element_delivery_time;
            $contract->element_quality = $request->element_quality;
            $contract->delivery_instructions = $request->delivery_instructions;
            $contract->status_meeting = $request->status_meeting;
            $contract->meeting_date = $request->meeting_date;
        }
        $contract->emp_id = auth()->user()->id;
        $contract->save();

        if($request->product_category) {
            foreach ($request->product_category as $key => $pc) {
                ContractProductCategory::insert([
                    'contract_id'=>$contract->id, 'product_category_id'=> $pc
                ]);
            }
        }
        
        if($request->hasFile('contract_file')) {
            if (is_array($request->contract_file)) {
                $files = $request->file('contract_file');
                foreach ($files as $file) {
                    
                    $contract_media=new ContractMedia;
                    $contract_media->contract_id = $contract->id;
                    $contract_media->file = custom_file_upload($file,CONTRACT_FILE_PATH);
                    $contract_media->orig_name = $file->getClientOriginalName();
                    $contract_media->save();
                }
            }else{
                $file = $request->file('contract_file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('contract_files', $filename);

                $contract_media=new ContractMedia;
                $contract_media->contract_id = $contract->id;
                $contract_media->file = $path;
                $contract_media->save();
            }
            
        }

        $contract->save();

        // Create Notification
        createNotification(
            "contract",
            $contract->emp_id,
            "Contract Created",
            "A new Contract has been created bearing id ".$contract->order_id,
            [
                "contract_id" => $contract->id,
            ]
        );
        
        // Create log
        activity('contract')
            ->performedOn($contract)
            ->causedBy(auth()->user())
            ->withProperties(['contract_id' => $contract->id])
            ->log('Contract created by ' . auth()->user()->name);

        return redirect()->back()->with("status", "Contract has been Created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contract=Contract::where('order_id',$id)->first();
        return view('backend.contract.report',compact('contract'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id)
    {
        $contract=Contract::where('order_id',$id)->first();
        $contract->status='COMPLETED';
        $contract->save();
        return redirect()->back()->with("status", "Contract status updated.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contract=Contract::where('order_id',$id)->first();
        $customers=User::customer()->get();
        
        $vendors=User::vendor()->get();

        $salesperson=User::salesperson()->get();

        $categories=Category::where('category_type','product')->get();
        return view('backend.contract.edit',compact('contract','customers','salesperson','vendors','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // dd($request->all());
        $rules=[
            "user_type" => ['required', 'in:customer,vendor'],
            "customer" => ['required_if:user_type,==,customer'],
            "vendor" => ['required_if:user_type,==,vendor'],
            "start_date" => ['required', 'date'],
            "end_date" => ['required', 'date','after:start_date'],
            "renewal_interval" => ['nullable', 'in:one_time,unlimited'],
            "renewal_reminder_date" => ['required', 'date','after:start_date','before:end_date'],
            "contract_value" =>['required', 'string'],
            "contract_file" => ['nullable', 'array'],
            "contract_file.*" => ['required', 'mimes:pdf'],
            "purchaser_id" => ['required_if:user_type,==,vendor'],
            "salesperson_id" => ['required_if:user_type,==,customer'],
        ];

        if ($request->user_type=='customer') {
            $rules = array_merge($rules, [
                "contract_type" => ['required', 'string'],
                "extension" => ['required', 'in:none,automatic'],
                "extension_period" => ['required', 'string'],
                "performance_delivery_degree" => ['required', 'string'],
                "performance_delivery_time" => ['required', 'string'],
                "performance_quality" => ['required', 'string'],
                "element_delivery_degree" => ['required', 'string'],
                "element_delivery_time" => ['required', 'string'],
                "element_quality" => ['required', 'string'],
                "delivery_instructions" => ['required', 'string'],
                "product_category" => ['required', 'array'],
                "product_category.*" => ['required', 'integer'],
                "status_meeting" => ['required', 'string'],
                "meeting_date" => ['required', 'date','after:start_date','before:end_date']
            ]);
        }
        
        $validator = Validator::make($request->all(),$rules);
        
        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error','validation error');
        }
        // dd($request->all());
        $contract=Contract::findOrFail($id);
        $contract->user_type = $request->user_type;
        $contract->user_id = $request->input($request->user_type);
        $contract->association_id = $request->user_type== 'customer' ? $request->salesperson_id : $request->purchaser_id;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;
        $contract->renewal_date = $request->end_date;
        $contract->renewal_interval = $request->renewal_interval ?? null;
        $contract->renewal_reminder_date = $request->renewal_reminder_date;
        $contract->contract_value = $request->contract_value;

        $val__=str_replace(".","",$request->contract_value);
        $val__=str_replace(",",".",$val__);
        $contract->contract_value_usd = $val__;

        
        $contract->contract_type = $request->user_type== 'customer' ? $request->contract_type : null;
        $contract->extension = $request->user_type== 'customer' ? $request->extension : null;
        $contract->extension_period = $request->user_type== 'customer' ? $request->extension_period : null;
        $contract->performance_delivery_degree = $request->user_type== 'customer' ? $request->performance_delivery_degree : null;
        $contract->performance_delivery_time = $request->user_type== 'customer' ? $request->performance_delivery_time : null;
        $contract->performance_quality = $request->user_type== 'customer' ? $request->performance_quality : null;
        $contract->element_delivery_degree = $request->user_type== 'customer' ? $request->element_delivery_degree : null;
        $contract->element_delivery_time = $request->user_type== 'customer' ? $request->element_delivery_time : null;
        $contract->element_quality = $request->user_type== 'customer' ? $request->element_quality : null;
        $contract->delivery_instructions = $request->user_type== 'customer' ? $request->delivery_instructions : null;
        $contract->status_meeting = $request->user_type== 'customer' ? $request->status_meeting : null;
        $contract->meeting_date = $request->user_type== 'customer' ? $request->meeting_date : null;
        
        $contract->emp_id = auth()->user()->id;
        $contract->save();

        $contract->product_categories()->delete();
        if($request->product_category) {
            foreach ($request->product_category as $key => $pc) {
                ContractProductCategory::insert([
                    'contract_id'=>$contract->id, 'product_category_id'=> $pc
                ]);
            }
        }

        if($request->hasFile('contract_file')) {
            if (is_array($request->contract_file)) {
                $files = $request->file('contract_file');
                foreach ($files as $file) {
                    
                    $contract_media=new ContractMedia;
                    $contract_media->contract_id = $contract->id;
                    $contract_media->file = custom_file_upload($file,CONTRACT_FILE_PATH);
                    $contract_media->orig_name = $file->getClientOriginalName();
                    $contract_media->save();
                }
            }else{
                $file = $request->file('contract_file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('contract_files', $filename);

                $contract_media=new ContractMedia;
                $contract_media->contract_id = $contract->id;
                $contract_media->file = $path;
                $contract_media->save();
            }
            
        }

        $contract->save();

        // Create Notification
        createNotification(
            "contract",
            $contract->emp_id,
            "Contract Created",
            "Contract #".$contract->order_id." has been updated",
            [
                "contract_id" => $contract->id,
            ]
        );

        // Create Log
        activity('contract')
            ->performedOn($contract)
            ->causedBy(auth()->user())
            ->withProperties(['contract_id' => $contract->id])
            ->log('Contract updated by ' . auth()->user()->name);

        return redirect()->back()->with("status", "Contract has been Updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract=Contract::findOrFail($id);

        // Create Notification
         createNotification(
            "contract",
            $contract->emp_id,
            "Contract Deleted",
            "Contract #".$contract->order_id." has been Deleted",
            [
                "contract_id" => $contract->id,
            ]
        );

        // Create Log
        activity('contract')
            ->performedOn($contract)
            ->causedBy(auth()->user())
            ->withProperties(['contract_id' => $contract->id])
            ->log('Contract deleted by ' . auth()->user()->name);
            
        $contract->delete();
        return redirect()->back();
    }
}
