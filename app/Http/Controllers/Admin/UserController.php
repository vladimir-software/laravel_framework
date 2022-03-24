<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users\User;
use App\Models\UserSurvey;
use App\Models\UserReviews;
use App\Models\UserPayments;
use App\Models\Pages;
use App\Models\Categories;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use App\Models\QuestionTypes;
use App\Models\Questions;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Industry;
use App\Models\Messages;
use App\Models\ManageHome;
use App\Models\ManageAd;
use App\Http\Controllers\Controller;
use DB;
use Mail;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;
use Carbon\Carbon;
use App\Models\Slug;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function admin(Request $request) {
        if ($request->isMethod('get')) {
            $start_Date = date('Y-01-01', strtotime(date('Y')));
            $current_Month = new Carbon(date('Y-m'));
            $tillDate = date('Y-12-31', strtotime(date('Y')));
            $start = (new DateTime($start_Date));
            $end = (new DateTime($tillDate));
            $interval = DateInterval::createFromDateString('1 month');
            $period = new DatePeriod($start, $interval, $end);
            $user_arr = array();
            $prev_user_arr = array();
            $date = [];
            foreach ($period as $key => $dt) {
                $date = date('Y-m-d', strtotime(date($dt->format('Y-m-d')) . '-1 year'));
                $amount = array();
                $post = UserPayments::select('id', 'created_at', 'amount')
                        ->whereMonth('created_at', $dt->format("m"))
                        ->whereYear('created_at', $dt->format("Y"))
                        ->get();

                foreach ($post as $data_arr) $amount[] = $data_arr['amount'] / 100;
                if (!empty($amount)) {
                    $sum[] = array_sum($amount);
                } else {
                    $sum[] = 0;
                }
                $users = User::select('id', 'created_at')
                        ->whereMonth('created_at', $dt->format("m"))
                        ->whereYear('created_at', $dt->format("Y"))
                        ->count();
                $user_arr[] = $users;

                $prevYearUsers = User::select('id', 'created_at')
                        ->whereMonth('created_at', date('m', strtotime($date)))
                        ->whereYear('created_at', date('Y', strtotime($date)))
                        ->count();
                $prev_user_arr[] = $prevYearUsers;
            }
 
            $totalMessages = Messages::select('*')->count();
            $totalUserReviews = UserReviews::select('*')->count();
            $totalUsers = User::select('*')->count();
            return view('admin.bootstrap.admin-dashboard')->with([
                        'totalMessages' => $totalMessages,
                        'totalUserReviews' => $totalUserReviews,
                        'totalUsers' => $totalUsers,
                        'sum' => implode(', ', $sum),
                        'user_arr' => implode(', ', $user_arr),
            ]);
        } else if ($request->isMethod('post') && $request->ajax()) {
            $year = $request['value'];
            $start_Date = date($year . '-01-01', strtotime(date($year)));

            $current_Month = new Carbon(date($year . '-m'));
            $tillDate = date($year . '-12-31', strtotime(date($year)));
            $start = (new DateTime($start_Date));
            $end = (new DateTime($tillDate));
            $interval = DateInterval::createFromDateString('1 month');
            $period = new DatePeriod($start, $interval, $end);
            $user_arr = array();
            $prev_user_arr = array();

            foreach ($period as $key => $dt) {
                $amount = array();
                $post = UserPayments::select('id', 'created_at', 'amount')
                        ->whereMonth('created_at', $dt->format("m"))
                        ->whereYear('created_at', $dt->format("Y"))
                        ->get();

                foreach ($post as $data_arr) $amount[] = $data_arr['amount'] / 100;
                if (!empty($amount)) {
                    $sum[] = array_sum($amount);
                } else {
                    $sum[] = 0;
                }
                $users = User::select('id', 'created_at')
                        ->whereMonth('created_at', $dt->format("m"))
                        ->whereYear('created_at', $dt->format("Y"))
                        ->count();
                $user_arr[] = $users;
            }
            return response()->json(array('status' => 'success', 'user_arr' => $user_arr, 'sum' => $sum, 'year' => $year));
            exit;
        }
    }

    public function addAdminUser(Request $request) {
    
        $user = Auth::user();
        if ($user->username != 'admin') {    
            return view('admin.bootstrap.unauthorized');
        }

        $userAdded = false;
        $error = false;
        if ($request->isMethod('post')) {
            $posts = $request->post();
            $UserRegister = new User();
            $findEmail = User::where('email', $posts['email'])->exists();
            if (!empty($findEmail)) {
                $error = 'Email Already Exists for another user';
                $userAdded = false;
            } else {
                $UserRegister->fullname = $posts['fullname'];
                $UserRegister->email = $posts['email'];
                $UserRegister->username = $posts['username'];
                $UserRegister->password = bcrypt($posts['password']);
                $UserRegister->account_type_id = 1;
                $UserRegister->status = 1;
                $UserRegister->token = Slug::generate();
                $UserRegister->company_name = '';
                $UserRegister->save();
                $userAdded = true;
            }
        }
        return view('admin.bootstrap.users.add-admin-user')->with(['userAdded' => $userAdded, 'error' => $error]);
    }
    
    public function editAdminUser(Request $request) {
            $users = User::select("id", 'fullname', 'email', 'account_type_id', 'mobile_number', 'token', 'approval', 'created_at', 'profile_pic')
                        ->where('delete', 0)
                        ->whereIn('account_type_id', [1, 3])
                        ->orderBy('id', 'desc')->paginate(10);
        return view('admin.bootstrap.users.admin-user')->with(['users' => $users]);
    }

    public function manageUsers1() {
        $users = User::select("id", 'fullname', 'email', 'account_type_id', 'mobile_number', 'token', 'approval', 'created_at', 'profile_pic')
                        ->where('delete', 0)
                        ->whereNotIn('account_type_id', [1, 3])
                        ->orderBy('id', 'desc')->paginate(10);
        return view('admin.bootstrap.users.user')->with(['users' => $users]);
    }

    public function userDetail1(Request $request, $id) {
        $users = User::select('fullname', 'email', 'mobile_number')->where('id', $id)->first();
        return view('admin.bootstrap.users.user-detail')->with(['users' => $users]);
    }

    public function editUser1(Request $request, $id) {
        $user = User::select('id', 'fullname', 'email', 'mobile_number', 'token', 'profile_pic')->where('id', $id)->first();
        return view('admin.bootstrap.users.edit-user')->with(['users' => $user]);
    }

    public function updateUser1(Request $request) {
        if ($request->isMethod('post')) {
            $posts = $request->post();
            $user = User::where('token', $posts['user-id'])->first();
            $user->fullname = $posts['fullname'];
            $user->email = $posts['email'];
            $user->mobile_number = $posts['contact'];
            $user->save();
            return redirect('/admin/users');
        }
    }

    public function userSurvey1(Request $request, $id) {
    
        $user_data = User::where('token', $id)->first();
        $userSurvey = UserSurvey::select('*')->where('user_id', $user_data->id)->whereNotIn('page_id', ['page_1', 'page_8'])->get();
        $survey = [];
        $answer = [];
        $i = 0;
        $ddd = 0;
        $in_exist = [];
        $is_exist = [];
        
        if (!empty($userSurvey)) {
            $service_cat1 = [];
            $service_sub_cat2 = array();
            $coolServeiceIndustry = [];
            $service_cat = [];
            $service_sub_cat = [];
            $productCategory = [];
            $productIndustry = [];

            foreach ($userSurvey as $user) {
                if ($user['page_id'] == "page_2") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $survey[$i]['answer'] = json_decode($user['answer'], true);
                } elseif ($user['page_id'] == "page_3") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $survey[$i]['answer'] = json_decode($user['answer'], true);
                } elseif ($user['page_id'] == "pageForObtainBusiness") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $category = json_decode($user['answer'], true);

                    if (isset($category['category']) && $category['category'] != "") {
                        $catVal = $category['category'];
                        $in_ordered = implode(', ', $category['category']);
                        $service_cat1 = ServiceCategory::whereIn('id', $catVal)
                                ->orderByRaw(DB::raw("FIELD(id, $in_ordered)"))
                                ->get();
                    }
                    if (isset($category['sub_category']) && $category['sub_category'] != "") {
                        foreach ($category['sub_category'] as $key => $subCat) $service_sub_cat2 = ServiceSubCategory::where('id', $subCat)->first();
                    }
                } elseif ($user['page_id'] == "page_4") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $category = json_decode($user['answer'], true);

                    if (isset($category['industry']) && $category['industry'] != "") {
                        $ind = $category['industry'];
                        $coolServeiceIndustry = Industry::whereIn('id', $ind)->get();
                    }

                    if (isset($category['category']) && $category['category'] != "") {
                        $cat = $category['category'];
                        $is_ordered = implode(', ', $category['category']);
                        $service_cat = ServiceCategory::whereIn('id', $cat)->orderByRaw(DB::raw("FIELD(id, $is_ordered)"))->get();
                    }
                    if (isset($category['sub_category']) && $category['sub_category'] != "") {
                        $sub = $category['sub_category'];
                        foreach ($sub as $key => $proCat) $service_sub_cat3 = ServiceSubCategory::where('id', $proCat)->first();
                    }
                    $survey[$i]['description'] = $category;
                } elseif ($user['page_id'] == "page_5") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $decode = json_decode($user['answer'], true);
                    if (isset($decode['type_of_product']) && $decode['type_of_product'] != "") {
                        $proCat = $decode['type_of_product'];
                        $productCategory = ProductCategory::whereIn('id', [$proCat])->get();
                    }
                    if (isset($decode['industry']) && $decode['industry'] != "") {
                        $proInd = $decode['industry'];
                        $productIndustry = Industry::whereIn('id', [$proInd])->get();
                    }
                    $survey[$i]['answer'] = $decode;
                    $survey[$i]['productCategory'] = isset($productCategory['name']) ? $productCategory['name'] : "";
                    $survey[$i]['industry'] = isset($industry['name']) ? $industry['name'] : "";
                } elseif ($user['page_id'] == "page_6") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $survey[$i]['answer'] = json_decode($user['answer'], true);
                } elseif ($user['page_id'] == "page_7") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $survey[$i]['answer'] = json_decode($user['answer'], true);
                }
                $i++;
            }
        }
        return view('admin.bootstrap.users.user_survey')
                        ->with([
                            'userSurvey' => $survey,
                            'user_data' => $user_data,
                            'service_cat1' => $service_cat1,
                            'service_sub_cat2' => $service_sub_cat2,
                            'coolServeiceIndustry' => $coolServeiceIndustry,
                            'service_cat' => $service_cat,
                            'service_sub_cat' => $service_sub_cat,
                            'productCategory' => $productCategory,
                            'productIndustry' => $productIndustry,
                            'is_exist' => $is_exist,
                            'in_exist' => $in_exist
        ]);
    }

    public function userApproval1(Request $request, $id) {
        $user = User::where('token', $id)->first();
        $user->approval = 1;
        $user->reject = 0;
        $user->forget_hash = Slug::generate();
        $user->save();
        $admin = User::where(['account_type_id' => 1])->first();
        if (!empty($user)) {
            $message = new Messages();
            $message->sender_id = (isset($admin['id']) ? $admin['id'] : '0');
            $message->receiver_id = $user['id'];
            $message->message = 'Congratulations! Your account has been approved by our team.';
            $message->save();
        }
        $set = array('email' => $user->email, 'name' => $user->fullname, 'token' => $user->forget_hash);
        echo Mail::send('admin.bootstrap.email.verify-email', $set, function($msg)use($set) {
            $msg->to($set['email'])->subject
                    ('You have been accepted to ConnectEO!');
            $msg->from('admin@connecteonetwork.com', 'ConnectEO Network');
        });

        return redirect()->back();
    }
    
    public function userRejected1(Request $request, $id) {
        $user = User::where('token', $id)->first();
        $admin = User::where(['account_type_id' => 1])->first();
        $messages = Messages::where([
                            'receiver_id' => $user->id, 'sender_id' => $admin->id
                        ])
                        ->orWhere([
                            'receiver_id' => $admin->id, 'sender_id' => $user->id
                        ])->delete();
        $user->approval = 0;
        $user->reject = 1;
        $user->save();
        return redirect()->back();
    }
    
     public function userMakeAdmin(Request $request, $id) {
        $user = User::where('token', $id)->first();        
        $user->account_type_id = 1;
        $user->username = $user->email;
        $user->save();
        return redirect()->back();
     }
     
     public function userRemoveAdmin(Request $request, $id) {
        $user = User::where('token', $id)->first();        
        $user->account_type_id = 2;
        $user->username = '';
        $user->save();
        return redirect()->back();
     }
    
    public function manageHome() {
        $matrix = ManageHome::select('*')->where('id', 1)->first();
        return view('admin.bootstrap.manage_home')->with('matrix', $matrix);
    }

    public function adManagement() {
        $adTop = ManageAd::select('*')
                    ->where(['ad_position' => 1, 'status' => 1])
                    ->limit(1)
                    ->inRandomOrder()->first();

        $adBottom = ManageAd::select('*')
                    ->where(['ad_position' => 2, 'status' => 1])
                    ->limit(1)
                    ->inRandomOrder()->first();
        return view('admin.bootstrap.ad_management', ['adTop'=> $adTop, 'adBottom'=> $adBottom]);
    }
    
    public function removeAd(Request $request) { 
        if ($request->isMethod('post')) {
            $post = request()->post();
            if (!empty($post)) {
                $ad = ManageAd::select('*')->where(['ad_position' => $post['ad_position']]);
                $ad->delete();
                return redirect()->back();
            }
        }
    }

    public function storeAd(Request $request) {
        if ($request->isMethod('post')) {
            $post = request()->post();
            if (!empty($post)) {
                $ad = new ManageAd();
                $ad->url = $post['url'];
                $ad->ad_position = $post['position'];
                $ad->status = 1;
                if ($file = $request->file('image')) {
                    $path = public_path() . "/asset/manage_ad";
                    $priv = 0777;
                    if (!file_exists($path)) mkdir($path, $priv) ? true : false; //
                    $name = $file->getClientOriginalName();
                    $file->move($path, $name);
                    $ad->image = trim('asset/manage_ad/' . $name);
                }
                $ad->save();
                return redirect()->back();
            }
        }
    }

    public function subscriptions() {
        $userSubscription = User::select('*')->where(['account_type_id' => 2, 'status' => 1])->with('userPayments')->paginate(10);
        return view('admin.bootstrap.subscriptions', ['userSubscription' => $userSubscription]);
    }
}
