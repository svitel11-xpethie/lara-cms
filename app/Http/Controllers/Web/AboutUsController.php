<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Service;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $company = Company::first();
        $company->about_us = str_replace("<p></p>", "<br>", $company->about_us);

        $services = Service::take(6)
            ->orderBy('order', 'ASC')
            ->get() // Fetch the collection first
            ->map(function ($blog) {
                $blog->description = strlen(strip_tags($blog->content)) > 150
                    ? substr(strip_tags($blog->content), 0, 150) . '...'
                    : strip_tags($blog->content);
                return $blog;
            });

        return view('web.pages.about.index', compact('company', 'services'));
    }
}
