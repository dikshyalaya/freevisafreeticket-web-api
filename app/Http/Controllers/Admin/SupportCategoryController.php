<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportCategoryRequest;
use App\Models\SupportCategory;
use App\Services\SlugService;
use App\Traits\Admin\AdminMethods;
use Illuminate\Support\Facades\DB;

class SupportCategoryController extends Controller
{
    use AdminMethods;

    private $redirectTo = "admin.support_category.index";
    private $page = "admin.pages.support_category.";

    public function __construct()
    {
        $this->slugService = new SlugService();
    }

    public function index()
    {
        return $this->view($this->page . "index", [
            "categories" => SupportCategory::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return $this->view($this->page . "create");
    }

    public function store(SupportCategoryRequest $request)
    {
        try {
            $input = $request->except('_token');
            $input['slug'] = $this->slugService->generateUniqueSlug(new SupportCategory(), $request->title, 'title');
            $support_category = SupportCategory::create($input);
            return response()->json(['msg' => 'Support Category created successfully', 'redirectRoute' => route($this->redirectTo)]);
        } catch (\Exception$e) {
            return response()->json(['db_error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $support_category = SupportCategory::findOrFail($id);
        return $this->view($this->page . "edit", [
            "support_category" => $support_category,
        ]);
    }

    public function update(SupportCategoryRequest $request, $id)
    {
        try {
            $support_category = SupportCategory::find($id);
            $input = $request->except('_token');
            $input['slug'] = $this->slugService->generateUniqueSlug(new SupportCategory(), $request->title, 'title');
            $support_category->update($input);
            return response()->json(['msg' => 'Support Category updated successfully', 'redirectRoute' => route($this->redirectTo)]);
        } catch (\Exception$e) {
            return response()->json(['db_error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $support_category = SupportCategory::find($id);
            if (!blank($support_category)) {
                $support_category->delete();
                DB::commit();
                return redirect()->back()->with(notifyMsg('success', 'Support Category deleted successfully'));
            }
            return redirect()->back()->with(notifyMsg('error', 'Support Category Not Found'));

        } catch (\Exception$e) {
            DB::rollBack();
            return redirect()->back()->with(notifyMsg('error', $e->getMessage()));
        }
        // SupportCategory::destroy($id);
        // return response()->json(['msg' => 'Support Category deleted successfully']);
    }
}
