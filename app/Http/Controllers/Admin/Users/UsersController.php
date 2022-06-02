<?php
namespace App\Http\Controllers\Admin\Users;
use App\Http\Controllers\Controller;
use App\Models\User;




class UsersController extends Controller{

    public function index(){
        $users = User::paginate(2);
        return view('admin.users.users', ['users' => $users]);
    }
}
