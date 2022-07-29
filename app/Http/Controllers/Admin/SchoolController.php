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

class SchoolController extends Controller
{
    private $urlSlugs, $titles;

    public function __construct()
    {
        $this->titles = "Schools";
        $this->urlSlugs = "schools";

        $areas = array();
        $allAreas = Area::where("status","Active")->orderBy("id","desc")->get(['id','title'])->toArray();
        foreach($allAreas as $allArea){
            $areas[$allArea['id']] = $allArea['title'];
        }

        $schoolTypes = array();
        $allSchoolTypes = SchoolType::where("status","Active")->orderBy("id","desc")->get(['id','title'])->toArray();
        foreach($allSchoolTypes as $allSchoolType){
            $schoolTypes[$allSchoolType['id']] = $allSchoolType['title'];
        }

        $schoolLevels = array();
        $allSchoolLevels = SchoolLevel::where("status","Active")->orderBy("id","desc")->get(['id','title'])->toArray();
        foreach($allSchoolLevels as $allSchoolLevel){
            $schoolLevels[$allSchoolLevel['id']] = $allSchoolLevel['title'];
        }

        $countries = array();
        $allCountries = Country::where("status","Active")->orderBy("id","desc")->get(['id','title'])->toArray();
        foreach($allCountries as $allCountry){
            $countries[$allCountry['id']] = $allCountry['title'];
        }

        $roles = array();
        $allRoles = Role::where("status","Active")->whereIn("title",array('Sales Rep','Sales Manager','TeleMarketing Rep','Director','Onboarding Rep','Onboarding Manager'))->orderBy("id","desc")->get(['id','title'])->toArray();
        foreach($allRoles as $allRole){
            $roles[$allRole['title']] = $allRole['id'];
        }

        $salesReps = array();
        //$allSalesReps = RoleUser::where("status","Active")->where("role_id",$roles['Sales Rep'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allSalesReps = RoleUser::select('role_users.*', 'roles.title', 'roles.description')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->where("role_id",$roles['Sales Rep'])
                            ->get()
                            ->toArray();
        foreach($allSalesReps as $allSalesRep){
            $salesReps[$allSalesRep['id']] = $allSalesRep['title'];
        }

        $salesManagers = array();
        //$allSalesManagers = RoleUser::where("status","Active")->where("role_id",$roles['Sales Manager'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allSalesManagers = RoleUser::select('role_users.*', 'roles.title', 'roles.description')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->where("role_id",$roles['Sales Manager'])
                            ->get()
                            ->toArray();
        foreach($allSalesManagers as $allSalesManager){
            $salesManagers[$allSalesManager['id']] = $allSalesManager['title'];
        }

        $teleMarketingReps = array();
        //$allteleMarketingReps = RoleUser::where("status","Active")->where("role_id",$roles['TeleMarketing Rep'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allteleMarketingReps = RoleUser::select('role_users.*', 'roles.title', 'roles.description')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->where("role_id",$roles['TeleMarketing Rep'])
                            ->get()
                            ->toArray();
        foreach($allteleMarketingReps as $allteleMarketingRep){
            $teleMarketingReps[$allteleMarketingRep['id']] = $allteleMarketingRep['title'];
        }

        $directors = array();
        //$allDirectors = RoleUser::where("status","Active")->where("role_id",$roles['Director'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allDirectors = RoleUser::select('role_users.*', 'roles.title', 'roles.description')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->where("role_id",$roles['Director'])
                            ->get()
                            ->toArray();
        foreach($allDirectors as $allDirector){
            $directors[$allDirector['id']] = $allDirector['title'];
        }

        $onboardingReps = array();
        //$allOnboardingReps = RoleUser::where("status","Active")->where("role_id",$roles['Onboarding Rep'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allOnboardingReps = RoleUser::select('role_users.*', 'roles.title', 'roles.description')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->where("role_id",$roles['Onboarding Rep'])
                            ->get()
                            ->toArray();
        foreach($allOnboardingReps as $allOnboardingRep){
            $onboardingReps[$allOnboardingRep['id']] = $allOnboardingRep['title'];
        }

        $onboardingManagers = array();
        //$allOnboardingManagers = RoleUser::where("status","Active")->where("role_id",$roles['Onboarding Manager'])->orderBy("id","desc")->get(['id','user_name'])->toArray();
        $allOnboardingManagers = RoleUser::select('role_users.*', 'roles.title', 'roles.description')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->where("role_id",$roles['Onboarding Manager'])
                            ->get()
                            ->toArray();
        foreach($allOnboardingManagers as $allOnboardingManager){
            $onboardingManagers[$allOnboardingManager['id']] = $allOnboardingManager['title'];
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
        $this->fieldItems = $fieldItems;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = School::orderBy('created_at','desc')->get();
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        return view('admin.'.$urlSlug.'.index', compact('items','urlSlug','title'));
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

        return view('admin.'.$urlSlug.'.create', compact('urlSlug','title','fieldItems'));
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
            $params['contract_till'] = date("Y-m-d",strtotime($params['contract_till']));
            $urlSlug = $this->urlSlugs;
            School::create($params);
            return redirect()->route($urlSlug.'.index')->with('success', 'Item created successfully.');
        }
        catch (\Exception $e) {
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
        return view('admin.'.$urlSlug.'.show', compact('item','urlSlug','title'));
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
        return view('admin.'.$urlSlug.'.edit', compact('item','urlSlug','title','fieldItems'));
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
            $params['contract_till'] = date("Y-m-d",strtotime($params['contract_till']));
            $urlSlug = $this->urlSlugs;
            $school->update($params);
            return redirect()->route($urlSlug.'.index')->with('success', 'Item updated successfully.');
        }
        catch (\Exception $e) {
            return back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception'=>$e->getMessage()]));
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
            $item = School::findOrFail($id);
            $item->update($params);
            return response()->json(['success'=>true, 'message'=>'Status Changes Successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['success'=>false, 'message'=>$e->getMessage()]);
        }
    }
}
