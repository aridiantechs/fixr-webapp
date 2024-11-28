<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
	public function index()
	{
		// fcm()
		// ->to(['dhSLmkMESTGjhDNgoomekR:APA91bFWwleN9aoS_x6nxbGXUdoRjxU5wasegp-jp9NYMXHYHj2v-cKPyCgGrLf5u_vsG2uuG45e8fCDbOenuYrobB99FDVH6Y_K1igOG_c_PUDV-wBkD10JnBbW4XpUQjycpTd8lpV7'])
		// ->priority('high')
		// ->timeToLive(0)
		// ->data([ 
		// 	'title' => "You have received a proposal ",
		// 	'body' => 'test',
		// 	'req_id' => "",
		// ])->notification([
		// 	'title' => "You have received a proposal ",
		// 	'body' => 'test',
		// 	'req_id' =>"",
		// 	])
		// ->send();
		
	}

	public function file_download(Request $request)
    {
        /* dd($request->all()); */
		if ($request->query('file')) {
			$file=UserDownload::where('filename',$request->query('file'))->first();
			$file_path = public_path().'/storage/downloads/'.$request->query('file');
	
			if (($file && $file->user_id ==auth()->user()->id) && file_exists($file_path))
			{
				return Response::download($file_path, $request->query('file'), [
					'Content-Length: '. filesize($file_path)
				]);
			}
			else
			{
				exit('Requested file does not exist on our server!');
			} 
        } else {
            return "permission denied...";
        }   
    }

}
