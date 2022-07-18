<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    private $urlSlugs, $titles;

    public function __construct()
    {
        $this->titles = "Areas";
        $this->urlSlugs = "areas";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Area::latest()->paginate(10);
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
                //'status' => 'required'
            ]);
            $params = $request->all();
            $urlSlug = $this->urlSlugs;
            Area::create($params);
            return redirect()->route($urlSlug.'.index')->with('success', 'Item created successfully.');
        }
        catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        $item = $area;
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        return view('admin.'.$urlSlug.'.show', compact('item','urlSlug','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        $item = $area;
        $urlSlug = $this->urlSlugs;
        $title = $this->titles;
        return view('admin.'.$urlSlug.'.edit', compact('item','urlSlug','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        try {
            $request->validate([
                'title' => 'required',
                //'description' => 'required',
                //'status' => 'required'
            ]);
            $params = $request->all();
            $urlSlug = $this->urlSlugs;
            $area->update($params);
            return redirect()->route($urlSlug.'.index')->with('success', 'Item updated successfully.');
        }
        catch (\Exception $e) {
            return back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception'=>$e->getMessage()]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();
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
            $item = Area::findOrFail($id);
            $item->update($params);
            return response()->json(['success'=>true, 'message'=>'Status Changes Successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['success'=>false, 'message'=>$e->getMessage()]);
        }
    }
}
