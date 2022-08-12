<?php

namespace App\Http\Controllers\Admin\Training;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingRequest;
use App\Models\Training;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    use AdminMethods;

    private $page = 'admin.pages.training.';
    private $redirectTo = "admin.training.index";

    public function index()
    {
        return $this->view($this->page . 'index', [
            'trainings' => Training::orderBy('id', 'DESC')->get()
        ]);
    }

    public function create()
    {
        return $this->view($this->page."create");
    }

    public function store(TrainingRequest $request)
    {
        $input = $request->except("_token");
        $input['slug'] = createSlug($request->title);
        $input['is_active'] = $request->is_active !== null ? 1 : 0;
        $training = Training::create($input);
        return redirect()->route($this->redirectTo)->with(notifyMsg('success', 'Training created successfully'));
    }

    public function edit($id)
    {
        return $this->view($this->page."edit",[
            'training' => Training::findOrFail($id),
        ]);
    }

    public function update(TrainingRequest $request, $id)
    {
        $training = Training::find($id);
        $input = $request->except('_token');
        $input['slug'] = createSlug($request->title);
        $input['is_active'] = $request->is_active !== null ? 1 : 0;
        $training->update($input);
        return redirect()->route($this->redirectTo)->with(notifyMsg('success', 'Training updated successfully'));
    }


    public function delete($id)
    {
        try{
            $training = Training::find($id);
            if(!blank($training)){
                $training->delete();
                return redirect()->back()->with(notifyMsg('success', 'Training deleted successfully'));
            }
            return redirect()->back()->with(notifyMsg('error', 'Training Not Found'));
        } catch(\Exception $e){
            return redirect()->back()->with(notifyMsg('error', $e->getMessage()));
        }
        // return response()->json(['redirectRoute' => route($this->redirectTo), 'msg' => 'Training deleted successfully']);
    }


    public function updateStatus(Request $request)
    {
        $training = Training::where("id", $request->training_id)->first();
        if($training->is_active == 0){
            $training->update(["is_active"=>1]);
            $msg = "Training is active";
        } else {
            $training->update(["is_active"=>0]);
            $msg = "Training is inactive";
        }
        $status = $training->is_active;
        return response()->json(["msg"=>$msg, "status"=>$status]);
    }


    public function ajaxStoreTraining(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => ['required', 'unique:trainings,title'],
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        if($validator->passes()){
            $input = $request->except('_token');
            $input['slug'] = createSlug($request->title);
            $input['is_active'] = 1;
            $training = Training::create($input);
            return response()->json(['training_id' => $training->id, 'training_title' => $training->title]);
        }
    }



}
