<?php

namespace App\Http\Controllers;

use App\Banners;
use App\Faqs;
use App\Portfolio;
use App\PortfolioImage;
use App\Services;
use App\SiteInformation;
use App\Slider;
use App\Testimonial;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SiteController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $siteInformation = SiteInformation::first();
        $sliders = Slider::orderBy('sequence')->get();
        $boxBanners = Banners::where('banner_size', 3)->orderBy('sequence', 'asc')->get();
        $verticalBanner = Banners::where('banner_size', 6)->orderBy('sequence', 'asc')->first();
        $verticalWideBanner = Banners::where('banner_size', 8)->orderBy('sequence', 'asc')->first();

        $services = Services::orderBy('sequence');
        $servicesForEnquiries = Services::orderBy('sequence')->get();

        $allProducts = Portfolio::with('portfolioImages')->orderBy('sequence')->get();

        $awesomeWorks = PortfolioImage::where('show_in_home_page', 1)
            ->orderBy('created_at', 'desc')->limit(12)->get();
        $testmonials = Testimonial::orderBy('created_at', 'desc')->get();

        return view('site.home', [
            'siteInformation' => $siteInformation,
            'sliders' => $sliders,
            'services' => $services,
            'awesomeWorks' => $awesomeWorks,
            'testmonials' => $testmonials,
            'servicesForEnquiries' => $servicesForEnquiries,
            'boxBanners' => $boxBanners,
            'verticalBanner' => $verticalBanner ?? new Banners(),
            'verticalWideBanner' => $verticalWideBanner ?? new Banners(),
            'allProducts' => $allProducts
        ]);
    }

    public function services(Request $request, $slug = null)
    {
        $siteInformation = SiteInformation::first();
        $services = Services::orderBy('sequence')->get();

        try {


            if ($slug) {

                $service = Services::where('slug', $slug)->first();

                if ($service) {

                    return view('site.service_single', [
                        'siteInformation' => $siteInformation,
                        'service' => $service
                    ]);
                } else {
                    throw new ModelNotFoundException();
                }
            } else {
                return view('site.service_multiple', [
                    'siteInformation' => $siteInformation,
                    'services' => $services
                ]);
            }
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            return response(['status' => "Service Not Found"], 404);
        }
    }

    public function portfolio()
    {

        $siteInformation = SiteInformation::first();
        $portfolios = Portfolio::orderBy('sequence')->get();

        return view(
            'site.portfolio',
            [
                'portfolios' => $portfolios,
                'siteInformation' => $siteInformation
            ]
        );
    }

    public function testimonial()
    {
    }

    public function howWeWork()
    {
    }

    public function faqs()
    {
        $siteInformation = SiteInformation::first();
        $faqs = Faqs::orderBy('sequence')->get();
        $services = Services::orderBy('sequence')->get();
        return view('site.faqs', ['siteInformation' => $siteInformation, 'faqs' => $faqs, 'services' => $services]);
    }

    public function saveEnquiry()
    {
    }
}
