<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Answers;
use App\Models\QuestionTypes;
use App\Models\Categories;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use App\Models\UserSurvey;
use App\Models\Pages;
use App\Models\UserPayments;
use App\Models\ProductCategory;
use App\Models\Industry;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;
use App\Models\Users\UserProfile;
use App\Models\UserOfferingIndustries;
use App\Models\UserOfferingCategories;
use App\Models\UserOfferingProducts;
use App\Models\UserPrimaryGoals;
use App\Models\UserReviewDetail;
use App\Models\UserReviews;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class EditSurveyController extends Controller {

    public function editSurvey1() {
        $userData = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();
        $val = json_decode($userData['answer'], true);
        return view('edit_survey.survey-1', ['answer' => $val]);
    }

    // submitEditedSurvey1
    public function submitEditedSurvey1(Request $request) {
        if (request()->isMethod('post')) {
            session()->forget('error');
            $data = request()->post();
            if (!empty($data)) {
                $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->first();
                if (!empty($user['answer'])) {
                    $val2 = json_decode($user['answer'], true);
                    $result1 = array_diff($data['answer'], $val2);
                    $result2 = array_diff($val2, $data['answer']);
                    if (empty($result1) && empty($result2)) {
                        $user->user_id = Auth::id();
                        $user->page_id = $data['page_name'];
                        $user->skip = 0;
                        $user->answer = json_encode($data['answer'], true);
                        $user->save();
                        return redirect('edit-survey-2');
                        exit;
                    } else {
                        $userSurvey111 = UserSurvey::where('user_id', Auth::id())->whereNotIn('page_id', ['page_1'])->get();
                        if (!empty($userSurvey111)) {
                            $userSurvey111->each->delete();
                            $userSurvey = new UserSurvey();
                            $userSurvey->user_id = Auth::id();
                            $userSurvey->page_id = $data['page_name'];
                            $userSurvey->skip = 0;
                            $userSurvey->answer = json_encode($data['answer'], true);
                            $userSurvey->save();
                            return redirect('edit-survey-2');
                            exit;
                        }
                    }
                } elseif (isset($user['skip']) && $user['skip'] == 1) {
                    $userSurvey111 = UserSurvey::where('user_id', Auth::id())->whereNotIn('page_id', ['page_1'])->get();
                    if (!empty($userSurvey111)) {
                        $userSurvey111->each->delete();
                        $userSurvey = new UserSurvey();
                        $userSurvey->user_id = Auth::id();
                        $userSurvey->page_id = $data['page_name'];
                        $userSurvey->skip = 0;
                        $userSurvey->answer = json_encode($data['answer'], true);
                        $userSurvey->save();
                        return redirect('edit-survey-2');
                        exit;
                    }
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->answer = json_encode($data['answer'], true);
                    $userSurvey->save();
                    return redirect('edit-survey-2');
                }
            } else {
                return redirect()->back()->with('error', 'Before submitting please select required fields');
            }
        }
    }

    public function editSurvey2() {
        $userData = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_3'])->first();
        $val = json_decode($userData['answer'], true);
        $page = Pages::where('page_name', 'page_3')->get();
        $data = [];
        $i = 0;
        foreach ($page as $pageData) {
            $data[$i]['content'] = $pageData['content'];
            $i++;
        }
        return view('edit_survey.survey-2')->with([
                    'val' => $val,
                    'data' => $data
        ]);
    }

    public function submitEditedSurvey2(Request $request) {
        if ($request->ajax() && request()->isMethod('post')) {
            $data = request()->post();
            if (!empty($data['answer'])) {
                $userPrimaryGoals = UserPrimaryGoals::where(['user_id' => Auth::id()])->delete();
                $obtainService = new UserPrimaryGoals();
                $obtainService->user_id = Auth::id();
                if (in_array("Provide a Business Service", $data['answer'])) {
                    $obtainService->provide_services = 1;
                }
                if (in_array("Collaboration Opportunities", $data['answer'])) {
                    $obtainService->collaboration = 1;
                }
                if (in_array("Obtain Business Services", $data['answer'])) {
                    $obtainService->obtain_services = 1;
                }
                $obtainService->save();
                $userSurveyForObtain = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->delete();
                $obtainServiceSurvey = new UserSurvey();
                $obtainServiceSurvey->user_id = Auth::id();
                $obtainServiceSurvey->page_id = $data['page_name'];
                $obtainServiceSurvey->skip = 0;
                $obtainServiceSurvey->answer = json_encode($data['answer'], true);
                $obtainServiceSurvey->save();
                return response()->json(array('status' => 'success', 'message' => 'Successfully Updated'));
            } else {
                return response()->json(array('status' => 'error', 'message' => 'Before submitting please select any field'));
            }
        }
    }

    public function editSurvey02() {
        $serviceCategory = ServiceCategory::select('*')->orderBy('name')->get();
        $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'pageForObtainBusiness'])->first();
        $data = json_decode($user['answer'], true);

        $is_exist = array();
        if (!empty($data['category'])) {
            foreach ($data['category'] as $key => $val) {
                $cat = ServiceCategory::select('*')->where('id', $val)->first();
                $is_exist[$key]['cat_name'] = $cat['name'];
                $is_exist[$key]['cat_id'] = $cat['id'];
                if (isset($data['sub_category'][$key]) && $data['sub_category'][$key] != "") {
                    $sub = ServiceSubCategory::select('*')->where('id', $data['sub_category'][$key])->first();
                    $is_exist[$key]['sub_cat_name'] = $sub['name'];
                    $is_exist[$key]['sub_cat_id'] = $sub['id'];
                } else {
                    $is_exist[$key]['sub_cat_name'] = "";
                    $is_exist[$key]['sub_cat_id'] = "";
                }
            }
        }
        $serviceSubCategory = ServiceSubCategory::select('*')->where('service_id', $data['category'])->orderBy('name')->get();
        $page = Pages::where('page_name', 'pageForObtainBusiness')->get();
        $pageData = [];
        $i = 0;
        foreach ($page as $val) {
            $pageData[$i]['content'] = $val['content'];
            $i++;
        }
        return view('edit_survey.survey-02')->with([
                    'data' => $is_exist,
                    'serviceSubCategory' => $serviceSubCategory,
                    'serviceCategory' => $serviceCategory,
                    'pageData' => $pageData
        ]);
    }

    public function submitEditedSurvey02(Request $request) {
        if ($request->ajax() && request()->isMethod('post')) {
            session()->forget('error');
            $data = request()->post();
            $userObtaining = UserOfferingCategories::where([
                        'user_id' => Auth::id(),
                        'type' => 'obtain service'
                    ])->get();
            if (!empty($data['category'])) {
                $services = ServiceCategory::select('id', 'name')->where('name', 'other')->first();
                $obtain = array_diff($data['category'], [$services->id]);
                $userObtaining->each->delete();
                foreach ($obtain as $key => $obtainCategories) {
                    $userObtainServices = new UserOfferingCategories();
                    $userObtainServices->user_id = Auth::id();
                    $userObtainServices->category_id = $obtainCategories;
                    $userObtainServices->sub_category_id = (isset($data['sub_category'][$key]) ? $data['sub_category'][$key] : NULL);
                    $userObtainServices->type = 'obtain service';
                    $userObtainServices->save();
                }
                $filtered = Arr::except($data, ['other']);

                $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->first();

                if (!empty($user)) {
                    $user->user_id = Auth::id();
                    $user->page_id = $data['page_name'];
                    $user->skip = 0;
                    if (isset($data['other']) && $data['other'] != "") {
                        $user->other = $data['other'];
                    }
                    $user->answer = json_encode($filtered, true);
                    $user->save();
                    return response()->json(array('status' => 'success', 'message' => 'Successfully Updated.'));
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->other = (isset($data['other']) && $data['other'] != "" ? $data['other'] : null);
                    $userSurvey->answer = json_encode($filtered, true);
                    $userSurvey->save();
                    return response()->json(array('status' => 'success', 'message' => 'Successfully Updated.'));
                }
            } else {
                return response()->json(array('status' => 'error', 'message' => 'dfsf.'));
            }
        }
    }

    public function editSurvey3() {
        $industry = Industry::select('*')->orderBy('name')->get();
        $serviceCategory = ServiceCategory::select('*')->orderBy('name')->get();
        $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_4'])->first();
        $data = json_decode($user['answer'], true);
        $data1 = json_decode($user['answer'], true);

        $is_exist = array();
        if (!empty($data['category'])) {
            foreach ($data['category'] as $key => $val) {
                $cat = ServiceCategory::select('*')->where('id', $val)->first();
                $is_exist[$key]['cat_name'] = $cat['name'];
                $is_exist[$key]['cat_id'] = $cat['id'];
                if (isset($data['sub_category'][$key]) && $data['sub_category'][$key] != "") {
                    $sub = ServiceSubCategory::select('*')->where('id', $data['sub_category'][$key])->first();
                    $is_exist[$key]['sub_cat_name'] = $sub['name'];
                    $is_exist[$key]['sub_cat_id'] = $sub['id'];
                } else {
                    $is_exist[$key]['sub_cat_name'] = "";
                    $is_exist[$key]['sub_cat_id'] = "";
                }
            }
        }

        $serviceSubCategory = ServiceSubCategory::select('*')->where('service_id', $data['category'])->orderBy('name')->get();

        $page = Pages::where('page_name', 'page_4')->get();
        $pageData = [];
        $i = 0;
        foreach ($page as $val) {
            $pageData[$i]['content'] = $val['content'];
            $i++;
        }
        return view('edit_survey.survey-3')->with(['industry' => $industry, 'data1' => $data1, 'data' => $is_exist, 'serviceSubCategory' => $serviceSubCategory, 'serviceCategory' => $serviceCategory, 'pageData' => $pageData]);
    }

    public function submitEditedSurvey3(Request $request) {
        if ($request->ajax() && request()->isMethod('post')) {
            session()->forget('error');
            $data = request()->post();
            if (!empty($data['category'])) {

///////////////////////////  FOR USER OFEERING SERVICES AND USER OFEERING INDUSTRIES TABLE //////////////////////
                $offeringCategories = UserOfferingCategories::where([
                            'user_id' => Auth::id(),
                            'type' => 'provide service category',
                        ])->delete();
                $offeringIndustry = UserOfferingIndustries::where([
                            'user_id' => Auth::id(),
                            'type' => 'provide service industry',
                        ])->delete();
                $services = ServiceCategory::select('id', 'name')->where('name', 'other')->first();
                $offerService = array_diff($data['category'], [$services->id]);
                foreach ($offerService as $key => $offeringCategories) {
                    $userOfferingCategoriesAdd = new UserOfferingCategories();
                    $userOfferingCategoriesAdd->user_id = Auth::id();
                    $userOfferingCategoriesAdd->category_id = $offeringCategories;
                    $userOfferingCategoriesAdd->sub_category_id = (isset($data['sub_category'][$key]) ? $data['sub_category'][$key] : NULL);
                    $userOfferingCategoriesAdd->type = 'provide service category';
                    $userOfferingCategoriesAdd->save();
                }
                if (!empty($data['industry'])) {
                    foreach ($data['industry'] as $offeringIndustry) {
                        $userOfferingIndustryAdd = new UserOfferingIndustries();
                        $userOfferingIndustryAdd->user_id = Auth::id();
                        $userOfferingIndustryAdd->industry_id = $offeringIndustry;
                        $userOfferingIndustryAdd->type = 'provide service industry';
                        $userOfferingIndustryAdd->save();
                    }
                }
///////////////////////////  FOR USER OFEERING SERVICES AND USER OFEERING INDUSTRIES TABLE END //////////////////////
                $filtered = Arr::except($data, ['other']);
                $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->first();
                if (!empty($user)) {
                    $user->user_id = Auth::id();
                    $user->page_id = $data['page_name'];
                    $user->skip = 0;
                    if (isset($data['other']) && $data['other'] != "") {
                        $user->other = $data['other'];
                    }
                    $user->answer = json_encode($filtered, true);
                    $user->save();
                    return response()->json(array('status' => 'success', 'message' => 'Successfully Updated.'));
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->other = (($data['other'] != "") ? $data['other'] : '');
                    $userSurvey->answer = json_encode($filtered, true);
                    $userSurvey->save();
                    return response()->json(array('status' => 'success', 'message' => 'Successfully Updated.'));
                }
            } else {
                return response()->json(array('status' => 'error', 'message' => 'Before submitting please select your services.'));
            }
        }
    }

    public function editSurvey4() {
        $productCategory = ProductCategory::select('*')->orderBy('name')->get();
        $industry = Industry::select('*')->orderBy('name')->get();
        $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_5'])->first();
        $data = json_decode($user['answer'], true);
        $page = Pages::where('page_name', 'page_5')->get();
        $pageData = [];
        $i = 0;
        foreach ($page as $val) {
            $pageData[$i]['content'] = $val['content'];
            $i++;
        }
        return view('edit_survey.survey-4')->with(['productCategory' => $productCategory, 'industry' => $industry, 'data' => $data, 'pageData' => $pageData]);
    }

    public function submitEditedSurvey4(Request $request) {
        if ($request->ajax() && request()->isMethod('post')) {
            $data = request()->post();
            if (!empty($data['category'])) {
                $userOfferingCategoriesDelete = UserOfferingCategories::where([
                            'user_id' => Auth::id(),
                            'type' => 'provide product category',
                        ])->delete();
                $userOfferingIndustriesDelete = UserOfferingIndustries::where([
                            'user_id' => Auth::id(),
                            'type' => 'provide product industry',
                        ])->delete();
                $services = ServiceCategory::select('id', 'name')->where('name', 'other')->first();
                $products = array_diff($data['category'], [$services->id]);
                foreach ($products as $key => $offeringCategories) {
                    $userOfferingCategoriesAdd = new UserOfferingCategories();
                    $userOfferingCategoriesAdd->user_id = Auth::id();
                    $userOfferingCategoriesAdd->category_id = $offeringCategories;
                    $userOfferingCategoriesAdd->sub_category_id = (isset($data['sub_category'][$key]) ? $data['sub_category'][$key] : NULL);
                    $userOfferingCategoriesAdd->type = 'provide product category';
                    $userOfferingCategoriesAdd->save();
                }
                if (!empty($data['industry'])) {
                    foreach ($data['industry'] as $offeringIndustry) {
                        $userOfferingIndustryAdd = new UserOfferingIndustries();
                        $userOfferingIndustryAdd->user_id = Auth::id();
                        $userOfferingIndustryAdd->industry_id = $offeringIndustry;
                        $userOfferingIndustryAdd->type = 'provide product industry';
                        $userOfferingIndustryAdd->save();
                    }
                }
                
                if (!empty($data['type_of_product'])) {
                    foreach ($data['type_of_product'] as $offeringProducts) {
                        $userOfferingProductAdd = new UserOfferingProducts();
                        $userOfferingProductAdd->user_id = Auth::id();
                        $userOfferingProductAdd->product_id = $offeringProducts;
                        $userOfferingProductAdd->type = 'provide product';
                        $userOfferingProductAdd->save();
                    }
                }
                
                $filtered = Arr::except($data, ['other']);
                $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->first();
                if (!empty($user)) {
                    $user->user_id = Auth::id();
                    $user->page_id = $data['page_name'];
                    $user->skip = 0;
                    if (isset($data['other']) && $data['other'] != "") {
                        $user->other = $data['other'];
                    }
                    $user->answer = json_encode($filtered, true);
                    $user->save();
                    return response()->json(array('status' => 'success', 'message' => 'Successfully Updated.'));
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->other = (($data['other'] != "") ? $data['other'] : '');
                    $userSurvey->answer = json_encode($filtered, true);
                    $userSurvey->save();
                    return response()->json(array('status' => 'success', 'message' => 'Successfully Updated.'));
                }
            } else {
                return response()->json(array('status' => 'error', 'message' => 'Before submitting please select your services.'));
            }
        }
    }

    public function editSurvey5() {
        $mapData = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_6'])->first();
        $val = json_decode($mapData['answer'], true);
        $page = Pages::where('page_name', 'page_6')->first();
        return view('edit_survey.survey-5')->with(['val' => $val, 'pageData' => $page]);
    }

    public function submitEditedSurvey5(Request $request) {
        if (request()->isMethod('post')) {
            session()->forget('error');
            $data = request()->post();
            if (!empty($data['answer'])) {
                $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->first();
                if (!empty($user)) {
                    $user->user_id = Auth::id();
                    $user->page_id = $data['page_name'];
                    $user->skip = 0;
                    $user->answer = json_encode($data, true);
                    $user->save();
                    return redirect('my-profile');
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->answer = json_encode($data, true);
                    $userSurvey->save();
                    return redirect('my-profile');
                }
            }
        }
    }

    public function editSurvey6() {
        $list = Pages::select('*')->where('page_name', 'page_7')->orderby('sort_order', 'asc')->get();
        $mapData = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_7'])->first();
        $val = json_decode($mapData['answer'], true);
        return view('edit_survey.survey-6')->with(['list' => $list, 'val' => $val]);
    }

    public function submitEditedSurvey6(Request $request) {
        if (request()->isMethod('post')) {
            session()->forget('error');
            $data = request()->post();
            if (!empty($data)) {
                $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->first();
                if (!empty($user)) {
                    $user->user_id = Auth::id();
                    $user->page_id = $data['page_name'];
                    $user->skip = 0;
                    $user->answer = json_encode($data, true);
                    $user->save();
                    return redirect('edit-survey');
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->answer = json_encode($data, true);
                    $userSurvey->save();
                    return redirect('edit-survey');
                }
            } else {
                return redirect()->back()->with('error', 'Before submitting please select required fields');
            }
        }
    }

    public function skipEditSurveyQuestion(Request $request, $page) {
        if ($request->isMethod('get')) {
            $posts = $request->post();
            $answers = new UserSurvey();
            $answers->user_id = Auth::id();
            if ($page == 'page_2') {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id()])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();
                return redirect('edit-location'); //map
                exit;
            } elseif ($page == 'page_3') {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $page])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();
                $userSurvey = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();

                $val = json_decode($userSurvey->answer, true);
                if (isset($val) && $val != '') {
                    if (in_array('product', $val) && in_array('service', $val)) {
                        return redirect('edit-survey-3');
                        exit;
                    } elseif (in_array('product', $val)) {
                        return redirect('edit-survey-4');
                        exit;
                    } else {
                        return redirect('edit-survey-3');
                        exit;
                    }
                }
            } elseif ($page == "pageForObtainBusiness") {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $page])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();
                $userSurvey = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();

                $val = json_decode($userSurvey->answer, true);
                if (isset($val) && $val != '') {
                    if (in_array('product', $val) && in_array('service', $val)) {
                        return redirect('edit-survey-3');
                        exit;
                    } elseif (in_array('product', $val)) {
                        return redirect('edit-survey-4');
                        exit;
                    } else {
                        return redirect('edit-survey-3');
                        exit;
                    }
                }
            } elseif ($page == 'page_4') {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $page])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();

                $userSurvey = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();
                $val = json_decode($userSurvey->answer, true);
                if (isset($val) && $val != '') {
                    if (in_array('product', $val) && in_array('service', $val)) {
                        return redirect('edit-survey-4');
                        exit;
                    } else {
                        return redirect('edit-location');
                        exit;
                    }
                }
            } elseif ($page == 'page_5') {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $page])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();
                return redirect('edit-location');
                exit;
            } elseif ($page == 'page_6') {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $page])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();
                return redirect('edit-survey');
                exit;
            } elseif ($page == 'page_7') {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $page])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();
                return redirect('edit-survey');
                exit;
            }
        }
    }

    /////////////////////////////////
}
