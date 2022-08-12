<?php

namespace App\Http\Controllers\Admin;

use App\Models\Support;
use App\Models\SupportType;
use App\Services\SlugService;
use App\Models\SupportCategory;
use App\Traits\Admin\AdminMethods;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupportRequest;

class SupportController extends Controller
{
    use AdminMethods;

    private $redirectTo = "admin.support.index";
    private $page = "admin.pages.support.";

    public function __construct()
    {
        $this->slugService = new SlugService();
        $this->categories = SupportCategory::get();
        $this->support_types = SupportType::get();
    }

    public function index()
    {
        return $this->view($this->page . "index", [
            'categories' => $this->categories,
            'supports' => Support::latest()->with(['support_category:id,title', 'support_types'])->paginate(10),
        ]);
    }

    public function create()
    {
        return $this->view($this->page . "create", [
            'categories' => $this->categories,
            'support_types' => $this->support_types,
        ]);
    }

    public function store(SupportRequest $request)
    {
        try {
            $input = $request->except('_token');
            $input['slug'] = $this->slugService->generateUniqueSlug(new Support(), $request->question, 'question');
            $support = Support::create($input);
            $support->support_types()->sync($request->support_types);
            return response()->json(['msg' => 'Support created successfully', 'redirectRoute' => route($this->redirectTo)]);
        } catch (\Exception $e) {
            return response()->json(['db_error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $support = Support::findOrFail($id);
        return $this->view($this->page . "edit", [
            'support' => $support,
            'categories' => $this->categories,
            'support_types' => $this->support_types,
        ]);
    }

    public function update(SupportRequest $request, $id)
    {
        try {
            $support = Support::find($id);
            $input = $request->except('_token');
            $input['slug'] = $this->slugService->generateUniqueSlug(new Support(), $request->question, 'question');
            $support->update($input);
            $support->support_types()->sync($request->support_types);
            return response()->json(['msg' => 'Support updated successfully', 'redirectRoute' => route($this->redirectTo)]);
        } catch (\Exception $e) {
            return response()->json(['db_error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $support = Support::where('id', $id)->first();
            if(!blank($support)){
                $support->support_types()->detach($support->support_types);
                $support->delete($id);
                DB::commit();
                return redirect()->back()->with(\notifyMsg('success', 'Support deleted successfully'));
            }
            return redirect()->back()->with(\notifyMsg('error', 'Support Not Found'));
            // return response()->json(['msg' => 'Support deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(\notifyMsg('error', $e->getMessage()));
            // return response()->json(['db_error' => $e->getMessage()]);
        }
    }
}
