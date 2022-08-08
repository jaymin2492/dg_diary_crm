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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
            if(!empty($params['contract_till'])){
                $params['contract_till'] = date("Y-m-d", strtotime($params['contract_till']));
            }
            if(!empty($params['folow_up_date'])){
                $params['folow_up_date'] = date("Y-m-d", strtotime($params['folow_up_date']));
            }
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
            if(!empty($params['contract_till'])){
                $params['contract_till'] = date("Y-m-d", strtotime($params['contract_till']));
            }
            if(!empty($params['folow_up_date'])){
                $params['folow_up_date'] = date("Y-m-d", strtotime($params['folow_up_date']));
            }
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
                //'value' => 'required'
            ]);
            $params = $request->all();
            $id = $params['id'];
            unset($params['id']);
            $item = School::findOrFail($id);
            $newParams = array();
            
            if ($params['key'] == "folow_up_date") {
                if(!empty($params['value'])){
                    $params['value'] = str_replace(" ","-",$params['value']);
                    $params['value'] = str_replace(",","-",$params['value']);
                    $newParams[$params['key']] = date("Y-m-d",strtotime($params['value']));
                }else{
                    $newParams[$params['key']] = NULL;
                }
            }else{
                $newParams[$params['key']] = $params['value'];
            }
            $item->update($newParams);
            if ($params['key'] == "status_id" || $params['key'] == "manager_status_id") {
                $allStatuses = Status::where("id", $params['value'])->get(['id', 'title'])->toArray();
                $params['value'] = $allStatuses[0]['title'];
            }
            if ($params['key'] == "folow_up_date") {
                if(!empty($params['value'])){
                    $params['value'] = date("d-M-y",strtotime($params['value']));
                }
            }
            if(empty($params['value'])){
                $params['value'] = '-';
            }
            return response()->json(['success' => true, 'message' => 'School Updated Successfully', 'new_value' => $params['value']]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function bulk_upload(Request $request)
    {
        try {
            $request->validate([
                'bulk_upload' => 'required',
                //'value' => 'required'
            ]);
            $params = $request->all();
            $urlSlug = $this->urlSlugs;
            $data = array();
            $the_file = $request->file('bulk_upload');
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 1, $row_limit );
            $column_range = range( 'F', $column_limit );
            if($column_limit !== "U"){
                return back()->withErrors('Invalid File Format')->withInput();
            }
            $startcount = 1;
            foreach ( $row_range as $i=>$row ) {
                if($i == 0){
                    $arrayKeys = array();
                    $arrayKeys[] = $sheet->getCell( 'A' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'B' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'C' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'D' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'E' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'F' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'G' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'H' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'I' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'J' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'K' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'L' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'M' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'N' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'O' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'P' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'Q' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'R' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'S' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'T' . $row )->getValue();
                    $arrayKeys[] = $sheet->getCell( 'U' . $row )->getValue();
                    $arrayKeysFiltered = array_filter($arrayKeys);
                    if(count($arrayKeys) > 21 || count($arrayKeys) < 21){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(count($arrayKeysFiltered) !== count($arrayKeys)){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[0]) !== "Name *"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[1]) !== "School Type *"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[2]) !== "School Level *"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[3]) !== "Country *"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[4]) !== "Area *"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[5]) !== "Population"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[6]) !== "System"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[7]) !== "Online Student Portal"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[8]) !== "Name Of system"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[9]) !== "Contract Date"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[10]) !== "Sales Rep *"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[11]) !== "Sales Manager"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[12]) !== "Telemarketing Rep"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[13]) !== "Director"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[14]) !== "Onboarding Rep"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[15]) !== "Onboarding Manager"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[16]) !== "School Tution"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[17]) !== "Current Status"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[18]) !== "Current Status by manager"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[19]) !== "Follow Up Date"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }elseif(trim($arrayKeys[20]) !== "Closure Month"){
                        return back()->withErrors('Invalid File Format')->withInput();
                    }
                }else{
                   /*  $fieldItems = array();
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
                    $fieldItems['statuses'] = $statuses; */
                    $fieldItems = $this->fieldItems;
                    $schoolType = $sheet->getCell( 'B' . $row )->getValue();
                    $schoolTypeId = array_search(trim($schoolType), $fieldItems['schoolTypes']);
                    if(empty($schoolTypeId)){
                        return back()->withErrors('Invalid School Type at Row #'.$i)->withInput();
                    }

                    $schoolLevel = $sheet->getCell( 'C' . $row )->getValue();
                    $schoolLevelId = array_search(trim($schoolLevel), $fieldItems['schoolLevels']);
                    if(empty($schoolLevelId)){
                        return back()->withErrors('Invalid School Level at Row #'.$i)->withInput();
                    }

                    $country = $sheet->getCell( 'D' . $row )->getValue();
                    $countryId = array_search(trim($country), $fieldItems['countries']);
                    if(empty($countryId)){
                        return back()->withErrors('Invalid Country at Row #'.$i)->withInput();
                    }

                    $area = $sheet->getCell( 'E' . $row )->getValue();
                    $areaId = array_search(trim($area), $fieldItems['areas']);
                    if(empty($areaId)){
                        return back()->withErrors('Invalid Area at Row #'.$i)->withInput();
                    }

                    $system = $sheet->getCell( 'G' . $row )->getValue();
                    if(!empty($system) && ($system == "Yes" || $system == "No")){

                    }elseif(empty($system)){
                        $system = NULL;
                    }else{
                        return back()->withErrors('Invalid System at Row #'.$i)->withInput();
                    }

                    $online_student_portal = trim($sheet->getCell( 'H' . $row )->getValue());
                    if(!empty($online_student_portal) && ($online_student_portal == "Yes" || $online_student_portal == "No")){

                    }elseif(empty($online_student_portal)){
                        $online_student_portal = NULL;
                    }else{
                        return back()->withErrors('Invalid Online Student Portal at Row #'.$i)->withInput();
                    }

                    $contract_till = trim($sheet->getCell( 'J' . $row )->getValue());
                    if(!empty($contract_till)){
                        $contract_till = ($contract_till - 25569) * 86400;
                        $contract_till = gmdate("Y-m-d",$contract_till);
                    }else{
                        $contract_till = NULL;
                    }

                    $salesRep = $sheet->getCell( 'K' . $row )->getValue();
                    $salesRepId = array_search(trim($salesRep), $fieldItems['salesReps']);
                    if(empty($salesRepId)){
                        return back()->withErrors('Invalid Sales Rep at Row #'.$i)->withInput();
                    }

                    $salesManager = $sheet->getCell( 'L' . $row )->getValue();
                    if(!empty($salesManager)){
                        $salesManagerId = array_search(trim($salesManager), $fieldItems['salesManagers']);
                        if(empty($salesManagerId)){
                            return back()->withErrors('Invalid Sales Manager at Row #'.$i)->withInput();
                        }
                    }else{
                        $salesManagerId = NULL;
                    }

                    $teleMarketingRep = $sheet->getCell( 'M' . $row )->getValue();
                    if(!empty($teleMarketingRep)){
                        $teleMarketingRepId = array_search(trim($teleMarketingRep), $fieldItems['teleMarketingReps']);
                        if(empty($teleMarketingRepId)){
                            return back()->withErrors('Invalid Telemarketing Rep at Row #'.$i)->withInput();
                        }
                    }else{
                        $teleMarketingRepId = NULL;
                    }

                    $director = $sheet->getCell( 'N' . $row )->getValue();
                    if(!empty($director)){
                        $directorId = array_search(trim($director), $fieldItems['directors']);
                        if(empty($directorId)){
                            return back()->withErrors('Invalid Director at Row #'.$i)->withInput();
                        }
                    }else{
                        $directorId = NULL;
                    }

                    $onboardingRep = $sheet->getCell( 'O' . $row )->getValue();
                    if(!empty($onboardingRep)){
                        $onboardingRepId = array_search(trim($onboardingRep), $fieldItems['onboardingReps']);
                        if(empty($onboardingRepId)){
                            return back()->withErrors('Invalid Onboarding Rep at Row #'.$i)->withInput();
                        }
                    }else{
                        $onboardingRepId = NULL;
                    }

                    $onboardingManager = $sheet->getCell( 'P' . $row )->getValue();
                    if(!empty($onboardingManager)){
                        $onboardingManagerId = array_search(trim($onboardingManager), $fieldItems['onboardingManagers']);
                        if(empty($onboardingManagerId)){
                            return back()->withErrors('Invalid Onboarding Manager at Row #'.$i)->withInput();
                        }
                    }else{
                        $onboardingManagerId = NULL;
                    }

                    $school_tution = trim($sheet->getCell( 'Q' . $row )->getValue());
                    if(!empty($school_tution) && ($school_tution == "Free" || $school_tution == "Paid")){

                    }elseif(empty($school_tution)){
                        $school_tution = NULL;
                    }else{
                        return back()->withErrors('Invalid School Tution at Row #'.$i)->withInput();
                    }

                    $status = $sheet->getCell( 'R' . $row )->getValue();
                    if(!empty($status)){
                        $statusId = array_search(trim($status), $fieldItems['statuses']);
                        if(empty($statusId)){
                            return back()->withErrors('Invalid Stage at Row #'.$i)->withInput();
                        }
                    }else{
                        $statusId = NULL;
                    }

                    $managerStatus = $sheet->getCell( 'S' . $row )->getValue();
                    if(!empty($managerStatus)){
                        $managerStatusId = array_search(trim($managerStatus), $fieldItems['statuses']);
                        if(empty($managerStatusId)){
                            return back()->withErrors('Invalid Manager Status at Row #'.$i)->withInput();
                        }
                    }else{
                        $managerStatusId = NULL;
                    }

                    $folow_up_date = trim($sheet->getCell( 'T' . $row )->getValue());
                    if(!empty($folow_up_date)){
                        $folow_up_date = ($folow_up_date - 25569) * 86400;
                        //$folow_up_date = date("Y-m-d",strtotime(trim($folow_up_date)));
                        $folow_up_date = gmdate("Y-m-d",$folow_up_date);
                    }else{
                        $folow_up_date = NULL;
                    }

                    $closure_month = trim($sheet->getCell( 'U' . $row )->getValue());
                    if(!empty($closure_month) && ($closure_month == "January" || $closure_month == "February" || $closure_month == "March" || $closure_month == "April" || $closure_month == "May" || $closure_month == "June" || $closure_month == "July" || $closure_month == "August" || $closure_month == "September" || $closure_month == "October" || $closure_month == "November" || $closure_month == "December")){

                    }elseif(empty($closure_month)){
                        $closure_month = NULL;
                    }else{
                        return back()->withErrors('Invalid Closure Month at Row #'.$i)->withInput();
                    }
                    
                    $data[] = [
                        'title' =>trim($sheet->getCell( 'A' . $row )->getValue()),
                        'school_type_id' => $schoolTypeId,
                        'school_level_id' => $schoolLevelId,
                        'country_id' => $countryId,
                        'area_id' => $areaId,
                        'population' =>trim($sheet->getCell( 'F' . $row )->getValue()),
                        'system' =>$system,
                        'online_student_portal' =>$online_student_portal,
                        'name_of_the_system' =>trim($sheet->getCell( 'I' . $row )->getValue()),
                        'contract_till' =>$contract_till,
                        'sales_rep_id' =>$salesRepId,
                        'sales_manager_id' =>$salesManagerId,
                        'telemarketing_rep_id' =>$teleMarketingRepId,
                        'director_id' =>$directorId,
                        'onboarding_rep_id' =>$onboardingRepId,
                        'onboarding_manager_id' =>$onboardingManagerId,
                        'school_tution' =>$school_tution,
                        'status_id' =>$statusId,
                        'manager_status_id' =>$managerStatusId,
                        'folow_up_date' =>$folow_up_date,
                        'closure_month' =>$closure_month
                    ];
                }
            }
            if(!empty($data)){
                School::insert($data);
                return redirect()->route($urlSlug . '.index')->with('success', 'Bulk Import successfully done.');
            }
            return back()->withErrors('No valid Rows found to import')->withInput();
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }


    public function ajax_list(Request $request)
    {
        try {
            $curUser = Auth::user();
            $curUserRole = $curUser->currentRole();
            $params = $request->all();
            
            $searchValue = '';
            $fieldItems = $this->fieldItems;
            if(isset($params['search']['value']) && !empty($params['search']['value'])){
                $searchValue = $params['search']['value'];
                $salesReps = $fieldItems['salesReps'];
                $matchingSalesReps = array();
                foreach($salesReps as $key=>$salesRep){
                    if (strpos($salesRep, $searchValue) !== false) {
                        $matchingSalesReps[] = $key;
                    }
                }
                $statuses = $fieldItems['statuses'];
                $matchingStatuses = array();
                foreach($statuses as $key=>$status){
                    if (strpos($status, $searchValue) !== false) {
                        $matchingStatuses[] = $key;
                    }
                }
            }

            $orderKey = "created_at";
            $order = 'desc';
            if(isset($params['order'][0]['column']) && !empty($params['order'][0]['column'])){
                if($params['order'][0]['column'] == "0"){
                    $orderKey = "id";
                }elseif($params['order'][0]['column'] == "2"){
                    $orderKey = "title";
                }elseif($params['order'][0]['column'] == "3"){
                    $orderKey = "population";
                }elseif($params['order'][0]['column'] == "5"){
                    $orderKey = "closure_month";
                }elseif($params['order'][0]['column'] == "6"){
                    $orderKey = "folow_up_date";
                }
                $order = $params['order'][0]['dir'];
            }
            
            
            if ($curUserRole == "Superadmin") {
                if(!empty($searchValue)){
                    $items = School::where(function($q) use ($searchValue,$matchingSalesReps,$matchingStatuses){
                        $q->where('title','LIKE','%'.$searchValue.'%')
                        ->orWhere('population','LIKE','%'.$searchValue.'%')
                        ->orWhere('closure_month','LIKE','%'.$searchValue.'%')
                        ->orWhere('folow_up_date','LIKE','%'.$searchValue.'%');
                        if(!empty($matchingSalesReps)){
                            $q->orWhereIn('sales_rep_id',$matchingSalesReps);
                        }
                        if(!empty($matchingStatuses)){
                            $q->orWhereIn('status_id',$matchingStatuses)->orWhereIn('manager_status_id',$matchingStatuses);
                        }
                    })->orderBy($orderKey, $order);
                }else{
                    $items = School::orderBy($orderKey, $order);
                }
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
                if(!empty($searchValue)){
                    $items = School::where(function($q) use ($searchValue,$matchingSalesReps,$matchingStatuses){
                        $q->where('title','LIKE','%'.$searchValue.'%')
                        ->orWhere('population','LIKE','%'.$searchValue.'%')
                        ->orWhere('closure_month','LIKE','%'.$searchValue.'%')
                        ->orWhere('folow_up_date','LIKE','%'.$searchValue.'%');
                        if(!empty($matchingSalesReps)){
                            $q->orWhereIn('sales_rep_id',$matchingSalesReps);
                        }
                        if(!empty($matchingStatuses)){
                            $q->orWhereIn('status_id',$matchingStatuses)->orWhereIn('manager_status_id',$matchingStatuses);
                        }
                    })
                    ->where($keyCheck, $curUser->currentUSerRoleId())
                    ->orderBy($orderKey, $order);
                }else{
                    $items = School::where($keyCheck, $curUser->currentUSerRoleId())->orderBy($orderKey, $order);
                }
            }

            $totalRows = $items->get()->count();
            $page = 1;
            if(isset($request->start) && !empty($request->start) && $request->start > 1){
                $page = $request->length/$request->start;
                $page = $page + 1;
            }
            $items = $items->paginate(10, ['*'], 'page', $page);
            //"recordsTotal": 57,
            $items = $items->toArray();
            
            $urlSlug = $this->urlSlugs;
            $title = $this->titles;
            $newData = array();
            if(!empty($items['data'])){
                foreach($items['data'] as $k=>$item){
                    $newData[$k][] = $item['id'];
                    if(isset($fieldItems['salesReps'][$item['sales_rep_id']])){
                        $newData[$k][] = $fieldItems['salesReps'][$item['sales_rep_id']];
                    }else{
                        $newData[$k][] = $item['sales_rep_id'];
                    }
                    $newData[$k][] = $item['title'];
                    if(empty($item['population'])){
                        $item['population'] = '';
                    }
                    $newData[$k][] = $item['population'];

                    $statusHTML= '';
                    $statusHTML.= '<div class="editable_field">';
                    if(isset($fieldItems['statuses'][$item['status_id']])){
                        $curSalesStage = $fieldItems['statuses'][$item['status_id']];
                        $statusHTML.= $fieldItems['statuses'][$item['status_id']];
                    }else{
                        $curSalesStage = $item['status_id'];
                        $statusHTML.= $item['status_id'];
                    }
                    $statusHTML.= '</div>';
                    $statusHTML.= '<div class="editable_form">';
                    $statusHTML.= '<select class="form-select" name="status_id" data-id="'.$item['id'].'" required>';
                    foreach($fieldItems['statuses'] as $key => $value){
                        if($item['status_id'] == $key ){
                            $statusHTML.= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                        }else{
                            $statusHTML.= '<option value="'.$key.'">'.$value.'</option>';
                        }
                    }
                    $statusHTML.= '</select>';
                    $newData[$k][] = $statusHTML;


                    $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"); 
                    $closure_month = $item['closure_month'];
                    if(empty($closure_month)){
                        $closure_month = '';
                    }
                    if(empty($item['closure_month'])){
                        $item['closure_month'] = '-';
                    }
                    $curClosureMonth = $closure_month;
                    $statusHTML= '';
                    $statusHTML.= '<div class="editable_field">';
                    $statusHTML.= $item['closure_month'];
                    $statusHTML.= '</div>';
                    $statusHTML.= '<div class="editable_form">';
                    $statusHTML.= '<select class="form-select" name="closure_month" data-id="'.$item['id'].'" required><option value="">Please Select</option>';
                    foreach($months as $key => $value){
                        if($item['closure_month'] == $value ){
                            $statusHTML.= '<option value="'.$value.'" selected="selected">'.$value.'</option>';
                        }else{
                            $statusHTML.= '<option value="'.$value.'">'.$value.'</option>';
                        }
                    }
                    $statusHTML.= '</select>';
                    $newData[$k][] = $statusHTML;




                    $statusHTML= '';
                    $statusHTML.= '<div class="editable_field">';
                    if(!empty($item['folow_up_date'])){
                        $curFollowUpDate = date("d-M-y",strtotime($item['folow_up_date']));
                        $statusHTML.= date("d-M-y",strtotime($item['folow_up_date']));
                    }else{
                        $curFollowUpDate = '';
                        $statusHTML.= '-';
                    }
                    $statusHTML.= '</div>';
                    $statusHTML.= '<div class="editable_form">';
                    if(!empty($item['folow_up_date'])){
                        $curDate = date("d-M-y",strtotime($item['folow_up_date']));
                    }else{
                        $curDate= '-';
                    }
                    $statusHTML.= '<input type="text" name="folow_up_date" class="form-control folow_up_date" data-id="'.$item['id'].'" placeholder="Follow-up Date*" value="'.$curDate.'" required>';
                    $newData[$k][] = $statusHTML;

                    
                    $statusHTML= '';
                    $statusHTML.= '<div class="editable_field">';
                    if(isset($fieldItems['statuses'][$item['manager_status_id']])){
                        $curManagerSalesStage = $fieldItems['statuses'][$item['manager_status_id']];
                        $statusHTML.= $fieldItems['statuses'][$item['manager_status_id']];
                    }else{
                        $statusHTML.= $item['manager_status_id'];
                        $curManagerSalesStage = $item['manager_status_id'];
                    }
                    $statusHTML.= '</div>';
                    $statusHTML.= '<div class="editable_form">';
                    $statusHTML.= '<select class="form-select" name="manager_status_id" data-id="'.$item['id'].'" required>';
                    foreach($fieldItems['statuses'] as $key => $value){
                        if($item['manager_status_id'] == $key ){
                            $statusHTML.= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                        }else{
                            $statusHTML.= '<option value="'.$key.'">'.$value.'</option>';
                        }
                    }
                    $statusHTML.= '</select>';
                    $newData[$k][] = $statusHTML;





                    $actionsHTML = '';
                    $actionsHTML.= '<a href="'.URL('/admin/'.$urlSlug. '/' . $item['id'] . '/edit').'" class="btn btn-sm btn-primary" title="Edit"><i class="mdi mdi-square-edit-outline"></i> Edit</a>';
                    $actionsHTML.= '<div class="btn-group" style="margin-left: 10px; position: relative;">';
                    
                    if ($item['status'] == 'Active'){
                        $actionsHTML.= '<button type="button" class="btn btn-sm btn-success dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">Active<i class="mdi mdi-chevron-down"></i></button><div class="dropdown-menu"><a class="dropdown-item change_Status deactivate_it" href="javascript: void(0);" data-id="'.$item['id'].'">Inactive</a></div>';
                    }else{
                        $actionsHTML.= '<button type="button" class="btn btn-sm btn-danger dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">Inactive<i class="mdi mdi-chevron-down"></i></button><div class="dropdown-menu"><a class="dropdown-item change_Status activate_it" href="javascript: void(0);" data-id="'.$item['id'].'">Active</a></div>';
                    }
                    $actionsHTML.= '</div>';
                    $newData[$k][] = '<a href="'.URL('admin/school_contacts/'.$item['id']).'" class="btn btn-sm btn-secondary"><i class="bx bxs-plus-circle"></i> <span>Contacts</span></a>&nbsp;&nbsp;<a href="'.URL('admin/school_notes/'.$item['id']).'" class="btn btn-sm btn-info"><i class="bx bxs-plus-circle"></i> <span>Notes</span></a>';
                    $newData[$k][] = $actionsHTML;




                    if(!empty($fieldItems['schoolTypes'][$item['school_type_id']])){
                        $newData[$k][] = $fieldItems['schoolTypes'][$item['school_type_id']];
                    }else{
                        $newData[$k][] = '';
                    }
                    if(!empty($fieldItems['schoolLevels'][$item['school_level_id']])){
                        $newData[$k][] = $fieldItems['schoolLevels'][$item['school_level_id']];
                    }else{
                        $newData[$k][] = '';
                    }
                    if(!empty($fieldItems['countries'][$item['country_id']])){
                        $newData[$k][] = $fieldItems['countries'][$item['country_id']];
                    }else{
                        $newData[$k][] = '';
                    }
                    if(!empty($fieldItems['areas'][$item['area_id']])){
                        $newData[$k][] = $fieldItems['areas'][$item['area_id']];
                    }else{
                        $newData[$k][] = '';
                    }
                    if(empty($item['system'])){
                        $item['system'] = '';
                    }
                    $newData[$k][] = $item['system'];
                    if(empty($item['online_student_portal'])){
                        $item['online_student_portal'] = '';
                    }
                    $newData[$k][] = $item['online_student_portal'];
                    if(empty($item['name_of_the_system'])){
                        $item['name_of_the_system'] = '';
                    }
                    $newData[$k][] = $item['name_of_the_system'];
                    if(!empty($item['contract_till'])){
                        $newData[$k][] = date("d-M-y",strtotime($item['contract_till']));
                    }else{
                        $newData[$k][] = '';
                    }
                    if(!empty($fieldItems['salesManagers'][$item['sales_manager_id']])){
                        $newData[$k][] = $fieldItems['salesManagers'][$item['sales_manager_id']];
                    }else{
                        $newData[$k][] = '';
                    }
                    if(!empty($fieldItems['teleMarketingReps'][$item['telemarketing_rep_id']])){
                        $newData[$k][] = $fieldItems['teleMarketingReps'][$item['telemarketing_rep_id']];
                    }else{
                        $newData[$k][] = '';
                    }
                    if(!empty($fieldItems['directors'][$item['director_id']])){
                        $newData[$k][] = $fieldItems['directors'][$item['director_id']];
                    }else{
                        $newData[$k][] = '';
                    }
                    if(!empty($fieldItems['onboardingReps'][$item['onboarding_rep_id']])){
                        $newData[$k][] = $fieldItems['onboardingReps'][$item['onboarding_rep_id']];
                    }else{
                        $newData[$k][] = '';
                    }
                    if(!empty($fieldItems['onboardingManagers'][$item['onboarding_manager_id']])){
                        $newData[$k][] = $fieldItems['onboardingManagers'][$item['onboarding_manager_id']];
                    }else{
                        $newData[$k][] = '';
                    }
                    $newData[$k][] = $item['school_tution'];


                    $newData[$k][] = $curSalesStage;
                    $newData[$k][] = $curClosureMonth;
                    $newData[$k][] = $curFollowUpDate;
                    $newData[$k][] = $curManagerSalesStage;

                }
            }
            return response()->json(['draw' => $request->draw, 'recordsTotal'=> $totalRows, 'recordsFiltered'=> $totalRows, 'data' => $newData]);
            //return view('admin.'.$urlSlug.'.index', compact('items','urlSlug','title'))->with('i', (request()->input('page', 1) - 1) * 5);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
