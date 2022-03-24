<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use App\Models\ProvideCategories;
use App\Models\ProductCategory;
use App\Models\Industry;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use App\Models\Pages;
use App\Models\ContactUs;
use App\Models\faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller {

    public function surveyCategory() {
        $provideCategory = ProvideCategories::select('id', 'name')->get();
        return view('admin.bootstrap.category.categories')->with(['provideCategory' => $provideCategory]);
    }

    public function surveyQuestions() {
        $provideCategory = ProvideCategories::select('id', 'name')->get();
        return view('admin.category.questions')->with(['provideCategory' => $provideCategory]);
    }

    public function serviceCategory1() {
        $category = ServiceCategory::select('*')->with('serviceSubCategory')->orderBy('name', 'asc')->get();
        return view('admin.bootstrap.category.service_category')->with('category', $category);
    }

    public function addServiceCategory1() {
        return view('admin.bootstrap.category.add_service_category');
    }

    public function storeServiceCategory1(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            if (!empty($data)) {
                $category = new ServiceCategory();
                $category->name = $data['category'];
                $category->save();
                if (isset($data['sub_cat_name']) && $data['sub_cat_name'] != '') {
                    foreach ($data['sub_cat_name'] as $subCat) {
                        $subCategory = new ServiceSubCategory();
                        $subCategory->service_id = $category->id;
                        $subCategory->name = $subCat;
                        $subCategory->save();
                    }
                }
                return redirect('/admin/service-category');
            }
        }
    }

    public function editServiceCategory($id) {
        $cat = ServiceCategory::where('id', $id)->with('serviceSubCategory')->first();
        return view('admin.bootstrap.category.edit_service_category')->with('category', $cat);
    }

    public function updateServiceCategory(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            $cat = ServiceCategory::where('id', $data['category_id'])->first();
            if (!empty($cat)) {
                $cat->name = $data['category_name'];
                $cat->save();
                return redirect('/admin/service-category');
            }
        }
    }

    public function deleteServiceCategory(Request $request, $id) {
        if (request()->isMethod('get')) {
            $cat = ServiceCategory::where('id', $id)->first();
            if (!empty($cat)) {
                ServiceSubCategory::where('service_id', $cat->id)->delete();
                $cat->delete();
                return redirect()->back();
            }
        }
    }

    public function productCategory1() {
        $productCat = ProductCategory::select('*')->orderBy('name', 'asc')->get();
        return view('admin.bootstrap.category.product_category')->with('productCat', $productCat);
    }

    public function addProductCategory1() {
        return view('admin.bootstrap.category.add_product_category');
    }

    public function storeProductCategory1(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            if (!empty($data)) {
                $product = new ProductCategory();
                $product->name = $data['product'];
                $product->save();
                return redirect('/admin/product-category');
            }
        }
    }

    public function deleteProductCat(Request $request, $id) {
        if (request()->isMethod('get')) {
            $cat = ProductCategory::where('id', $id)->first();
            if (!empty($cat)) {
                $cat->delete();
                return redirect()->back();
            }
        }
    }

    /////////////////////// productIndustry  

    public function productIndustry1() {
        // print_R('working');exit;
        $productIndustry = Industry::select('*')->orderBy('name', 'asc')->get();
        return view('admin.bootstrap.category.product_industry')->with('productIndustry', $productIndustry);
    }

    public function addProductIndustry1() {
        return view('admin.bootstrap.category.add_product_industry');
    }

    public function storeProductIndustry1(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            // print_r($data);exit;
            if (!empty($data)) {
                $productIndustry = new Industry();
                $productIndustry->name = $data['industry'];
                $productIndustry->save();
                return redirect('/admin/industry');
            }
        }
    }

    public function deleteProductIndustry(Request $request, $id) {
        if (request()->isMethod('get')) {
            $cat = Industry::where('id', $id)->first();
            if (!empty($cat)) {
                $cat->delete();
                return redirect()->back();
            }
        }
    }

    ////// pages

    public function pages1() {
        return view('admin.bootstrap.pages.pages');
    }

    public function manageSurvey1() {
        $list = Pages::where('page_name', 'page_1')->first();
        return view('admin.bootstrap.pages.manage_page1', ['list' => $list]);
    }

    public function updateWelcome(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            $page = Pages::where('page_name', $data['id'])->first();
            if (!empty($page)) {
                $page->content = json_encode($data, true);
                $page->type = 'input';
                $page->save();
                return redirect()->back();
            }
        }
    }

    public function manageSurvey2() {
        $list = Pages::where('page_name', 'page_2')->get();
        return view('admin.bootstrap.pages.manage_page2', ['list' => $list]);
    }

    public function updateSurvey2(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            if (!empty($data['content'])) {
                $page = Pages::where('page_name', $data['id'])->delete();
                foreach ($data['content'] as $val) {
                    $page = new Pages();
                    $page->content = $val;
                    $page->page_name = $data['id'];
                    $page->type = 'radio button';
                    $page->save();
                }
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }
    }

    public function manageSurvey3() {
        $list = Pages::where('page_name', 'page_3')->get();
        return view('admin.bootstrap.pages.manage_page3', ['list' => $list]);
    }

    public function updateSurvey3(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            if (!empty($data['content'])) {
                $page = Pages::where('page_name', $data['id'])->delete();
                foreach ($data['content'] as $val) {
                    $page = new Pages();
                    $page->content = $val;
                    $page->page_name = $data['id'];
                    $page->type = 'radio button';
                    $page->save();
                }
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }
    }

    public function addDataForSurvey3() {
        return view('admin.bootstrap.pages.add_data_page3');
    }

    public function storeDataForSurvey3(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            if (!empty($data)) {
                $page = new Pages();
                $page->content = $data['category'];
                $page->page_name = 'page_3';
                $page->type = 'checkbox';
                $page->save();
                return redirect('/admin/survey-3');
            }
        }
    }

    public function managePageForObtainBusiness() {
        $list = Pages::where('page_name', 'pageForObtainBusiness')->get();
        return view('admin.bootstrap.pages.manage_pageForObtainBusiness', ['list' => $list]);
    }

    public function updateSurvey01(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            //print_r($data);exit;
            if (!empty($data['content'])) {
                $page = Pages::where('page_name', 'pageForObtainBusiness')->delete();
                foreach ($data['content'] as $val) {
                    $pages = new Pages();
                    $pages->content = $val;
                    $pages->page_name = 'pageForObtainBusiness';
                    $pages->type = 'select box';
                    $pages->save();
                }
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }
    }

    public function manageSurvey4() {
        $list = Pages::where('page_name', 'page_4')->get();
        return view('admin.bootstrap.pages.manage_page4', ['list' => $list]);
    }

    public function updateSurvey4(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            if (!empty($data['content'])) {
                $page = Pages::where('page_name', 'page_4')->delete();
                foreach ($data['content'] as $val) {
                    $pages = new Pages();
                    $pages->content = $val;
                    $pages->page_name = 'page_4';
                    $pages->type = 'select box';
                    $pages->save();
                }
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }
    }

    public function manageSurvey5() {
        $list = Pages::where('page_name', 'page_5')->get();
        return view('admin.bootstrap.pages.manage_page5', ['list' => $list]);
    }

    public function updateSurvey5(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            if (!empty($data['content'])) {
                $page = Pages::where('page_name', 'page_5')->delete();
                foreach ($data['content'] as $val) {
                    $pages = new Pages();
                    $pages->content = $val;
                    $pages->page_name = 'page_5';
                    $pages->save();
                }
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }
    }

    public function manageSurvey6() {
        $list = Pages::where('page_name', 'page_6')->first();
        return view('admin.bootstrap.pages.manage_page6', ['list' => $list]);
    }

    public function updateSurvey6(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            if (!empty($data['content'])) {
                $page = Pages::where('page_name', 'page_6')->delete();
                $pages = new Pages();
                $pages->content = $data['content'];
                $pages->page_name = 'page_6';
                $pages->save();
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }
    }

    public function manageSurvey7() {
        $list = Pages::select('*')->where(['page_name' => 'page_7'])->orderBy('sort_order', 'asc')->get();
        return view('admin.bootstrap.pages.manage_page7', ['list' => $list]);
    }

    public function saveQuestion7(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            $count = Pages::select('sort_order')->where('page_name', $data['page_name'])->orderBy('sort_order', 'desc')->take(1)->first();
            if (!empty($data['question'])) {
                $list = Pages::where('page_name', $data['page_name'])->get()->toArray();
                foreach ($data['question'] as $key => $ds) {
                    $page = new Pages();
                    $page->page_name = $data['page_name'];
                    $page->content = $ds;
                    $page->sort_order = (isset($count['sort_order']) ? $count['sort_order'] : 0) + ++$key;
                    $page->type = 'input';
                    $page->save();
                }
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }
    }

    public function deleteSurveyQuestion(Request $request, $id) {
        if (!empty($id)) {
            $delete = Pages::where('id', $id)->delete();
            return redirect()->back();
        }
    }

    public function viewFAQs() {
        $faq = faq::select('*')->get();
        return view('admin.bootstrap.FAQ', ['faq' => $faq]);
    }

    public function addFAQs() {

        return view('admin.bootstrap.add_FAQ');
    }

    public function storeFAQ(Request $request) {
        if (request()->isMethod('post')) {
            $data = $request->post();
            if (!empty($data)) {
                $faq = new faq();
                $faq->question = $data['question'];
                $faq->answer = $data['answer'];
                $faq->save();
                return redirect('admin/FAQ');
            }
        }
    }

    public function deleteFAQ(Request $request, $id) {
        if (request()->isMethod('get')) {
            if (!empty($id)) {
                $faq = faq::where('id', $id)->delete();
                return redirect()->back();
            }
        }
    }

    public function editFAQs(Request $request, $id) {
        if (!empty($id)) {
            $faq = faq::where('id', $id)->first();
        } else {
            $faq = [];
        }
        return view('admin.bootstrap.edit_FAQ', ['faq' => $faq]);
    }

    public function updateFAQ(Request $request) {
        if (request()->isMethod('post')) {
            $post = request()->post();
            if (!empty($post)) {
                $find = faq::where('id', $post['id'])->first();
                $find->question = $post['question'];
                $find->answer = $post['answer'];
                $find->save();
                return redirect('admin/FAQ');
            }
        }
    }

    public function contactUsMessages() {
        $mesages = ContactUs::select('*')->orderby('id', 'desc')->paginate(10);
        return view('admin.bootstrap.messages')->with(['mesages' => $mesages]);
    }
}
