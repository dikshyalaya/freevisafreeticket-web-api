<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Applicants PDF</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style media="all">
        .column {
            float: left;
            width: 45%;
        }

        .column1 {
            width: 100%;
        }

        .padding {
            padding-left: 74px;
        }

        .card img {
            height: 150px;
            width: 150px;
        }

        p {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .otherP {
            margin-left: 317px;
        }

        .d-flex {
            display: flex;
            flex-direction: row;
            width: 100%;
            flex-wrap: nowrap;

        }

        .mt-3 {
            margin-top: 40px;
        }

        .ml-5 {
            margin-left: 40px;
            text-align: left;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: 400;
        }

        h1 {
            margin-bottom: 5px;
            font-size: 26px;
            font-weight: 600;
        }

        .breakpage {
            page-break-after: always;
        }

        .breakpage:last-child {
            page-break-after: unset;
        }

    </style>
</head>

<body>
    @foreach ($employes as $employ)
        <div class="card breakpage">
            <div class="row d-flex">
                <div class="column">
                    @if (!blank($employ->avatar) and file_exists($employ->avatar))
                        <img src="{{ public_path($employ->avatar) }}" alt="" />
                    @else
                        <img src="{{ public_path('images/defaultimage.jpg') }}" alt="" />
                    @endif
                </div>
                <div class="column1">
                    <h1>{{ $employ->full_name }}</h1>
                    <p>{{ $employ->state != null ? $employ->state->name : '' }}
                        {{ $employ->country != null ? ', ' . $employ->country->name : '' }}
                        {{ $employ->city != null ? ', ' . $employ->city->name : '' }}</p>
                    <p>Email : {{ $employ->user != null ? $employ->user->email : '' }}</p>
                    <p>Phone : {{ $employ->mobile_phone }}</p>
                </div>
            </div>
            <div class="row d-flex mt-3">
                <div class="column">
                    <h2 class="pI">Personal Details</h2>
                </div>
                <div class="column1">
                    <p>Gender : {{ $employ->gender }}</p>
                    <p>Marital Status : {{ $employ->marital_status }}</p>
                    <p class="otherP">Weight : {{ $employ->weight ? $employ->weight . ' KG' : '' }}</p>
                    <p class="otherP">Date of Birth : {{ date('Y F d', strtotime($employ->dob)) }}</p>
                    <p class="otherP">Height : {{ $employ->height ? $employ->height . ' CM' : '' }}</p>
                </div>
            </div>
            @if ($employ->experience != null && !empty($employ->experience))
                <div class="row d-flex mt-3">
                    <div class="column">
                        <h2 class="pI">Experience</h2>
                    </div>
                    <div class="column1">
                        @if ($employ->experience != null)
                            @foreach ($employ->experience as $employ_experience)
                                <p class="otherP">
                                    {{ $loop->iteration }}.&nbsp;<span>{{ $employ_experience->industry != null ? $employ_experience->industry->title : '' }},
                                        {{ $employ_experience->working_year != null ? $employ_experience->working_year . ' ' . getYearForm($employ_experience->working_year) : '' }}
                                        {{ $employ_experience->working_month != null ? $employ_experience->working_month . ' ' . getMonthForm($employ_experience->working_month) : '' }}
                                        {{ $employ_experience->job_category != null ? $employ_experience->job_category->functional_area : '' }},
                                        {{ $employ_experience->country != null ? $employ_experience->country->name : '' }}</span>
                                </p>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
            <div class="row d-flex mt-3">
                <div class="column">
                    <h2 class="pI">Education</h2>
                </div>
                <div class="column1">
                    <p>{{ $employ->education_level != null ? $employ->education_level->title : '' }}</p>
                </div>
            </div>
            <div class="row d-flex mt-3">
                <div class="column">
                    <h2 class="pI">Training</h2>
                </div>
                <div class="column1">
                    <p>
                        @if ($employ->employeeTrainings != null)
                            @foreach ($employ->employeeTrainings as $etraining)
                                {{ $loop->first ? '' : ',' }}
                                {{ $etraining->training != null ? $etraining->training->title : '' }}
                            @endforeach
                        @endif
                    </p>
                </div>
            </div>
            <div class="row d-flex mt-3">
                <div class="column">
                    <h2 class="pI">Skills</h2>
                </div>
                <div class="column1">
                    <p>
                        @if ($employ->employeeSkills != null)
                            @foreach ($employ->employeeSkills as $eskill)
                                @if ($eskill->skill != null)
                                    {{ $loop->first ? '' : ',' }}
                                    {{ $eskill->skill != null ? $eskill->skill->title : '' }}
                                @endif
                            @endforeach
                        @endif
                    </p>
                </div>
            </div>
            <div class="row d-flex mt-3">
                <div class="column">
                    <h2 class="pI">Language</h2>
                </div>
                <div class="column1">
                    @if ($employ->employeeLanguage != null)
                        @foreach ($employ->employeeLanguage as $elanguage)
                            @if ($elanguage->language != null)
                                <p class="otherP">
                                    {{ $elanguage->language != null ? $elanguage->language->lang : '' }} <span
                                        class="ml-5">{{ $elanguage->language_level }}</span></p>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="row d-flex mt-3">
                <div class="column">
                    <h2 class="pI">Preferred Jobs</h2>
                </div>
                <div class="column1">
                    <p class="otherP">
                        @php
                            $jobs = ( new App\Services\PreferredJobService)->getPreferredJob($employ);
                        @endphp
                        @foreach ($jobs as $job)
                            {{ $loop->first ? '' : ',' }}
                            {{ ucfirst($job->title) }}
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</body>

</html>
