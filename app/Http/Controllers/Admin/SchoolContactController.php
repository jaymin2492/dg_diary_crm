<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SchoolContact;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolContactController extends Controller
{
    private $urlSlugs, $titles;

    public function __construct()
    {
        $this->titles = "Contacts";
        $this->urlSlugs = "school_contacts";
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
            $items = SchoolContact::orderBy('created_at','desc')->get();
            $school = School::findOrFail($sid);
            $urlSlug = $this->urlSlugs;
            $title = $this->titles;
            return view('admin.'.$urlSlug.'.index', compact('items','urlSlug','title','sid','school'));
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
            return view('admin.' . $urlSlug . '.create', compact('urlSlug', 'title', 'sid','school'));
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
                'title' => 'required',
                //'description' => 'required',
                //'status' => 'required'
            ]);
            $params = $request->all();
            $urlSlug = $this->urlSlugs;
            SchoolContact::create($params);
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
     * @param  \App\Models\SchoolContact  $schoolContact
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolContact $schoolContact)
    {
        $item = $schoolContact;
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        return view('admin.'.$urlSlug.'.show', compact('item','urlSlug','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolContact  $schoolContact
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolContact $schoolContact)
    {
        try {
            $item = $schoolContact;
            $urlSlug = $this->urlSlugs;
            $title = $this->titles;
            $sid = $schoolContact->school_id;
            $school = School::findOrFail($sid);
            return view('admin.' . $urlSlug . '.edit', compact('item', 'urlSlug', 'title', 'sid', 'school'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolContact  $schoolContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolContact $schoolContact)
    {
        try {
            $request->validate([
                'title' => 'required',
                //'description' => 'required',
                //'status' => 'required'
            ]);
            $params = $request->all();
            $urlSlug = $this->urlSlugs;
            $schoolContact->update($params);
            return redirect('admin/'.$urlSlug.'/'.$schoolContact->school_id)->with('success', 'Item updated successfully.');
            return redirect()->route($urlSlug.'.index')->with('success', 'Item updated successfully.');
        }
        catch (\Exception $e) {
            return back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception'=>$e->getMessage()]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolContact  $schoolContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolContact $schoolContact)
    {
        $schoolContact->delete();
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
            $item = SchoolContact::findOrFail($id);
            $item->update($params);
            return response()->json(['success'=>true, 'message'=>'Status Changes Successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['success'=>false, 'message'=>$e->getMessage()]);
        }
    }
}
