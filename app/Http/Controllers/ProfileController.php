<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

        // Assign only to ONE method in this Controller
        $this->middleware('auth');



    }
    public function index()
    {
        /*
        $profile=Profile::orderBy('id','desc')
        ->simplePaginate(8);

        return view('subscriber.profiles.edit',compact('profiles'));*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
        //$this->authorize('view',$profile);
        return view('subscriber.profiles.edit',compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        //
        //$this->authorize('update',$profile);
        $user = Auth::user();

        if ($request->hasfile('photo')){
            File::delete(public_path('storage/'.$profile->photo));
            // asignar nueva foto
            $photo=$request['photo']->store('profiles');

        }else{
            $photo =$user->profile->photo;
        }

        //asignar nombre y corre

        $user->full_name=$request->full_name;
        $user->email=$request->email;

        $user->profile->photo =$photo;

        //guargar campos de usuario

        $user->save();
        //guardar campos de perfil

        $user->profile->save();

        return redirect()->route('profiles.edit',$user->profile->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
