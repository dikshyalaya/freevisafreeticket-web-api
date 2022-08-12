@extends('themes.fvft.company.layouts.dashmaster')
@section('title', 'Applicants')
@section('applicants', 'active')
@section('content')
    <div class="card-header">
        <h3 class="card-title">{{ __('Applicant List') }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('company.applicant.index') }}" method="GET">
                    <div class="d-inline-flex">
                        <div class="form-group">
                            <input type="text" name="job_title" value="{{ request()->job_title }}" class="form-control" placeholder="{{ __('Search By Job Title') }}">
                        </div>
                        <div class="form-group">
                            <select name="category_id" class="form-control ml-2">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->functional_area }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ml-3">
                            <button type="submit" class="btn btn-primary rounded-0">{{ __('Search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered table-hover mb-0 text-nowrap">
            <thead>
                <tr>
                    <th>{{ __('Employe Name') }}</th>
                    <th>{{ __('Job Title') }}</th>
                    <th>{{ __('Applied At') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Interview Status') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $key => $applicant)
                    <tr>
                        <td>{{ $applicant->employe->full_name }}</td>
                        <td>{{ $applicant->job->title }}</td>
                        <td>{{ date('Y-m-d', strtotime($applicant->created_at)) }}</td>
                        <td>{{ $applicant->status }}</td>
                        <td>{{ $applicant->interview_status }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm text-white" data-toggle="tooltip" data-original-title="Edit"
                                href="{{ route('company.applicant.editApplication', $applicant->id) }}"><i
                                    class="fa fa-edit"></i></a>
                            <a class="btn btn-primary btn-sm text-white" data-toggle="tooltip" data-original-title="View"
                                href="{{ route('company.applicant.detail', $applicant->employ_id) }}"><i
                                    class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $applicants->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
