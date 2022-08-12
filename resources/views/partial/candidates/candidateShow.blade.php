<style>
    .req {
        color: #ff382b !important;
    }

    #profilePicture .dropify-wrapper {
        height: 120px !important;
        width: 50% !important;
        max-width: 50% !important;
    }

    .personal_information p,
    .passport_detail p,
    .education_detail p,
    .training_detail p,
    .skill_detail p,
    .preferred_job_detail p,
    .language_detail p {
        line-height: 0.9
    }

    ..experience_detail p {
        line-height: 0.9
    }

    .tempcolor {
        color: #1650e2;
        font-weight: bold;
    }

</style>
<div class="row">
    <div class="col-xl-6">
        <div class="card m-b-20">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="personal_information_div">
                            <h4>{{ strtoupper('Personal Information') }}</h4>
                            <div class="mt-5 personal_information">
                                <p>Name: <span>{{ $employ->full_name }}</span></p>
                                <p>Gender: <span>{{ $employ->gender }}</span></p>
                                <p>Marital Status: <span>{{ $employ->marital_status }}</span></p>
                                <p>Date of Birth: <span>{{ !blank($employ->dob) ? date('Y F d', strtotime($employ->dob)) : '' }}</span></p>
                                <p>Height: <span>{{ $employ->height ? $employ->height . ' CM' : '' }}</span></p>
                                <p>Weight: <span>{{ $employ->weight ? $employ->weight . ' KG' : '' }}</span></p>
                            </div>
                        </div>
                        <div class="passport_detail_div mt-5">
                            <h4>{{ strtoupper('Passport Details') }}</h4>
                            <div class="mt-5 passport_detail">
                                <p>Passport Number: <span>{{ $employ->passport_number }}</span></p>
                                <p>Passport Expiry Date:
                                    <span>{{ $employ->passport_expiry_date != null ? date('Y F d', strtotime($employ->passport_expiry_date)) : '' }}</span>
                                </p>
                            </div>
                        </div>
                        @if ($employ->experience != null)
                            <div class="experience_div mt-5">
                                <h4>{{ strtoupper('Experience') }}</h4>

                                <div class="mt-5 experience_detail">
                                    @foreach ($employ->experience as $employ_experience)
                                        <?php
                                        // $job = DB::table('jobs')->where('id', $employ_experience['job_title_id']);
                                        // $job_category = DB::table('job_categories')
                                        //     ->where('id', $employ_experience['job_category_id']);
                                        // $country_name = DB::table('countries')
                                        //     ->where('id', $employ_experience['country_id']);

                                        // $job_title = $job->exists() ? $job->first()->title : '';
                                        // $country_title = $country_name->exists() ? $country_name->first()->name : '';
                                        // $job_category_title = $job_category->exists() ? $job_category->first()->functional_area : '';
                                        ?>
                                        <p>{{ $loop->iteration }}.&nbsp;<span>{{ $employ_experience->industry != null ? $employ_experience->industry->title : '' }},
                                                {{ $employ_experience->working_year != null? $employ_experience->working_year . ' ' . getYearForm($employ_experience->working_year): '' }}
                                                {{ $employ_experience->working_month != null? $employ_experience->working_month . ' ' . getMonthForm($employ_experience->working_month): '' }}
                                                {{ $employ_experience->job_category != null ? $employ_experience->job_category->functional_area : '' }}, {{ $employ_experience->country != null ? $employ_experience->country->name : '' }}</span></p>
                                    @endforeach
                                </div>

                            </div>
                        @endif

                        @if ($employ->education_level_id != null)
                            <div class="education_div mt-5">
                                <h4>{{ strtoupper('Education') }}</h4>
                                <div class="mt-3 education_detail">
                                    <p>{{ DB::table('educationlevels')->where('id', $employ->education_level_id)->first()->title }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($employ->employeeTrainings != null)
                            <div class="training_div mt-5">
                                <h4>{{ strtoupper('Training') }}</h4>
                                <div class="mt-3 training_detail">
                                    @foreach ($employ->employeeTrainings as $etraining)
                                        <p>{{ $loop->iteration }}.&nbsp;<span>{{ $etraining->training != null ? $etraining->training->title : '' }}</span>
                                        </p>
                                    @endforeach

                                </div>
                            </div>
                        @endif
                        @if ($employ->employeeSkills != null)
                            <div class="skill_div mt-5">
                                <h4>{{ strtoupper('Skills') }}</h4>
                                <div class="mt-3 skill_detail">
                                    @foreach ($employ->employeeSkills as $eskill)
                                        <p>{{ $loop->iteration }}.&nbsp;<span>{{ $eskill->skill != null ? $eskill->skill->title : '' }}</span>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($employ->employeeLanguage != null)
                            <div class="language_div mt-5">
                                <h4>{{ strtoupper('Language') }}</h4>
                                <div class="mt-3 language_detail">
                                    @foreach ($employ->employeeLanguage as $elanguage)
                                        <p>{{ $loop->iteration }}.&nbsp;{{ $elanguage->language != null ? $elanguage->language->lang : '' }}:&nbsp;<span>{{ $elanguage->language_level }}</span>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        {{-- <div class="preferred_job_div mt-5">
                            <h4>{{ strtoupper('Preferred Jobs') }}</h4>
                            <div class="mt-3 preferred_job_detail">
                                <p>1.&nbsp;English:&nbsp;<span>Good</span></p>
                                <p>2.&nbsp;Hindi:&nbsp;<span>Very Good</span></p>
                                <p>2.&nbsp;Malay:&nbsp;<span>Good</span></p>
                                <p>2.&nbsp;Chinese:&nbsp;<span>Fair</span></p>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-md-4">
                        <div class="image">
                            @php
                                $avatar = $employ->avatar != null ? $employ->avatar : 'uploads/defaultimage.jpg';
                            @endphp
                            <img src="{{ asset($avatar) }}" style="object-fit: cover" alt="">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    @if (json_decode($employ->full_picture, true) != null)
        <div class="col-xl-6">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="row">
                        @foreach (json_decode($employ->full_picture, true) as $efullpicture)
                            <div class="col-md-6 mt-5">
                                <div class="image">
                                    <img src="{{ asset($efullpicture) }}" style="object-fit: cover" alt="">
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
