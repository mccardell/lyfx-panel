<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

use App\User;
use App\UserGroupUser;
use App\UserGroup;

use App\Helpers\DebugHelper;

class UsersController extends Controller
{
    public function getLogin(){
    	return view('backend.default.users.login');
    }
    public function getLogout(Request $request){
    	Auth::logout();
        $request->session()->flush();

    	return redirect()->action('Admin\UsersController@getLogin');
    }

    public function postLogin(Request $request){
		$rules = [
			'username' => 'required',
			'password' => 'required'
		];

		$this->validate($request, $rules);

		if( Auth::attempt(['username' => $request->username, 'password' => $request->password]) ) return redirect()->intended('panel/');
		else return redirect()->action('Admin\UsersController@getLogin')->withErrors(['username' => 'Invalid', 'password' => 'Invalid']);
    }


    public function index(){
        $items = User::orderBy('name')->get();

        return view('backend.default.users.list')->with(compact('items'));
    }
    public function create(){
        $item = new User;

        return view('backend.default.users.form')->with(compact('item'));
    }
    public function edit( $id = NULL ){
        $item = User::find($id);
        if( $item == NULL ) return redirect()->action('Admin\UsersController@create');

        return view('backend.default.users.form')->with(compact('item'));
    } 

    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'username' => 'required_without:my-account',
            'email' => 'email',
            'password' => 'required_without:id|confirmed',
            'filepath' => 'nullable|image',
            'old_password' => 'nullable|required_with_all:id,password',
        ];

        $this->validate($request, $rules);
        if( $request->has('old_password') && !Hash::check($request->old_password, User::find($request->id)->pluck('password')->first()) ) 
            return redirect()->back()->withErrors(['Senha atual incorreta'])->withInput();

        if( $request->has('id') ) $user = User::find($request->id);
        else {
            $user = new User;
            // $user->created_by = Auth::id();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        if( $request->has('username') ) $user->username = $request->username;
        if( $request->has('password') ) $user->password = Hash::make($request->password);
        if( $request->has('filepath') || $request->hasFile('filepath') ) $user->filepath = User::upload($request->file('filepath'));
        if( !$request->has('my-account') ) $user->status = $request->has('status') ? 'active':'inactive';
        $user->save();

        if( $request->has('user_group_id') ){
            UserGroupUser::where('user_id',$user->id)->delete();
            foreach($request->user_group_id as $userGroupId){
                $userGroupUser = new UserGroupUser;
                $userGroupUser->user_id = $user->id;
                $userGroupUser->user_group_id = $userGroupId;
                $userGroupUser->save();
            }
        }

        if( $request->has('my-account') ) return redirect()->action('Admin\UsersController@myAccount');
        if( $request->submit == 'save_and_continue' ) return  redirect()->route('users.edit',['id'=>$user->id]);
        else return redirect()->route('users.index');
    }

    public function myAccount(){
        $item = Auth::user();

        return view('backend.default.users.my-account')->with(compact('item'));
    }

	public function destroy(Request $request, $id){
		User::where('id',$id)->delete();
		
		return redirect()->route('users.index');
	}
}
