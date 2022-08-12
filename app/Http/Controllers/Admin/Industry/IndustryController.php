<?php

namespace App\Http\Controllers\Admin\Industry;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndustryController extends Controller
{
    use AdminMethods;

    private $redirectTo = "admin.industry.index";
    private $page = "admin.pages.industry.";

    public function index()
    {
        return $this->view($this->page."index", [
            'industries' => Industry::paginate(10)
        ]);
    }

    public function create()
    {
        return $this->view($this->page."create");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => ['required', 'unique:industries,title'],
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        } 
        if($validator->passes()){
            $input = $request->except('_token');
            $input['slug'] = createSlug($request->title);
            $input['is_active'] = $request->is_active !== null ? 1 : 0;
            $industry = Industry::create($input);
            return response()->json(['msg' => 'Industry created successfully', 'redirectRoute' => route($this->redirectTo)]);
        }
    }

    public function edit($id)
    {
        $industry = Industry::findOrFail($id);
        return $this->view($this->page.'edit',[
            'industry' => $industry
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => ['required', 'unique:industries,title,'.$id],
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        } 
        if($validator->passes()){
            $industry = Industry::find($id);
            $input = $request->except('_token');
            $input['slug'] = createSlug($request->title);
            $input['is_active'] = $request->is_active !== null ? 1 : 0;
            $industry ->update($input);
            return response()->json(['msg' => 'Industry updated successfully', 'redirectRoute' => route($this->redirectTo)]);
        }
    }

    public function delete($id)
    {
        try{
            $industry = Industry::find($id);
            if(!blank($industry)){
                $industry->delete();
                return redirect()->back()->with(notifyMsg('success', 'Industry deleted successfully'));
            }
            return redirect()->back()->with(notifyMsg('error', 'Industry Not Found'));
        } catch(\Exception $e){
            return redirect()->back()->with(notifyMsg('error', $e->getMessage()));

        }
    }


    public function updateStatus(Request $request)
    {
        $industry = Industry::where("id", $request->industry_id)->first();
        if($industry->is_active == 0){
            $industry->update(["is_active"=>1]);
            $msg = "Industry is active";
        } else {
            $industry->update(["is_active"=>0]);
            $msg = "Industry is inactive";
        }
        $status = $industry->is_active;
        return response()->json(["msg"=>$msg, "status"=>$status]);
    }
}
