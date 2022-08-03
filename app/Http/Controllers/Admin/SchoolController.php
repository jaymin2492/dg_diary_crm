<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolType;
use App\Models\SchoolLevel;
use App\Models\Area;
use App\Models\Country;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    private $urlSlugs, $titles;

    public function __construct()
    {
        $this->titles = "Schools";
        $this->urlSlugs = "schools";

        $areas = array();
        $allAreas = Area::where("status", "Active")->orderBy("id", "desc")->get(['id', 'title'])->toArray();
        foreach ($allAreas as $allArea) {
            $areas[$allArea['id']] = $allArea['title'];
        }

        $schoolTypes = array();
        $allSchoolTypes = SchoolType::where("status", "Active")->orderBy("id", "desc")->get(['id', 'title'])->toArray();
        foreach ($allSchoolTypes as $allSchoolType) {
            $schoolTypes[$allSchoolType['id']] = $allSchoolType['title'];
        }

        $schoolLevels = array();
        $allSchoolLevels = SchoolLevel::where("status", "Active")->orderBy("id", "desc")->get(['id', 'title'])->toArray();
        foreach ($allSchoolLevels as $allSchoolLevel) {
            $schoolLevels[$allSchoolLevel['id']] = $allSchoolLevel['title'];
        }

        $countries = array();
        $allCountries = Country::where("status", "Active")->orderBy("id", "desc")->get(['id', 'title'])->toArray();
        foreach ($allCountries as $allCountry) {
            $countries[$allCountry['id']] = $allCountry['title'];
        }

        $roles = array();
        $allRoles = Role::where("status", "Active")->whereIn("title", array('Sales Rep', 'Sales Manager', 'TeleMarketing Rep', 'Director', 'Onboarding Rep', 'Onboarding Manager'))->orderBy("id", "desc")->get(['id', 'title'])->toArray();
        foreach ($allRoles as $allRole) {
            $roles[$allRole['title']] = $allRole['id'];
        }

        $salesReps = array();
        //$allSalesReps = RoleUser::where("status","Active")->where("role_id",$roles['Sales Rep'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allSalesReps = RoleUser::select('role_users.*', 'roles.title', 'roles.description', 'users.name', 'users.email')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->join('users', 'users.id', '=', 'role_users.user_id')
            ->where("role_id", $roles['Sales Rep'])
            ->get()
            ->toArray();
        foreach ($allSalesReps as $allSalesRep) {
            $salesReps[$allSalesRep['id']] = $allSalesRep['name'];
        }

        $salesManagers = array();
        //$allSalesManagers = RoleUser::where("status","Active")->where("role_id",$roles['Sales Manager'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allSalesManagers = RoleUser::select('role_users.*', 'roles.title', 'roles.description', 'users.name', 'users.email')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->join('users', 'users.id', '=', 'role_users.user_id')
            ->where("role_id", $roles['Sales Manager'])
            ->get()
            ->toArray();
        foreach ($allSalesManagers as $allSalesManager) {
            $salesManagers[$allSalesManager['id']] = $allSalesManager['name'];
        }

        $teleMarketingReps = array();
        //$allteleMarketingReps = RoleUser::where("status","Active")->where("role_id",$roles['TeleMarketing Rep'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allteleMarketingReps = RoleUser::select('role_users.*', 'roles.title', 'roles.description', 'users.name', 'users.email')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->join('users', 'users.id', '=', 'role_users.user_id')
            ->where("role_id", $roles['TeleMarketing Rep'])
            ->get()
            ->toArray();
        foreach ($allteleMarketingReps as $allteleMarketingRep) {
            $teleMarketingReps[$allteleMarketingRep['id']] = $allteleMarketingRep['name'];
        }

        $directors = array();
        //$allDirectors = RoleUser::where("status","Active")->where("role_id",$roles['Director'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allDirectors = RoleUser::select('role_users.*', 'roles.title', 'roles.description', 'users.name', 'users.email')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->join('users', 'users.id', '=', 'role_users.user_id')
            ->where("role_id", $roles['Director'])
            ->get()
            ->toArray();
        foreach ($allDirectors as $allDirector) {
            $directors[$allDirector['id']] = $allDirector['name'];
        }

        $onboardingReps = array();
        //$allOnboardingReps = RoleUser::where("status","Active")->where("role_id",$roles['Onboarding Rep'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allOnboardingReps = RoleUser::select('role_users.*', 'roles.title', 'roles.description', 'users.name', 'users.email')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->join('users', 'users.id', '=', 'role_users.user_id')
            ->where("role_id", $roles['Onboarding Rep'])
            ->get()
            ->toArray();
        foreach ($allOnboardingReps as $allOnboardingRep) {
            $onboardingReps[$allOnboardingRep['id']] = $allOnboardingRep['name'];
        }

        $onboardingManagers = array();
        //$allOnboardingManagers = RoleUser::where("status","Active")->where("role_id",$roles['Onboarding Manager'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allOnboardingManagers = RoleUser::select('role_users.*', 'roles.title', 'roles.description', 'users.name', 'users.email')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->join('users', 'users.id', '=', 'role_users.user_id')
            ->where("role_id", $roles['Onboarding Manager'])
            ->get()
            ->toArray();
        foreach ($allOnboardingManagers as $allOnboardingManager) {
            $onboardingManagers[$allOnboardingManager['id']] = $allOnboardingManager['name'];
        }

        $statuses = array();
        $allStatuses = Status::where("status", "Active")->orderBy("id", "asc")->get(['id', 'title'])->toArray();
        foreach ($allStatuses as $allStatus) {
            $statuses[$allStatus['id']] = $allStatus['title'];
        }

        $fieldItems = array();
        $fieldItems['areas'] = $areas;
        $fieldItems['schoolTypes'] = $schoolTypes;
        $fieldItems['schoolLevels'] = $schoolLevels;
        $fieldItems['countries'] = $countries;
        $fieldItems['salesReps'] = $salesReps;
        $fieldItems['salesManagers'] = $salesManagers;
        $fieldItems['teleMarketingReps'] = $teleMarketingReps;
        $fieldItems['directors'] = $directors;
        $fieldItems['onboardingReps'] = $onboardingReps;
        $fieldItems['onboardingManagers'] = $onboardingManagers;
        $fieldItems['statuses'] = $statuses;
        $this->fieldItems = $fieldItems;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curUser = Auth::user();
        $curUserRole = $curUser->currentRole();
        if ($curUserRole == "Superadmin") {
            $items = School::orderBy('created_at', 'desc')->get();
        } else {
            if ($curUserRole == "Sales Rep") {
                $keyCheck = "sales_rep_id";
            } elseif ($curUserRole == "Sales Manager") {
                $keyCheck = "sales_manager_id";
            } elseif ($curUserRole == "TeleMarketing Rep") {
                $keyCheck = "telemarketing_rep_id";
            } elseif ($curUserRole == "Director") {
                $keyCheck = "director_id";
            } elseif ($curUserRole == "Onboarding Rep") {
                $keyCheck = "onboarding_rep_id";
            } elseif ($curUserRole == "Onboarding Manager") {
                $keyCheck = "onboarding_manager_id";
            }
            $items = School::where($keyCheck, $curUser->currentUSerRoleId())->orderBy('created_at', 'desc')->get();
        }
        $fieldItems = $this->fieldItems;
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        return view('admin.' . $urlSlug . '.index2', compact('items', 'urlSlug', 'title', 'fieldItems'));
        return view('admin.' . $urlSlug . '.index', compact('items', 'urlSlug', 'title', 'fieldItems'));
        //return view('admin.'.$urlSlug.'.index', compact('items','urlSlug','title'))->with('i', (request()->input('page', 1) - 1) * 5);
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

        $fieldItems = $this->fieldItems;

        return view('admin.' . $urlSlug . '.create', compact('urlSlug', 'title', 'fieldItems'));
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
                'title' => 'required',
                //'description' => 'required',
                //'status' => 'required'
            ]);
            $params = $request->all();
            $params['contract_till'] = date("Y-m-d", strtotime($params['contract_till']));
            $params['folow_up_date'] = date("Y-m-d", strtotime($params['folow_up_date']));
            $urlSlug = $this->urlSlugs;
            School::create($params);
            return redirect()->route($urlSlug . '.index')->with('success', 'Item created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        $item = $school;
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        return view('admin.' . $urlSlug . '.show', compact('item', 'urlSlug', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        $item = $school;
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        $fieldItems = $this->fieldItems;
        return view('admin.' . $urlSlug . '.edit', compact('item', 'urlSlug', 'title', 'fieldItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {
        try {
            $request->validate([
                'title' => 'required',
                //'description' => 'required',
                //'status' => 'required'
            ]);
            $params = $request->all();
            $params['contract_till'] = date("Y-m-d", strtotime($params['contract_till']));
            $params['folow_up_date'] = date("Y-m-d", strtotime($params['folow_up_date']));
            $urlSlug = $this->urlSlugs;
            $school->update($params);
            return redirect()->route($urlSlug . '.index')->with('success', 'Item updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception' => $e->getMessage()]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        $school->delete();
        $urlSlug = $this->urlSlugs;
        return redirect()->route($urlSlug . '.index')->with('success', 'Item deleted successfully');
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
            $item = School::findOrFail($id);
            $item->update($params);
            return response()->json(['success' => true, 'message' => 'Status Changes Successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function field_update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'key' => 'required',
                'value' => 'required'
            ]);
            $params = $request->all();
            $id = $params['id'];
            unset($params['id']);
            $item = School::findOrFail($id);
            $newParams = array();
            $newParams[$params['key']] = $params['value'];
            $item->update($newParams);
            if ($params['key'] == "status_id" || $params['key'] == "manager_status_id") {
                $allStatuses = Status::where("id", $params['value'])->get(['id', 'title'])->toArray();
                $params['value'] = $allStatuses[0]['title'];
            }
            return response()->json(['success' => true, 'message' => 'School Updated Successfully', 'new_value' => $params['value']]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function ajax_list(Request $request)
    {
        try {
            $curUser = Auth::user();
            
            $curUserRole = $curUser->currentRole();
            if ($curUserRole == "Superadmin") {
                $items = School::orderBy('created_at', 'desc')->get();
            } else {
                if ($curUserRole == "Sales Rep") {
                    $keyCheck = "sales_rep_id";
                } elseif ($curUserRole == "Sales Manager") {
                    $keyCheck = "sales_manager_id";
                } elseif ($curUserRole == "TeleMarketing Rep") {
                    $keyCheck = "telemarketing_rep_id";
                } elseif ($curUserRole == "Director") {
                    $keyCheck = "director_id";
                } elseif ($curUserRole == "Onboarding Rep") {
                    $keyCheck = "onboarding_rep_id";
                } elseif ($curUserRole == "Onboarding Manager") {
                    $keyCheck = "onboarding_manager_id";
                }
                $items = School::where($keyCheck, $curUser->currentUSerRoleId())->orderBy('created_at', 'desc')->get();
            }
            
            $fieldItems = $this->fieldItems;
            $urlSlug = $this->urlSlugs;
            $title = $this->titles;
            $newData = array();
            if(!empty($items->toArray())){
                foreach($items->toArray() as $k=>$item){
                    $newData[$k][] = $item['id'];
                    if(isset($fieldItems['salesReps'][$item['sales_rep_id']])){
                        $newData[$k][] = $fieldItems['salesReps'][$item['sales_rep_id']];
                    }else{
                        $newData[$k][] = $item['sales_rep_id'];
                    }
                    $newData[$k][] = $item['title'];
                    $newData[$k][] = $item['population'];




                    $statusHTML= '';
                    $statusHTML.= '<div class="editable_field">';
                    if(isset($fieldItems['statuses'][$item['status_id']])){
                        $statusHTML.= $fieldItems['statuses'][$item['status_id']];
                    }else{
                        $statusHTML.= $item['status_id'];
                    }
                    $statusHTML.= '</div>';
                    $statusHTML.= '<div class="editable_form">';
                    $statusHTML.= '<select class="form-select" name="status_id" data-id="'.$item['id'].'" required><option value="">Please Select</option>';
                    foreach($fieldItems['statuses'] as $key => $value){
                        if($item['status_id'] == $key ){
                            $statusHTML.= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                        }else{
                            $statusHTML.= '<option value="'.$key.'">'.$value.'</option>';
                        }
                    }
                    if(isset($fieldItems['statuses'][$item['status_id']])){
                        $statusHTML.= $fieldItems['statuses'][$item['status_id']];
                    }else{
                        $statusHTML.= $item['status_id'];
                    }
                    $statusHTML.= '</select>';
                    $newData[$k][] = $statusHTML;

                    $newData[$k][] = $item['closure_month'];
                    $newData[$k][] = $item['folow_up_date'];
                    if(isset($fieldItems['statuses'][$item['manager_status_id']])){
                        $newData[$k][] = $fieldItems['statuses'][$item['manager_status_id']];
                    }else{
                        $newData[$k][] = $item['manager_status_id'];
                    }

                    $actionsHTML = '';
                    $actionsHTML.= '<a href="'.URL('/admin/'.$urlSlug. '/' . $item['id'] . '/edit').'" class="btn btn-sm btn-primary" title="Edit"><i class="mdi mdi-square-edit-outline"></i> Edit</a>';
                    $actionsHTML.= '<div class="btn-group" style="margin-left: 10px;">';
                    $actionsHTML.= '</div>';
                    if ($item['status'] == 'Active'){
                        $actionsHTML.= '<button type="button" class="btn btn-sm btn-success dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">Active<i class="mdi mdi-chevron-down"></i></button><div class="dropdown-menu"><a class="dropdown-item change_Status deactivate_it" href="javascript: void(0);" data-id="'.$item['id'].'">Inactive</a></div>';
                    }else{
                        $actionsHTML.= '<button type="button" class="btn btn-sm btn-danger dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">Inactive<i class="mdi mdi-chevron-down"></i></button><div class="dropdown-menu"><a class="dropdown-item change_Status activate_it" href="javascript: void(0);" data-id="'.$item['id'].'">Active</a></div>';
                    }
                    $newData[$k][] = '<a href="'.URL('admin/school_contacts/'.$item['id']).'" class="btn btn-sm btn-secondary"><i class="bx bxs-plus-circle"></i> <span>Contacts</span></a>&nbsp;&nbsp;<a href="'.URL('admin/school_notes/'.$item['id']).'" class="btn btn-sm btn-info"><i class="bx bxs-plus-circle"></i> <span>Notes</span></a>';
                    $newData[$k][] = $actionsHTML;
                }
            }
            return response()->json(['draw' => true, 'data' => $newData]);
            //return view('admin.'.$urlSlug.'.index', compact('items','urlSlug','title'))->with('i', (request()->input('page', 1) - 1) * 5);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
