<?php

namespace App\Http\Controllers\API\Candidates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployCv;
use App\Models\Employe;
use App\Traits\Api\ApiMethods;

class CvController extends Controller
{
    use ApiMethods;
    public $employ;
    public function upload(Request $request)
    {
        $employ = Employe::where('user_id', auth()->user()->id)->first();
        $request->validate([
            'cv_file' => 'required|file|mimes:pdf|max:5120',
        ]);
        $cv_record = EmployCv::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title ?? '',
                'cv_file' => $this->store($request->file('cv_file')),
                'employ_id' => $employ->id,
            ]
        );
        return  $this->sendResponse($this->process($cv_record), "CV uploaded successfully.");
    }
    public function fetch()
    {
        $employ = Employe::where('user_id', auth()->user()->id)->first();
        try {
            $cv_record = EmployCv::where('employ_id', $employ->id)->first();
            return  $this->sendResponse($this->process($cv_record), "CV fetched successfully.");
        } catch (\Throwable $th) {
            $errors = ["No CV found."];
            return  $this->sendError($errors);
        }
    }
    private function process($cv)
    {
        return [
            "id" => $cv->id,
            "title" => $cv->title,
            "cv_file" => env('APP_URL') . $cv->cv_file,
        ];
    }
    public function store($file)
    {
        $imageName = time() . '.pdf';
        $file->move(public_path('/uploads/cv/'), $imageName);
        return 'uploads/cv/' . $imageName;
    }
    public function edit(Request $request)
    {
        $employ = Employe::where('user_id', auth()->user()->id)->first();
        $cv = EmployCv::where('id', $request->id)->where('employ_id', $employ->id)->first();
        $cv->update(
            [
                'title' => $request->title ?? '',
                'cv_file' => $this->store($request->file('cv_file')),
            ]
        );
        return  $this->sendResponse($this->process($cv), "CV fetched successfully.");
    }
    // Delete CV file
    public function delete($id)
    {
        $employ = Employe::where('user_id', auth()->user()->id)->first();
        $cv = EmployCv::where('id', $id)->where('employ_id', $employ->id)->first();
        $cv->delete();
        return  $this->sendResponse([], "CV deleted successfully.");
    }
}
