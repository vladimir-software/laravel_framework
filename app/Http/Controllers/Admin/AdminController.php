<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users\User;
use App\Models\UserSurvey;
use App\Models\Pages;
use App\Models\Categories;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use App\Models\QuestionTypes;
use App\Models\Questions;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Industry;
use App\Models\MangePromo;
use App\Http\Controllers\Controller;

class AdminController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function manageUsers() {
        $users = User::select("id", 'fullname', 'email', 'account_type_id', 'mobile_number', 'token')->whereNotIn('account_type_id', [1])->paginate(15);
        return view('admin/users.user')->with(['users' => $users]);
    }

    public function userDetail(Request $request, $id) {
        $users = User::select('fullname', 'email', 'mobile_number')->where('token', $id)->first();
        return view('admin/users.user-detail')->with(['users' => $users]);
    }

    public function editUser(Request $request, $id) {
        $user = User::select('fullname', 'email', 'mobile_number', 'token')->where('token', $id)->first();
        return view('admin/users.edit-user')->with(['users' => $user]);
    }

    public function updateUser(Request $request) {
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

    public function userSurvey(Request $request, $id) {
        $user_data = User::where('token', $id)->first();
        $userSurvey = UserSurvey::select('*')->where('user_id', $user_data->id)->whereNotIn('page_id', ['page_1', 'page_8'])->get();

        $survey = [];
        $answer = [];
        $i = 0;

        if (!empty($userSurvey)) {
            foreach ($userSurvey as $user) {
                if ($user['page_id'] == "page_2") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $survey[$i]['answer'] = $user['answer'];
                } elseif ($user['page_id'] == "page_3") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $survey[$i]['answer'] = json_decode($user['answer'], true);
                } elseif ($user['page_id'] == "page_4") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $category = json_decode($user['answer'], true);
                    if (isset($category['service_category_id']) && $category['service_category_id'] != "") {
                        $service_cat = ServiceCategory::where('id', $category['service_category_id'])->first();
                    }
                    if (isset($category['service_sub_category_id']) && $category['service_sub_category_id'] != "") {
                        $service_sub_cat = ServiceSubCategory::where('id', $category['service_sub_category_id'])->first();
                    }
                    $set = isset($service_cat->name) ? $service_cat->name : "";
                    $set2 = isset($service_sub_cat['name']) ? $service_sub_cat['name'] : "";
                    $survey[$i]['answer'] = $set . " > " . $set2;
                } elseif ($user['page_id'] == "page_5") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $decode = json_decode($user['answer'], true);
                    if (isset($decode['type_of_product']) && $decode['type_of_product'] != "") {
                        $productCategory = ProductCategory::where('id', $decode['type_of_product'])->first();
                    }
                    if (isset($decode['industry']) && $decode['industry'] != "") {
                        $industry = Industry::where('id', $decode['industry'])->first();
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

        return view('admin.users.user_survey')->with(['userSurvey' => $survey, 'user_data' => $user_data]);
    }

    public function userApproval(Request $request, $id) {
        $user = User::where('token', $id)->first();
        $user->approval = 1;
        $user->save();
        return redirect()->back();
    }

    public function userRejected(Request $request, $id) {
        $user = User::where('token', $id)->first();
        $user->approval = 2;
        $user->save();
        return redirect()->back();
    }

    public function logout() {
        auth()->logout();
        return redirect('/admin');
    }

    public function platinumPromo(Request $request) {
    
        if ($request->isMethod('post')) {
        
            if ($request['method'] == 'delete') {
                MangePromo::where('id', $request['id'])->delete();
                return response()->json(array('status' => 'success', 'message' => "add has been removed"));
            }
        
            if ($file = $request->file('image')) {
                $path = public_path() . "/asset/platinum-promo";
                $priv = 0777;
                if (!file_exists($path)) mkdir($path, $priv) ? true : false;
                $name = $file->getClientOriginalName();
                $file->move($path, $name);
                
                $managePromo = new MangePromo();
                $managePromo->user_id = 1;
                $managePromo->image = 'asset/platinum-promo/'.$name;
                $managePromo->url = $request['url'];
                $managePromo->status = 1;
                $managePromo->save();
            }
        }
    
        $promo = MangePromo::whereNotIn('status', [0])->orderby('id', 'desc')->get();
        return view('admin.bootstrap.manage_promo.platinum-promo')->with('promo', $promo);
    }

    public function promoApproval(Request $request, $id = null) {
        if ($id != null) {
            MangePromo::where('id', $id)->update(['status' => 2]);
            return redirect()->back();
        }
    }

    public function commentForRejectPromo(Request $request) {
        if ($request->isMethod('post')) {
            if (!empty($request['promo_id'])) {
                MangePromo::where('id', $request['promo_id'])->update([
                    'comment' => $request['comment'],
                    'status' => 3
                ]);
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }
    }

    ////////////////////////////////
}
