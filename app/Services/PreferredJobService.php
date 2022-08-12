<?php

namespace App\Services;

use App\Models\Job;
use App\Models\Company;

class PreferredJobService
{
    public function getPreferredJob($employ)
    {
        $q = Job::query();
        $category_id = [];
        $industry_id = [];
        $country_id = [];
        $company_id = [];
        $category_id = array_merge(
            $category_id,
            $employ->jobCategoryPreference->pluck('id')->toArray(),
        );
        $country_id = array_merge(
            $country_id,
            $employ->countryPreference->pluck('id')->toArray(),
        );
        $industry_id = array_merge(
            $industry_id,
            $employ->industryPreference->pluck('id')->toArray(),
        );
        $company_id = array_merge(
            $company_id,
            Company::whereIn('industry_id', (array) $industry_id)
                ->pluck('id')
                ->toArray(),
        );

        $q->whereIn('job_categories_id', $category_id)
            ->orWhereIn('country_id', $country_id)
            ->orWhereIn('company_id', $company_id);
        return $q->take(5)->get('title');
    }
}
