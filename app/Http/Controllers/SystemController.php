<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function tentantCreate(Request $request){
        $id = $request->get('id');
        $domain = $request->get('domain');
        $tenant1 = Tenant::create(['id' => $id]);
        if($domain){
            $tenant1->domains()->create(['domain' => $domain]);
        }
        return response()->json($tenant1);
    }
}
