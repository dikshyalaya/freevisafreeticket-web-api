<template>
    <div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-2">
                    <div class="card">
                        <div class="item-card">
                            <div class="item-card-desc">
                                <a href="#" @click.prevent="setStatusFilter('')"></a>
                                <div class="item-card-img">
                                    <img src="/images/defaultimage.jpg" alt="img" class="br-tr-7 br-tl-7"/>
                                </div>
                                <div class="item-card-text">
                                    <h4 class="mb-0">
                                        All <br />
                                        Applications<span>{{ status_count["total"] }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2">
                    <div class="card">
                        <div class="item-card">
                            <div class="item-card-desc">
                                <a href="#" @click.prevent="setStatusFilter('pending')"></a>
                                <div class="item-card-img">
                                    <img src="/images/defaultimage.jpg" alt="img" class="br-tr-7 br-tl-7"/>
                                </div>
                                <div class="item-card-text">
                                    <h4 class="mb-0">
                                        Unscreened Applications<span>{{status_count["pending"]}}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2">
                    <div class="card mb-xl-0">
                        <div class="item-card">
                            <div class="item-card-desc">
                                <a href="#" @click.prevent="setStatusFilter('shortlisted')"></a>
                                <div class="item-card-img">
                                    <img src="/images/defaultimage.jpg" alt="img" class="br-tr-7 br-tl-7"/>
                                </div>
                                <div class="item-card-text">
                                    <h4 class="mb-0">
                                        Shortlisted Applications<span>{{status_count["shortlisted"]}}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2">
                    <div class="card mb-xl-0">
                        <div class="item-card">
                            <div class="item-card-desc">
                                <a href="#" @click.prevent="setStatusFilter('interviewed')"></a>
                                <div class="item-card-img">
                                    <img src="/images/defaultimage.jpg" alt="img" class="br-tr-7 br-tl-7"/>
                                </div>
                                <div class="item-card-text">
                                    <h4 class="mb-0">
                                        Interviewed Applications<span>{{status_count["interviewed"]}}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2">
                    <div class="card mb-xl-0">
                        <div class="item-card">
                            <div class="item-card-desc">
                                <a href="#" @click.prevent="setStatusFilter('accepted')"></a>
                                <div class="item-card-img">
                                    <img src="/images/defaultimage.jpg" alt="img" class="br-tr-7 br-tl-7"/>
                                </div>
                                <div class="item-card-text">
                                    <h4 class="mb-0">Selected Applications<span>{{status_count["accepted"]}}</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2">
                    <div class="card mb-0">
                        <div class="item-card">
                            <div class="item-card-desc">
                                <a href="#" @click.prevent="setStatusFilter('rejected')"></a>
                                <div class="item-card-img">
                                    <img src="/images/defaultimage.jpg" alt="img" class="br-tr-7 br-tl-7"/>
                                </div>
                                <div class="item-card-text">
                                    <h4 class="mb-0">Rejected Applications<span>{{status_count["rejected"]}}</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-right">
                    <div class="row">
                        <strong class="col-md-3">Bulk Actions:</strong>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="row">
                        <span class="col-md-3 text-right">Set Application Status: </span>
                        <div class="btn-group  col-md-9">
                            <button :disabled="!selected.length" class="btn btn-outline-primary btn-sm" @click="bulkStatusUpdate('pending')">Unscreened</button>
                            <button :disabled="!selected.length" class="btn btn-outline-primary btn-sm" @click="bulkStatusUpdate('shortlisted')">Shortlisted</button>
                            <button :disabled="!selected.length" class="btn btn-outline-primary btn-sm" @click="bulkStatusUpdate('INTERVIEWED')">Interviewed</button>
                            <button :disabled="!selected.length" class="btn btn-outline-primary btn-sm" @click="bulkStatusUpdate('SELECTEDFORINTERVIEW')">Selected</button>
                            <button :disabled="!selected.length" class="btn btn-outline-primary btn-sm" @click="bulkStatusUpdate('REJECTED')">Rejected</button>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 mb-3">
                    <div class="row">
                        <span class="col-md-3 text-right">Actions: </span>
                        <div class="btn-group col-md-9">
                            <button :disabled="!selected.length" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#interviewModal">Schedule Interview</button>
                            <button :disabled="!selected.length" class="btn btn-outline-primary btn-sm">Send Email</button>
                            <button :disabled="!selected.length" class="btn btn-outline-primary btn-sm">Send Message</button>
                            <button :disabled="!selected.length" class="btn btn-outline-primary btn-sm" @click="bulkApplicationDelete()">Delete</button>
                            <button :disabled="!selected.length" class="btn btn-outline-primary btn-sm" @click="bulkCvDownload()">Download CV</button>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <strong>Filters:</strong>
                </div>
                <div class="col-md-12">
                    <div class="d-flex">
                        <div class="row mb-1 mr-0">
                            <div class="col-md-12 d-flex justify-content-center">
                                <form action="" method="GET">
                                    <div class="input-group input-icons">
                                        <i class="fa fa-search-icon"></i>
                                        <input type="text" class="form-control" v-model="filter.query"
                                               placeholder="Search Applicants" aria-label="Search Applicants"
                                               @keypress="setFilter" @keydown="setFilter" aria-describedby="button-addon2"/>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary rounded-0 ml-2"
                                                    @click.prevent="showAdvancedFilter">
                                                <i class="fa fa-filter mr-2"></i>Advanced Search
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="limit" value="" class="form-control" />
                                </form>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle rounded-0 mr-2" type="button" id="" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-filter mr-2"></i><span id="categorySelect">All Categories</span>
                                </button>
                                <div class="dropdown-menu scrollable-menu" ref="categorySelect" role="menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" @click.prevent="setCategoryFilter('', 'All Categories')">All Categories</a>
                                    <a v-for="(category, i) in job_categories" :key="i" class="dropdown-item" href="#"
                                       @click.prevent="setCategoryFilter(category.id, category.functional_area)">
                                        {{ category.functional_area }}
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-outline-primary  dropdown-toggle rounded-0 mr-2" type="button" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-filter mr-2"></i><span id="countrySelect">All Countries</span>
                                </button>
                                <div class="dropdown-menu scrollable-menu" role="menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" @click.prevent="setCountryFilter('', 'All Countries')">All Countries</a>
                                    <a v-for="(country, i) in countries" :key="i"
                                       class="dropdown-item" href="#"
                                       @click.prevent="setCountryFilter(country.id, country.name)">{{ country.name }}</a>
                                </div>
                            </div>

                            <!--<div class="form-checkntjobs@gmail.com">-->
                            <!--<input type="checkbox" class="form-check-input" id="checkAll">-->
                            <!--<label for="" class="my-auto">Select All Applicants On This Page</label>-->
                            <!--</div>-->

                            <!--<div class="form-check">-->
                            <!--<div class="form-check">-->
                            <!--<input type="checkbox" class="form-check-input">-->
                            <!--<label for="" class="my-auto">Select All 2 Applicants On This Job</label>-->
                            <!--</div>-->
                        </div>


                    </div>
                    <div class="text-center mt-4" v-if="!applicants.length">
                        <hr>
                        <img src="/images/flat-icons/empty-box.png" alt="" style="width: 200px;opacity: .5;"><br>
                        <p>No applicants.</p>
                    </div>
                    <div v-else class="table-responsive">
                        <table class="table table-bordered border-top mb-0">
                            <thead>
                            <tr>
                                <th>
                                    <!--<input type="checkbox" class="form-check rowCheck" name="applicationID[]" value="" data-id="">-->
                                    <label class="form-checkbox">
                                        <input type="checkbox" v-model="selectAll" @click="select"/>
                                        <i class="form-icon"></i>
                                    </label>
                                </th>
                                <th>S.N</th>
                                <th style="min-width: 200px">Candidate</th>
                                <th>Status</th>
                                <th style="min-width: 200px">Contact</th>
                                <th style="min-width: 200px">Job</th>
                                <th>Category</th>
                                <th style="min-width: 200px">Applied On</th>
                                <th>Country</th>
                                <th style="min-width: 150px">Profile Score</th>
                                <th style="min-width: 200px">Experience</th>
                                <th style="min-width: 200px">Education</th>
                                <th style="min-width: 200px">Training</th>
                                <th style="min-width: 150px">Language</th>
                                <th style="min-width: 200px">Skill</th>
                                <th style="min-width: 200px">Preferred Country</th>
                                <th style="min-width: 200px">Preferred Job</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(applicant, index) in applicants" :key="index" :data-id="applicant.id">
                                <td>
                                    <input type="checkbox" class="rowCheck" :value="applicant.id" v-model="selected"/>
                                    <!--<input type="checkbox" class="form-check rowCheck" name="applicationID[]" value="" data-id="">-->
                                </td>
                                <td>{{ index + 1 }}</td>
                                <td>
                                    <span v-if="applicant.employe">
                                      {{ applicant.employe.full_name }}<br />
                                      Gender/Age: {{ applicant.employe.gender }}, 23<br />
                                      Email: {{ applicant.employe.user.email }}
                                    </span>
                                </td>
                                <td class="applicantStatus">
                                    <strong>{{capitalizeFirstLetter(applicant.status) }}</strong>
                                </td>
                                <td>
                                    <span v-if="applicant.employe">
                                      Phone1:
                                      {{ applicant.employe.mobile_phone || "Not-Available"
                                      }}<br />
                                      Phone2:
                                      {{ applicant.employe.mobile_phone2 || "Not-Available" }}
                                    </span>
                                </td>
                                <td>
                                    <span v-if="applicant.job">{{ applicant.job.title }}</span>
                                </td>
                                <td>
                                    <span v-if="applicant.job">{{applicant.job.job_category.functional_area}}</span>
                                </td>

                                <td>{{ applicant.created_at }}</td>
                                <td>
                                    <span v-if="applicant.employe">{{applicant.employe.country.name}}</span>
                                </td>
                                <td>
                                    <span v-if="applicant.employe">{{ applicant.employe.profile_score }} %</span>
                                </td>
                                <td>
                                    <span v-if="applicant.employe && applicant.employe.experience">
                                      <span v-for="(experience, i) in applicant.employe.experience" :key="i">
                                        <span v-if="experience.job_category && i == 0">
                                          {{ experience.job_category.functional_area }},
                                          {{experience.working_year + getYearForm(experience.working_year)}},
                                          {{experience.working_month + getMonthForm(experience.working_month)}}
                                        </span>
                                      </span>
                                    </span>
                                </td>
                                <td>
                                    <span v-if="applicant.employe.education_level">
                                      {{ applicant.employe.education_level.title }}
                                    </span>
                                </td>
                                <td>
                                    <span v-if="applicant.employe && applicant.employe.employee_trainings">
                                      <span v-for="(item, i) in applicant.employe.employee_trainings" :key="i">
                                        <span v-if="i == 0">
                                          {{ item.training.title }}
                                        </span>
                                      </span>
                                    </span>
                                </td>
                                <td>
                                    <span v-if="applicant.employe && applicant.employe.employee_language">
                                      <span v-for="(item, i) in applicant.employe.employee_language" :key="i">
                                        <span v-if="i == 0">
                                          {{ item.language.lang }}
                                        </span>
                                      </span>
                                    </span>
                                </td>
                                <td>
                                    <span v-if="applicant.employe && applicant.employe.employee_skills">
                                      <span v-for="(item, i) in applicant.employe.employee_skills" :key="i">
                                        <span v-if="i == 0">
                                          {{ item.skill.title }}
                                        </span>
                                      </span>
                                    </span>
                                </td>
                                <td>
                                    <span v-if="applicant.employe &&  applicant.employe.country_preference">
                                      <span v-for="(countryPreference, i) in applicant.employe.country_preference" :key="i">
                                        <span v-if="i == 0">
                                          {{ countryPreference.name }}
                                        </span>
                                      </span>
                                    </span>
                                </td>
                                <td>
                                    <span v-if=" applicant.employe && applicant.employe.job_category_preference">
                                      <span v-for="(categoryPreference, i) in applicant.employe.job_category_preference" :key="i">
                                        <span v-if="i == 0">
                                          {{ categoryPreference.functional_area }}
                                        </span>
                                      </span>
                                    </span>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" @click="redirectTo('company/applicants/edit/', applicant.id)" class="text-primary my-auto"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0);" @click="redirectTo('company/applicants/applicant-detail/', applicant.employe.id)" class="text-primary my-auto"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12" v-if="applicants.length">
                    <div class="form-inline">
                        <label for="">Applicant Per Page</label>
                        <select @change="setLimit($event)" name="limit" v-model="limit" class="form-control rounded-0 bg-gray text-white">
                            <option value="All">All</option>
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="250">250</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!--Advanced Filter-->
        <div class="modal fade" id="advancedFilter" tabindex="-1" role="dialog" aria-labelledby="advancedFilter" aria-hidden="true">
            <div class="modal-dialog modal-lg filter-modal" role="document" style="width: 100%">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title" id="newSkillModalLabel">
                            Advanced Applicants Search
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-0">
                        <form action="#" method="#" id="FilterForm">
                            <div class="card mb-1">
                                <div class="card-body bg-secondary">
                                    <div class="filter-section">
                                        <div class="row mb-1">
                                            <div class="col-md-6 d-flex">
                                                <select name="predefined_filter" class="form-control" @change="setAdvancedFilterValue($event)">
                                                    <option value="">Select Filter</option>
                                                    <option v-for="(applicant_filter, index) in applicant_filters" :key="index" :value="applicant_filter.id">
                                                        {{ applicant_filter.filter_name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 d-flex"></div>
                                        </div>
                                        <!-- <form action="" @submit.prevent="saveFilter"> -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="filter_name" class="form-control" id="filterName" placeholder="Filter Name" required/>
                                                <div class="require text-danger filter_name"></div>
                                                <span class="" style="color: #1650e2">Save this setting for future use.</span>
                                            </div>
                                            <div class="col-md-6">
                                                <button v-if="filter_saving" type="button" class="btn btn-warning rounded-0">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </button>
                                                <button v-else type="submit" @click.prevent="saveFilter()" class="btn btn-warning rounded-0">
                                                    Save Filter
                                                </button>
                                                <a href="javascript:void(0);" @click="resetAdvancedSearchForm()" class="btn btn-outline-warning rounded-0" id="ResetFilter">
                                                    Reset Filter
                                                </a>
                                            </div>
                                        </div>
                                        <!-- </form> -->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="search-section mx-auto">
                                        <div class="row mt-1">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Category</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="job_title" class="form-control select2-show-search" data-placeholder="All Job Title" id="jobTitle">
                                                                <option value="">All Job Categories</option>
                                                                <option v-for="(job_category, index) in job_categories" :key="index" :value="job_category.id">
                                                                    {{ job_category.functional_area }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Gender</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="gender" class="form-control select2-show-search" data-placeholder="Select Gender" id="gender">
                                                                <option value="">Select Gender</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Applied Date (From)</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="from_date" class="form-control from_date" placeholder="25-01-2022" id="from_date" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Applied Date (To)</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="to_date" class="form-control to_date" placeholder="25-02-2022" id="to_date" readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Experience</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="d-flex">
                                                                <select name="experience" class="form-control select2-show-search w-60" data-placeholder="Select Experience" id="Experience">
                                                                    <option value="">Select Experience</option>
                                                                    <option v-for="(i, index) in 10" :key="index" :value="i">
                                                                        {{ i }}
                                                                    </option>
                                                                </select>
                                                                <label for="" class="w-40 my-auto">Years Min</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Education</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="education_level" class="form-control select2-show-search"
                                                                    data-placeholder="Select Education Level" id="EducationLevel">
                                                                <option value="">Select Education Level</option>
                                                                <option v-for="(education_level, index) in education_levels"
                                                                        :key="index" :value="education_level.id">
                                                                    {{ education_level.title }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Skills</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="skills[]" class="form-control select2-show-search" id="Skills" multiple>
                                                                <option value="">Select Skills</option>
                                                                <option v-for="(skill, index) in skills"
                                                                        :key="index" :value="skill.id">
                                                                    {{ skill.title }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Application Status</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="application_status" class="form-control select2-show-search"
                                                                    data-placeholder="Select Application Status" id="ApplicationStatus">
                                                                <option value="">Select Application Status</option>
                                                                <option v-for="(application_status, index) in applicationStatus"
                                                                        :key="index" :value="application_status">
                                                                    {{capitalizeFirstLetter(application_status)}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Profile Score</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="hidden" name="profile_score" id="profileScore"/>
                                                            <div id="profileScoreSlider">
                                                                <span id="rangeValue" tabindex="0" style="left: 0">0%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Age Range</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="d-flex">
                                                                        <select name="min_age" class="form-control select2-show-search"
                                                                                data-placeholder="Min" id="MinAge">
                                                                            <option value="">Min</option>
                                                                            <option v-for="(n, index) in minAge" :key="index" :value="n">
                                                                                {{ n }}
                                                                            </option>
                                                                        </select>
                                                                        <label for="" class="my-auto ml-1">years to</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="d-flex">
                                                                        <select name="max_age" class="form-control select2-show-search"
                                                                                data-placeholder="Max" id="MaxAge">
                                                                            <option value="">Max</option>
                                                                            <option v-for="(n, index) in maxAge" :key="index" :value="n">
                                                                                {{ n }}
                                                                            </option>
                                                                        </select>
                                                                        <label for="" class="my-auto ml-1">years</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Training</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="trainings[]" class="form-control select2-show-search" multiple id="Trainings">
                                                                <option value="">Select Trainings</option>
                                                                <option v-for="(training, index) in trainings" :key="index" :value="training.id">
                                                                    {{ training.title }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Language</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="languages[]" class="form-control select2-show-search" multiple id="Languages">
                                                                <option value="">Select Languages</option>
                                                                <option v-for="(language, index) in languages" :key="index" :value="language.id">
                                                                    {{ language.lang }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Preferred Job</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="preferred_jobs[]" class="form-control select2-show-search"
                                                                    multiple id="PreferredJobs">
                                                                <option value="">Select Preferred Job</option>
                                                                <option v-for="(preferredCategory, index) in preferredCategories"
                                                                        :key="index" :value="preferredCategory.id">
                                                                    {{ preferredCategory.functional_area }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4 my-auto">
                                                            <label for="" class="form-label">Preferred Country</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="preferred_countries[]" class="form-control select2-show-search"
                                                                    multiple id="PreferredCountries">
                                                                <option value="">Select Preferred Country</option>
                                                                <option v-for="(preferredCountry, index) in preferredCountries"
                                                                        :key="index" :value="preferredCountry.id">
                                                                    {{ preferredCountry.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-center mx-auto">
                                                <button v-if="filter_submitting" class="btn btn-primary rounded-0">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </button>
                                                <button v-else type="button" class="btn btn-primary rounded-0" @click.prevent="advanceFilter">
                                                    <i class="fa fa-search"></i> Search Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Interview -->
        <div class="modal fade" id="interviewModal" tabindex="-1" role="dialog" aria-labelledby="interviewModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="interviewModalLabel">
                            Schedule Interview
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="#" id="scheduleInterViewForm">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Interview Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" class="form-control" name="interview_date"/>
                                        <span class="require text-danger interview_date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Interview Time</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="time" class="form-control" name="interview_time"/>
                                        <span class="require text-danger interview_time"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary" id="saveScheduleInterview" @click="scheduleInterview()">
                            Schedule Interview
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Schedule Interview -->
    </div>
</template>

<script>
    import CompanyService from "../services/CompanyService";
    import { Errors } from "../error";

    export default {
        name: "Applicants",
        data() {
            return {
                errors: new Errors(),
                filter_saving: false,
                filter_submitting: false,
                applicants_pg: {},
                applicants: "",

                // data sets
                status_count: "",
                job_categories: [],
                education_levels: [],
                skills: [],
                countries: [],
                trainings: [],
                languages: [],
                preferredCategories: [],
                preferredCountries: [],
                applicant_filters: [],
                applicationStatus: [],

                // filter
                filter: {
                    query: "",
                    application_status: "",
                    category: "",
                    country: "",
                    formData: {},
                },

                // advanced filter
                // advanced_filter: {
                //   job_title: "",
                //   gender: "",
                //   from_date: "",
                //   to_date: "",
                //   experience: "",
                //   education_level: "",
                //   skills: "",
                //   application_status: "",
                //   profile_score: "",
                //   min_age: "",
                // },

                limit: "50",
                filterId: "",

                // selection
                selected: [],
                selectAll: false,
                category: "",
                country: "",
            };
        },
        created() {
            this.category = "All Categories";
            this.country = "All Countries";
        },
        mounted() {
            $(document).ready(function () {
                $("#from_date")
                    .datepicker({
                        format: "yyyy-mm-dd",
                        autoclose: true,
                        todayHighlight: true,
                        endDate: "0d",
                    })
                    .on("changeDate", function (selected) {
                        var minDate = new Date(selected.date.valueOf());
                        $("#to_date").datepicker("setStartDate", minDate);
                    });

                $("#to_date")
                    .datepicker({
                        format: "yyyy-mm-dd",
                        autoclose: true,
                        todayHighlight: true,
                        // endDate: '0d',
                    })
                    .on("changeDate", function (selected) {
                        var minDate = new Date(selected.date.valueOf());
                        $("#from_date").datepicker("setEndDate", minDate);
                    });

                $("#profileScoreSlider").find("span:nth-child(3)").remove();
            });
            $("#profileScoreSlider").slider({
                range: true,
                min: 0,
                max: 100,
                values: [0],
                slide: function (event, ui) {
                    $("#profileScore").val(ui.values[1] + "%");
                    $("#rangeValue")
                        .text(ui.values[1] + "%")
                        .css({
                            left: ui.values[1] + "%",
                        });
                },
            });

            $("#profileScore").val($("#profileScoreSlider").slider("values", 1) + "%");
            this.getDataSets();
            this.getApplicants();

            var selectedCategory = this.$refs.categorySelect.children;
            console.log(selectedCategory);
            if(selectedCategory.length){
                this.category = selectedCategory[0].value;
            }
        },
        methods: {
            select() {
                this.selected = [];
                if (!this.selectAll) {
                    for (let i in this.applicants) {
                        this.selected.push(this.applicants[i].id);
                    }
                }
            },

            async getDataSets() {
                const response = await CompanyService.getDataSets();
                if (response.data.success === true) {
                    this.job_categories = response.data.data.job_categories;
                    this.education_levels = response.data.data.education_levels;
                    this.skills = response.data.data.skills;
                    this.trainings = response.data.data.trainings;
                    this.languages = response.data.data.languages;
                    this.preferredCategories = response.data.data.preferredCategories;
                    this.preferredCountries = response.data.data.preferredCountries;
                    this.countries = response.data.data.countries;
                    this.status_count = response.data.data.status_count;
                    this.applicant_filters = response.data.data.applicant_filters;
                    this.applicationStatus = response.data.data.applicationStatus;
                }
            },
            setStatusFilter(status) {
                this.filter.application_status = status;
                this.getApplicants();
            },
            setCategoryFilter(status, categoryName) {
                this.filter.category = status;
                $("#categorySelect").html(categoryName)
                this.getApplicants();
            },
            setCountryFilter(status, countryName) {
                this.filter.country = status;
                $("#countrySelect").html(countryName)
                this.getApplicants();
            },
            async saveFilter() {
                this.filter_saving = true;
                var formData = new FormData($("#FilterForm")[0]);
                await CompanyService.saveAdvancedFilter(formData).then((response) => {
                    if (response.data.success == false) {
                        if (response.data.errors) {
                            toastr.error(response.data.errors.filter_name[0]);
                            $(".filter_name").html(response.data.errors.filter_name[0]);
                        } else if (response.data.db_error) {
                            toastr.error(response.data.db_error);
                        }
                    } else if (response.data.success == true) {
                        toastr.success(response.data.msg);
                        this.resetAdvancedSearchForm();
                    }
                });
                this.filter_saving = false;
            },
            advanceFilter() {
                this.showBusySign();
                this.filter_submitting = true;
                var myFormData = new FormData($("#FilterForm")[0]);
                var formValue = Object.fromEntries(myFormData.entries());
                formValue.preferred_jobs = myFormData.getAll('preferred_jobs[]');
                formValue.skills = myFormData.getAll('skills[]');
                formValue.trainings = myFormData.getAll('trainings[]');
                formValue.languages = myFormData.getAll('languages[]');
                formValue.preferred_countries = myFormData.getAll('preferred_countries[]');
                // console.log(JSON.stringify(formValue, null, 2));
                // var data = {};
                // $("#FilterForm").serializeArray().map(function(x){
                //   data[x.name] = x.value;
                // });
                this.filter.formData = JSON.stringify(formValue, null, 2);
                // console.log(this.filter.formData);
                this.getApplicants();
                this.resetAdvancedSearchForm();
                $("#advancedFilter").modal("hide");

                // this.getApplicants(0, 50, JSON.stringify(this.filter), myFormData);
                this.filter_submitting = false;
                this.hideBusySign();
            },
            setLimit(event) {
                this.showBusySign();
                this.limit = event.target.value;
                this.getApplicants(0, this.limit, JSON.stringify(this.filter));
                this.hideBusySign();
            },
            setFilter: _.debounce(function () {
                this.getApplicants();
            }, 800),

            async getApplicants(page = 0, limit = this.limit ?? 50) {
                let response = await CompanyService.getApplicants(
                    page,
                    limit,
                    JSON.stringify(this.filter),
                );
                if (response.data.success === true) {
                    this.applicants_pg = response.data.data.applicants;
                    this.applicants = response.data.data.applicants.data;
                }
            },

            showAdvancedFilter() {
                $("#advancedFilter").modal("show");
                this.filter.query = "";
                this.filter.category = "";
                this.filter.application_status = "";
                this.filter.country = "";
            },
            resetAdvancedSearchForm() {
                $("#FilterForm")[0].reset();
                $(".select2-show-search").val(null).trigger("change");
                $(".select2").val(null).trigger("change");
                $("#profileScore").val("0%");
                $("#rangeValue").text("0%").css({
                    left: "0%",
                });
                $(".ui-slider-range.ui-corner-all.ui-widget-header").css({
                    width: "0%",
                });
                $(".ui-slider-handle.ui-corner-all.ui-state-default").css({
                    left: "0%",
                });
                $(".require").css("display", "none");
                $("#filterName").val("");
            },
            setAdvancedFilterValue(event) {
                this.showBusySign();
                this.filterId = event.target.value;
                if (this.filterId == "") {
                    this.resetAdvancedSearchForm();
                } else {
                    CompanyService.getApplicantFilterData({
                        params: { applicantFilterId: this.filterId },
                    }).then((response) => {
                        if (response.data.success == false) {
                            toastr.error(response.data.error);
                        } else if (response.data.success == true) {
                            var jsonData = JSON.parse(
                                response.data.applicantFilter.filter_value
                            )[0];
                            $("#jobTitle").select2("val", jsonData.job_title);
                            $("#gender").val(jsonData.gender).trigger("change");
                            $("#from_date").val(jsonData.from_date);
                            $("#to_date").val(jsonData.to_date);
                            $("#Experience").select2("val", jsonData.experience);
                            $("#EducationLevel").select2("val", jsonData.education_level);
                            $("#Skills").val(JSON.parse(jsonData.skills)).trigger("change");
                            $("#ApplicationStatus")
                                .val(jsonData.application_status)
                                .trigger("change");
                            $("#profileScore").val(jsonData.profile_score);
                            $("#rangeValue").text(jsonData.profile_score).css({
                                left: jsonData.profile_score,
                            });
                            $(".ui-slider-range.ui-corner-all.ui-widget-header").css({
                                width: jsonData.profile_score,
                            });
                            $(".ui-slider-handle.ui-corner-all.ui-state-default").css({
                                left: jsonData.profile_score,
                            });
                            $("#MinAge").val(jsonData.min_age).trigger("change");
                            $("#MaxAge").val(jsonData.max_age).trigger("change");
                            $("#Trainings")
                                .val(JSON.parse(jsonData.trainings))
                                .trigger("change");
                            $("#Languages")
                                .val(JSON.parse(jsonData.languages))
                                .trigger("change");
                            $("#PreferredJobs")
                                .val(JSON.parse(jsonData.preferred_jobs))
                                .trigger("change");
                            $("#PreferredCountries")
                                .val(JSON.parse(jsonData.preferred_countries))
                                .trigger("change");
                            $("#filterName").val(response.data.applicantFilter.filter_name);
                        }
                    });
                }
                this.hideBusySign();
            },
            async bulkStatusUpdate(status) {
                await Swal.fire({
                    text: "Are you sure you want to perform bulk operation?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.showBusySign();
                        let data = new FormData();
                        data.append("ids", this.selected);
                        data.append("applicantStatus", status);
                        CompanyService.updateBulkStatus(data).then((response) => {
                            if (response.data.success == false) {
                                if (response.data.db_error) {
                                    toastr.error(response.data.db_error);
                                } else if (response.data.error) {
                                    toastr.error(response.data.error);
                                }
                            }
                            if (response.data.success == true) {
                                var statuses = JSON.parse(response.data.statuses);
                                $.each(statuses, function (k, v) {
                                    $.each(v, function (key, value) {
                                        var tableRow = $('tr[data-id="' + key + '"]');
                                        $(tableRow).find(".applicantStatus").html('<strong>' + value + '</strong>');
                                    });
                                });
                                toastr.success(response.data.msg);
                                $("input:checkbox").prop("checked", false);
                                this.selected = [];
                                this.selectAll = false;
                                // $("#applicationStatusButton").attr('disabled', true);
                                // $("#bulkActionButton").attr('disabled', true);
                            }
                            this.hideBusySign();
                        });
                    }
                });
            },

            async bulkCvDownload() {
                await Swal.fire({
                    text: "Are you sure you want to perform bulk download?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes Download!",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.showBusySign();
                        const config = {
                            responseType: "blob",
                        };
                        let data = new FormData();
                        data.append("ids", this.selected);

                        CompanyService.downloadBulkCv(data, config).then((response) => {
                            if (response.data.success == false) {
                                if (response.data.error) {
                                    toastr.error(response.data.error.ids[0]);
                                }
                            }
                            if (response.data.success != false) {
                                var blob = new Blob([response.data], {
                                    type: "application/pdf",
                                });
                                var link = document.createElement("a");
                                link.href = window.URL.createObjectURL(blob);
                                link.download = "Applicants.pdf";
                                link.click();
                                toastr.success("Applicants CV Downloaded");
                                $("input:checkbox").prop("checked", false);
                                this.selected = [];
                                this.selectAll = false;
                            }

                            this.hideBusySign();
                        });
                    }
                });
            },

            async bulkApplicationDelete() {
                await Swal.fire({
                    text: "Are you sure you want to perform bulk delete?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes Delete!",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.showBusySign();
                        CompanyService.deleteBulkApplication({
                            data: { ids: this.selected.join(","), _method: "DELETE" },
                        }).then((response) => {
                            if (response.data.success == false) {
                                if (response.data.error) {
                                    toastr.error(response.data.error);
                                }
                            }
                            // $(".rowCheck:checked").each(function(){
                            //     $(this).parents("tr").remove();
                            // });
                            this.getApplicants();
                            toastr.success(response.data.msg);
                            $("input:checkbox").prop("checked", false);
                            this.selected = [];
                            this.selectAll = false;
                            this.hideBusySign();
                        });
                    }
                });
            },

            async scheduleInterview() {
                await $(".require").css("display", "none");
                Swal.fire({
                    text: "Are you sure you want to perform bulk operation?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.showBusySign();
                        let formData = new FormData($("#scheduleInterViewForm")[0]);
                        formData.append("ids", this.selected);
                        CompanyService.interviewSchedule(formData).then((response) => {
                            if (response.data.success == false) {
                                if (response.data.errors) {
                                    $.each(response.data.errors, function (key, value) {
                                        $("." + key)
                                            .css("display", "block")
                                            .html(value);
                                    });
                                } else if (response.data.error) {
                                    toastr.error(response.data.error);
                                }
                            } else if (response.data.success == true) {
                                toastr.success(response.data.msg);
                                var statuses = JSON.parse(response.data.statuses);
                                $.each(statuses, function (key, value) {
                                    $.each(value, function (k, v) {
                                        var tableRow = $('tr[data-id="' + k + '"]');
                                        $(tableRow).find(".applicantStatus").text(v);
                                    });
                                });
                                $("#interviewModal").modal("hide");
                                this.selected = [];
                                this.selectAll = false;
                                this.hideBusySign();
                            }
                        });
                    }
                });
            },
            redirectTo(url, id){
                var current_url = window.location.origin;
                var url = current_url + '/' + url + id;
                location.href = url;
            }
        },

        computed: {
            minAge() {
                let arr = [];
                for (var i = 18; i <= 25; i++) arr[i] = i;
                return arr;
            },
            maxAge() {
                let maxage = [];
                for (var i = 18; i <= 50; i++) maxage[i] = i;
                return maxage;
            },
        },
    };
</script>

<style scoped>
    .item-card .item-card-desc .item-card-text {
        position: absolute;
        top: 25%;
        left: 0;
        right: 0;
        bottom: 0;
        text-align: center;
        color: #fff;
        z-index: 2;
        align-items: center;
        vertical-align: middle;
    }

    .item-card-text h4 {
        font-size: 14px;
        font-weight: 600;
        text-transform: none;
    }

    .table-bordered,
    .text-wrap table {
        border: 1px solid #e8ebf3 !important;
    }

    .item-card-text span {
        font-size: 25px;
        display: block;
        margin: 0.5rem;
        font-weight: 400;
    }
    .scrollable-menu {
        height: auto;
        max-height: 200px;
        overflow-y: auto;
    }

    .modal-content{
        max-width: 1345px;
    }
    .modal-dialog{
        max-width: 1345px;
    }
</style>
