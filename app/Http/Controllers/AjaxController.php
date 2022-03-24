<?php

namespace App\Http\Controllers;

use App\Models\Users\User;
use App\Models\Slug;
use App\Models\Answers;
use App\Models\Pages;
use App\Models\UserSurvey;
use App\Models\ServiceSubCategory;
use App\Models\ServiceCategory;
use App\Models\ProductCategory;
use App\Models\Industry;
use App\Models\Messages;
use App\Models\MangePromo;
use App\Models\UserRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hash;
use Carbon\Carbon;
use Mail;
use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AjaxController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request) {

        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            $checkUser = User::where(['email' => $posts['email']])->first();
            if (!empty($checkUser)) {
                if ($checkUser['delete'] == 1 || $checkUser['status'] != 1) {
                    return response()->json(array('status' => 'notApproved', 'message' => 'Your account is currently disabled.'));
                    exit;
                }
                if (Hash::check($posts['password'], $checkUser->password)) {
                    Auth::loginUsingId($checkUser['id']);
                    return response()->json(array('status' => 'success', 'message' => 'login successfully'));
                } else {
                    return response()->json(array('status' => 'fail', 'message' => 'That email address and password combination is not correct.', 'type' => "password"));
                }
            } else {
                return response()->json(array('status' => 'mai', 'message' => 'That email address and password combination is not correct', 'type' => "email"));
            }
        }
    }

    public function postSignup(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            $UserRegister = new User();
            $findEmail = User::where('email', $posts['email'])->exists();
            if (!empty($findEmail)) {
                return response()->json(array('status' => 'fail', 'message' => 'Email already exists'), 200);
                exit;
            }
            $UserRegister->fullname = $posts['fullname'];
            $UserRegister->email = $posts['email'];
            $UserRegister->password = bcrypt($posts['password']);
            $UserRegister->account_type_id = 2;
            if (!empty($posts['promo_code']) && $posts['promo_code'] == 'CONNECTEO') {
                $UserRegister->subscription_type = 2;
            } else {
                $UserRegister->subscription_type = 1;
            }
            $UserRegister->status = 1;
            $UserRegister->token = Slug::generate();
            $UserRegister->company_name = $posts['company_name'];
            $UserRegister->save();

            if (!empty($UserRegister)) {
                Auth::loginUsingId($UserRegister->id);
                return response()->json(array('status' => 'success', 'message' => 'Successfully logged in'));
            } else {
                return response()->json(array('status' => 'fail', 'message' => 'Error!!'));
            }
        }
    }

    public function completeSurveyForm(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            //UserSurvey
            $answers = new UserSurvey();
            $answers->user_id = Auth::id();
            $answers->page_id = $posts['pageId'];
            $answers->skip = 0;
            $answers->answer = 'complete survey';
            $answers->save();
            return response()->json(array('status' => 'success', 'data' => 'page_2'));
        }
    }

    public function getSubCategory(Request $request) {

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

    public function updateUserPic(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $data = $request->image;
            list($imgtype, $data) = explode(';', $data);
            list(, $imgtype) = explode(':', $imgtype);
            if ($imgtype == 'image/png') {
                $name = time() . ".png";
            } elseif ($imgtype == 'image/jpeg' || $imgtype == 'image/jpg') {
                $name = time() . ".jpg";
            } else {
                $name = time() . ".gif";
            }
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $sPath = public_path() . "/asset/user-profile";
            $priv = 0777;
            if (!file_exists($sPath)) {
                mkdir($sPath, $priv, true) ? true : false; // creates profilepic directory with write permission.
            }
            $save = $sPath . "/" . $name;
            file_put_contents($save, $data);
            $user = User::where('id', Auth::id())->first();
            $user->id = Auth::id();
            $user->profile_pic = "/asset/user-profile/" . $name;
            $user->save();
            return response()->json(array('status' => 'success', 'message' => "Successfully Updated", 'user' => $user));
        }
    }

    public function changeProfilePic(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            if ($file = $request->file('profile_pic')) {
                $path = public_path() . "/asset/user-profile";
                $priv = 0777;
                if (!file_exists($path)) {
                    mkdir($path, $priv) ? true : false; //
                }
                $name = $file->getClientOriginalName();
                $file->move($path, $name);
                $user = User::where('id', Auth::id())->first();
                $user->id = Auth::id();
                $user->profile_pic = "/asset/user-profile/" . $name;
                $user->save();
                return response()->json(array('status' => 'success', 'message' => "Successfully Updated", "user" => $user->profile_pic));
            }
        }
    }

    public function changeUserPassword(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            $userFind = User::where('forget_hash', $posts['token'])->first();
            if (!empty($userFind)) {
                $userFind->password = bcrypt($posts['password1']);
                $userFind->forget_hash = '';
                $userFind->save();
                return response()->json(array('status' => 'success', 'message' => 'Successfully changed your password'));
            } else {
                return response()->json(array('status' => 'failed'));
            }
        }
    }

    public function getSurveyData(Request $request) {
        if ($request->ajax() && $request->isMethod('get')) {
            $posts = $request->post();
            $pageName = '';
            $data = [];
            $productCategory = [];
            $is_exist = [];
            $is_exist_product = [];
            $serviceCategory = [];
            $productIndustry = [];
            $categoryIndustry = [];
            $data1 = [];
            $serviceCategory = ServiceCategory::select('*')->orderBy('name')->get();
            if (!empty($posts['surveyId']) && $posts['surveyId'] == 'page_4') {
            
                $categoryIndustry = Industry::select('*')->orderBy('name')->get();
                $pageName = $posts['surveyId'];
                $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_4'])->first();
                
                // @TODO need better NULL checks here, fixing bug for now
                if(empty($user)) {
                    $user = [];
                    $user['answer'] = '';
                }
                $data = json_decode($user['answer'], true);
                if (!$data) $data = array('answer' => '');
                
                $data1 = json_decode($user['answer'], true);
                if (!$data1) $data1 = array('answer' => '');
                
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
                    $pageData[$i]['content'] = $val['content'];
                    $i++;
                }
                
            } elseif (!empty($posts['surveyId']) && $posts['surveyId'] == 'page_5') {
            
                $productIndustry = Industry::select('*')->orderBy('name')->get();
                $pageName = $posts['surveyId'];
                $productCategory = ProductCategory::select('*')->orderBy('name')->get();
                $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_5'])->first();                
                
                // @TODO need better NULL checks here, fixing bug for now
                if(empty($user)) {
                    $user = [];
                    $user['answer'] = '';
                }
                $data = json_decode($user['answer'], true);
                if (!$data) $data = array('answer' => '');
                
                $is_exist_product = array();
                if (!empty($data['category'])) {
                    foreach ($data['category'] as $key => $vall) {
                        $cat1 = ServiceCategory::select('*')->where('id', $vall)->first();
                        $is_exist_product[$key]['cat_name'] = $cat1['name'];
                        $is_exist_product[$key]['cat_id'] = $cat1['id'];
                        if (isset($data['sub_category'][$key]) && $data['sub_category'][$key] != "") {
                            $sub1 = ServiceSubCategory::select('*')->where('id', $data['sub_category'][$key])->first();
                            $is_exist_product[$key]['sub_cat_name'] = $sub1['name'];
                            $is_exist_product[$key]['sub_cat_id'] = $sub1['id'];
                        } else {
                            $is_exist_product[$key]['sub_cat_name'] = "";
                            $is_exist_product[$key]['sub_cat_id'] = "";
                        }
                    }
                }
            }
            
            return view('business.edit-business-detail')->with([
                        'data' => $data,
                        'data1' => $data1,
                        'pageName' => $pageName,
                        'is_exist' => $is_exist,
                        'serviceCategory' => $serviceCategory,
                        'productCategory' => $productCategory,
                        'productIndustry' => $productIndustry,
                        'categoryIndustry' => $categoryIndustry,
                        'is_exist_product' => $is_exist_product
            ]);
        }
    }

    public function addBusinessData(Request $request) {
        if ($request->ajax() && $request->isMethod('get')) {
            $posts = $request->post();
            $pageName = '';
            $data = [];
            $productCategory = [];
            $is_exist = [];
            $serviceCategory = [];
            $productIndustry = [];
            $categoryIndustry = [];
            $data1 = [];

            if (!empty($posts['surveyId']) && $posts['surveyId'] == 'page_4') {
                $categoryIndustry = Industry::select('*')->orderBy('name')->get();
                $pageName = $posts['surveyId'];
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
                $page = Pages::where('page_name', 'page_4')->get();
                $pageData = [];
                $i = 0;
                foreach ($page as $val) {
                    $pageData[$i]['content'] = $val['content'];
                    $i++;
                }
            } elseif (!empty($posts['surveyId']) && $posts['surveyId'] == 'page_5') {
                $productIndustry = Industry::select('*')->orderBy('name')->get();
                $pageName = $posts['surveyId'];
                $productCategory = ProductCategory::select('*')->orderBy('name')->get();
                $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_5'])->first();
                $data = json_decode($user['answer'], true);
            }
            return view('business.add-business-detail')->with([
                        'data' => $data,
                        'data1' => $data1,
                        'pageName' => $pageName,
                        'is_exist' => $is_exist,
                        'serviceCategory' => $serviceCategory,
                        'productCategory' => $productCategory,
                        'productIndustry' => $productIndustry,
                        'categoryIndustry' => $categoryIndustry
            ]);
        }
    }

    public function editPrimaryGoals(Request $request) {
        if ($request->ajax() && $request->isMethod('get')) {
            $posts = $request->post();
            $business = [];
            $i = 0;
            $pageName = '';
            $data = [];
            $is_exist = [];
            $serviceCategory = [];
            $serviceSubCategory = [];
            $pageData = [];
            $pageData1 = [];
            $val = [];
            if (!empty($posts['surveyId']) && $posts['surveyId'] == 'page_3') {
                $pageName = $posts['surveyId'];
                $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => $pageName])->first();
                
                if (!empty($user)) {
                    $val = json_decode($user['answer'], true);
                } else $val = array();
                
                $page = Pages::where('page_name', $pageName)->get();
                foreach ($page as $pageData) {
                    $data[$i]['content'] = $pageData['content'];
                    $i++;
                }
            } elseif (!empty($posts['surveyId']) && $posts['surveyId'] == 'pageForObtainBusiness') {
            
                $pageName = $posts['surveyId'];
                $serviceCategory = ServiceCategory::select('*')->orderBy('name')->get();
                $user = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => $pageName])->first();

                if (!empty($user)) {
                    $data = json_decode($user['answer'], true);
                } else $data = array();

                $is_exist = array();
                $serviceSubCategory = array();
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
                    $serviceSubCategory = ServiceSubCategory::select('*')->where('service_id', $data['category'])->orderBy('name')->get();
                }

                $page = Pages::where('page_name', 'pageForObtainBusiness')->get();
                $pageData1 = [];
                $i = 0;
                foreach ($page as $val) {
                    $pageData1[$i]['content'] = $val['content'];
                    $i++;
                }
            } elseif (!empty($posts['surveyId']) && $posts['surveyId'] == 'page_6') {
                $pageName = $posts['surveyId'];
                $mapData = UserSurvey::select('answer')->where(['user_id' => Auth::id(), 'page_id' => 'page_6'])->first();
                $val = json_decode($mapData['answer'], true);
                $page = Pages::where('page_name', 'page_6')->first();
            }
            return view('business.edit-business-detail')->with([
                        'data' => $data,
                        'val' => $val,
                        'pageName' => $pageName,
                        'is_exist' => $is_exist,
                        'serviceSubCategory' => $serviceSubCategory,
                        'serviceCategory' => $serviceCategory,
                        'pageData' => $pageData1
            ]);
        }
    }

    public function userMessage(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            if (!empty($posts)) {
                $message = new Messages();
                $message->sender_id = Auth::id();
                $message->receiver_id = $posts['receiverId'];
                $message->message = $posts['message'];
                $message->save();
                $receiverDetails = User::select('email', 'fullname', 'forget_hash')
                                ->where(['id' => $posts['receiverId'], 'subscription_type' => 1])->first();
                if (!empty($receiverDetails)) {
                    $receiverDetails->forget_hash = (($receiverDetails->forget_hash != '') ? $receiverDetails->forget_hash : Slug::generate());
                    $receiverDetails->save();
                    $set = array('email' => $receiverDetails->email, 'name' => $receiverDetails->fullname, 'token' => $receiverDetails->forget_hash, 'senderName' => Auth::user()->fullname);
                    echo Mail::send('email.free-user-email', $set, function($msg)use($set) {
                        $msg->to($set['email'])->subject
                                ('Message');
                        $msg->from('admin@connecteonetwork.com', 'ConnectEO Network');
                    });
                }
                return response()->json(array('status' => 'success', 'message' => 'Successfully messaged'));
            }
        }
    }

    public function userRating(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            if (!empty($posts)) {
                $userRating = UserRating::select('*')
                                ->where('user_id', Auth::id())
                                ->where('to_user_id', $posts['toUserId'])->first();
                if (!empty($userRating)) {
                    $userRating->user_id = Auth::id();
                    $userRating->to_user_id = $posts['toUserId'];
                    $userRating->rating = $posts['user_rating'];
                    $userRating->comment = (isset($posts['userReviewComment']) ? $posts['userReviewComment'] : '');
                    $userRating->save();
                } else {
                    $newUserRating = new UserRating();
                    $newUserRating->user_id = Auth::id();
                    $newUserRating->to_user_id = $posts['toUserId'];
                    $newUserRating->rating = $posts['user_rating'];
                    $newUserRating->comment = (isset($posts['userReviewComment']) ? $posts['userReviewComment'] : '');
                    $newUserRating->save();
                }
                return response()->json(array('status' => 'success', 'message' => 'Successfully Saved'));
            }
        }
    }

    public function userSubscriptionUpdate(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            if (isset($request->value) && $request->value == "CONNECTEO") {
                $date = Carbon::now()->addDays(180);
                User::where('id', Auth::id())->update(['subscription_type' => 2, 'subscription_date' => $date]);
                session()->put('status', 'success');
                return response()->json(['status' => 'success']);
            }
        }
    }
    
    public function getUserAdminInfo(Request $request) {
        $user = Auth::user();
        print $user;
    }
    
    public function addPromoImage(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $data = $request->image;
            list($imgtype, $data) = explode(';', $data);
            list(, $imgtype) = explode(':', $imgtype);
            if ($imgtype == 'image/png') {
                $name = time() . ".png";
            } elseif ($imgtype == 'image/jpeg' || $imgtype == 'image/jpg') {
                $name = time() . ".jpg";
            } else {
                $name = time() . ".gif";
            }
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $sPath = public_path() . "/promo";
            $priv = 0777;
            if (!file_exists($sPath)) {
                mkdir($sPath, $priv, true) ? true : false; // creates profilepic directory with write permission.
            }
            $save = $sPath . "/" . $name;
            file_put_contents($save, $data);
            
            $delete = MangePromo::where('user_id', Auth::id())->first();
            if(!empty($delete)){
                MangePromo::where('user_id', Auth::id())->delete();
            }
            $addPromo = new MangePromo();
            $addPromo->user_id = Auth::id();
            $addPromo->image = "/promo/" . $name;
            $addPromo->save();
            return response()->json(array('status' => 'success'));
        }
    }

/////////////////////////////////
}
