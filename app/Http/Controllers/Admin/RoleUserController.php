<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RoleUserController extends Controller
{
    
    private $urlSlugs, $titles;

    public function __construct()
    {
        $this->titles = "Users";
        $this->urlSlugs = "role_users";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::with('role')->orderBy('created_at','desc')->get();
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        $roles = Role::where("status","Active")->get()->toArray();
        $idWiseRoles = array();
        foreach ($roles as $role){
            $idWiseRoles[$role['id']] = $role['title'];
        }
        $roles = $idWiseRoles;
        return view('admin.'.$urlSlug.'.index', compact('items','urlSlug','title','roles'));
        //return view('admin.'.$urlSlug.'.index', compact('items','urlSlug','title','roles'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        $roles = Role::where("status","Active")->get()->toArray();
        return view('admin.'.$urlSlug.'.create', compact('urlSlug','title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_name' => 'required',
                'role_id' => 'required|integer',
                //'status' => 'required'
                'email' => 'required|unique:users,email',
                //'password' => 'required'
            ]);
            $params = $request->all();
            $urlSlug = $this->urlSlugs;
            $userParams = array();
            $userParams['name'] = $params['user_name'];
            $userParams['email'] = $params['email'];
            if(isset($params['password']) && !empty($params['password'])){
                $userParams['password'] = Hash::make($params['password']);
            }
            $createdUser = User::create($userParams);
            $roleUser = array();
            $roleUser['role_id'] = $params['role_id'];
            $roleUser['user_id'] = $createdUser->id;
            RoleUser::create($roleUser);
            return redirect()->route($urlSlug.'.index')->with('success', 'Item created successfully.');
        }
        catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoleUser  $roleUser
     * @return \Illuminate\Http\Response
     */
    public function show(RoleUser $roleUser)
    {
        $item = $roleUser;
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        $roles = Role::where("status","Active")->get()->toArray();
        return view('admin.'.$urlSlug.'.show', compact('item','urlSlug','title','roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoleUser  $roleUser
     * @return \Illuminate\Http\Response
     */
    public function edit(RoleUser $roleUser)
    {
        $item = $roleUser;
        $item = User::with('role')->where("id",$roleUser->user_id)->first();
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        $roles = Role::where("status","Active")->get()->toArray();
        return view('admin.'.$urlSlug.'.edit', compact('item','urlSlug','title','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoleUser  $roleUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoleUser $roleUser)
    {
        try {
            $request->validate([
                'user_name' => 'required',
                'role_id' => 'required|integer',
                //'status' => 'required'
                'email' => 'required|unique:users,email,'.$roleUser->user_id,
                //'password' => 'required'
            ]);
            $params = $request->all();
            $userParams = array();
            $userParams['name'] = $params['user_name'];
            $userParams['email'] = $params['email'];
            if(isset($params['password']) && !empty($params['password'])){
                $userParams['password'] = Hash::make($params['password']);
            }
            User::where("id",$roleUser->user_id)->update($userParams);
            $roleUseri = array();
            $roleUseri['role_id'] = $params['role_id'];
            $roleUseri['user_id'] = $roleUser->user_id;
            $roleUser->update($roleUseri);
            $urlSlug = $this->urlSlugs;
            return redirect()->route($urlSlug.'.index')->with('success', 'Item updated successfully.');
        }
        catch (\Exception $e) {
            return back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception'=>$e->getMessage()]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoleUser  $roleUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleUser $roleUser)
    {
        $roleUser->delete();
        $urlSlug = $this->urlSlugs;
        return redirect()->route($urlSlug.'.index')->with('success', 'Item deleted successfully');
    }

    public function change_Status(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'status' => 'required'
            ]);
            $params = $request->all();
            $id = $params['id'];
            unset($params['id']);
            $item = User::findOrFail($id);
            $item->update($params);
            return response()->json(['success'=>true, 'message'=>'Status Changes Successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['success'=>false, 'message'=>$e->getMessage()]);
        }
    }
}
