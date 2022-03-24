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
use App\Models\UserOfferingIndustries;
use App\Models\UserOfferingCategories;
use App\Models\UserPrimaryGoals;
use App\Models\faq;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Industry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
use Stripe;

class UserSurveyController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function welcome() {
        $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_1'])->first();
        if (!empty($user)) {
            return redirect('business');
            exit;
        }
        $page = Pages::where('page_name', 'page_1')->first();
        $content = json_decode($page['content'], true);
        $data = [];
        $data['heading'] = $content['heading'];
        $data['paragraph'] = $content['paragraph'];
        $data['image'] = $page['image'];
        return view('user_survey.welcome', ['data' => $data]);
    }

    public function submitWelcome() {
        $userSurvey = new UserSurvey();
        $userSurvey->user_id = Auth::id();
        $userSurvey->page_id = 'page_1';
        $userSurvey->skip = 0;
        $userSurvey->answer = 'welcome';
        $userSurvey->save();
        return redirect('business');
    }

    public function survey() {
        $userCompletedSurvey = UserSurvey::where('user_id', auth()->user()->id)->where('page_id', 'page_8')->first();        
        if (isset($userCompletedSurvey->answer)) {
            if ($userCompletedSurvey->answer == 'complete survey' && !$userCompletedSurvey->skip) return redirect('/pending');
        }    
	    $userData = UserSurvey::where('user_id', auth()->user()->id)->where('page_id', 'page_2')->first();  
    	$val = [];
        $page = Pages::where('page_name', 'page_2')->get();
        if (isset($userData->answer)) $val = json_decode($userData->answer);
        $data = [];
        $i = 0;
        foreach ($page as $pageData) {
            $data[$i]['content'] = (isset($pageData['content'])) ? $pageData['content'] : "";
            $i++;
        }
        return view('user_survey.survey')->with(['answer' => $val, 'data' => $data]);
    }

    public function submitSurvey(Request $request) {
        if (request()->isMethod('post')) {
            session()->forget('error');
            $data = request()->post();            
            if (!empty($data['answer'])) {
                $userSurvey = new UserSurvey();
                $userSurvey->user_id = Auth::id();
                UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->delete();
                $userSurvey->page_id = $data['page_name'];
                $userSurvey->skip = 0;
                $userSurvey->answer = json_encode($data['answer'], true);
                $userSurvey->save();
                return redirect('primary-goals');
            } else {
                return redirect()->back()->with('error', 'Before submitting please select required fields');
            }
        }
    }

    public function survey1() {
        $userData = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_3'])->first();
        $val = []; 
        $page = Pages::where('page_name', 'page_3')->get();
        if (isset($userData->answer)) $val = json_decode($userData->answer);
        
        $data = [];
        $i = 0;
        foreach ($page as $pageData) {
            $data[$i]['content'] = $pageData['content'];
            $i++;
        }
        return view('user_survey.survey_1')->with(['val' => $val, 'data' => $data]);
    }

    public function submitSurvey1(Request $request) {
        if (request()->isMethod('post')) {
            session()->forget('error');
            $data = request()->post();
            if (!empty($data['answer'])) {
                // PRIMARY GOALS //
                $userPrimaryGoals = UserPrimaryGoals::where(['user_id' => Auth::id()])->delete();
                $new = new UserPrimaryGoals();
                $new->user_id = Auth::id();
                if (in_array('Provide a Business Service', $data['answer'])) $new->provide_services = 1;
                if (in_array('Obtain Business Services', $data['answer'])) $new->obtain_services = 1;
                if (in_array('Collaboration Opportunities', $data['answer'])) $new->collaboration = 1;
                $new->save();
                // PRIMARY GOALS END //
                $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->first();
                if (!empty($user)) {
                    $user->user_id = Auth::id();
                    $user->page_id = $data['page_name'];
                    $user->skip = 0;
                    $user->answer = json_encode($data['answer'], true);
                    $user->save();
                    if (in_array('Obtain Business Services', $data['answer'])) {
                        return redirect('obtain-services');
                        exit;
                    }
                    $userSurvey = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();
                    $val = isset($userSurvey->answer) ? json_decode($userSurvey->answer, true) : array('service');
                    if (isset($val) && $val != '') {
                        if (in_array('product', $val) && in_array('service', $val)) {
                            return redirect('services');
                            exit;
                        } elseif (in_array('product', $val)) {
                            return redirect('products');
                            exit;
                        } else {
                            return redirect('services');
                            exit;
                        }
                    }
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->answer = json_encode($data['answer'], true);
                    $userSurvey->skip = 0;
                    $userSurvey->save();
                    if (in_array('Obtain Business Services', $data['answer'])) {
                        return redirect('obtain-services');
                        exit;
                    }
                    $userSurvey = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();
                    $val = isset($userSurvey->answer) ? json_decode($userSurvey->answer, true) : array('service');
                    if (isset($val) && $val != '') {
                        if (in_array('product', $val) && in_array('service', $val)) {
                            return redirect('services');
                            exit;
                        } elseif (in_array('product', $val)) {
                            return redirect('products');
                            exit;
                        } else {
                            return redirect('services');
                            exit;
                        }
                    }
                }
            } else {
                return redirect()->back()->with('error', 'Before submitting please select required fields');
            }
        }
    }

    public function surveyForObtainBusiness() {
        $serviceCategory = ServiceCategory::select('*')->orderBy('name')->get();
        $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'pageForObtainBusiness'])->first();
        $data = [];

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

        $page = Pages::where('page_name', 'pageForObtainBusiness')->get();
        $pageData = [];
        $i = 0;
        foreach ($page as $val) {
            $pageData[$i]['content'] = $val['content'];
            $i++;
        }
        return view('user_survey.surveyForObtainBusines')->with([
                    'data' => $is_exist,
                    'serviceCategory' => $serviceCategory,
                    'pageData' => $pageData
        ]);
    }

    public function submitSurvey01(Request $request) {
        if (request()->isMethod('post')) {
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
                $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->first();
                if (!empty($user)) {
                    $user->user_id = Auth::id();
                    $user->page_id = $data['page_name'];
                    $user->skip = 0;
                    if (isset($data['other']) && $data['other'] != "") {
                        $user->other = $data['other'];
                    }
                    $user->answer = json_encode($data, true);
                    $user->save();
                    $userSurvey = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();
                    $val = isset($userSurvey->answer) ? json_decode($userSurvey->answer, true) : array('service');
                    if (isset($val) && $val != '') {
                        if (in_array('product', $val) && in_array('service', $val)) {
                            return redirect('services');
                            exit;
                        } elseif (in_array('product', $val)) {
                            return redirect('products');
                            exit;
                        } else {
                            return redirect('services');
                            exit;
                        }
                    }
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->other = (($data['other'] != "") ? $data['other'] : '');
                    $userSurvey->answer = json_encode($data, true);
                    $userSurvey->save();
                    $userSurvey = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();
                    $val = isset($userSurvey->answer) ? json_decode($userSurvey->answer, true) : array('service');
                    if (isset($val) && $val != '') {
                        if (in_array('product', $val) && in_array('service', $val)) {
                            return redirect('services');
                            exit;
                        } elseif (in_array('product', $val)) {
                            return redirect('products');
                            exit;
                        } else {
                            return redirect('services');
                            exit;
                        }
                    }
                }
            } else {
                return redirect()->back()->with('error', 'Before submitting please select required fields');
            }
        }
    }

    public function survey2() {
        $industry = Industry::select('*')->orderBy('name')->get();
        $serviceCategory = ServiceCategory::select('*')->orderBy('name')->get();
        $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_4'])->first();
	
	    $data = ['answer' => ''];
	    $data1 = ['answer' => ''];
	    
	    
	    // @TODO prefill out the answers
	    
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
        $page = Pages::where('page_name', 'page_4')->get();
        $pageData = [];
        $i = 0;
        foreach ($page as $val) {
            $pageData[$i]['content'] = (isset($val['content'])) ? $val['content'] : "";
            $i++;
        }
        return view('user_survey.survey_2')->with([
                    'industry' => $industry,
                    'data' => $is_exist,
                    'data1' => $data1,
                    'serviceCategory' => $serviceCategory,
                    'pageData' => $pageData
        ]);
    }

    public function submitSurvey2(Request $request) {
        if (request()->isMethod('post')) {
            session()->forget('error');
            $data = request()->post();
            if (!empty($data['category'])) {
            
                ///////////////////////////  FOR USER OFFERING SERVICES AND USER OFEERING INDUSTRIES TABLE //////////////////////
                $userOfferingCategoriesDelete = UserOfferingCategories::where([
                            'user_id' => Auth::id(),
                            'type' => 'provide service category',
                        ])->delete();
                $userOfferingIndustriesDelete = UserOfferingIndustries::where([
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
                
                ///////////////////////////  FOR USER OFFERING SERVICES AND USER OFEERING INDUSTRIES TABLE END //////////////////////
                $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->first();
                if (!empty($user)) {
                    $user->user_id = Auth::id();
                    $user->page_id = $data['page_name'];
                    $user->skip = 0;
                    if (isset($data['other']) && $data['other'] != "") {
                        $user->other = $data['other'];
                    }
                    $user->answer = json_encode($data, true);
                    $user->save();
                    $userSurvey = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();
                    
                    $val = isset($userSurvey->answer) ? json_decode($userSurvey->answer, true) : array('service');
                    
                    
                    if (isset($val) && $val != '') {
                        if (in_array('product', $val) && in_array('service', $val)) {
                            return redirect('products');
                            exit;
                        } else {
                            return redirect('location');
                            exit;
                        }
                    }
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->other = (($data['other'] != "") ? $data['other'] : '');
                    $userSurvey->answer = json_encode($data, true);
                    $userSurvey->save();
                    $userSurvey = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();
                    
                    $val = isset($userSurvey->answer) ? json_decode($userSurvey->answer, true) : array('service');
                    
                    if (isset($val) && $val != '') {
                        if (in_array('product', $val) && in_array('service', $val)) {
                            return redirect('products');
                            exit;
                        } else {
                            return redirect('location');
                            exit;
                        }
                    }
                }
            } else {
                return redirect()->back()->with('error', 'Please select Industry and add a category with description');
            }
        }
    }

    public function survey3() {
        $productCategory = ProductCategory::select('*')->orderBy('name')->get();
        $industry = Industry::select('*')->orderBy('name')->get();
        $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_5'])->first();
        $data = ['answer' => ''];
    	$page = Pages::where('page_name', 'page_5')->get();

        $serviceCategory = ServiceCategory::select('*')->orderBy('name')->get();
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

        $pageData = [];
        $i = 0;
        foreach ($page as $val) {
            $pageData[$i]['content'] = $val['content'];
            $i++;
        }

        return view('user_survey.survey_3')->with([
                    'productCategory' => $productCategory,
                    'industry' => $industry,
                    'data' => $data,
                    'pageData' => $pageData,
                    'serviceCategory' => $serviceCategory,
                    'is_exist' => $is_exist
        ]);
    }

    public function submitSurvey3(Request $request) {
        if (request()->isMethod('post')) {
            session()->forget('error');
            $data = request()->post();
            $userProvideProduct = UserOfferingCategories::where([
                        'user_id' => Auth::id(),
                        'type' => 'provide product category'
                    ])->get();
            $userProvideProductIndustry = UserOfferingIndustries::where([
                        'user_id' => Auth::id(),
                        'type' => 'provide product industry'
                    ])->get();
            if (!empty($data)) {
                if ($userProvideProduct->isNotEmpty()) {
                    $userProvideProduct->each->delete();
                }
                if (!empty($data['category'])) {
                    $products = ServiceCategory::select('id', 'name')->where('name', 'other')->first();
                    $offerProducts = array_diff($data['category'], [$products->id]);
                    foreach ($offerProducts as $key => $provideCategories) {
                        $userProvideProductServices = new UserOfferingCategories();
                        $userProvideProductServices->user_id = Auth::id();
                        $userProvideProductServices->category_id = $provideCategories;
                        $userProvideProductServices->sub_category_id = (isset($data['sub_category'][$key]) ? $data['sub_category'][$key] : NULL);
                        $userProvideProductServices->type = 'provide product category';
                        $userProvideProductServices->save();
                    }
                }
                if ($userProvideProductIndustry->isNotEmpty()) {
                    $userProvideProductIndustry->each->delete();
                }
                if (!empty($data['industry'])) {
                    foreach ($data['industry'] as $offeringProductIndustry) {
                        $userOfferingIndustry = new UserOfferingIndustries();
                        $userOfferingIndustry->user_id = Auth::id();
                        $userOfferingIndustry->industry_id = $offeringProductIndustry;
                        $userOfferingIndustry->type = 'provide product industry';
                        $userOfferingIndustry->save();
                    }
                }
                $user = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $data['page_name']])->first();
                if (!empty($user)) {
                    $user->user_id = Auth::id();
                    $user->page_id = $data['page_name'];
                    $user->skip = 0;
                    if (isset($data['other']) && $data['other'] != "") {
                        $user->other = $data['other'];
                    }
                    $user->answer = json_encode($data, true);
                    $user->save();

                    return redirect('location');
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->other = (($data['other'] != "") ? $data['other'] : '');
                    $userSurvey->answer = json_encode($data, true);
                    $userSurvey->save();

                    return redirect('location');
                }
            } else {
                return redirect()->back()->with('error', 'Please select Industry and add a category with description');
            }
        }
    }

    public function survey4() {
        $mapData = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_6'])->first();
        $val = ['answer' => ''];
        $page = Pages::where('page_name', 'page_6')->first();
        return view('user_survey.survey_4')->with(['val' =>
                    $val, 'pageData' => $page]);
    }

    public function submitSurvey4(Request $request) {
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

                    return redirect('questions');
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->answer = json_encode($data, true);
                    $userSurvey->save();
                    return redirect('questions');
                }
            } else {
                return redirect()->back()->with('error', 'Before submitting please select a location');
            }
        }
    }

    public function survey5() {
        $list = Pages::select('*')->where('page_name', 'page_7')->orderby('sort_order', 'asc')->get();
        $mapData = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_7'])->first();
        $val = ['answer' => ['0' => '', '1' => '', '2' => '', '3' => '', '4' => '', '5' => '', '6' => '', '7' => '']];
        if (isset($mapData->answer)) $val = ['answer' =>  json_decode($mapData->answer)->answer];
        return view('user_survey.survey_5')->with(['list' => $list, 'val' => $val]);
    }

    public function submitSurvey5(Request $request) {
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

                    return redirect('congrats');
                } else {
                    $userSurvey = new UserSurvey();
                    $userSurvey->user_id = Auth::id();
                    $userSurvey->page_id = $data['page_name'];
                    $userSurvey->skip = 0;
                    $userSurvey->answer = json_encode($data, true);
                    $userSurvey->save();

                    return redirect('congrats');
                }
            } else {
                return redirect()->back()->with('error', 'Before submitting please select required fields');
            }
        }
    }

    public function congrats() {
        return view('user_survey.congrats');
    }

    public function skipSurveyQuestion(Request $request, $page) {
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
                return redirect('location'); //map
                exit;
            } elseif ($page == 'page_3') {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $page])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();
                $userSurvey = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => 'page_2'])->first();
                $val = isset($userSurvey->answer) ? json_decode($userSurvey->answer, true) : array('service');
                if (isset($val) && $val != '') {
                    if (in_array('product', $val) && in_array('service', $val)) {
                        return redirect('services');
                        exit;
                    } elseif (in_array('product', $val)) {
                        return redirect('products');
                        exit;
                    } else {
                        return redirect('services');
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
                $val = isset($userSurvey->answer) ? json_decode($userSurvey->answer, true) : array('service');
                if (isset($val) && $val != '') {
                    if (in_array('product', $val) && in_array('service', $val)) {
                        return redirect('services');
                        exit;
                    } elseif (in_array('product', $val)) {
                        return redirect('products');
                        exit;
                    } else {
                        return redirect('services');
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
                $val = isset($userSurvey->answer) ? json_decode($userSurvey->answer, true) : array('service');
                if (isset($val) && $val != '') {
                    if (in_array('product', $val) && in_array('service', $val)) {
                        return redirect('products');
                        exit;
                    } else {
                        return redirect('location');
                        exit;
                    }
                }
            } elseif ($page == 'page_5') {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $page])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();

                return redirect('location');
                exit;
            } elseif ($page == 'page_6') {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $page])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();

                return redirect('questions');
                exit;
            } elseif ($page == 'page_7') {
                $userSurvey01 = UserSurvey::where(['user_id' => Auth::id(), 'page_id' => $page])->get();
                $userSurvey01->each->delete();
                $answers->page_id = $page;
                $answers->skip = 1;
                $answers->save();

                return redirect('congrats');

                exit;
            }
        }
    }

    public function FAQ() {
        $faq = faq::select('*')->get();
        return view('FAQ', ['faq' => $faq]);
    }

    public function pending() {
        return view('pending');
    }

    public function subscription() {
        Stripe::setApiKey("sk_test_IAk4AQaTNYLFZXTJNGCnh2BU00pLgZXeyE");
        $create_token = StripeToken::create([
                    'card' => [
                        'number' => '4242424242424242',
                        'exp_month' => 10,
                        'exp_year' => 2020,
                        'cvc' => '314'
                    ]
        ]);
        return view('subscription');
    }
}
