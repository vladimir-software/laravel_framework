<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use App\Models\Matrix;

class BusinessController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function matchingMatrix(Request $request) {
    
        $matrixCollaboration = Matrix::select('id', 'category', 'sub_category', 'match_category', 'match_sub_category', 'product', 'match_product')->where('type', 'collaboration')->paginate(100);

        $b = 0;
        $collaborationId = [];
        $collaborationCategory = [];
        $collaborationSubCategory = [];
        $collaborationMatchCategory = [];
        $collaborationMatchSubCategory = [];
        $collaborationProduct = [];
        $collaborationMatchProduct = [];

        if (!empty($matrixCollaboration)) {
            foreach ($matrixCollaboration as $key => $data) {
                $collaboration[$b]['id'] = $data['id'];
                $collaboration[$b]['category'] = $data['category'];
                $collaboration[$b]['sub_category'] = $data['sub_category'];
                $collaboration[$b]['match_category'] = $data['match_category'];
                $collaboration[$b]['match_sub_category'] = $data['match_sub_category'];

                $collaboration[$b]['product'] = $data['product'];
                $collaboration[$b]['match_product'] = $data['match_product'];
                array_push($collaborationId, $collaboration[$b]['id']);

                if (isset($collaboration[$b]['product']) && $collaboration[$b]['product'] != '') {
                    $product = ProductCategory::select('name')->where('id', $collaboration[$b]['product'])->first();
                    array_push($collaborationProduct, $product);
                } else {
                    array_push($collaborationProduct, '');
                }

                if (isset($collaboration[$b]['match_product']) && $collaboration[$b]['match_product'] != '') {
                    $product = ProductCategory::select('name')->where('id', $collaboration[$b]['match_product'])->first();
                    array_push($collaborationMatchProduct, $product);
                } else {
                    array_push($collaborationMatchProduct, '');
                }

                if (isset($collaboration[$b]['category']) && $collaboration[$b]['category'] != '') {
                    $category = ServiceCategory::select('name')->where('id', $collaboration[$b]['category'])->first();
                    array_push($collaborationCategory, $category);
                } else {
                    array_push($collaborationCategory, '');
                }

                if (isset($collaboration[$b]['sub_category']) && $collaboration[$b]['sub_category'] != '') {
                    $subCategory = ServiceSubCategory::select('name')->where('id', $collaboration[$b]['sub_category'])->first();
                    array_push($collaborationSubCategory, $subCategory);
                } else {
                    array_push($collaborationSubCategory, '');
                }

                if (isset($collaboration[$b]['match_category']) && $collaboration[$b]['match_category'] != '') {
                    $matchCategory = ServiceCategory::select('name')->where('id', $collaboration[$b]['match_category'])->first();
                    array_push($collaborationMatchCategory, $matchCategory);
                } else {
                    array_push($collaborationMatchCategory, '');
                }

                if (isset($collaboration[$b]['match_sub_category']) && $collaboration[$b]['match_sub_category'] != '') {
                    $matchSubCategory = ServiceSubCategory::select('name')->where('id', $collaboration[$b]['match_sub_category'])->first();
                    array_push($collaborationMatchSubCategory, $matchSubCategory);
                } else {
                    array_push($collaborationMatchSubCategory, '');
                }
            }
        }
        
        return view('admin.bootstrap.business.matching-matrix')->with([
            'matrixCollaboration' => $matrixCollaboration,
            'collaborationId' => $collaborationId,
            'collaborationCategory' => $collaborationCategory,
            'collaborationSubCategory' => $collaborationSubCategory,
            'collaborationMatchCategory' => $collaborationMatchCategory,
            'collaborationMatchSubCategory' => $collaborationMatchSubCategory,
            'collaborationProduct' => $collaborationProduct,
            'collaborationMatchProduct' => $collaborationMatchProduct                    
        ]);
    }

    public function manageBusiness() {
        $serviceCategory = ServiceCategory::select('*')->whereNotIn('name', ['Other'])->orderBy('id')->get();
        $products = ProductCategory::select('*')->whereNotIn('name', ['Other'])->orderBy('id')->get();
        return view('admin.bootstrap.business.manage-business')->with(['serviceCategory' => $serviceCategory, 'products' => $products]);
    }

    public function deleteProduct(Request $request, $id) {

        if (!empty($id)) {
            $product = Matrix::where('id', $id)->first();
            $product->delete();
            return redirect()->back();
        }
    }

    ///////////////////// NOT IN USE ////////////////////////////////

    public function viewBusiness() {
        $matrixProduct = Matrix::select('category', 'match_category')->where('type', 'product')->get();
        $product = [];
        $a = 0;
        $x = [];
        if (!empty($matrixProduct)) {
            foreach ($matrixProduct as $key => $data) {
                $product[$a]['category'] = $data['category'];
                $product[$a]['match_category'] = $data['match_category'];

                $productCategory = ProductCategory::select('name')->whereIn('id', [$product[$a]['category'], $product[$a]['match_category']])->get();
                array_push($x, $productCategory);
                $a++;
            }
        }

        $matrixService = Matrix::select('category', 'sub_category', 'match_category', 'match_sub_category')->where('type', 'service')->get();
        $service = [];

        $b = 0;
        $t = [];
        $y = [];
        $z = [];
        $s = [];
        $serviceCategory = [];
        $serviceSubCategory = [];
        $serviceMatchSubCategory = [];


        $new = [];
        $new1 = [];

        if (!empty($matrixService)) {
            foreach ($matrixService as $key => $data) {
                $service[$b]['category'] = $data['category'];
                $service[$b]['sub_category'] = $data['sub_category'];
                $service[$b]['match_category'] = $data['match_category'];
                $service[$b]['match_sub_category'] = $data['match_sub_category'];

                //////////////////////////////shortest way //////////////////////
                $serviceCategory = ServiceCategory::select('name')->whereIn('id', [$service[$b]['category'], $service[$b]['match_category']])->get();
                array_push($new, $serviceCategory);


                $ddd = array_filter([$service[$b]['sub_category'], $service[$b]['match_sub_category']]);
                $serviceSubCategory = ServiceSubCategory::select('id', 'name')->whereIn('id', $ddd)->get();
                array_push($new1, $serviceSubCategory);

                //////////////////// end  //////////////////////////////
                ////////////////////////////////////// long way ///////////////////////////

                $serviceCategory = ServiceCategory::select('name')->where('id', $service[$b]['category'])->first();
                array_push($t, $serviceCategory);

                if (isset($service[$b]['sub_category']) && $service[$b]['sub_category'] != '') {
                    $serviceSubCategory = ServiceSubCategory::select('name')->where('id', $service[$b]['sub_category'])->first();
                    array_push($y, $serviceSubCategory);
                } else {
                    array_push($y, '');
                }

                $serviceMatchCategory = ServiceCategory::select('name')->where('id', $service[$b]['match_category'])->first();
                array_push($z, $serviceMatchCategory);

                if (isset($service[$b]['match_sub_category']) && $service[$b]['match_sub_category'] != '') {
                    $serviceMatchSubCategory = ServiceSubCategory::select('name')->where('id', $service[$b]['match_sub_category'])->first();
                    array_push($s, $serviceMatchSubCategory);
                } else {
                    array_push($s, '');
                }

                /////////////////////////////////end ////////////////////////
            }
        }
        print_r($service);
        exit;
        return view('admin.bootstrap.business.view-business')->with([
                    'product' => $product,
                    'productCategory' => $x,
                    'serviceCategory' => $t,
                    'serviceSubCategory' => $y,
                    'serviceMatchCategory' => $z,
                    'serviceMatchSubCategory' => $s,
                    'new' => $new,
                    'new1' => $new1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
