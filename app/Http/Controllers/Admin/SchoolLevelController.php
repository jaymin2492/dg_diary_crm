<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SchoolLevel;
use Illuminate\Http\Request;

class SchoolLevelController extends Controller
{
    private $urlSlugs, $titles;

    public function __construct()
    {
        $this->titles = "School Levels";
        $this->urlSlugs = "school_levels";
    }
    /**1
     * Display a listing of the resource.
     *C
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = SchoolLevel::latest()->paginate(10);
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        return view('admin.'.$urlSlug.'.index', compact('items','urlSlug','title'))->with('i', (request()->input('page', 1) - 1) * 5);
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
        return view('admin.'.$urlSlug.'.create', compact('urlSlug','title'));
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
                'status' => 'required'
            ]);
            $params = $request->all();
            $urlSlug = $this->urlSlugs;
            SchoolLevel::create($params);
            return redirect()->route($urlSlug.'.index')->with('success', 'Item created successfully.');
        }
        catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchoolLevel  $schoolLevel
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolLevel $schoolLevel)
    {
        $item = $schoolLevel;
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        return view('admin.'.$urlSlug.'.show', compact('item','urlSlug','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolLevel  $schoolLevel
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolLevel $schoolLevel)
    {
        $item = $schoolLevel;
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        return view('admin.'.$urlSlug.'.edit', compact('item','urlSlug','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolLevel  $schoolLevel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolLevel $schoolLevel)
    {
        try {
            $request->validate([
                'title' => 'required',
                //'description' => 'required',
                'status' => 'required'
            ]);
            $params = $request->all();
            $urlSlug = $this->urlSlugs;
            $schoolLevel->update($params);
            return redirect()->route($urlSlug.'.index')->with('success', 'Item updated successfully.');
        }
        catch (\Exception $e) {
            return back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception'=>$e->getMessage()]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolLevel  $schoolLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolLevel $schoolLevel)
    {
        $schoolLevel->delete();
        $urlSlug = $this->urlSlugs;
        return redirect()->route($urlSlug.'.index')->with('success', 'Item deleted successfully');
    }
}
