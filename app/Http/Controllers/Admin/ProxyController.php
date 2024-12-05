<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proxy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ProxyController extends Controller
{
    public function index(Request $request)
    {
        $proxies = Proxy::orderBy("created_at", "desc")->paginate(10);
        return view("backend.proxies.proxies", ["proxies" => $proxies]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            "proxy_content" => "required"
        ]);
        $proxy = new Proxy();
        $proxy->content = trim($request->proxy_content);
        $saved = $proxy->save();

        if ($saved)
            return back()->with("success", "Proxy successfully created");
        return back()->with("error", "Error creating the new proxy")->withInput(request()->all());
    }
    public function show_update_form(Proxy $proxy, Request $request)
    {
        if (!$proxy)
            abort(404);
        return view("backend.proxies.update-proxy", ['proxy' => $proxy]);
    }
    public function update(Request $request, Proxy $proxy)
    {
        $this->validate($request, [
            "proxy_content" => "required"
        ]);
        $proxy = Proxy::find($request->proxy_id);
        if (!$proxy)
            return redirect()->route('backend.proxy.view')->with('error', 'Proxy not found');
        $proxy->content = trim($request->proxy_content);
        $updated = $proxy->save();
        if ($updated)
            return redirect()->route('backend.proxy.view')->with('success', 'Proxy successfully updated');
        return redirect()->route('backend.proxy.view')->with('error', 'Something went wrong...');
    }
    public function delete(Request $request)
    {
        $proxy = Proxy::find($request->proxy_id);
        if (!$proxy)
            return redirect()->route("backend.proxy.view")->with('error', 'Porxy not found');
        $deleted = $proxy->delete();
        if ($deleted) {
            $key = 'success';
            $message = 'Task successfully deleted';
        } else {
            $key = 'error';
            $message = 'Something went wrong';
        }

        return redirect()->route("backend.proxy.view")->with($key, $message);
    }
}
