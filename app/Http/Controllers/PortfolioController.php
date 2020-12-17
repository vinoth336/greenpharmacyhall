<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceRequest;
use App\Portfolio;
use App\PortfolioImage;
use App\Services;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolioImages = Portfolio::OrderBy('sequence')->get();

        return view('portfolio.list', ['portfolios' => $portfolioImages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $services = $this->getServices()->orderBy('sequence')->get();

        return view('portfolio.create', ['services' => $services]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiceRequest $request)
    {

        DB::beginTransaction();
        try{

            $this->savePortfolio(new Portfolio(), $request);

            DB::commit();

            return redirect()->route('portfolio.index')->with('status', 'Created Successfully');

        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => "Can't Store Data", "message" => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        $services = $this->getServices()->orderBy('sequence')->get();

        return view('portfolio.edit')->with([
            'portfolio' => $portfolio,
            'services' => $services
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateServiceRequest $request, Portfolio $portfolio)
    {
        DB::beginTransaction();
        try{

            $this->savePortfolio($portfolio, $request);

            DB::commit();

            return redirect()->route('portfolio.index')->with('status', 'Created Successfully');

        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => "Can't Store Data"], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        DB::beginTransaction();

        try{

            foreach($portfolio->portfolioImages as $portfolioImage){
                    $portfolioImage->unlinkImage($portfolioImage->image);
            }

            $portfolio->portfolioImages()->delete();
            $portfolio->services()->detach();
            $portfolio->delete();

            DB::commit();

            return redirect()->route('portfolio.index')->with('status', 'Removed Successfully');

        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => "Can't Delete Data"], 500);
        }

    }

    public function updateSequence(Request $request)
    {

        DB::beginTransaction();

        try
        {
            foreach($request->input('sequence') as $sequence => $id) {
                $portfolio = Portfolio::find($id);
                $portfolio->sequence = $sequence + 1;
                $portfolio->save();
            }
        } catch(Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            response(['status' => 'Cannot Update Sequence'], 500);
        }

        DB::commit();

        return response(['message' => 'Updated Successfully'], 200);
    }


     /**
     * Create or Update the Portfolio in storage
     *
     * @param PortfolioImageRequest $request
     * @param Portfolio $Portfolio
     * @return Portfolio
     */
    public function savePortfolio($portfolio, $request)
    {

        $portfolioBanner = $request->file('portfolio_banner_image') ?? null;
        $portfolio->storeImage($portfolioBanner, ['width' => 161 , 'height' => 161]);
        $portfolio->name = $request->input('name');
        $portfolio->product_code = $request->input('product_code');
        $portfolio->description = $request->input('description');
        $portfolio->price = (float) $request->input('price');
        $portfolio->discount_amount = (float) $request->input('discount_amount');
        $portfolio->sequence = $portfolio->sequence ?? Portfolio::count() + 1;
        $portfolio->save();

        $portfolio->services()->sync($request->input('services'));


        if($request->has('portfolio_images')) {

            $portfolioImageCount = $portfolio->portfolioImages()->count() + 1;
            $images = $request->file('portfolio_images');
            foreach($images as $image){
                $portfolioImage = new PortfolioImage();
                $portfolioImage->storeImage($image, ['width' => 230 , 'height' => 230]);
                $portfolioImage->sequence = $portfolioImageCount++;
                $portfolio->portfolioImages()->save($portfolioImage);
            }

        }


        return $portfolio;
    }


    public function getServices()
    {

        return new Services;
    }


}
