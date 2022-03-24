<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users\User;
use App\Models\Questions;
use App\Models\Categories;
use App\Models\ContactUs;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use App\Models\ProductCategory;
use App\Models\Industry;
use App\Models\Pages;
use App\Models\Matrix;
use App\Models\ManageHome;
use App\Models\ProvideCategories;
use App\Models\QuestionCategories;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class AjaxController extends Controller {

    public function updatePassword(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            $user = User::where('token', $posts['user_token'])->first();
            if (!empty($user)) {
                $user->password = bcrypt($posts['password']);
                $user->save();
                return response()->json(array('status' => 'success', 'message' => 'Successfully updated password'));
            } else {
                return response()->json(array('status' => 'failed', 'message' => 'Failed .. Please Try Again'));
            }
        }
    }

    public function deleteUser(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            $user = User::where('token', $posts['user_token'])->first();
            if (!empty($user)) {
        		$user->delete();
                return response()->json(array('status' => 'success', 'message' => 'Successfully deleted'));
            } else {
                return response()->json(array('status' => 'failed', 'message' => 'Failed ..!! Please Try Again'));
            }
        }
    }

    public function addCategory(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            if (!empty($posts['cat_name'])) {
                $add = new ProvideCategories();
                $add->name = $posts['cat_name'];
                $add->save();
                return response()->json(array('status' => 'success', 'message' => 'Successfully Added', 'category' => $add));
            } else {
                return response()->json(array('status' => 'failed', 'message' => 'Failed ..!! Please Try Again'));
            }
        }
    }

    public function addQuestion(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            //print_r($posts);exit;
            if (!empty($posts['selected_category'])) {
                $addQuestion = new Questions();
                $addQuestion->questions = $posts['input_question'];
                $addQuestion->provider_id = $posts['selected_category'];
                $addQuestion->save();
                foreach ($posts['input_sub_part_type'] as $key => $val) {
                    $new = new QuestionCategories();
                    $new->question_id = $addQuestion->id;
                    $new->input_type = $val;
                    $new->name = $posts['input_sub_part_q'][$key];
                    $new->save();
                }
                return response()->json(array('status' => 'success', 'message' => 'Successfully Added'));
            } else {
                return response()->json(array('status' => 'failed', 'message' => 'Failed ..!! Please Try Again'));
            }
        }
    }

    public function updateServiceSubCategory(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            $subCat = ServiceSubCategory::where('id', $posts['id'])->first();
            if (!empty($subCat)) {
                $subCat->name = $posts['sub_cat_data'];
                $subCat->save();
                return response()->json(array('status' => 'success', 'message' => 'Successfully updated', 'subCat' => $subCat));
            }
        }
    }

    public function addMoreSubCategory(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post(); //value
            if (!empty($posts['value'])) {
                $subCat = new ServiceSubCategory();
                $subCat->service_id = $posts['id'];
                $subCat->name = $posts['value'];
                $subCat->save();
                return response()->json(array('status' => 'success', 'message' => 'Successfully updated'));
            }
        }
    }

    public function deleteServiceSubCategory(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            $subCat = ServiceSubCategory::where('id', $posts['id'])->first();
            if (!empty($subCat)) {
                $subCat->delete();
                return response()->json(array('status' => 'success', 'message' => 'Successfully deleted'));
            }
        }
    }

    //updateProductCategory
    public function updateProductCategory(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post(); //product_cat
            $subCat = ProductCategory::where('id', $posts['id'])->first();
            if (!empty($subCat)) {
                $subCat->name = $posts['product_cat'];
                $subCat->save();
                return response()->json(array('status' => 'success', 'message' => 'Successfully updated', 'ProductCat' => $subCat));
            }
        }
    }

    public function updateIndustry(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post(); //product_cat
            $subCat = Industry::where('id', $posts['id'])->first();
            if (!empty($subCat)) {
                $subCat->name = $posts['product_industry'];
                $subCat->save();
                return response()->json(array('status' => 'success', 'message' => 'Successfully updated', 'ProductIndustry' => $subCat));
            }
        }
    }

    public function updatePage7(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post(); //$posts['data'] 

            $page = Pages::where('id', $posts['id'])->first();
            if (!empty($page)) {
                $page->content = $posts['data'];
                $page->save();
                return response()->json(array('status' => 'success', 'message' => 'Successfully updated', 'data' => $page));
            }
        }
    }

    public function sortOrderForSurvey7(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            if (!empty($posts['sortIdFrom']) && !empty($posts['sortIdTo'])) {
                $idFrom = Pages::where('id', $posts['sortIdFrom'])->first();
                $sortOrderIdFrom = $idFrom->sort_order;
                $idTo = Pages::where('id', $posts['sortIdTo'])->first();
                $idFrom->sort_order = $idTo->sort_order;
                $idTo->sort_order = $sortOrderIdFrom;
                $idTo->save();
                $idFrom->save();
                return response()->json(array('status' => 'success', 'message' => 'Successfully updated'));
            }
        }
    }

    public function updateWelcomeImage(Request $request) {

        if ($request->ajax() && $request->isMethod('post')) {
            if ($file = $request->file('welcom_image')) {
                $path = public_path() . "/bootstrap/asset";
                $priv = 0777;
                if (!file_exists($path)) {
                    mkdir($path, $priv) ? true : false; //
                }
                $name = $file->getClientOriginalName();
                $file->move($path, $name);
                if (!empty($request->id)) {
                    $welcome = Pages::where('page_name', $request->id)->first();
                    $welcome->image = trim('/bootstrap/asset/' . $name);
                    $welcome->save();
                    return response()->json(array('status' => 'success', 'message' => "Successfully Updated", 'welcome' => $welcome));
                }
            }
        }
    }

    public function updateProfilePic(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            if ($file = $request->file('profile_pic')) {
                $path = public_path() . "/asset/user_profile";
                $priv = 0777;
                if (!file_exists($path)) {
                    mkdir($path, $priv) ? true : false; //
                }
                $name = $file->getClientOriginalName();
                $file->move($path, $name);
                if (!empty($request->user_id)) {
                    $user = User::where('id', $request->user_id)->first();
                    $user->profile_pic = trim('/asset/user_profile/' . $name);
                    $user->save();
                    return response()->json(array('status' => 'success', 'message' => "Successfully Updated", 'user' => $user));
                }
            }
        }
    }

    public function deleteContactMessages() {
        ContactUs::whereIn('id', preg_split("/,/", request()->get('messageIds')))->delete();
        echo json_encode("messages deleted");
    }

    public function searchUserByName(Request $request) {
        $posts = request()->post();
        $users = User::select('*')
                        ->whereNotIn('account_type_id', [1, 3])
                        ->where("email", "like", "%" . $posts['search'] . "%")
                        ->orderBy('id', 'desc')
                        ->offset(0)
                        ->limit(15)->get();
        return view('admin.bootstrap.ajax.filtered_user')->with(['users' => $users]);
    }
    
    public function searchAdminUserByName(Request $request) {
        $posts = request()->post();
        $users = User::select('*')
                        ->whereIn('account_type_id', [1, 3])
                        ->where("email", "like", "%" . $posts['search'] . "%")
                        ->orderBy('id', 'desc')
                        ->offset(0)
                        ->limit(15)->get();
        return view('admin.bootstrap.ajax.filtered_admin_user')->with(['users' => $users]);
    }
    
    public function saveProducts(Request $request) {
        $posts = request()->post();
        if (empty($posts['product']) || empty($posts['sub_product'])) {
            return response()->json(array('status' => 'error', 'message' => "Please select required fields."));
            exit;
        }
        if (!empty($posts)) {
            $matrix = new Matrix();
            $matrix->category = $posts['product'];
            $matrix->match_category = $posts['sub_product'];
            $matrix->type = 'product';
            $matrix->save();
            return response()->json(array('status' => 'success', 'message' => "Successfully saved"));
        }
    }

    public function saveServices(Request $request) {
        $posts = request()->post();
        if (empty($posts['category']) || empty($posts['related_category'])) {
            return response()->json(array('status' => 'error', 'message' => "Please select required fields."));
            exit;
        }
        if (!empty($posts)) {
            $matrix = new Matrix();
            $matrix->category = $posts['category'];
            $matrix->sub_category = (isset($posts['sub_category']) ? $posts['sub_category'] : '');
            $matrix->match_category = $posts['related_category'];
            $matrix->match_sub_category = (isset($posts['related_sub_category']) ? $posts['related_sub_category'] : '');
            $matrix->type = 'service';
            $matrix->save();
            return response()->json(array('status' => 'success', 'message' => "Successfully saved"));
        }
    }

    public function serviceSubCategory(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $serviceSubCat = ServiceSubCategory::select('*')->where('service_id', $request->cat_id)->get();
            $subCategory = array();
            foreach ($serviceSubCat as $key => $subCat) {
                $subCategory[$key]['id'] = $subCat['id'];
                $subCategory[$key]['name'] = $subCat['name'];
                $subCategory[$key]['service_id'] = $subCat['service_id'];
            }
            return response()->json(array('status' => 'success', 'data' => $subCategory));
        }
    }

    public function deleteProduct(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = request()->post();
            if (!empty($posts['productId'])) {
                $product = Matrix::where('id', $posts['productId'])->first();
                $product->delete();
                return response()->json(array('status' => 'success', 'message' => 'successfully deleted'));
            } else {
                return response()->json(array('status' => 'error', 'message' => 'Something went wrong.'));
            }
        }
    }

    public function deleteServices(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = request()->post();
            if (!empty($posts['serviceId'])) {
                $product = Matrix::where('id', $posts['serviceId'])->first();
                $product->delete();
                return response()->json(array('status' => 'success', 'message' => 'successfully deleted'));
            } else {
                return response()->json(array('status' => 'error', 'message' => 'Something went wrong.'));
            }
        }
    }

    private function addMatrixItem($category = NULL, $sub_category = NULL, $match_category = NULL, $match_sub_category = NULL, $product = NULL, $match_product = NULL) {
        $matrix = new Matrix();
        $matrix->category = $category;
        $matrix->sub_category = $sub_category;
        $matrix->match_category = $match_category;
        $matrix->match_sub_category = $match_sub_category;
        $matrix->product = $product;
        $matrix->match_product = $match_product;
        $matrix->type = 'collaboration';
        $matrix->save();
    }
    
    public function saveCollaboration(Request $request) {
    
        $posts = request()->post();
        $validForm = true;
        if ($posts['match-from-type'] == 'CATEGORY') {
            if (empty($posts['category'])) $validForm = false;
        } else {
            if (empty($posts['product'])) $validForm = false;
        }
        if ($posts['match-to-type'] == 'CATEGORY') {
            if (empty($posts['related_category'])) $validForm = false;
        } else {
            if (empty($posts['related_product'])) $validForm = false;
        }
        if (!$validForm) {
            return response()->json(array('status' => 'error', 'message' => "Please select required fields."));
            exit;        
        }
        
        if (!empty($posts)) {
        
            $productData = ProductCategory::whereNotIn('name', ['Other'])->get();
            $productCount = count($productData);
        
            $serviceData = ServiceCategory::whereNotIn('name', ['Other'])->get();
            $serviceCount = count($serviceData);
        
            if (($posts['match-from-type'] == 'PRODUCT') && ($posts['match-to-type'] == 'PRODUCT')) {
                if (!empty($posts['related_product'])) {
                    if (in_array($productCount, $posts['related_product'])) {
                        foreach ($productData as $service) $this->addMatrixItem(NULL, NULL, NULL, NULL, $posts['product'], $service->id);
                    } else {
                        foreach ($posts['related_product'] as $product) $this->addMatrixItem(NULL, NULL, NULL, NULL, $posts['product'], $product);
                    }
                }
            }
        
            if (($posts['match-from-type'] == 'CATEGORY') && ($posts['match-to-type'] == 'CATEGORY')) {
                if (!empty($posts['related_category'])) {
                    if (in_array($serviceCount, $posts['related_category'])) {
                        foreach ($serviceData as $service) $this->addMatrixItem($posts['category'], (isset($posts['sub_category']) ? $posts['sub_category'] : NULL), $service->id);
                    } else {
                        foreach ($posts['related_category'] as $category) $this->addMatrixItem($posts['category'], (isset($posts['sub_category']) ? $posts['sub_category'] : NULL), $category, (isset($posts['related_sub_category']) ? $posts['related_sub_category'] : NULL));
                    }
                }
            }
            
            if (($posts['match-from-type'] == 'PRODUCT') && ($posts['match-to-type'] == 'CATEGORY')) {
                if (!empty($posts['related_category'])) {
                    if (in_array($serviceCount, $posts['related_category'])) {
                        foreach ($serviceData as $service) $this->addMatrixItem(NULL, NULL, $service->id, NULL, $posts['product']);
                    } else {
                        foreach ($posts['related_category'] as $category) $this->addMatrixItem(NULL, NULL, $category, (isset($posts['related_sub_category']) ? $posts['related_sub_category'] : NULL), $posts['product']);
                    }
                }
            }
        
            if (($posts['match-from-type'] == 'CATEGORY') && ($posts['match-to-type'] == 'PRODUCT')) {                
                if (!empty($posts['related_product'])) {
                    if (in_array($productCount, $posts['related_product'])) {
                        foreach ($productData as $service) $this->addMatrixItem($posts['category'], (isset($posts['sub_category']) ? $posts['sub_category'] : NULL), NULL, NULL, NULL, $service->id);
                    } else {
                        foreach ($posts['related_product'] as $product) $this->addMatrixItem($posts['category'], (isset($posts['sub_category']) ? $posts['sub_category'] : NULL), NULL, NULL, NULL, $product);                        
                    }
                }
            }            

            return response()->json(array('status' => 'success', 'message' => "Successfully saved"));   
        }
    }

    public function saveForManageHome(Request $request) {
        $posts = request()->post();
        $matrix = ManageHome::select('*')->where('id', 1)->first();
        $matrix->home_status = $posts['status'];
        $matrix->save();
        return response()->json(array('status' => 'success', 'message' => "Successfully saved"));
    }

    ///////////////////////////////////////////////////////
}
