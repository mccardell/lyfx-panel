<?php
namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Session;

class IndexController extends Controller{
    private static $defaults = [];

    public function index(){
        return view('frontend.default.cms.index');
    }

    public function signup(){
        $page = 'signup';
        return view('frontend.default.cms.signup', compact('page'));
    }

    public function done(){
        $page = 'done';
        return view('frontend.default.cms.done', compact('page'));
    }

    public function login(Request $request){
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if( $validator->fails() ) {
            // $res = $validator->errors();
            $res = ['status'=>'error'];
            return response()->json($res);
        }

        if( Auth::attempt(['username' => $request->username, 'password' => $request->password]) ) return response()->json(['status'=>'success']);
        else return response()->json(['status'=>'error']);

    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->flush();

        return redirect()->action('IndexController@index');
    }
}