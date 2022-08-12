<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{
    use AdminMethods;
    private $destination = 'uploads/about/';
    private $redirectTo = 'admin.about.index';
    public function __construct()
    {
        
    }

    public function index()
    {
        $abouts = About::latest()->paginate(10);
        return $this->view('admin.pages.about.index', ['abouts' => $abouts]);
    }

    public function create()
    {
        return $this->view('admin.pages.about.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'title' => ['required', 'unique:abouts,title'],
            'feature_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:4096'],

        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        if($validator->passes()){
            try{
                $input = $request->except('_token');
                $input['slug'] = createSlug($request->title);
                $input['status'] = $request->status != null ? 1 : 0;
                if($request->hasFile('feature_image')){
                    if(!file_exists($this->destination)){
                        mkdir($this->destination, 0777, true);
                    }
                    $fimage = $request->file('feature_image');
                    $fimagename = time() . '_' . $fimage->getClientOriginalName();
                    $input['feature_image'] = $this->destination.$fimagename;
                    $fimage->move(public_path($this->destination, 'public'), $fimagename);
                }
                About::create($input);
                return response()->json(['msg' => 'About created successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch(\Exception $e){
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
        
    }

    public function edit($id)
    {
        $about = About::findOrFail($id);
        return $this->view('admin.pages.about.edit', ['about' => $about]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => ['required', 'unique:abouts,title,'.$id],
            'feature_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:4096'],

        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        if($validator->passes()){
            try{
                $about = About::find($id);
                $input = $request->except('_token');
                $input['slug'] = createSlug($request->title);
                $input['status'] = $request->status != null ? 1 : 0;
                if($request->hasFile('feature_image')){
                    if(!file_exists($this->destination)){
                        mkdir($this->destination, 0777, true);
                    }
                    $fimage = $request->file('feature_image');
                    $fimagename = time().'_'.$fimage->getClientOriginalName();
                    $input['feature_image'] = $this->destination.$fimagename;
                    if(file_exists($this->destination.$fimagename) && $about->feature_image != null){
                        unlink($this->destination.$about->feature_image);
                    }
                    $fimage->move(public_path($this->destination, 'public'), $fimagename);
                }
                $about->update($input);
                return response()->json(['msg' => 'About updated successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch(\Exception $e){
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function delete($id)
    {
        $about = About::findOrFail($id);
        $about->delete();
        $lastAbout = About::latest();
        if($lastAbout->exists()){
            $lastAbout->first()->update(['status' => 1]);
        }
        return redirect()->back()->with(notifyMsg('success', 'Data deleted'));
    }

    public function updateStatus(Request $request)
    {
        $about = About::where("id", $request->about_id)->first();
        if($about->status == 0){
            $about->update(["status"=>1]);
            $msg = "About is active";
        } else {
            $about->update(["status"=>0]);
            $msg = "About is inactive";
        }
        $status = $about->status;
        return response()->json(["msg"=>$msg, "status"=>$status]);

    }
}
