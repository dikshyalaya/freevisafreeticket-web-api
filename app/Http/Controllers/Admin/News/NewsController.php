<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Traits\Admin\AdminMethods;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    use AdminMethods;
    public function list()
    {
        return $this->view('admin.pages.news.list', [
            'news' => News::paginate(10)
        ]);
    }
    public function new()
    {
        return $this->view('admin.pages.news.editadd', [
            'action' => "New",
        ]);
    }
    public function edit($id)
    {
        $news = News::find($id);
        // dd(User::find($page->user_id));
        return $this->view('admin.pages.news.editadd', [
            'news' => $news,
            'action' => "Edit"
        ]);
    }
    public function save(Request $request)
    {
//         dd($request->all());
        $validator = Validator::make($request->all(),[
            'title' => ['required'],
            'seo_title' => ['required'],
            'feature_img' => ['nullable', 'image', 'mimes:jpeg,jpg,png,svg', 'max:2048'],
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $destination = 'uploads/news/';
        $fields = [];
        $request->title ? $fields['title'] = $request->title : null;
        $request->body ? $fields['body'] = $request->body : null;
        $request->seo_title ? $fields['seo_title'] = $request->seo_title : null;
        $request->seo_description ? $fields['seo_description'] = $request->seo_description : null;
        $request->html_content ? $fields['html_content'] = $request->html_content : null;
        $request->seo_keywords ? $fields['seo_keywords'] = $request->seo_keywords : null;
        $request->is_active ? $fields['is_active'] = $request->is_active == "on" ? 1 : 0 : null;

        if($request->hasFile('feature_img')){
            $file = $request->file('feature_img');
            $logoName = time().'.'.$file->getClientOriginalExtension();
            $fields['feature_img'] = $destination.$logoName;
            $file->move(public_path($destination), $logoName);
        }

        $news = News::updateOrCreate(['id' => $request->id], $fields);

        return $this->view('admin.pages.news.editadd', [
            'news' => $news,
            'action' => "Edit"
        ]);
    }
    public function delete($id)
    {
        try {
            $news = News::find($id);
            if(!blank($news)){
                $news->delete();
                return redirect()->back()->with(notifyMsg('success', 'News deleted successfully'));
            }
            return redirect()->back()->with(notifyMsg('error', 'News Not Found'));
            // DB::table('news')->delete($id);
            // return redirect()
            //     ->route('admin.pages.news.list')
            //     ->with(['delete' => [
            //         'status' => 'success'
            //     ]]);
        } catch (\Exception $e) {
            return redirect()->back()->with(notifyMsg('error', $e->getMessage()));
            // return redirect()
            //     ->route('admin.news.list')
            //     ->with(['delete' => [
            //         'status' => 'failed'
            //     ]]);
        }
    }
}
