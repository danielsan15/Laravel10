<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {

         // Assign only to ONE method in this Controller
         $this->middleware('can:users.index')->only('index');
         $this->middleware('can:users.edit')->only(['edit', 'update']);
         $this->middleware('can:users.destroy')->only('destroy');


     }

    public function index()
    {
        //
        $users=User::simplePaginate(10);

        return view('admin.users.index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        $roles=Role::all();
        return view('admin.users.edit',compact('user','roles'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //llenar la tabla intermedia

        $user->roles()->sync($request->role);
        return redirect()->route('users.edit',$user)
                        ->with('success-update','Rol establecido con exito');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return redirect()->action([UserController::class,'index'])
                ->with('success-delete','Usuario eliminado con exito');
    }
}
