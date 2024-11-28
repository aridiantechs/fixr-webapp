@extends('backend.layouts.app')
{{-- {{ dd($contents) }} --}}
@section('styles')
<!--Third party Styles(used by this page)--> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
   .form-group label {
   font-size: 1.2rem;
   }

   .bootstrap-tagsinput{
        color: #495057 !important;
        background-color: #fff !important;
        background-clip: padding-box !important;
        border: 1px solid #e2e5ec !important;
        border-radius: 4px !important;
	}

    .bootstrap-tagsinput input{
        width: 100% !important;
    }
	
   .bootstrap-tagsinput .badge{
		margin: 2px 2px;
		background-color: #5969ff;
		border-radius: 4px;
	}
</style>
@endsection
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
   <div class="row">
      <div class="col-md-12">
         <!--begin::Portlet-->
         <div class="kt-portlet">
            <div class="kt-portlet__head">
               <div class="kt-portlet__head-label">
                  <h3 class="kt-portlet__head-title">
                     {{isset($user) ? 'Update' : 'Create'}} User
                  </h3>
               </div>
            </div>
            @if($errors->any())
               @foreach ($errors->all() as $error)
                  <div>{{ $error }}</div>
               @endforeach
            @endif

            <!--begin::Form-->
            @php 
            $route = route('backend.user.store');
            if(isset($user)){
            $route = route('backend.user.update',$user->id);
            }
            @endphp
            <form action="{{$route}}" method="POST" id="user-content-form" enctype="multipart/form-data" class="kt-form">
               @csrf
               @if(isset($user))
               {{ method_field('PATCH') }}
               @endif
               <div class="kt-portlet__body">
                  <div class="row">
                     <div class="col-md-8 col-sm-12 col-xs-12 mx-auto">
                        <br />

                        {{-- <div class="form-group">
                           <label class="col-md-12">Add Role</label>
                           <div class="col-md-12">
                           <select class="form-control" name="role_id">
                              <option value="">Select Role</option>
                              @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                              @endforeach
                           </select>
                           </div>
                        </div> --}}

                        <div class="row">
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>First Name</label>
                                 <input type="text" class="form-control" name="f_name" value="{{isset($user)?$user->f_name : ''}}"/> 
                                 
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Last Name</label>
                                 <input type="text" class="form-control" name="l_name" value="{{isset($user)?$user->l_name : ''}}"/> 
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Dob</label>
                                 <input type="date" class="form-control" name="dob" value="{{isset($user)?/* $user->age */$user->dob : ''}}"/> 
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Location</label>
                                 <input type="text" class="form-control" name="country" value="{{isset($user)?$user->country : ''}}"/> 
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label class="col-md-6">Gender</label>
                                 <select class="form-control" name="gender">
                                    <option value="">Select gender</option>
                                    <option value="male" {{ isset($user) && $user->gender=="male" ? 'selected' : '' }}>male</option>
                                    <option value="female" {{isset($user) && $user->gender=="female" ? 'selected' : '' }}>female</option>
                                    <option value="transgender" {{isset($user) && $user->gender=="transgender" ? 'selected' : '' }}>Transgender</option>
                                 </select>
                              </div>
                           </div>

                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Hair Color</label>
                                 
                                 <select class="form-control" name="hairs">
                                    <option>Select color</option>
                                    <option value="black" {{$user->profile()->exists() && $user->profile->hairs=="black" ? 'selected' : '' }}>black</option>
                                    <option value="grey" {{$user->profile()->exists() && $user->profile->hairs=="grey" ? 'selected' : '' }}>grey</option>
                                    <option value="brown" {{$user->profile()->exists() && $user->profile->hairs=="brown" ? 'selected' : '' }}>Brown</option>
                                    <option value="white" {{$user->profile()->exists() && $user->profile->hairs=="white" ? 'selected' : '' }}>White</option>
                                 </select>
                                 
                              </div>
                           </div>

                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Eye Color</label>
                                 
                                 <select class="form-control" name="eyes">
                                    <option>Select color</option>
                                    <option value="black" {{$user->profile()->exists() && $user->profile->eyes=="black" ? 'selected' : '' }}>black</option>
                                    <option value="brown" {{$user->profile()->exists() && $user->profile->eyes=="brown" ? 'selected' : '' }}>brown</option>
                                    <option value="blue" {{$user->profile()->exists() && $user->profile->eyes=="blue" ? 'selected' : '' }}>blue</option>
                                 </select>
                                 
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Body Type</label>
                                 
                                 <select class="form-control" name="body">
                                    <option value="">Select body type</option>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                 </select>
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Ethnicity</label>
                              
                                 <select class="form-control" name="role_id">
                                    <option value="">black</option>
                                    <option value="">white</option>
                                    <option value="">brown</option>
                                    <option value="">African</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        
                        <div class="row">
                           <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12">
                              <div class="form-group">
                              
                                 <label>Skills:</label>
                                 <select class="form-control js-example-basic-multiple"  multiple="multiple" name="skills[]">
                                    @foreach ($skills as $skill)
                                       <option value="{{$skill->id}}">{{$skill->title}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                       </div>

                       <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Union Status:</label>
                           <div class="col-xl-8 col-lg-8 col-sm-12 col-md-12">
                              <div class="kt-checkbox-inline">
                                 <label class="kt-checkbox">
                                 <input type="checkbox"> Email 
                                 <span></span>
                                 </label>
                                 <label class="kt-checkbox">
                                 <input type="checkbox"> SMS 
                                 <span></span>
                                 </label>
                                 <label class="kt-checkbox">
                                 <input type="checkbox"> Phone 
                                 <span></span>
                                 </label>
                              </div>
                           </div>
                        </div>

                        <div class="form-group">
                           <label>Other Info</label>
                           <input type="text" class="form-control" name="info" value=""/> 
                        </div>
                        
                        {{-- <div class="form-group mt-3">
                           <div class="col-md-12 col-sm-12 col-xs-12">
							         <textarea name="description" id="summernote" class="summernote">{!!isset($user)?html_entity_decode($user->description) : ''!!}</textarea>
                           </div>
                        </div> --}}

                        <div class="form-group">
                           <div class="col-md-12 col-sm-9 col-xs-12">
                              <button type="submit" class="btn btn-info btn-xs" role="button" style="font-size:13px" ><b>Save</b></button>
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
            <!--end::Form-->			
         </div>
         <!--end::Portlet-->
      </div>
   </div>
</div>
@endsection
@section('scripts')
<!-- Third Party Scripts(used by this page)-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">
   
   $(document).ready(function(){

      $('.js-example-basic-multiple').select2();
        
      @if($user->skills()->exists())
         var skills={{$user->skills->pluck('skill_id')}};
         console.log(skills);
         $('[name="skills[]"]').val(skills);
         $('[name="skills[]"]').trigger('change');
      @endif



      @if (session('status'))
         toastr.success('{{session('status')}}', "Success");
      @endif
   })

   $(document).ready(function(){
		window.sidebar_search=function() {
			var input, filter, div, childdiv, label, i, txtValue;
			input = document.getElementById("admin_sidebar_search");
			filter = input.value.toUpperCase();
			div = document.getElementById("admin_sidebar");
			childdiv = div.getElementsByTagName("div");
			//console.log(childdiv);
			for (i = 0; i < childdiv.length; i++) {
				label = childdiv[i].getElementsByTagName("label");
				//console.log(a);
				if(label.length !=0)
				{
					label = childdiv[i].getElementsByTagName("label")[0]
					//console.log(label);
					txtValue = label.textContent || label.innerText;
					if (txtValue.toUpperCase().indexOf(filter) > -1) {
						childdiv[i].style.display = "";
					} else {
						childdiv[i].style.display = "none";
					}
				}
			}
		}
		
	})
   
   function formSubmitWithTextEditor(editorId,fieldToCopyIn,formId)
   {
   	console.log($('#'+editorId).html() );
   	if ($('#'+editorId).html() !=='') {
   		$('[name='+fieldToCopyIn+']').val($('#'+editorId).html());
   		$('#'+formId).submit();
   	} else {
   		$('#'+formId).submit();
   	}
   }
   
function changeImageView(input, id,max_size) {
   
   var FileUploadPath = input.value;
   
   if (FileUploadPath == '') {
   	alert("Please upload an image");
   
   } 
   else 
   {
   	var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
   	if (Extension == "jpg" || Extension == "png")
   	{
   		if (input.files && input.files[0]) {
   			var size = input.files[0].size;
   			
   			if(size > max_size){
   				alert("Maximum file size exceeds");
   				return;
   			}else{
   				var reader = new FileReader();
   				/* alert(input.files[0].size); */
   				reader.onload = function (e) {
   					$('#'+id).attr('src', e.target.result).fadeIn('slow');
   				}
   				reader.readAsDataURL(input.files[0]);
   			}
   		}
   	}
   	else{
   		alert("Photo only allows file types of GIF, PNG");
   	}
   	
   }   
   // alert('');
}
   
</script>
@endsection