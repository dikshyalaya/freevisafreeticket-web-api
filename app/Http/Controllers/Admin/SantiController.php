<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SantiRequest;
use App\Models\AboutSanti;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;

class SantiController extends Controller
{
    use AdminMethods;

    private $destination = "uploads/santi/";

    private $redirectTo = "admin.santi.index";

    public function __construct()
    {

    }

    public function index()
    {
        $abouts = AboutSanti::latest()->paginate(10);
        return $this->view('admin.pages.santi.index', ['abouts' => $abouts]);
    }

    public function create()
    {
        return $this->view('admin.pages.santi.create');
    }

    public function store(SantiRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json(['errors' => $request->validator->errors()]);
        }
      
        if (isset($request->validator) && $request->validator->passes()) {
            try {
                $input = $request->except('_token');
                $input["slug"] = createSlug($request->title);
                $input["status"] = $request->status != null ? 1 : 0;
                if ($request->hasFile('feature_image')) {
                    if (!file_exists($this->destination)) {
                        mkdir($this->destination, 0777, true);
                    }
                    $fimage = $request->file('feature_image');
                    $fimagename = time() . '_' . $fimage->getClientOriginalName();
                    $input['feature_image'] = $this->destination . $fimagename;
                    $fimage->move(public_path($this->destination, 'public'), $fimagename);
                }
                AboutSanti::create($input);
                return response()->json(['msg' => 'Santi About created successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch (\Exception $e) {
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function edit($id)
    {
        $about = AboutSanti::findOrFail($id);
        return $this->view('admin.pages.about.edit', ['about' => $about]);
    }

    public function update(SantiRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json(['errors' => $request->validator->errors()]);
        }

        if (isset($request->validator) && $request->validator->passes()) {
            try {
                $about = AboutSanti::find($id);
                $input = $request->except('_token');
                $input['slug'] = createSlug($request->title);
                $input['status'] = $request->status != null ? 1 : 0;
                if ($request->hasFile('feature_image')) {
                    if (!file_exists($this->destination)) {
                        mkdir($this->destination, 0777, true);
                    }
                    $fimage = $request->file('feature_image');
                    $fimagename = time() . '_' . $fimage->getClientOriginalName();
                    $input['feature_image'] = $this->destination . $fimagename;
                    if (file_exists($this->destination . $fimagename) && $about->feature_image != null) {
                        unlink($this->destination . $about->feature_image);
                    }
                    $fimage->move(public_path($this->destination, 'public'), $fimagename);
                }
                $about->update($input);
                return response()->json(['msg' => 'Santi about updated successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch (\Exception $e) {
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function delete($id)
    {
        $about = AboutSanti::findOrFail($id);
        $about->delete();
        $lastAbout = AboutSanti::latest();
        if ($lastAbout->exists()) {
            $lastAbout->first()->update(['status' => 1]);
        }
        return redirect()->back()->with(notifyMsg('success', 'Data Deleted'));
    }

    public function updateStatus(Request $request)
    {
        $about = AboutSanti::where("id", $request->about_id)->first();
        if($about->status == 0){
            $about->update(["status"=>1]);
            $msg = "Item is active";
        } else {
            $about->update(["status"=>0]);
            $msg = "Item is inactive";
        }
        $status = $about->status;
        return response()->json(["msg"=>$msg, "status"=>$status]);

    }
}
