<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Traits\Admin\AdminMethods;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PageController extends Controller
{
    use AdminMethods;
    public function list(){
        return $this->view('admin.pages.pages.list',[
            'pages'=>Page::paginate(10)
        ]);
    }
    public function new(){
        return $this->view('admin.pages.pages.editadd',[
            'action'=>"New",
        ]);
    }
    public function edit($id){
        $page =Page::find($id);
        // dd(User::find($page->user_id));
        return $this->view('admin.pages.pages.editadd',[
            'page'=>$page,
            'action'=>"Edit"
        ]);
    }
    public function save(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(),[
            'title' => ['required', 'unique:pages,title,'.$request->id],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $fields = [];
        $request->title?$fields['title']=$request->title:null;
        $request->body?$fields['body']=$request->body:null;
        $request->html_content?$fields['html_content']=$request->html_content:null;
        $request->seo_title?$fields['seo_title']=$request->seo_title:null;
        $request->seo_description?$fields['seo_description']=$request->seo_description:null;
        $request->seo_keywords?$fields['seo_keywords']=$request->seo_keywords:null;
        $fields['slug']= Str::slug($request->title);
        // $request->slug?$fields['slug']=$request->slug:null;
        $request->is_active?$fields['is_active']=$request->is_active=="on"?1:0:null;

        $page=Page::updateOrCreate(['id'=>$request->id],$fields);
        $msg = $request->id == '' ? 'Page created succesfully' : 'Page updated succesfully';
        return redirect()->route('admin.pages.list')->with(notifyMsg('success', $msg));

        // return $this->view('admin.pages.pages.editadd',[
        //     'page'=>$page,
        //     'action'=>"Edit"
        // ]);
    }
    public function delete($id){
        try {
            $page = Page::find($id);
            if($page != null){
                $page->delete();
                return redirect()->back()->with(notifyMsg('success', 'Page deleted successfully'));
            }
            return redirect()->back()->with(notifyMsg('error', 'Page Not Found'));
            // DB::table('pages')->delete($id);
            // return redirect()
            // ->route('admin.pages.list')
            // ->with(['delete'=>[
            //     'status' => 'success'
            // ]]);
        } catch (\Exception $e) {
            return redirect()->back()->with(notifyMsg('error', $e->getMessage()));
            // return redirect()
            // ->route('admin.pages.list')
            // ->with(['delete'=>[
            //     'status' => 'failed'
            // ]]);
        }
    }
}
