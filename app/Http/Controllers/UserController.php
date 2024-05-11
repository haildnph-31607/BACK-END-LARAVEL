<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user->Users();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data =[
            "users_status"=> $this->user->getUserStatus(),
            "departments"=> $this->user->getDepartments()
        ];
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "username"=>"required|unique:users,username",
            "name"=>"required|max:255",
            "email"=>"required|email",
            "password"=>"required|confirmed",
            "departments_id"=>"required",
            "status_id"=>"required",

        ]);
        // return $request['status_id'];
        // $users = $request->all(['password','password_confirmation']);
        // $users['password'] = Hash::make($request['password']);
        // User::create($users);
        User::create([
              "username"=>$request['username'],
              "name"=>$request['name'],
              "email"=>$request['email'],
              "password"=>Hash::make($request['password']),
              "departments_id"=>$request['departments_id'],
              "status_id"=>$request['status_id'],


        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       $data = $this->user->ShowUser($id);
       return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json([
            "users"=> $user,
            "departments" => $this->user->getDepartments(),
            "users_status" => $this->user->getUserStatus(),
              
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "username"=>"required|unique:users,username,".$id,
            "name"=>"required|max:255",
            "email"=>"required|email",
            
            "departments_id"=>"required",
            "status_id"=>"required",

        ]);
        User::find($id)->update([
            "username"=>$request['username'],
            "name"=>$request['name'],
            "email"=>$request['email'],
         
            "departments_id"=>$request['departments_id'],
            "status_id"=>$request['status_id'],
        ]);
        // thích dùng tiếng anh chứ k phải kh chuyển rule sang tiếng việt nhaa
        if($request['change_password'] == true){
            $validated = $request->validate([
                "password"=>"required|confirmed",
    
            ]);
            User::find($id)->update([
              
                "password"=>Hash::make($request['password']),
                "change_password_at"=> NOW()
                
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
    }
}
