<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {

        // Assign only to ONE method in this Controller
        $this->middleware('can:roles.index')->only('index');
        $this->middleware('can:roles.create')->only(['create', 'store']);
        $this->middleware('can:roles.edit')->only(['edit', 'update']);
        $this->middleware('can:roles.destroy')->only('destroy');

    }
     public function index()
    {
        //
        $roles=Role::simplePaginate(10);
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$permission = Permission::get();
        $permissions=Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //


        $request->validate([
            'name'=>'required',

        ]);

        $role = Role::create([
            'name'=>$request->name,
        ]);

        $role->permissions()->sync($request->permissions);
        return redirect()->action([RoleController::class,'index'])
        ->with('success-create','Rol creado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
        $permissions=Permission::all();
        return view('admin.roles.edit',compact('permissions','role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        $request->validate([
            'name'=>'required',

        ]);

        $role = Role::update([
            'name'=>$request->name,
        ]);

        $role->permissions()->sync($request->permissions);
        return redirect()->action([RoleController::class,'index'])
        ->with('success-update','Rol modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //

        $role->delete();
        return redirect()->action([RoleController::class,'index'])
        ->with('success-delete','Rol Eliminado con exito');

    }
}
