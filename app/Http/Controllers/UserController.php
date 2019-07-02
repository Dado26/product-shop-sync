<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UserRequest;

use App\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function create(){
        
       
        return view('user.create');
    }

    public function store(UserRequest $request)
    {
       
        $params=$request->all();
        $params['password'] = bcrypt('asdasd');
    
        User::create($params);
    
        return redirect()->route('index.users');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request,User $user)
    {
        $params = $request->all();
        $params['password'] = bcrypt($params['password']);

        $user->update($params);

        return redirect()->route('index.users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        //flash('Uspešno ste izbrisali predmet!!')->success();
        return redirect()->route('index.users');
    }
}
