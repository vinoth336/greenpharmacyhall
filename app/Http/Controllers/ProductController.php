<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\GetSlugNameRequest;
use App\Http\Requests\ImportProductImageRequest;
use App\Imports\ImportProduct;
use App\Product;
use App\ProductImage;
use App\Services;
use App\SubCategory;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Psy\Util\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ProductImages = Product::with('brand')->OrderBy('name')->get();

        return view('product.list', ['products' => $ProductImages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $services = $this->getServices()->orderBy('sequence')->get();
        $subCategories = SubCategory::orderBy('sequence')->get();

        $brands = Brand::get();

        return view('product.create', ['services' => $services, 'brands' => $brands, 'subCategories' => $subCategories]);
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
        try {

            $this->savePortfolio(new Product(), $request);

            DB::commit();

            return redirect()->route('product.index')->with('status', 'Created Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => "Can't Store Data", "message" => $e->getMessage()], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import_product(Request $request)
    {
        if ($request->get('type') == 'product') {
            return view('product.import');
        } else {
            return view('product.import_image');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $services = $this->getServices()->orderBy('sequence')->get();
        $subCategories = SubCategory::orderBy('sequence')->get();
        $brands = Brand::get();


        return view('product.edit')->with([
            'product' => $product,
            'services' => $services,
            'brands' => $brands,
            'subCategories' => $subCategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateServiceRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {

            $this->savePortfolio($product, $request);

            DB::commit();

            return redirect()->route('product.index')->with('status', 'Created Successfully');
        } catch (Exception $e) {
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
    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {

            if($product->ProductImages()->count() > 0) {
                foreach ($product->ProductImages as $ProductImage) {
                    $ProductImage->unlinkImage($ProductImage->image);
                }
                $product->ProductImages()->delete();
            }
            $product->services()->detach();
            $product->delete();

            DB::commit();

            return response(['status' => true, "message" => "Removed Successfully"], 200);
        } catch(ModelNotFoundException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => false, "message" => $e->getMessage()], 404);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => false, "message" => $e->getMessage()], 500);
        }
    }

    public function updateSequence(Request $request)
    {

        DB::beginTransaction();

        try {
            foreach ($request->input('sequence') as $sequence => $id) {
                $product = Product::find($id);
                $product->sequence = $sequence + 1;
                $product->save();
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            response(['status' => 'Cannot Update Sequence'], 500);
        }

        DB::commit();

        return response(['message' => 'Updated Successfully'], 200);
    }


    /**
     * Create or Update the Product in storage
     *
     * @param PortfolioImageRequest $request
     * @param Product $Product
     * @return Product
     */
    public function savePortfolio($product, $request)
    {

        $portfolioBanner = $request->file('portfolio_banner_image') ?? null;
        $product->storeImage($portfolioBanner, ['width' => 161, 'height' => 161]);
        $product->name = $request->input('name');
        $product->slug = str_slug($request->input('name'));
        $product->brand_id = $request->input('brand');
        $product->sub_category_id = $request->input('sub_category');
        $product->product_code = $request->input('product_code');
        $product->description = $request->input('description');
        $product->price = (float) $request->input('price');
        $product->discount_amount = (float) $request->input('discount_amount');
        $product->sequence = $product->sequence ?? Product::count() + 1;
        $product->status = $request->has('status') ? 1 : 0;
        $product->save();
        $product->services()->sync($request->input('services'));
        $product->touch(); // This will help to add in cache
        if ($request->has('product_images')) {
            $portfolioImageCount = $product->ProductImages()->count() + 1;
            $images = $request->file('product_images');
            foreach ($images as $image) {
                $ProductImage = new ProductImage();
                $ProductImage->storeImage($image, ['width' => 230, 'height' => 230]);
                $ProductImage->sequence = $portfolioImageCount++;
                $product->ProductImages()->save($ProductImage);
            }
        }

        return $product;
    }

    public function getSlugName(GetSlugNameRequest $request)
    {
        if ($request->has('name')) {
            return ['slug_name' => str_slug($request->input('name'))];
        }

        return null;
    }

    public function getServices()
    {

        return new Services;
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 180);
        DB::beginTransaction();

        try {
            Excel::import(new ImportProduct, request()->file('product_list'));
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            die($e->getMessage());
            response(['status' => 'Cannot Import File'], 500);
        }

        return redirect()->route('product.index')->with('status', 'Imported Product List Successfully Successfully');
    }



    public function import_image(ImportProductImageRequest $request)
    {
        ini_set('max_execution_time', 1800);
        DB::beginTransaction();
        try {
            $images = $request->file("product_images");
            $n = 0;
            $temp = [];
            foreach ($images as $image) {
                $fileInfo = pathinfo($image->getClientOriginalName());
                $product = Product::where('product_code', $fileInfo['filename'])->first();
                if ($product) {
                    if ($product->ProductImages()->count() > 0) {
                        foreach ($product->ProductImages as $ProductImage) {
                            $ProductImage->unlinkImage($ProductImage->image);
                        }
                        $product->ProductImages()->delete();
                    }
                    $portfolioImageCount = $product->ProductImages()->count() + 1;
                    $ProductImage = new ProductImage();
                    $ProductImage->storeImage($image, ['width' => 230, 'height' => 230]);
                    $ProductImage->sequence = $portfolioImageCount++;
                    $product->ProductImages()->save($ProductImage);
                    usleep(1000);
                } else {
                    $temp[] = $fileInfo['filename'];
                    info("Product Not Found " . $fileInfo['filename']);
                    $n++;
                }
            }

            DB::commit();

            return redirect()->route('product.import', ['type' => 'product_image'])
                ->with('status', 'Imported Image Successfully Successfully, Not Matched record ' . $n . " - " . implode(",", $temp));
        } catch (Exception $e) {
            DB::rollback();
            die($e->getMessage());
            return response(['status' => 'Cannot Import Images'], 500);
        }
    }
}
