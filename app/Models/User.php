<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded =[];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function ShowUser($id){
        return DB::table('users')
        ->where('id',$id)
        ->get();
    }
    public function Users(){
        $user =  DB::table('users')
        ->join('departments', 'users.departments_id', '=', 'departments.id')
        ->join('users_status', 'users.status_id', '=', 'users_status.id')
        ->select('users.*', 'departments.name as departments', 'users_status.name as users_status')
        ->paginate();
        return response()->json($user);
    }
    public function getUserStatus(){
        $status = DB::table('users_status')
        ->select(
            "id as value",
            "name as label"
        )
        ->get();
        return response()->json($status);
    }
    public function getDepartments(){
        $departments = DB::table('departments')
        ->select(
            "id as value",
            "name as label"
        )
        ->get();
        return response()->json($departments);
    }
}
