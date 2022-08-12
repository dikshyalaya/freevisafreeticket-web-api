<?php

namespace App\Traits\Site;

use Illuminate\Http\Response;
use App\Models\Company;
use App\Traits\Site\ThemeMethods;

trait CompanyMethods
{
    use ThemeMethods;

    public function company()
    {
        return @Company::where('user_id', \Auth::user()->id)->first();
    }

    public function company_view($path, $obj = [])
    {
        $company = $this->company();
        return $this->site_view($path, array_merge($obj, ["company" => $company]));
    }
}
