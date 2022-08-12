<div class="row">
    <div class="card mb-0">
        <div class="card-body">
            <div class="row">
                @foreach ($jobCategories as $category)
                    <div class="col-md-4">
                        <a href="{{ route('candidate.job_search.index', ['type' => 'jobs_by_category', 'category_id' => $category->id]) }}">
                            <p>{{ $category->functional_area }}&nbsp;({{ $category->jobs_count }})</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@if (request()->has('category_id'))
    @php
        $data = App\Models\JobCategory::where('id', request()->category_id)
            ->value('functional_area');
    @endphp
    <div class="row">
        <div class="card mb-0">
            <div class="card-header">
                <div class="d-flex mx-auto">
                    <h5 class="card-title my-auto ml-5">{{ $data }}</h5>
                </div>
            </div>
        </div>
    </div>
@endif