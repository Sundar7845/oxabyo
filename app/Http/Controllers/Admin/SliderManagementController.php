<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Slider;
use App\Event;

/* Services */
use App\Services\FileService;

class SliderManagementController extends Controller
{

    /**
     * @var FileService
     */
    private $fileService;

    public function __construct(
        FileService $fileService
    ) {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search'));

        $sliders = Slider::with(['events', 'events.player_types', 'events.games'])
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->appends(request()->query());

 

        return view('admin.slider-management.index', compact('sliders', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = Event::get();

        return view('admin.slider-management.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        Slider::create($input);     

        return redirect()->route('slider-management.index')
            ->with('success', 'Slider created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin.slider-management.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        $slider->fill($request->all());
        $slider->save();

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $slider->id . '.' . $ext;

            $slider->image = "oxabyo/sliders/".$slider->id."/".$filename;
            $slider->save();
            
            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/sliders/".$slider->id
            );
        }

        return redirect()->route('slider-management.index')
            ->with('success', 'Slider updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        $slider->delete();
        return redirect()->route('slider-management.index')
            ->with('success', 'Slider deleted successfully');
    }
}
