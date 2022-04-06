<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(Request $request){
        $user = Auth::user();
        return view('app.settings', ['user' => $user]);
    }

    public function basic_settings(Request $request){
//        $data = $request->all();
        $data = $request->validate([
            'fname' => ['required','string','max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'company' => ['nullable'],
            'dob' => ['nullable'],
            'gender' => ['nullable','in:male,female,other', 'sometimes'],
            'currency' => ['exists:currencies,code'],
        ]);

        $user = Auth::user();

        $user->update($data);

        $user->save();

        return redirect()->back()->with('success','Setting Saved Successfully');

    }
    public function contact_settings(Request $request){
//        $data = $request->all();
        $data = $request->validate([
            'contact' => ['nullable','numeric','digits_between:10,13'],
            'address' => ['nullable']
        ]);

        $user = Auth::user();

        $user->update($data);

        $user->save();

        return redirect()->back()->with('success','Setting Saved Successfully');

    }
    public function security_settings(Request $request){
//        $data = $request->all();
    $data = $request->validate([
        'current_password' => ['required','string','min:8'],
        'password' => ['required','string','min:8','confirmed']
    ]);

    $user = Auth::user();
    if(Hash::check($data['current_password'],$user->password)){
        $hash=Hash::make($data['password']);
        $user->password=$hash;
        $user->save();

        return redirect()->back()->with('success','Password Changed Successfully');
    }

    return redirect()->back()->with('danger','Incorrect Current Password');

}
}
