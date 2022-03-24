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
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Industry;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;
use App\Models\BusinessProfile;
use App\Models\Users\UserProfile;
use App\Models\UserReviews;
use App\Models\UserPrimaryGoals;
use App\Models\UserRating;
use App\Models\Matrix;
use App\Models\UserOfferingCategories;
use App\Models\UserOfferingIndustries;
use App\Models\UserOfferingProducts;
use App\Models\UserReviewDetail;
use App\Models\Project;
use App\Models\Messages;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Token;
use Stripe\Stripe;
use Carbon\Carbon;
use App\Models\ManageAd;
use Stripe\Error\Base as StripeException;
use DB;
use App\Models\MangePromo;
use Illuminate\Database\Query\Builder;
use Cookie;
use Session;
use Mail;

class SurveyController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    function reviewCount() {
    
        $userConnectForCollboration01 = UserReviewDetail::where([
                    "user_id" => Auth::id(),
                    "type" => "collaboration"
                ])
                ->join('users', 'users.id', '=', 'to_user_id')
                ->where('users.approval', 1)
                ->groupBy("user_review_id")->get();

        $userConnectForObtain01 = UserReviewDetail::where([
                    "user_id" => Auth::id(),
                    "type" => "obtain"
                ])
                ->join('users', 'users.id', '=', 'to_user_id')
                ->where('users.approval', 1)
                ->groupBy("user_review_id")->get();

        $userConnectForProvide01 = UserReviewDetail::where([
                    "user_id" => Auth::id(),
                    "type" => "provide"
                ])
                ->join('users', 'users.id', '=', 'to_user_id')
                ->where('users.approval', 1)
                ->groupBy("user_review_id")->get();
                
        $count = array($userConnectForCollboration01, $userConnectForObtain01, $userConnectForProvide01);
        return $count;
    }

    function UserNotAllowed() {
        $userss = User::select('*')->where(function ($query) {
                            $query->where('profile_pic', "")
                            ->orWhereNull('profile_pic')
                            ->orWhere('approval', 0)
                            ->orWhere('delete', 1);
                        })->get();
        $userReview = UserReviews::select('to_user_id')->where('user_id', Auth::id())->get();
        $not_show = array();
        $not_show[] = Auth::id();
        foreach ($userReview as $st) {
            $not_show[] = $st['to_user_id'];
        }
        foreach ($userss as $st1) {
            $not_show[] = $st1['id'];
        }
        return $not_show;
    }
    
    public function home() {
    
        if (!empty(Auth::id()) && Auth::user()->approval != 1) {
            return redirect()->back();
            exit;
        }
        
        // get banner ads for top and bottom if added in admin
        $adTop = ManageAd::select('*')->where(['ad_position' => 1, 'status' => 1])->limit(1)->inRandomOrder()->get();
        $adBottom = ManageAd::select('*')->where(['ad_position' => 2, 'status' => 1])->limit(1)->inRandomOrder()->get();

        $usersForObtainServices = [];
        $result = array();
        $userss = User::select('*')->where(function ($query) {
                            $query->where('profile_pic', "")
                            ->orWhereNull('profile_pic')
                            ->orWhere('approval', 0)
                            ->orWhere('delete', 1);
                        })->get();

        // if user has goals to connect with other users
        $my_goals = UserPrimaryGoals::select('*')->where(['user_id' => Auth::id()])->first();
        if (!empty($my_goals)) {
    
            // create a list of already connected users to not show
            $userReview = UserReviews::select('to_user_id')->where('user_id', Auth::id())->get();
            $not_show = array();
            $not_show[] = Auth::id();
            foreach ($userReview as $st) $not_show[] = $st['to_user_id'];
            foreach ($userss as $st1) $not_show[] = $st1['id'];
            
            // if user is looking to obtain a service
            if ($my_goals['obtain_services'] == 1) {
                $user_obtain = [];
                $my_obtain_categories = UserOfferingCategories::select("*")->where('user_id', Auth::id())->where('type', 'obtain service')->get();
                $groupby = [];
                foreach ($my_obtain_categories as $key => $group) {
                    if ($group['sub_category_id'] != "") {
                        $key = $group['sub_category_id'];
                        $groupby[$key] = $group;
                    } else {
                        $key = $group['category_id'];
                        $groupby[$key] = $group;
                    }
                }
                $my_ob_categories = array();
                $my_ob_categories['sub_category'] = array();
                $my_ob_categories['category'] = array();
                foreach ($groupby as $moc) {
                    if ($moc['sub_category_id'] == '') {
                        $my_ob_categories['category'][] = $moc['category_id'];
                    } else {
                        $my_ob_categories['sub_category'][] = $moc['sub_category_id'];
                    }
                }
                $services = ServiceCategory::select('id', 'name')->where('name', 'other')->first();
                $my_ob_categories['category'] = array_diff($my_ob_categories['category'], [$services->id]);

                $userOffO = UserOfferingCategories::select("*")
                        ->Where(function($subquery) use ($my_ob_categories) {
                            $subquery->whereIn('category_id', $my_ob_categories['category']);
                            $subquery->OrWhereIn('sub_category_id', $my_ob_categories['sub_category']);
                        })
                        ->with('user')
                        ->where('type', '!=', 'obtain service')
                        ->whereNotIn('user_id', $not_show)
                        ->get();

                if (!empty($userOffO)) {
                    foreach ($userOffO as $key => $gr) {
                        if ($gr['sub_category_id'] != "") {
                            if (!empty($gr['user']['id'])) {
                                $key = $gr['user']['id'];
                                $cat = $gr['sub_category_id'];
                                $user_obtain[$key][$cat] = $gr;
                            }                            
                        } else {
                            if (!empty($gr['user']['id']) && !empty($gr['category_id'])) {
                                $key = $gr['user']['id'];
                                $cat = $gr['category_id'];
                                $user_obtain[$key][$cat] = $gr;
                            }
                        }
                    }
                }
                $data = array();
                foreach ($user_obtain as $key => $data_01) {
                    foreach ($data_01 as $key => $data) {
                        $key = $data['user']['id'];
                        $usersForObtainServices[$key]['id'] = $data['user']['id'];
                        $usersForObtainServices[$key]['category_id'][] = $data['category_id'];
                        $usersForObtainServices[$key]['sub_category_id'][] = $data['sub_category_id'];
                        $usersForObtainServices[$key]['token'] = (($data['user']['token']) ? $data['user']['token'] : $data['user']['id']);
                        $usersForObtainServices[$key]['fullname'] = $data['user']['fullname'];
                        $usersForObtainServices[$key]['company_name'] = $data['user']['company_name'];
                        $usersForObtainServices[$key]['username'] = $data['user']['username'];
                        $usersForObtainServices[$key]['email'] = $data['user']['email'];
                        $usersForObtainServices[$key]['mobile_number'] = $data['user']['mobile_number'];
                        $usersForObtainServices[$key]['type'][] = 'obtain';
                        $usersForObtainServices[$key]['profile_pic'] = ($data['user']['profile_pic']) ? asset($data['user']['profile_pic']) : asset('asset/noimage_person.png');
                        
                        // get user addresses
                        $userProfile = UserProfile::where('user_id', $data['user']['id'])->first();
                        if (isset($userProfile['location_city']) && isset($userProfile['location_state'])) $usersForObtainServices[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state'];
                    }
                }
            }

            // user is providing a service
            if ($my_goals['provide_services'] == 1) {
                $my_provided_categories = UserOfferingCategories::select("*")->where('user_id', Auth::id())->where('type', '!=', 'obtain service')->get();
                $user_provide = [];
                $groupby = [];
                foreach ($my_provided_categories as $key => $group) {
                    if ($group['sub_category_id'] != "") {
                        $key = $group['sub_category_id'];
                        $groupby[$key] = $group;
                    } else {
                        $key = $group['category_id'];
                        $groupby[$key] = $group;
                    }
                }
                $my_categories = array();
                $my_categories['sub_category'] = array();
                $my_categories['category'] = array();
                foreach ($my_provided_categories as $mpc) {
                    if ($mpc['sub_category_id'] == '') {
                        $my_categories['category'][] = $mpc['category_id'];
                    } else {
                        $my_categories['sub_category'][] = $mpc['sub_category_id'];
                    }
                }
                $my_categories['category'] = array_unique($my_categories['category']);
                $my_categories['sub_category'] = array_unique($my_categories['sub_category']);

                $services = ServiceCategory::select('id', 'name')->where('name', 'other')->first();
                $my_categories['category'] = array_diff($my_categories['category'], [$services->id]);

                $userOffP = UserOfferingCategories::select("*")
                        ->Where(function($subquery) use ($my_categories) {
                            $subquery->whereIn('category_id', $my_categories['category']);
                            $subquery->OrWhereIn('sub_category_id', $my_categories['sub_category']);
                        })
                        ->with('user')
                        ->where('type', 'obtain service')
                        ->whereNotIn('user_id', $not_show)
                        ->get();
                if (!empty($userOffP)) {
                    foreach ($userOffP as $key => $gr) { //echo "<pre>"; print_r($gr);
                        if ($gr['sub_category_id'] != "") {
                            if (!empty($gr['user']['id'])) {
                                $key = $gr['user']['id'];
                                $cat = $gr['sub_category_id'];
                                $user_provide[$key][$cat] = $gr;
                            }                            
                        } else {
                            if (!empty($gr['user']['id']) && !empty($gr['category_id'])) {
                                $key = $gr['user']['id'];
                                $cat = $gr['category_id'];
                                $user_provide[$key][$cat] = $gr;
                            }
                        }
                    }
                }
                $data = array();
                foreach ($user_provide as $key => $data_02) {
                    foreach ($data_02 as $key => $data) {
                        $key = $data['user']['id'];
                        $usersForObtainServices[$key]['id'] = $data['user']['id'];
                        $usersForObtainServices[$key]['category_id'][] = $data['category_id'];
                        $usersForObtainServices[$key]['sub_category_id'][] = $data['sub_category_id'];
                        $usersForObtainServices[$key]['token'] = (($data['user']['token']) ? $data['user']['token'] : $data['user']['id']);
                        $usersForObtainServices[$key]['fullname'] = $data['user']['fullname'];
                        $usersForObtainServices[$key]['company_name'] = $data['user']['company_name'];
                        $usersForObtainServices[$key]['username'] = $data['user']['username'];
                        $usersForObtainServices[$key]['email'] = $data['user']['email'];
                        $usersForObtainServices[$key]['mobile_number'] = $data['user']['mobile_number'];
                        $usersForObtainServices[$key]['type'][] = 'provide';
                        $usersForObtainServices[$key]['profile_pic'] = ($data['user']['profile_pic']) ? asset($data['user']['profile_pic']) : asset('asset/noimage_person.png');
                        
                        // get user addresses
                        $userProfile = UserProfile::where('user_id', $data['user']['id'])->first();
                        if (isset($userProfile['location_city']) && isset($userProfile['location_state']))$usersForObtainServices[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state']; 
                    }
                }
            }
            
            // user wants to collaborate
            if ($my_goals['collaboration'] == 1) {
            
                $user_coll = [];
                $my_provided_categories = UserOfferingCategories::select("*")->where('user_id', Auth::id())->where('type', '!=', 'obtain service')->get();
                $groupby = [];
                foreach ($my_provided_categories as $key => $group) {
                    if ($group['sub_category_id'] != "") {
                        $key = $group['sub_category_id'];
                        $groupby[$key] = $group;
                    } else {
                        $key = $group['category_id'];
                        $groupby[$key] = $group;
                    }
                }
                
                foreach ($groupby as $mpc) {
                    if ($mpc['sub_category_id'] == "") {
                        $matrix = Matrix::select('*')
                                ->where(['type' => 'collaboration'])
                                ->where(function ($query) use ($mpc) {
                                    $query->where('category', $mpc['category_id'])
                                    ->orWhere('match_category', $mpc['category_id']);
                                })
                                ->get();
                    } else {
                        $matrix = Matrix::select('*')
                                ->where(['type' => 'collaboration'])
                                ->where(function ($query) use ($mpc) {
                                    $query->where('sub_category', $mpc['sub_category_id'])
                                    ->orWhere('match_sub_category', $mpc['sub_category_id']);
                                })
                                ->get();
                    }
                    $array = array();
                    $array['sub_category'] = array();
                    $array['category'] = array();
                    foreach ($matrix as $m) {
                        if ($m['sub_category'] == '') {
                            $array['category'][] = $m['category'];
                        } else {
                            $array['sub_category'][] = $m['sub_category'];
                        }
                        if ($m['match_sub_category'] == '') {
                            $array['category'][] = $m['match_category'];
                        } else {
                            $array['sub_category'][] = $m['match_sub_category'];
                        }
                    }
                    $array['sub_category'] = array_unique($array['sub_category']);
                    $array['category'] = array_unique($array['category']);

                    $userOff = UserOfferingCategories::select("*")
                            ->where(function($subquery) use ($array) {
                                $subquery->whereIn('category_id', $array['category']);
                                $subquery->OrWhereIn('sub_category_id', $array['sub_category']);
                            })
                            ->where(function ($query) use ($mpc) {
                                $query->where('category_id', '!=', $mpc['category_id'])
                                ->orWhere('sub_category_id', '!=', $mpc['sub_category_id']);
                            })
                            ->with('user')
                            ->where('type', '!=', 'obtain service')
                            ->whereNotIn('user_id', $not_show)
                            ->get();

                    if (!empty($userOff)) {
                        foreach ($userOff as $key => $gr) {
                            if ($gr['sub_category_id'] != "") {
                                if (!empty($gr['user']['id'])) {
                                    $key = $gr['user']['id'];
                                    $cat = $gr['sub_category_id'];
                                    $user_coll[$key][$cat] = $gr;
                                }                            
                            } else {
                                if (!empty($gr['user']['id']) && !empty($gr['category_id'])) {
                                    $key = $gr['user']['id'];
                                    $cat = $gr['category_id'];
                                    $user_coll[$key][$cat] = $gr;
                                }
                            }
                        }
                    }
                }
                
                $data = array();
                foreach ($user_coll as $key => $data01) {
                    foreach ($data01 as $key => $data) {
                        $key = $data['user']['id'];
                        $usersForObtainServices[$key]['id'] = $data['user']['id'];
                        $usersForObtainServices[$key]['category_id'][] = $data['category_id'];
                        $usersForObtainServices[$key]['sub_category_id'][] = $data['sub_category_id'];
                        $usersForObtainServices[$key]['token'] = (($data['user']['token']) ? $data['user']['token'] : $data['user']['id']);
                        $usersForObtainServices[$key]['fullname'] = $data['user']['fullname'];
                        $usersForObtainServices[$key]['company_name'] = $data['user']['company_name'];
                        $usersForObtainServices[$key]['username'] = $data['user']['username'];
                        $usersForObtainServices[$key]['email'] = $data['user']['email'];
                        $usersForObtainServices[$key]['mobile_number'] = $data['user']['mobile_number'];
                        $usersForObtainServices[$key]['type'][] = 'collaboration';
                        $usersForObtainServices[$key]['profile_pic'] = ($data['user']['profile_pic']) ? asset($data['user']['profile_pic']) : asset('asset/noimage_person.png');
                        
                        // get user addresses
                        $userProfile = UserProfile::where('user_id', $data['user']['id'])->first();
                        if (isset($userProfile['location_city']) && isset($userProfile['location_state']))$usersForObtainServices[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state'];
                    }
                }
            }
                        
            // match on product to product / user wants to collaborate
            if ($my_goals['collaboration'] == 1) {
                $user_coll = [];
                $my_provided_products = UserOfferingProducts::select("*")->where('user_id', Auth::id())->where('type', 'provide product')->get();
                $groupby = [];                
                foreach ($my_provided_products as $key => $group) {
                    $key = $group['product_id'];
                    $groupby[$key] = $group;
                }

                foreach ($groupby as $mpc) {
                
                    $matrix = Matrix::select('*')
                            ->where(['type' => 'collaboration'])
                            ->where(function ($query) use ($mpc) {
                                $query->where('product', $mpc['product_id'])
                                ->orWhere('match_product', $mpc['product_id']);
                            })
                            ->get();

                    $array = array();
                    $array['product'] = array();
                    foreach ($matrix as $m) {
                        $array['product'][] = $m['product'];
                        $array['product'][] = $m['match_product'];
                    }
                    $array['product'] = array_unique($array['product']);
                    $userOff = UserOfferingProducts::select("*")
                            ->where(function($subquery) use ($array) {
                                $subquery->whereIn('product_id', $array['product']);
                            })
                            ->where(function ($query) use ($mpc) {
                                $query->where('product_id', '!=', $mpc['product_id']);
                            })
                            ->with('user')
                            ->where('type', 'provide product')
                            ->whereNotIn('user_id', $not_show)
                            ->get();
                            
                    if (!empty($userOff)) {
                        foreach ($userOff as $key => $gr) {
                            if (!empty($gr['user']['id']) && !empty($gr['product_id'])) {
                                $key = $gr['user']['id'];
                                $cat = $gr['product_id'];
                                $user_coll[$key][$cat] = $gr;
                            }
                        
                        }
                    }
                }

                $data = array();
                foreach ($user_coll as $key => $data01) {
                    foreach ($data01 as $key => $data) {
                        $key = $data['user']['id'];
                        $usersForObtainServices[$key]['id'] = $data['user']['id'];
                        $usersForObtainServices[$key]['category_id'][] = $data['category_id'];
                        $usersForObtainServices[$key]['sub_category_id'][] = $data['sub_category_id'];
                        $usersForObtainServices[$key]['token'] = (($data['user']['token']) ? $data['user']['token'] : $data['user']['id']);
                        $usersForObtainServices[$key]['fullname'] = $data['user']['fullname'];
                        $usersForObtainServices[$key]['company_name'] = $data['user']['company_name'];
                        $usersForObtainServices[$key]['username'] = $data['user']['username'];
                        $usersForObtainServices[$key]['email'] = $data['user']['email'];
                        $usersForObtainServices[$key]['mobile_number'] = $data['user']['mobile_number'];
                        $usersForObtainServices[$key]['type'][] = 'collaboration';
                        $usersForObtainServices[$key]['profile_pic'] = ($data['user']['profile_pic']) ? asset($data['user']['profile_pic']) : asset('asset/noimage_person.png');
                        
                        // get user addresses
                        $userProfile = UserProfile::where('user_id', $data['user']['id'])->first();
                        if (isset($userProfile['location_city']) && isset($userProfile['location_state']))$usersForObtainServices[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state'];
                    }
                }
            }
            
            // match on product to category / user wants to collaborate
            if ($my_goals['collaboration'] == 1) {
            
                $user_coll = [];
                $my_provided_products = UserOfferingProducts::select("*")->where('user_id', Auth::id())->where('type', 'provide product')->get();
                $groupby = [];                
                foreach ($my_provided_products as $key => $group) {
                    $key = $group['product_id'];
                    $groupby[$key] = $group;
                }
                                
                foreach ($groupby as $mpc) {

                    $matrix = Matrix::select('*')
                            ->where(['type' => 'collaboration'])
                            ->where(function ($query) use ($mpc) {
                                $query->where('product', $mpc['product_id'])
                                ->orWhere('match_product', $mpc['product_id']);
                            })
                            ->get();
     
                    $array = array();
                    $array['sub_category'] = array();
                    $array['category'] = array();
                    foreach ($matrix as $m) {
                        if ($m['sub_category'] == '') {
                            $array['category'][] = $m['category'];
                        } else {
                            $array['sub_category'][] = $m['sub_category'];
                        }
                        if ($m['match_sub_category'] == '') {
                            $array['category'][] = $m['match_category'];
                        } else {
                            $array['sub_category'][] = $m['match_sub_category'];
                        }
                    }
                    $array['sub_category'] = array_unique($array['sub_category']);
                    $array['category'] = array_unique($array['category']);

                    $userOff = UserOfferingCategories::select("*")
                            ->where(function($subquery) use ($array) {
                                $subquery->whereIn('category_id', $array['category']);
                                $subquery->OrWhereIn('sub_category_id', $array['sub_category']);
                            })
                            ->where(function ($query) use ($mpc) {
                                $query->where('category_id', '!=', $mpc['category_id'])
                                ->orWhere('sub_category_id', '!=', $mpc['sub_category_id']);
                            })
                            ->with('user')
                            ->where('type', '!=', 'obtain service')
                            ->whereNotIn('user_id', $not_show)
                            ->get();

                    if (!empty($userOff)) {
                        foreach ($userOff as $key => $gr) {
                            if ($gr['sub_category_id'] != "") {
                                if (!empty($gr['user']['id'])) {
                                    $key = $gr['user']['id'];
                                    $cat = $gr['sub_category_id'];
                                    $user_coll[$key][$cat] = $gr;
                                }                            
                            } else {
                                if (!empty($gr['user']['id']) && !empty($gr['category_id'])) {
                                    $key = $gr['user']['id'];
                                    $cat = $gr['category_id'];
                                    $user_coll[$key][$cat] = $gr;
                                }
                            }
                        }
                    }
                }
                
                $data = array();
                foreach ($user_coll as $key => $data01) {
                    foreach ($data01 as $key => $data) {
                        $key = $data['user']['id'];
                        $usersForObtainServices[$key]['id'] = $data['user']['id'];
                        $usersForObtainServices[$key]['category_id'][] = $data['category_id'];
                        $usersForObtainServices[$key]['sub_category_id'][] = $data['sub_category_id'];
                        $usersForObtainServices[$key]['token'] = (($data['user']['token']) ? $data['user']['token'] : $data['user']['id']);
                        $usersForObtainServices[$key]['fullname'] = $data['user']['fullname'];
                        $usersForObtainServices[$key]['company_name'] = $data['user']['company_name'];
                        $usersForObtainServices[$key]['username'] = $data['user']['username'];
                        $usersForObtainServices[$key]['email'] = $data['user']['email'];
                        $usersForObtainServices[$key]['mobile_number'] = $data['user']['mobile_number'];
                        $usersForObtainServices[$key]['type'][] = 'collaboration';
                        $usersForObtainServices[$key]['profile_pic'] = ($data['user']['profile_pic']) ? asset($data['user']['profile_pic']) : asset('asset/noimage_person.png');
                        
                        // get user addresses
                        $userProfile = UserProfile::where('user_id', $data['user']['id'])->first();
                        if (isset($userProfile['location_city']) && isset($userProfile['location_state']))$usersForObtainServices[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state'];
                    }
                }
            }
            
            if (!empty($usersForObtainServices)) {
                foreach ($usersForObtainServices as $key => $ufos) {
                    $result[$key] = $usersForObtainServices[$key];
                    $c = array();
                    foreach ($ufos['type'] as $k => $type) {

                        if ($type == 'obtain') $v = 'You Need Them';
                        if ($type == 'collaboration') $v = 'Collaboration Opportunity';
                        if ($type == 'provide') $v = 'They Need You';

                        if ($ufos['category_id'][$k]) {
                            $cat = ServiceCategory::select('name')->where('id', $ufos['category_id'][$k])->first();
                            $subcat = ServiceSubCategory::select('name')->where('id', $ufos['sub_category_id'][$k])->first();

                            if (!empty($subcat['name'])) {
                                $c[$v][] = $cat['name'] . " > " . $subcat['name'];
                            } else {
                                $c[$v][] = $cat['name'];
                            }
                        }
                    }
                    $result[$key]['relation'] = $c;
                }
            }
        }
        $allConn = $this->reviewCount();
        $totalConnCount = (count($allConn[0]) + count($allConn[1]) + count($allConn[2]));
        return view('home', [
            'connection' => $totalConnCount,
            'usersForObtainServices' => $result,
            'adTop' => $adTop,
            'adBottom' => $adBottom
        ]);
    }
    
    public function adView(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {

            $ads = MangePromo::where('status', 2)
                            ->limit(1000)
                            ->orderby('id', 'desc')->get();            
            $ads = $ads->shuffle();
            $collection = new \Illuminate\Database\Eloquent\Collection();
            for ($i = 1; $i <= 25; $i++) {
                foreach ($ads as $currentAd) $collection[] = $currentAd;
            }
            return response()->json(array('status' => 'success', 'data' => $collection, 'count' => count($collection)));
        }
    }

    public function userReview(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $posts = $request->post();
            $reviewFromUP = session()->get('user_review_ids');
            $isConnected = false;
            if (!empty($posts) && isset($posts['to_user_id'])) {
                $review = UserReviews::select('*')->where(['user_id' => Auth::id(), 'to_user_id' => $posts['to_user_id']])->first();
                if ($review) {
                    $review->id = $review['id'];
                } else {
                    $review = new UserReviews();
                }
                $review->user_id = Auth::id();
                $review->to_user_id = $posts['to_user_id'];
                if (isset($posts['data']) && $posts['data'] == 'accept') {
                    $review->review_status = 1;
                } else {
                    $review->review_status = 0;
                }
                $review->save();
                if (isset($posts['data']) && $posts['data'] == 'accept') {
                    if (!empty($posts['relation'])) {
                        foreach ($posts['relation'] as $rel) {
                            $relation = explode(":", $rel);
                            $cat = explode(",", $relation[1]);
                            $review_detail = new UserReviewDetail();
                            $review_detail->user_review_id = $review->id;
                            $review_detail->user_id = Auth::id();
                            $review_detail->to_user_id = $posts['to_user_id'];
                            $review_detail->category_id = (int) $cat[0];
                            $review_detail->sub_category_id = (int) $cat[1];
                            $review_detail->type = $relation[0];
                            $review_detail->save();
                        }
                    }

                    if (!empty($reviewFromUP)) {
                        foreach ($reviewFromUP as $rel) {
                            $relation = explode(":", $rel);
                            $cat = explode(",", $relation[1]);
                            $review_detail = new UserReviewDetail();
                            $review_detail->user_review_id = $review->id;
                            $review_detail->user_id = Auth::id();
                            $review_detail->to_user_id = $posts['to_user_id'];
                            $review_detail->category_id = (int) $cat[0];
                            $review_detail->sub_category_id = isset($cat[1]) && $cat[1] != 0 ? (int) $cat[1] : null;
                            $review_detail->type = $relation[0];
                            $review_detail->save();
                        }
                    }

                    // check if there's a match with the new "connect" request to show user there's a new match
                    $isConnectedCheck = UserReviews::select('*')->where(['to_user_id' => Auth::id(), 'user_id' => $posts['to_user_id']])->first();
                    if (isset($isConnectedCheck)) {
                        if(isset($isConnectedCheck->review_status) && $isConnectedCheck->review_status) $isConnected = true;
                    }
                }

                session()->forget('user_review_ids');
                $allConn = $this->reviewCount();
                $totalConnCount = (count($allConn[0]) + count($allConn[1]) + count($allConn[2]));

                // get to and from users images
                $toUserPicture = asset('asset/noimage_person.png');
                $toUserName = '';
                $toUserToken = '';
                $fromUserPicture = asset('asset/noimage_person.png');
                $fromUserName = '';
                $fromUserToken = '';

                // if a connection, then lookup user info about who is connected
                if ($isConnected) {
                
                    $toUserData = User::select('token', 'fullname', 'profile_pic', 'created_at', 'email')->whereIn('id', array(intval($posts['to_user_id'])))->first();
                    if (isset($toUserData['profile_pic'])) $toUserPicture = ($toUserData['profile_pic']) ? asset($toUserData['profile_pic']) : asset('asset/noimage_person.png');
                    if (isset($toUserData['fullname'])) $toUserName = $toUserData['fullname'];
                    if (isset($toUserData['token'])) $toUserToken = $toUserData['token'];
                    if (isset($toUserData['email'])) $toUserEmail = $toUserData['email'];
                    
                    $message = new Messages();
                    $message->sender_id = Auth::id();
                    $message->receiver_id = intval($posts['to_user_id']);
                    $message->message = "Hello! our profiles have been connected";
                    $message->save();

                    $fromUserData = User::select('token', 'fullname', 'profile_pic', 'created_at', 'email')->whereIn('id', array(Auth::id()))->first();
                    if (isset($fromUserData['profile_pic'])) $fromUserPicture = ($fromUserData['profile_pic']) ? asset($fromUserData['profile_pic']) : asset('asset/noimage_person.png');
                    if (isset($fromUserData['fullname'])) $fromUserName = $fromUserData['fullname'];
                    if (isset($fromUserData['token'])) $fromUserToken = $fromUserData['token'];
                    if (isset($fromUserData['email'])) $fromUserEmail = $fromUserData['email'];
                    
                    $message = new Messages();
                    $message->sender_id = intval($posts['to_user_id']);
                    $message->receiver_id = Auth::id();
                    $message->message = "Hello! our profiles have been connected";
                    $message->save();
                    
                    $set = array('email' => $toUserEmail, 'name' => $toUserName, 'token' => $toUserToken);
                    echo Mail::send('email.connected', $set, function($msg)use($set) {
                        $msg->to('admin@connecteonetwork.com')->subject('You have a new connection from ConnectEO!');
                        $msg->from('admin@connecteonetwork.com', 'You have a new connection from ConnectEO!');
                    });
                    
                    $set = array('email' => $fromUserEmail, 'name' => $fromUserName, 'token' => $fromUserToken);
                    echo Mail::send('email.connected', $set, function($msg)use($set) {
                        $msg->to('admin@connecteonetwork.com')->subject('You have a new connection from ConnectEO!');
                        $msg->from('admin@connecteonetwork.com', 'You have a new connection from ConnectEO!');
                    });
                
                }
                
                return response()->json(
                    array (
                        'status' => 'success',
                        'count' => $totalConnCount,
                        'isConnected' => $isConnected,
                        'fromUserPicture' => $fromUserPicture,
                        'fromUserName' => $fromUserName,
                        'fromUserToken' => $fromUserToken,
                        'toUserPicture' => $toUserPicture,
                        'toUserName' => $toUserName,
                        'toUserToken' => $toUserToken,
                        'user_id' => Auth::id(),
                        'to_user_id' => intval($posts['to_user_id'])
                    )
                );
            }
        }
    }

    public function userProfileSession(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            session()->put('user_review_ids', $request['types']);
            return response()->json(['id' => $request['id']]);
        }
    }

    public function createProject(Request $request) {
        if (request()->isMethod('post')) {

            $data = $request->post();
            $loggedInUser = Auth::id();
            $user_data = User::where("token", $data['token'])->first();
        
            // insert if doesn't exist yet
            $projectConnection = Project::where([
                "to_user_id" => Auth::id(),
                "from_user_id" => $user_data['id']
            ])->get();

            $projectConnection1 = Project::where([
                "to_user_id" => $user_data['id'],
                "from_user_id" => Auth::id()
            ])->get();

            if ($projectConnection->isEmpty() && $projectConnection1->isEmpty()) {
                $project = new Project();
                $project->to_user_id = $user_data['id'];
                $project->from_user_id = Auth::id();
                $project->created_at = now();
                $project->save();
            }
            return redirect()->route('project', $project->id);
        }
    }

    public function userProfile($id) {
        if (request()->isMethod('get')) {
        
            $user_data = User::where("token", $id)->first();
            
            if (!empty($user_data)) {
                $userData = User::where('id', $user_data->id)->first();
                $connection = UserReviews::where([
                            'user_id' => Auth::id(),
                            'to_user_id' => $userData['id']
                        ])->first();
                        
                $connectionReceived = UserReviews::where([
                            'user_id' => $userData['id'],
                            'to_user_id' => Auth::id()
                        ])->first();
                        
                // Rating
                $userRating = UserRating::select('rating', "comment")
                                ->where('user_id', Auth::id())
                                ->where('to_user_id', $user_data->id)->first();

                // Overall user Rating
                $overallUserRatings = UserRating::select('user_id','rating', 'comment')->where('to_user_id', $user_data->id)->get();

                // calculate the overall score
                $numberOfStars = 0;
                $numberOfReviews = 0;
                foreach ($overallUserRatings as $rating) {            
                    $userRatingData = User::where('id', $rating->user_id)->first();
                    $rating->userThatRated = $userRatingData;
                    $numberOfReviews++;
                    $numberOfStars = $numberOfStars + $rating->rating;
                }
                $overallRatingScore = 0;
                if (!empty($numberOfStars) && !empty($numberOfReviews)) $overallRatingScore = ceil($numberOfStars/$numberOfReviews);
                
                // Matched                 
                $auth = Auth::id();
                $userConnected = UserReviews::select('*')
                        ->where('user_id', Auth::id())
                        ->where('to_user_id', $user_data->id)
                        ->Orwhere(function($query) use ($user_data, $auth) {
                            $query->where('user_id', $user_data->id)
                            ->where('to_user_id', $auth);
                        })
                        ->count();
                        
                // UserSurvey                           
                $userSurvey = UserSurvey::select('page_id', 'answer', 'other')->where('user_id', $user_data->id)->get();
                $business = [];
                $is_exist = array();
                $pro_is_exist = array();
                $services_category = [];
                $serviceIndustry = [];
                $productIndustry = [];
                $productCategory = [];
                $product_services_category = [];
                if (isset($userSurvey) && $userSurvey != '') {
                    foreach ($userSurvey as $key => $data) {
                        $key = $data['page_id'];
                        if (isset($data['page_id']) && $data['page_id'] == 'pageForObtainBusiness') {
                            $business[$key]['page_name'] = $data['page_id'];
                            $business[$key]['other'] = $data['other'];
                            $answer = json_decode($data['answer'], true);
                            if (isset($answer['category']) && $answer['category'] != "") {
                                foreach ($answer['category'] as $sub => $obt) {
                                    $ObtServices = ServiceCategory::where('id', $obt)->first();
                                    $business[$key]['obtain_cat_name'][] = $ObtServices->name;
                                    if (isset($answer['sub_category']) && $answer['sub_category'] != "") {
                                        $ObtSubCat = ServiceSubCategory::where('id', $answer['sub_category'][$sub])->first();
                                    }
                                }
                            }
                        } elseif (isset($data['page_id']) && $data['page_id'] == 'page_4') {
                            $business[$key]['page_name'] = $data['page_id'];
                            $business[$key]['other'] = $data['other'];
                            $answer = json_decode($data['answer'], true);
                            if (isset($answer['category']) && $answer['category'] != "") {
                                foreach ($answer['category'] as $subCat => $offer) {
                                    $servicesCat = ServiceCategory::where('id', $offer)->first();
                                    $business[$key]['service_cat_name'][] = $servicesCat->name;
                                    if (isset($answer['sub_category']) && $answer['sub_category'] != "") {
                                        $subCat = ServiceSubCategory::where('id', $answer['sub_category'][$subCat])->first();
                                    }
                                }
                            }
                        } elseif (isset($data['page_id']) && $data['page_id'] == 'page_5') {
                            $business[$key]['page_name'] = $data['page_id'];
                            $answer = json_decode($data['answer'], true);
                            $business[$key]['other'] = $data['other'];
                            if (isset($answer['category']) && $answer['category'] != "") {
                                foreach ($answer['category'] as $proSubCat => $proOffer) {
                                    $servicesCat = ServiceCategory::where('id', $proOffer)->first();
                                    $business[$key]['pro_service_cat_name'][] = $servicesCat->name;
                                    if (isset($answer['sub_category']) && $answer['sub_category'] != "") {
                                        $subCat = ServiceSubCategory::where('id', $answer['sub_category'][$proSubCat])->first();
                                    }
                                }
                            }
                        }
                    }
                }

                // insert if doesn't exist yet
                $projectConnection = Project::where([
                    "to_user_id" => Auth::id(),
                    "from_user_id" => $userData['id']
                ])->first();

                $projectConnection1 = Project::where([
                    "to_user_id" => $userData['id'],
                    "from_user_id" => Auth::id()
                ])->first();

                $projectId = false;
                if (isset($projectConnection->id)) $projectId = $projectConnection->id;
                if (isset($projectConnection1->id)) $projectId = $projectConnection1->id;
                return view('user_profile')->with([
                            'currentUserId' => Auth::id(),
                            'userData' => $userData,
                            'connection' => $connection,
                            'business' => $business,
                            'userRating' => $userRating,
                            'userConnected' => $userConnected,
                            'overallUserRatings' => $overallUserRatings,
                            'overallRatingScore' => $overallRatingScore,
                            'projectId' => $projectId
                ]);
            } else {
                return redirect()->back()->with("error", "User details temporarily unavailable. Please check later.");
            }
        }
    }

    public function subscription() {
        $userPayment = User::where('id', Auth::id())->first();
        if (!empty($userPayment)) {
            $userPayment = $userPayment['subscription_type'];
        } else {
            $userPayment = [];
        }
        return view('subscription')->with('userPayment', $userPayment);
    }

    public function payment(Request $request) {
        if (request()->isMethod('post')) {
            $posts = request()->post();
            $amount = str_replace('$', '', $posts['pay_price']);
            Stripe::setApiKey("sk_test_iD5YyczVNSQV6lWxWgocQPGw007M3PMj9I");
            $create_customer = Customer::create([
                        "description" => Auth::user()->email,
                        "source" => $posts['card_token'] // obtained with Stripe.js
            ]);

            if ($posts['selected_plan'] == 2) {
                $type = 'Premium';
            } elseif ($posts['selected_plan'] == 3) {
                $type = 'Platinum';
            }

            $customer_id = Customer::retrieve($create_customer->id);
            $charge = Charge::create([
                        'amount' => $amount * 100,
                        'currency' => 'usd',
                        'customer' => $customer_id,
                        'description' => "Plan Purchase for " . $type,
                        'receipt_email' => Auth::user()->email,
            ]);

            if (!empty($charge['customer'])) {
                $payment = new UserPayments();
                $payment->user_id = Auth::id();
                $payment->stripe_charge = (isset($charge['id']) ? $charge['id'] : '');
                $payment->stripe_transaction = (isset($charge['balance_transaction']) ? $charge['balance_transaction'] : '');
                $payment->stripe_customer = (isset($charge['customer']) ? $charge['customer'] : '');
                $payment->amount = (isset($charge['amount']) ? $charge['amount'] : '');
                $payment->stripe_payment_status = (isset($charge['status']) ? $charge['status'] : '');
                $payment->receipt_url = (isset($charge['receipt_url']) ? $charge['receipt_url'] : '');
                $payment->country = (isset($charge['payment_method_details']['card']['country']) ? $charge['payment_method_details']['card']['country'] : '');
                $payment->exp_month = (isset($charge['payment_method_details']['card']['exp_month']) ? $charge['payment_method_details']['card']['exp_month'] : '');
                $payment->exp_year = (isset($charge['payment_method_details']['card']['exp_year']) ? $charge['payment_method_details']['card']['exp_year'] : '');
                $payment->last4 = (isset($charge['payment_method_details']['card']['last4']) ? $charge['payment_method_details']['card']['last4'] : '');
                $payment->brand = (isset($charge['payment_method_details']['card']['brand']) ? $charge['payment_method_details']['card']['brand'] : '');
                $payment->type = (isset($posts['selected_plan']) ? $posts['selected_plan'] : '');
                $payment->status = 1;
                $payment->save();
                $user = User::where('id', Auth::id())->first();
                $user->subscription_type = $posts['selected_plan'];
                $user->subscription_date = null;
                $user->save();
                return redirect()->back()->with('status', 'success');
            }
        }
    }

    public function freeSubscription() {
        $user = User::where('id', Auth::id())->first();
        $user->subscription_type = 1;
        $user->save();
        return redirect('subscription');
    }

    public function connectLeads() {
    
        $connectedUser = UserReviews::select('to_user_id')->where(['review_status' => 1, 'user_id' => Auth::id()])->get();
        $userData = User::select('id', 'fullname', 'profile_pic', 'created_at')->whereIn('id', $connectedUser)->where('approval', 1)->get();        
        $allConn = $this->reviewCount();
        
        return view('connect_leads', [
            'userData' => $userData,
            'userConnectForCollboration' => count($allConn[0]),
            'userConnectForObtain' => count($allConn[1]),
            'userConnectForProvide' => count($allConn[2])
        ]);
    }

    public function collaborationMatches() {
        $userOff = UserReviewDetail::select('*')
                ->with('userReview.user')
                ->where([
                    'type' => 'collaboration',
                    'user_id' => Auth::id()
                ])
                ->join('users', 'users.id', '=', 'to_user_id')
                ->where('users.approval', 1)
                ->orderBy('user_review_details.id', 'desc')
                ->get();
        $data = $usersForObtainServices = array();
        foreach ($userOff as $key => $data) {
            if (isset($data->userReview['user']['id'])) {
                $key = $data->userReview['user']['id'];
                $auth = Auth::id();
                $usersForObtainServices[$key]['connection'] = UserReviews::select('*')
                        ->where('user_id', Auth::id())
                        ->where('to_user_id', $key)
                        ->Orwhere(function($query) use ($key, $auth) {
                            $query->where('user_id', $key)
                            ->where('to_user_id', $auth);
                        })
                        
                        ->count();
                $usersForObtainServices[$key]['id'] = $key;
                $usersForObtainServices[$key]['category_id'][] = $data['category_id'];
                $usersForObtainServices[$key]['sub_category_id'][] = $data['sub_category_id'];
                $usersForObtainServices[$key]['token'] = (($data->userReview['user']['token']) ? $data->userReview['user']['token'] : $data->userReview['user']['id']);
                $usersForObtainServices[$key]['fullname'] = $data->userReview['user']['fullname'];
                $usersForObtainServices[$key]['company_name'] = $data->userReview['user']['company_name'];
                $usersForObtainServices[$key]['username'] = $data->userReview['user']['username'];
                $usersForObtainServices[$key]['email'] = $data->userReview['user']['email'];
                $usersForObtainServices[$key]['mobile_number'] = $data->userReview['user']['mobile_number'];
                $usersForObtainServices[$key]['type'][] = $data['type'];
                $usersForObtainServices[$key]['timing'] = Carbon::parse($data['created_at'])->diffForHumans();
                $usersForObtainServices[$key]['profile_pic'] = ($data->userReview['user']['profile_pic']) ? asset($data->userReview['user']['profile_pic']) : asset('asset/noimage_person.png');
                
                // get user addresses
                $userProfile = UserProfile::where('user_id', $key)->first();
                if (isset($userProfile['location_city']) && isset($userProfile['location_state']))$usersForObtainServices[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state'];
            }
        }
        $result = array();
        if (!empty($usersForObtainServices)) {
            foreach ($usersForObtainServices as $key => $ufos) {
                $result[$key] = $usersForObtainServices[$key];
                $c = array();
                foreach ($ufos['type'] as $k => $type) {

                    if ($type == 'obtain') $v = 'You Need Them';
                    if ($type == 'collaboration') $v = 'Collaboration Opportunity';
                    if ($type == 'provide') $v = 'They Need You';

                    if ($ufos['category_id'][$k]) {
                        $cat = ServiceCategory::select('name')->where('id', $ufos['category_id'][$k])->first();
                        $subcat = ServiceSubCategory::select('name')->where('id', $ufos['sub_category_id'][$k])->first();

                        if (!empty($subcat['name'])) {
                            $c[$v][] = $cat['name'] . " > " . $subcat['name'];
                        } else {
                            $c[$v][] = $cat['name'];
                        }
                    }
                }
                $not_show = $this->UserNotAllowed();
                $result[$key]['relation'] = $c;
                foreach ($ufos['category_id'] as $k => $cat) {
                    if (isset($ufos['sub_category_id'][$k]) && $ufos['sub_category_id'][$k] != 0) {
                        $userOffO = UserOfferingCategories::select("*")
                                ->where('category_id', $cat)
                                ->where('sub_category_id', $ufos['sub_category_id'][$k])
                                ->with('user')
                                ->where('type', 'obtain service')
                                ->whereNotIn('user_id', $not_show)
                                ->count();
                        $result[$key]['cat_sub_ids'][$k] = $ufos['sub_category_id'][$k] . '_sub';
                    } else {
                        $userOffO = UserOfferingCategories::select("*")
                                ->where('category_id', $cat)
                                ->with('user')
                                ->where('type', '!=', 'obtain service')
                                ->whereNotIn('user_id', $not_show)
                                ->count();
                        $result[$key]['cat_sub_ids'][$k] = $cat . '_cat';
                    }
                    $result[$key]['count'][$k] = $userOffO;
                }
                foreach ($result as $key => $c) $result[$key]['total'] = array_sum($c['count']);
                foreach ($result[$key]['relation'] as $c) {
                    foreach ($c as $val) $result[$key]['cat_name'][] = $val;
                }
                foreach ($result as $key => $c) $result[$key]['total'] = array_sum($c['count']);
                $get = $result[$key]['cat_sub_ids'];
                $result[$key]['combine'] = array();
                if (isset($result[$key]['cat_name'])) $result[$key]['combine'] = array_combine($get, $result[$key]['cat_name']);
            }
        }
        $dropdown = [];
        if (!empty($result)) {
            foreach ($result as $k => $val) {
                foreach ($val['combine'] as $key => $com) $dropdown[$key] = $com;
            }
        }
        return view('connection.collaboration_matches', [
            'usersForObtainServices' => $result,
            'dropdown' => $dropdown
        ]);
    }

    public function moreCollaborationMatchesSession(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            session()->put('collaboration_category_id', $request['cat']);
            session()->put('collaboration_sub_category_id', $request['subCat']);
        }
    }

    public function filterForMatchingPending(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $data = $request->post();
            exit;
        }
    }

    public function moreCollaborationMatches() {
        $d = $this->UserNotAllowed();
        $usersForCollaboration = [];
        $allIds = [];
        $allIds['category_id'] = explode(',', session()->get('collaboration_category_id'));
        $allIds['sub_category_id'] = explode(',', session()->get('collaboration_sub_category_id'));
        $user_coll = [];
        if (isset($allIds['category_id']) && $allIds['category_id'] != "") {
            foreach ($allIds['category_id'] as $key => $id) {
                if (isset($allIds['sub_category_id'][$key]) && $allIds['sub_category_id'][$key] != 0) {
                    $userCollo[] = UserOfferingCategories::select("*")
                            ->where('sub_category_id', $allIds['sub_category_id'][$key])
                            ->with('user')
                            ->where('type', '!=', 'obtain service')
                            ->whereNotIn('user_id', $d)
                            ->get();
                } else {
                    $userCollo[] = UserOfferingCategories::select("*")
                            ->where('category_id', $id)
                            ->with('user')
                            ->where('type', '!=', 'obtain service')
                            ->whereNotIn('user_id', $d)
                            ->get();
                }
            }
        }
        $data = array();
        foreach ($userCollo as $k => $data01) {
            foreach ($data01 as $key => $data) {
                if (isset($data['user'])) {
                    $key = $data['user']['id'];
                    $usersForCollaboration[$key]['id'] = $data['user']['id'];
                    $usersForCollaboration[$key]['token'] = (($data['user']['token']) ? $data['user']['token'] : $data['user']['id']);
                    $usersForCollaboration[$key]['fullname'] = $data['user']['fullname'];
                    $usersForCollaboration[$key]['company_name'] = $data['user']['company_name'];
                    $usersForCollaboration[$key]['username'] = $data['user']['username'];
                    $usersForCollaboration[$key]['email'] = $data['user']['email'];
                    $usersForCollaboration[$key]['mobile_number'] = $data['user']['mobile_number'];
                    $usersForCollaboration[$key]['profile_pic'] = ($data['user']['profile_pic']) ? asset($data['user']['profile_pic']) : asset('asset/noimage_person.png');
                    $cat = ServiceCategory::select('id', 'name')->where('id', $data['category_id'])->first();
                    $subcat = ServiceSubCategory::select('id', 'name')->where('id', $data['sub_category_id'])->first();
                    
                    // get user addresses
                    $userProfile = UserProfile::where('user_id', $data['user']['id'])->first();
                    if (isset($userProfile['location_city']) && isset($userProfile['location_state']))$usersForCollaboration[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state'];
                    
                    if (!empty($subcat['name'])) {
                        $sub_cat_id = $subcat->id;
                        $usersForCollaboration[$key]['cat_id'][$sub_cat_id] = $cat['id'];
                        $usersForCollaboration[$key]['sub_cat_id'][$sub_cat_id] = $subcat['id'];
                        $usersForCollaboration[$key]['catSubCat'][$sub_cat_id] = $cat['name'] . " > " . $subcat['name'];
                    } else {
                        $cat_id = $cat->id;
                        $usersForCollaboration[$key]['cat_id'][$cat_id] = $cat['id'];
                        $usersForCollaboration[$key]['catSubCat'][$cat_id] = $cat['name'];
                    }
                }
            }
        }

        return view('connection.more-like-this.more-collaboration-matches')->with('usersForCollaboration', $usersForCollaboration);
    }

    public function findProductServices() {
                
        $userOff = UserReviewDetail::select('*')
                ->with('userReview.user')
                ->where([ 'type' => 'obtain', 'user_id' => Auth::id()])
                ->join('users', 'users.id', '=', 'to_user_id')
                ->where('users.approval', 1)
                ->orderBy('user_review_details.id', 'desc')
                ->get();
                
        $data = $usersForObtainServices = array();
        foreach ($userOff as $key => $data) {
            if (isset($data->userReview['user']['id'])) {
                $key = $data->userReview['user']['id'];
                $auth = Auth::id();
                $usersForObtainServices[$key]['connection'] = UserReviews::select('*')
                        ->where('user_id', Auth::id())
                        ->where('to_user_id', $key)
                        ->Orwhere(function($query) use ($key, $auth) {
                            $query->where('user_id', $key)
                            ->where('to_user_id', $auth);
                        })
                        ->count();
                        
                $usersForObtainServices[$key]['id'] = $key;
                $usersForObtainServices[$key]['category_id'][] = $data['category_id'];
                $usersForObtainServices[$key]['sub_category_id'][] = $data['sub_category_id'];
                $usersForObtainServices[$key]['token'] = (($data->userReview['user']['token']) ? $data->userReview['user']['token'] : $data->userReview['user']['id']);
                $usersForObtainServices[$key]['fullname'] = $data->userReview['user']['fullname'];
                $usersForObtainServices[$key]['company_name'] = $data->userReview['user']['company_name'];
                $usersForObtainServices[$key]['username'] = $data->userReview['user']['username'];
                $usersForObtainServices[$key]['email'] = $data->userReview['user']['email'];
                $usersForObtainServices[$key]['mobile_number'] = $data->userReview['user']['mobile_number'];
                $usersForObtainServices[$key]['type'][] = $data['type'];
                $usersForObtainServices[$key]['timing'] = Carbon::parse($data['created_at'])->diffForHumans();
                $usersForObtainServices[$key]['profile_pic'] = ($data->userReview['user']['profile_pic']) ? asset($data->userReview['user']['profile_pic']) : asset('asset/noimage_person.png');                
                
                // get user addresses
                $userProfile = UserProfile::where('user_id', $key)->first();
                if (isset($userProfile['location_city']) && isset($userProfile['location_state']))$usersForObtainServices[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state'];
            }
        }
        $not_show = $this->UserNotAllowed();
        $result = array();
        if (!empty($usersForObtainServices)) {
            foreach ($usersForObtainServices as $key => $ufos) {
                $result[$key] = $usersForObtainServices[$key];
                $c = array();
                foreach ($ufos['type'] as $k => $type) {

                    if ($type == 'obtain') $v = 'You Need Them';
                    if ($type == 'collaboration') $v = 'Collaboration Opportunity';
                    if ($type == 'provide') $v = 'They Need You';

                    if ($ufos['category_id'][$k]) {
                        $cat = ServiceCategory::select('name')->where('id', $ufos['category_id'][$k])->first();
                        $subcat = ServiceSubCategory::select('name')->where('id', $ufos['sub_category_id'][$k])->first();

                        if (!empty($subcat['name'])) {
                            $c[$v][] = $cat['name'] . " > " . $subcat['name'];
                        } else {
                            $c[$v][] = $cat['name'];
                        }
                    }
                }
                $result[$key]['relation'] = $c;
                foreach ($ufos['category_id'] as $k => $cat) {
                    if (isset($ufos['sub_category_id'][$k]) && $ufos['sub_category_id'][$k] != 0) {
                        $userOffO = UserOfferingCategories::select("*")
                                ->where('category_id', $cat)
                                ->where('sub_category_id', $ufos['sub_category_id'][$k])
                                ->with('user')
                                ->where('type', '!=', 'obtain service')
                                ->whereNotIn('user_id', $not_show)
                                ->count();
                        $result[$key]['cat_sub_ids'][$k] = $ufos['sub_category_id'][$k] . '_sub';
                    } else {
                        $userOffO = UserOfferingCategories::select("*")
                                ->where('category_id', $cat)
                                ->with('user')
                                ->where('type', '!=', 'obtain service')
                                ->whereNotIn('user_id', $not_show)
                                ->count();
                        $result[$key]['cat_sub_ids'][$k] = $cat . '_cat';
                    }
                    $result[$key]['count'][$k] = $userOffO;
                }
                foreach ($result[$key]['relation'] as $c) {
                    foreach ($c as $val) $result[$key]['cat_name'][] = $val;
                }
                foreach ($result as $key => $c) {
                    $result[$key]['total'] = array_sum($c['count']);
                }
                $get = $result[$key]['cat_sub_ids'];
                $result[$key]['combine'] = array();
                if (isset($result[$key]['cat_name'])) $result[$key]['combine'] = array_combine($get, $result[$key]['cat_name']);
            }
        }
        $dropdown = [];
        if (!empty($result)) {
            foreach ($result as $k => $val) {
                foreach ($val['combine'] as $key => $com) {
                    $dropdown[$key] = $com;
                }
            }
        }        
        return view('connection.find_products_services', [
            'usersForObtainServices' => $result,
            'dropdown' => $dropdown
        ]);
    }

    public function moreObtainMatchesSession(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            session()->put('obtain_category_id', $request['cat']);
            session()->put('obtain_sub_category_id', $request['subCat']);
        }
    }

    public function moreObtainMatches(Request $request) {
        $d = $this->UserNotAllowed();
        $usersForObtainServices = [];
        $allIds = [];
        $allIds['category_id'] = explode(',', session()->get('obtain_category_id'));
        $allIds['sub_category_id'] = explode(',', session()->get('obtain_sub_category_id'));
        if (isset($allIds['category_id']) && $allIds['category_id'] != "") {
            foreach ($allIds['category_id'] as $key => $id) {
                if (isset($allIds['sub_category_id'][$key]) && $allIds['sub_category_id'][$key] != 0) {
                    $userOffering[] = UserOfferingCategories::select("*")
                            ->where('sub_category_id', $allIds['sub_category_id'][$key])
                            ->with('user')
                            ->where('type', '!=', 'obtain service')
                            ->whereNotIn('user_id', $d)
                            ->get();
                } else {
                    $userOffering[] = UserOfferingCategories::select("*")
                            ->where('category_id', $id)
                            ->with('user')
                            ->where('type', '!=', 'obtain service')
                            ->whereNotIn('user_id', $d)
                            ->get();
                }
            }
        }
        if (!empty($userOffering)) {
            foreach ($userOffering as $relation) {
                foreach ($relation as $key => $data) {
                    if (isset($data->user)) {
                        $key = $data->user->id;
                        $usersForObtainServices[$key]['id'] = $key;
                        $usersForObtainServices[$key]['token'] = (($data->user['token']) ? $data->user['token'] : $data->user['id']);
                        $usersForObtainServices[$key]['fullname'] = $data->user['fullname'];
                        $usersForObtainServices[$key]['company_name'] = $data->user['company_name'];
                        $usersForObtainServices[$key]['username'] = $data->user['username'];
                        $usersForObtainServices[$key]['email'] = $data->user['email'];
                        $usersForObtainServices[$key]['mobile_number'] = $data->user['mobile_number'];
                        $usersForObtainServices[$key]['type'] = $data['type'];
                        $usersForObtainServices[$key]['timing'] = Carbon::parse($data['created_at'])->diffForHumans();
                        $usersForObtainServices[$key]['profile_pic'] = !empty($data->user['profile_pic']) ? asset($data->user['profile_pic']) : asset('asset/noimage_person.png');
                        $cat = ServiceCategory::select('id', 'name')->where('id', $data['category_id'])->first();
                        $subcat = ServiceSubCategory::select('id', 'name')->where('id', $data['sub_category_id'])->first();
                        
                        // get user addresses
                        $userProfile = UserProfile::where('user_id', $key)->first();
                        if (isset($userProfile['location_city']) && isset($userProfile['location_state']))$usersForObtainServices[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state'];                
                        
                        if (!empty($subcat['name'])) {
                            $sub_cat_id = $subcat->id;
                            $usersForObtainServices[$key]['cat_id'][$sub_cat_id] = $cat['id'];
                            $usersForObtainServices[$key]['sub_cat_id'][$sub_cat_id] = $subcat['id'];
                            $usersForObtainServices[$key]['catSubCat'][$sub_cat_id] = $cat['name'] . " > " . $subcat['name'];
                        } else {
                            $cat_id = $cat->id;
                            $usersForObtainServices[$key]['cat_id'][$cat_id] = $cat['id'];
                            $usersForObtainServices[$key]['catSubCat'][$cat_id] = $cat['name'];
                        }
                    }
                    
                }
            }
        }
        return view('connection.more-like-this.more-obtain-matches', ['usersForObtainServices' => $usersForObtainServices]);
    }

    public function provideProductServices() {
        $not_show = $this->UserNotAllowed();
        if (isset($offset) && $offset != "") {
            $offset = $offset['offset'];
        } else {
            $offset = 0;
        }
        $limit = 12;
         
        $userOff = UserReviewDetail::select('*')
                ->with('userReview.user')
                ->where(['type' => 'provide', 'user_id' => Auth::id()])
                ->join('users', 'users.id', '=', 'to_user_id')
                ->where('users.approval', 1)
                ->orderBy('user_review_details.id', 'desc')
                ->get();
                
        $data = $usersForObtainServices = array();
        foreach ($userOff as $key => $data) {
            if (isset($data->userReview['user']['id'])) {
                $key = $data->userReview['user']['id'];
                $auth = Auth::id();
                $usersForObtainServices[$key]['connection'] = UserReviews::select('*')
                        ->where('user_id', Auth::id())
                        ->where('to_user_id', $key)
                        ->Orwhere(function($query) use ($key, $auth) {
                            $query->where('user_id', $key)
                            ->where('to_user_id', $auth);
                        })
                        ->count();
                $usersForObtainServices[$key]['id'] = $key;
                $usersForObtainServices[$key]['category_id'][] = $data['category_id'];
                $usersForObtainServices[$key]['sub_category_id'][] = $data['sub_category_id'];
                $usersForObtainServices[$key]['token'] = (($data->userReview['user']['token']) ? $data->userReview['user']['token'] : $data->userReview['user']['id']);
                $usersForObtainServices[$key]['fullname'] = $data->userReview['user']['fullname'];
                $usersForObtainServices[$key]['company_name'] = $data->userReview['user']['company_name'];
                $usersForObtainServices[$key]['username'] = $data->userReview['user']['username'];
                $usersForObtainServices[$key]['email'] = $data->userReview['user']['email'];
                $usersForObtainServices[$key]['mobile_number'] = $data->userReview['user']['mobile_number'];
                $usersForObtainServices[$key]['type'][] = $data['type'];
                $usersForObtainServices[$key]['timing'] = Carbon::parse($data['created_at'])->diffForHumans();
                $usersForObtainServices[$key]['profile_pic'] = ($data->userReview['user']['profile_pic']) ? asset($data->userReview['user']['profile_pic']) : asset('asset/noimage_person.png');
                
                // get user addresses
                $userProfile = UserProfile::where('user_id', $key)->first();
                if (isset($userProfile['location_city']) && isset($userProfile['location_state']))$usersForObtainServices[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state'];
            }
        }
        $result = array();
        if (!empty($usersForObtainServices)) {
            foreach ($usersForObtainServices as $key => $ufos) {
                $result[$key] = $usersForObtainServices[$key];
                $c = array();
                foreach ($ufos['type'] as $k => $type) {

                    if ($type == 'obtain') $v = 'You Need Them';
                    if ($type == 'collaboration') $v = 'Collaboration Opportunity';
                    if ($type == 'provide') $v = 'They Need You';

                    if ($ufos['category_id'][$k]) {
                        $cat = ServiceCategory::select('name')->where('id', $ufos['category_id'][$k])->first();
                        $subcat = ServiceSubCategory::select('name')->where('id', $ufos['sub_category_id'][$k])->first();

                        if (!empty($subcat['name'])) {
                            $c[$v][] = $cat['name'] . " > " . $subcat['name'];
                        } else {
                            $c[$v][] = $cat['name'];
                        }
                    }
                }
                $result[$key]['relation'] = $c;
                foreach ($ufos['category_id'] as $k => $cat) {
                    if (isset($ufos['sub_category_id'][$k]) && $ufos['sub_category_id'][$k] != 0) {
                        $userOffO = UserOfferingCategories::select("*")
                                ->where('category_id', $cat)
                                ->where('sub_category_id', $ufos['sub_category_id'][$k])
                                ->with('user')
                                ->where('type', 'obtain service')
                                ->whereNotIn('user_id', $not_show)
                                ->count();
                        $result[$key]['cat_sub_ids'][$k] = $ufos['sub_category_id'][$k] . '_sub';
                    } else {
                        $userOffO = UserOfferingCategories::select("*")
                                ->where('category_id', $cat)
                                ->with('user')
                                ->where('type', 'obtain service')
                                ->whereNotIn('user_id', $not_show)
                                ->count();
                        $result[$key]['cat_sub_ids'][$k] = $cat . '_cat';
                    }
                    $result[$key]['count'][$k] = $userOffO;
                }
                foreach ($result as $key => $c) $result[$key]['total'] = array_sum($c['count']);
                foreach ($result[$key]['relation'] as $c) {
                    foreach ($c as $val) $result[$key]['cat_name'][] = $val;
                }
                foreach ($result as $key => $c) {
                    $result[$key]['total'] = array_sum($c['count']);
                }
                $get = $result[$key]['cat_sub_ids'];
                $result[$key]['combine'] = array();
                if (isset($result[$key]['cat_name'])) $result[$key]['combine'] = array_combine($get, $result[$key]['cat_name']);
            }
        }
        $dropdown = [];
        if (!empty($result)) {
            foreach ($result as $k => $val) {
                foreach ($val['combine'] as $key => $com) $dropdown[$key] = $com;
            }
        }
        return view('connection.provide_services_products', [
            'usersForObtainServices' => $result,
            'dropdown' => $dropdown
        ]);
    }

    public function moreProvideMatchesSession(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            session()->put('provide_category_id', $request['cat']);
            session()->put('provide_sub_category_id', $request['subCat']);
        }
    }

    public function moreProvideMatches(Request $request) {
        $d = $this->UserNotAllowed();
        $usersForProvideServices = [];
        $allIds = [];
        $allIds['category_id'] = explode(',', session()->get('provide_category_id'));
        $allIds['sub_category_id'] = explode(',', session()->get('provide_sub_category_id'));
        if (isset($allIds['category_id']) && $allIds['category_id'] != "") {
            foreach ($allIds['category_id'] as $key => $id) {
                if (isset($allIds['sub_category_id'][$key]) && $allIds['sub_category_id'][$key] != 0) {
                    $userProviding[] = UserOfferingCategories::select("*")
                            ->where('sub_category_id', $allIds['sub_category_id'][$key])
                            ->with('user')
                            ->where('type', '=', 'obtain service')
                            ->whereNotIn('user_id', $d)
                            ->get();
                } else {
                    $userProviding[] = UserOfferingCategories::select("*")
                            ->where('category_id', $id)
                            ->with('user')
                            ->where('type', '=', 'obtain service')
                            ->whereNotIn('user_id', $d)
                            ->get();
                }
            }
        }
        if (!empty($userProviding)) {
            foreach ($userProviding as $relation) {
                foreach ($relation as $key => $data) {
                    if (isset($data->user->id)) {
                        $key = $data->user->id;
                        $usersForProvideServices[$key]['id'] = $key;
                        $usersForProvideServices[$key]['token'] = (($data->user['token']) ? $data->user['token'] : $data->user['id']);
                        $usersForProvideServices[$key]['fullname'] = $data->user['fullname'];
                        $usersForProvideServices[$key]['company_name'] = $data->user['company_name'];
                        $usersForProvideServices[$key]['username'] = $data->user['username'];
                        $usersForProvideServices[$key]['email'] = $data->user['email'];
                        $usersForProvideServices[$key]['mobile_number'] = $data->user['mobile_number'];
                        $usersForProvideServices[$key]['type'] = $data['type'];
                        $usersForProvideServices[$key]['timing'] = Carbon::parse($data['created_at'])->diffForHumans();
                        $usersForProvideServices[$key]['profile_pic'] = ($data->user['profile_pic']) ? asset($data->user['profile_pic']) : asset('asset/noimage_person.png');
                        
                        // get user addresses
                        $userProfile = UserProfile::where('user_id', $key)->first();
                        if (isset($userProfile['location_city']) && isset($userProfile['location_state']))$usersForProvideServices[$key]['location_address'] = $userProfile['location_city'] . ', ' . $userProfile['location_state'];
                        
                        $cat = ServiceCategory::select('id', 'name')->where('id', $data['category_id'])->first();
                        $subcat = ServiceSubCategory::select('id', 'name')->where('id', $data['sub_category_id'])->first();
                        if (!empty($subcat['name'])) {
                            $sub_cat_id = $subcat->id;
                            $usersForProvideServices[$key]['cat_id'][$sub_cat_id] = $cat['id'];
                            $usersForProvideServices[$key]['sub_cat_id'][$sub_cat_id] = $subcat['id'];
                            $usersForProvideServices[$key]['catSubCat'][$sub_cat_id] = $cat['name'] . " > " . $subcat['name'];
                        } else {                    
                            $cat_id = $cat->id;
                            $usersForProvideServices[$key]['cat_id'][$cat_id] = $cat['id'];
                            $usersForProvideServices[$key]['sub_cat_id'][] = isset($subcat['id']) ? $subcat['id'] : "";
                            $usersForProvideServices[$key]['catSubCat'][$cat_id] = $cat['name'];
                        }
                    }
                }
            }
        }
        return view('connection.more-like-this.more-provide-matches')->with('usersForProvideServices', $usersForProvideServices);
    }

    public function myProfile() {
        $userSurvey = UserSurvey::where(['user_id' => Auth::id()])
                        ->whereIn('page_id', ['page_3', 'pageForObtainBusiness', 'page_6'])->get();
        $business = [];
        if (isset($userSurvey) && $userSurvey != '') {
            $is_exist = array();
            $service_cat1 = [];
            foreach ($userSurvey as $k => $data) {
                $k = $data['page_id'];
                if (isset($data['page_id']) && $data['page_id'] == 'page_3') {
                    $business[$k]['page_name'] = $data['page_id'];
                    $answer = json_decode($data['answer'], true);
                    $business[$k]['answer'] = $answer;
                } elseif (isset($data['page_id']) && $data['page_id'] == 'pageForObtainBusiness') {
                    $business[$k]['page_name'] = $data['page_id'];
                    $answer = json_decode($data['answer'], true);
                    $business[$k]['answer'] = $answer;
                    $business[$k]['other'] = $data['other'];
                    if (isset($answer['category']) && $answer['category'] != "") {
                        foreach ($answer['category'] as $key => $Cat) {
                            $service_cat1 = ServiceCategory::where('id', $Cat)->first();
                            $is_exist[$key]['cat_name'] = $service_cat1['name'];
                            if (isset($answer['sub_category'][$key]) && $answer['sub_category'][$key] != "") {
                                $service_sub_cat2 = ServiceSubCategory::where('id', $answer['sub_category'][$key])->first();
                                $is_exist[$key]['sub_cat_name'] = $service_sub_cat2['name'];
                                $is_exist[$key]['sub_cat_id'] = $service_sub_cat2['id'];
                            }
                        }
                    }
                } elseif (isset($data['page_id']) && $data['page_id'] == 'page_6') {
                    $business[$k]['page_name'] = $data['page_id'];
                    $answer = json_decode($data['answer'], true);
                    $business[$k]['answer'] = $answer;
                }
            }
        }
        $userData = User::where('id', Auth::user()->id)->with('userProfile')->first();

        return view('users.my_profile', [
            'userData' => $userData,
            'is_exist' => $is_exist,
            'business' => $business
        ]);
    }

    public function editProfile(Request $request, $token) {
        $userData = User::where('token', $token)->with('userProfile')->first();
        return view('users.edit_profile', ['userData' => $userData]);
    }

    public function updateUserProfile(Request $request) {
    
        if (request()->isMethod('post')) {
            $posts = request()->post();
            if (!empty($posts)) {
                $errors = '';
                $userUpdate = User::where('id', Auth::id())->first();
                $userEmailCheck = User::where('email', $posts['email'])->first();
                if (isset($userUpdate->id) && isset($userEmailCheck->id)) {
                    if ($userUpdate->id != $userEmailCheck->id) $errors = 'email-in-use';
                }
                if (empty($errors)) $userUpdate->email = $posts['email'];
                
                $userUpdate->fullname = $posts['fullname'];
                $userUpdate->mobile_number = $posts['contact'];
                $userUpdate->company_name = $posts['company_name'];
                $userUpdate->website_url = $posts['website_url'];
                $userUpdate->description = trim($posts['description']);
                $userUpdate->save();
                $userProfile = UserProfile::where('user_id', Auth::id())->first();
                if (!empty($userProfile)) {
                    $userProfile->location_address1 = $posts['address'];
                    $userProfile->location_country = $posts['country'];
                    $userProfile->location_state = $posts['state'];
                    $userProfile->location_city = $posts['city'];
                    $userProfile->location_zipcode = $posts['zipcode'];
                    $userProfile->save();
                } else {
                    $profile = new UserProfile();
                    $profile->user_id = Auth::id();
                    $profile->location_address1 = $posts['address'];
                    $profile->location_country = $posts['country'];
                    $profile->location_state = $posts['state'];
                    $profile->location_city = $posts['city'];
                    $profile->location_zipcode = $posts['zipcode'];
                    $profile->save();
                }
            }
            return redirect('my-profile?msg='.$errors);
        }
    }

    public function businessProfile() {
        $userSurvey = UserSurvey::where(['user_id' => Auth::id()])->whereIn('page_id', ['page_4', 'page_5'])->get();
        $business = [];

        if (isset($userSurvey) && $userSurvey != '') {
            $is_exist = array();
            $is_exist_pro = array();
            $service_cat1 = [];
            $service_sub_cat2 = array();
            $productCategory = [];
            $productIndustry = [];
            $coolServeiceIndustry = [];
            foreach ($userSurvey as $key_id => $data) {
                $key_id = $data["page_id"];
                if (isset($data['page_id']) && $data['page_id'] == 'page_4') {
                    $business[$key_id]['page_name'] = $data['page_id'];
                    $answer = json_decode($data['answer'], true);
                    $business[$key_id]['other'] = $data['other'];
                    $business[$key_id]['answer'] = $answer;
                    $business[$key_id]['category_description'] = $answer['answer'];
                    if (!empty($answer['category'])) {
                        foreach ($answer['category'] as $key => $val) {
                            $cat = ServiceCategory::select('*')->where('id', $val)->first();
                            $is_exist[$key]['cat_name'] = $cat['name'];
                            $is_exist[$key]['cat_id'] = $cat['id'];
                            if (isset($answer['sub_category'][$key]) && $answer['sub_category'][$key] != "") {
                                $sub = ServiceSubCategory::select('*')->where('id', $answer['sub_category'][$key])->first();
                                $is_exist[$key]['sub_cat_name'] = $sub['name'];
                                $is_exist[$key]['sub_cat_id'] = $sub['id'];
                            } else {
                                $is_exist[$key]['sub_cat_name'] = "";
                                $is_exist[$key]['sub_cat_id'] = "";
                            }
                        }
                    }
                    if (isset($answer['industry']) && $answer['industry'] != "") {
                        $catData = $answer['industry'];
                        $coolServeiceIndustry = Industry::whereIn('id', $catData)->get();
                    }
                } elseif (isset($data['page_id']) && $data['page_id'] == 'page_5') {
                    $business[$key_id]['page_name'] = $data['page_id'];
                    $business[$key_id]['other'] = $data['other'];
                    $answer = json_decode($data['answer'], true);
                    $business[$key_id]['answer'] = $answer;
                    $business[$key_id]['description'] = (isset($answer['answer']) ? $answer['answer'] : '');
                    if (isset($answer['industry']) && $answer['industry'] != "") $productIndustry = Industry::whereIn('id', $answer['industry'])->get();
                    if (isset($answer['type_of_product']) && $answer['type_of_product'] != "") $productCategory = ProductCategory::whereIn('id', $answer['type_of_product'])->get();
                    if (!empty($answer['category'])) {
                        foreach ($answer['category'] as $key => $val) {
                            $cat = ServiceCategory::select('*')->where('id', $val)->first();
                            $is_exist_pro[$key]['cat_name'] = $cat['name'];
                            $is_exist_pro[$key]['cat_id'] = $cat['id'];
                            if (isset($answer['sub_category'][$key]) && $answer['sub_category'][$key] != "") {
                                $sub = ServiceSubCategory::select('*')->where('id', $answer['sub_category'][$key])->first();
                                $is_exist_pro[$key]['sub_cat_name'] = $sub['name'];
                                $is_exist_pro[$key]['sub_cat_id'] = $sub['id'];
                            } else {
                                $is_exist_pro[$key]['sub_cat_name'] = "";
                                $is_exist_pro[$key]['sub_cat_id'] = "";
                            }
                        }
                    }
                }
            }
        }
        return view('business.business-profile', [
            'userSurvey' => $userSurvey,
            'is_exist' => $is_exist,
            'is_exist_pro' => $is_exist_pro,
            'service_cat1' => $service_cat1,
            'service_sub_cat2' => $service_sub_cat2,
            'business' => $business,
            'productCategory' => $productCategory,
            'productIndustry' => $productIndustry,
            'coolServeiceIndustry' => $coolServeiceIndustry
        ]);
    }

    public function editBusinessProfile() {
        $data = User::where('id', Auth::id())->with('userBusiness')->first();
        return view('business.edit-business-profile', ['data' => $data]);
    }

    public function updateBusiness(Request $request) {
        if (request()->isMethod('post')) {
            $posts = request()->post();
            if (!empty($posts)) {
                $user = BusinessProfile::where('user_id', Auth::id())->first();
                if (!empty($user)) {
                    $user->business_name = $posts['business_name'];
                    $user->address = $posts['business_address'];
                    $user->save();
                } else {
                    $business = new BusinessProfile();
                    $business->user_id = Auth::id();
                    $business->business_name = $posts['business_name'];
                    $business->address = $posts['business_address'];
                    $business->save();
                }
                return redirect('business-profile');
            }
        }
    }

    public function editSurvey() {
        $userSurvey = UserSurvey::select('*')->where('user_id', Auth::id())->get();
        $survey = [];
        $answer = [];
        $i = 0;

        if (!empty($userSurvey)) {
            $coolServeiceIndustry = [];
            $is_exist = array();
            $service_cat1 = [];
            $productIndustry = [];
            $service_sub_cat2 = array();
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
                        $service_cat1 = ServiceCategory::whereIn('id', $category['category'])->get();
                    } else {
                        $service_cat1 = [];
                    }
                    if (isset($category['sub_category']) && $category['sub_category'] != "") {
                        $service_sub_cat2 = ServiceSubCategory::whereIn('id', $category['sub_category'])->get();
                    } else {
                        $service_sub_cat2 = array();
                    }
                } elseif ($user['page_id'] == "page_4") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $category = json_decode($user['answer'], true);
                    if (isset($category['industry']) && $category['industry'] != "") {
                        $coolServeiceIndustry = Industry::whereIn('id', $category['industry'])->get();
                    } else {
                        $coolServeiceIndustry = [];
                    }
                    if (!empty($category['category'])) {
                        foreach ($category['category'] as $key => $val) {
                            $cat = ServiceCategory::select('*')->where('id', $val)->first();
                            $is_exist[$key]['cat_name'] = $cat['name'];
                            $is_exist[$key]['cat_id'] = $cat['id'];
                            if (isset($category['sub_category'][$key]) && $category['sub_category'][$key] != "") {
                                $sub = ServiceSubCategory::select('*')->where('id', $category['sub_category'][$key])->first();
                                $is_exist[$key]['sub_cat_name'] = $sub['name'];
                                $is_exist[$key]['sub_cat_id'] = $sub['id'];
                            } else {
                                $is_exist[$key]['sub_cat_name'] = "";
                                $is_exist[$key]['sub_cat_id'] = "";
                            }
                        }
                    }
                    $survey[$i]['description'] = $category;
                } elseif ($user['page_id'] == "page_5") {
                    $survey[$i]['page_name'] = $user['page_id'];
                    $survey[$i]['skip'] = $user['skip'];
                    $decode = json_decode($user['answer'], true);
                    if (isset($decode['type_of_product']) && $decode['type_of_product'] != "") {
                        $productCategory = ProductCategory::whereIn('id', $decode['type_of_product'])->get();
                    }
                    if (isset($decode['industry']) && $decode['industry'] != "") {
                        $productIndustry = Industry::whereIn('id', $decode['industry'])->get();
                    }
                    $survey[$i]['answer'] = $decode;
                    $survey[$i]['productCategory'] = isset($productCategory['name']) ? $productCategory['name'] : "";
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
        return view('users.edit-survey', [
            'coolServeiceIndustry' => $coolServeiceIndustry,
            'productIndustry' => $productIndustry,
            'userSurvey' => $survey,
            'service_cat' => $is_exist,
            'service_cat1' => $service_cat1,
            'service_sub_cat2' => $service_sub_cat2,
            'productCategory' => $productCategory,
            'productIndustry' => $productIndustry
        ]);
    }

    public function userRatings() {
        $userRating = UserRating::select('*')->where('to_user_id', Auth::id())->orderby('id', 'desc')->get();
        return view('user_ratings', ['userRating' => $userRating]);
    }

    public function updateCompanyName(Request $request) {
        if (!empty($request['company_name'])) {
            $userUpdate = User::where('id', Auth::id())->first();
            $userUpdate->company_name = $request['company_name'];
            $userUpdate->save();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
    public function managePromo() {
        $get = MangePromo::where('user_id', Auth::id())->first();
        return view('manage-promo')->with('get', $get);
    }

    public function addMangePromoUrl(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->post();
            if (!empty($data)) {
                $exists = MangePromo::where('user_id', Auth::id())->exists();
                if ($exists > 0) {
                    MangePromo::where('user_id', Auth::id())->update(['url' => $data['url']]);
                } else {
                    MangePromo::create([
                        'user_id' => Auth::id(),
                        'image' => '/promo/mange_promo.jpg',
                        'url' => $data['url']
                    ]);
                }
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }
    }

    public function sendForApprovalPromo(Request $request) {
        if ($request->isMethod('get')) {
            MangePromo::where('user_id', Auth::id())->update(['status' => 1]);
            return redirect()->back();
        }
    }

    public function removePromoImage(Request $request) {
        if ($request->isMethod('get')) {
            MangePromo::where('user_id', Auth::id())->update(['image' => '']);
            return redirect()->back();
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
