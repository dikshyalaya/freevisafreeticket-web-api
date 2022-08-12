<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobcategoryController extends Controller
{
    use AdminMethods;

    private $page = 'admin.pages.job_category.';

    private $redirectTo = 'admin.job_category.index';

    public function index(Request $request)
    {
        $job_categories = JobCategory::query();
        if ($request->filled('title')) {
            $job_categories = $job_categories->where('functional_area', 'like', '%' . $request->title . '%');
        }
        if($request->filled('status')){
            if($request->status == 'Active'){
                $job_categories = $job_categories->where('is_active', 1);
            } else if($request->status == 'Inactive'){
                $job_categories = $job_categories->where('is_active', 0);
            }
        }
        $job_categories = $job_categories->latest()->paginate(10)->setPath('');
        return $this->view($this->page.'index', [
            'job_categories' => $job_categories,
            'pagination' => $job_categories->appends(array(
                'title' => $request->title,
                'status' => $request->status

            )),
        ]);
    }

    public function create()
    {
        return $this->view($this->page.'create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'functional_area' => ['required', 'unique:job_categories,functional_area'],
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        if($validator->passes()){
            try{
                $input = $request->except('_token');
                $input['image_url'] = 'https://avatars.dicebear.com/api/initials/'.$request->functional_area.'.svg';
                $input['is_default'] = 1;
                $input['is_active'] = 1;
                $input['sort_order'] = JobCategory::max('sort_order') + 1;
                $input['lang'] = 'en';
                JobCategory::create($input);
                return response()->json(['msg' => 'Job Category created successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch(\Exception $e){
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function edit($id)
    {
        $job_category = JobCategory::findOrFail($id);
        return $this->view($this->page.'edit', [
            'job_category' => $job_category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'functional_area' => ['required', 'unique:job_categories,functional_area,'.$id],
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        if($validator->passes()){
            try{
                $job_category = JobCategory::find($id);
                $input = $request->except('_token');
                $input['image_url'] = 'https://avatars.dicebear.com/api/initials/'.$request->functional_area.'.svg';
                $input['is_default'] = 1;
                $input['is_active'] = 1;
                $input['sort_order'] = JobCategory::max('sort_order') + 1;
                $input['lang'] = 'en';
                $job_category->update($input);
                return response()->json(['msg' => 'Job Category updated successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch(\Exception $e){
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }
}
