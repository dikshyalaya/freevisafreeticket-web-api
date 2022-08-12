<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UsefulInformation;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsefulInformationController extends Controller
{
    use AdminMethods;
    private $page = 'admin.usefulinfo.';

    public function index()
    {
        return $this->view($this->page . 'index',[
            'useful_informations' => UsefulInformation::paginate(10),
        ]);
    }

    public function create()
    {
        return $this->view($this->page . 'editadd', [
            'action' => "New",
        ]);
    }

    public function edit($id)
    {
        $useful_info = UsefulInformation::find($id);
        // dd(User::find($page->user_id));
        return $this->view($this->page.'editadd', [
            'useful_info' => $useful_info,
            'action' => "Edit"
        ]);
    }

    public function save(Request $request)
    {
        $destination = 'uploads/informations/';
        $validator = Validator::make($request->all(),[
            'title' => ['required', 'unique:useful_information,title,'.$request->id],
            'desc' => ['required'],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $fields = [];
        $request->title ? $fields['title'] = $request->title : null;
        $request->desc ? $fields['desc'] = $request->desc : null;
        $request->desc_content ? $fields['desc_content'] = $request->desc_content : null;
        $fields['slug'] = createSlug($request->title);
        if($request->hasFile('logo')){
            $logo = $request->file('logo');
            $logoName = time().'.'.$logo->getClientOriginalExtension();
            $fields['logo'] = $destination.$logoName;
            $logo->move($destination, $logoName);
        }
        $information = UsefulInformation::updateOrCreate(['id' => $request->id], $fields);

        return $this->view($this->page.'editadd', [
            'useful_info' => $information,
            'action' => "Edit",
        ]);
    }

    public function delete($id)
    {
        $info = UsefulInformation::find($id);
        try{
            if(!blank($info)){
                $info->delete();
                return redirect()->back()->with(notifyMsg('success', 'Information deleted successfully'));
            }
            return redirect()->back()->with(notifyMsg('error', 'Information Not Found'));
        } catch(\Exception $e){
            return redirect()->back()->with(notifyMsg('error', $e->getMessage()));
        }
        // return response()->json(['redirectRoute' => route('admin.usefulinfo.index'), 'msg' => 'Item deleted successfully']);
    }
}


