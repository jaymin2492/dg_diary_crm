<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SchoolNote;
use App\Models\School;
use App\Models\Status;
use Illuminate\Http\Request;

class SchoolNoteController extends Controller
{
    private $urlSlugs, $titles;

    public function __construct()
    {
        $this->titles = "Notes";
        $this->urlSlugs = "school_notes";
        $statuses = array();
        $allStatuses = Status::where("status","Active")->orderBy("id","asc")->get(['id','title'])->toArray();
        foreach($allStatuses as $allStatus){
            $statuses[$allStatus['id']] = $allStatus['title'];
        }
        $fieldItems = array();
        $fieldItems['statuses'] = $statuses;
        $this->fieldItems = $fieldItems;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $sid='')
    {
        try {
            if(empty($sid)){
                return redirect()->route('schools.index');
            }
            $items = SchoolNote::where("school_id",$sid)->orderBy('created_at','desc')->get();
            $school = School::findOrFail($sid);
            $urlSlug = $this->urlSlugs;
            $title = $this->titles;
            $fieldItems = $this->fieldItems;
            return view('admin.'.$urlSlug.'.index', compact('items','urlSlug','title','sid','school','fieldItems'));
            //return view('admin.'.$urlSlug.'.index', compact('items','urlSlug','title'))->with('i', (request()->input('page', 1) - 1) * 5);

        }
        catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $sid='')
    {
        try {
            if (empty($sid)) {
                return redirect()->route('schools.index');
            }
            $school = School::findOrFail($sid);
            $urlSlug = $this->urlSlugs;
            $title = $this->titles;
            $fieldItems = $this->fieldItems;

            return view('admin.' . $urlSlug . '.create', compact('urlSlug', 'title', 'sid','school','fieldItems'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
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
                'notes' => 'required',
                //'description' => 'required',
                //'status' => 'required'
            ]);
            $params = $request->all();
            $urlSlug = $this->urlSlugs;
            $params['folow_up_date'] = date("Y-m-d",strtotime($params['folow_up_date']));
            SchoolNote::create($params);
            return redirect('admin/'.$urlSlug.'/'.$params['school_id'])->with('success', 'Item created successfully.');
            return redirect()->route($urlSlug.'.index')->with('success', 'Item created successfully.');
        }
        catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchoolNote  $schoolNote
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolNote $schoolNote)
    {
        $item = $schoolNote;
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        return view('admin.'.$urlSlug.'.show', compact('item','urlSlug','title'));//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolNote  $schoolNote
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolNote $schoolNote)
    {
        try {
            $item = $schoolNote;
            $urlSlug = $this->urlSlugs;
            $title = $this->titles;
            $sid = $schoolNote->school_id;
            $school = School::findOrFail($sid);
            $fieldItems = $this->fieldItems;
            return view('admin.' . $urlSlug . '.edit', compact('item', 'urlSlug', 'title', 'sid', 'school','fieldItems'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolNote  $schoolNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolNote $schoolNote)
    {
        try {
            $request->validate([
                'notes' => 'required',
                //'description' => 'required',
                //'status' => 'required'
            ]);
            $params = $request->all();
            $params['folow_up_date'] = date("Y-m-d",strtotime($params['folow_up_date']));
            $urlSlug = $this->urlSlugs;
            $schoolNote->update($params);
            return redirect('admin/'.$urlSlug.'/'.$schoolNote->school_id)->with('success', 'Item updated successfully.');
            return redirect()->route($urlSlug.'.index')->with('success', 'Item updated successfully.');
        }
        catch (\Exception $e) {
            return back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception'=>$e->getMessage()]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolNote  $schoolNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolNote $schoolNote)
    {
        $schoolNote->delete();
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
            $item = SchoolNote::findOrFail($id);
            $item->update($params);
            return response()->json(['success'=>true, 'message'=>'Status Changes Successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['success'=>false, 'message'=>$e->getMessage()]);
        }
    }
}
