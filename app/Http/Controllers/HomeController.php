<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\StoreVideo;
use App\Models\UserPayments;
use App\Models\Users\User;
use App\Models\Slug;
use Stripe\Charge;
use App\Models\UserSurvey;
use App\Models\Pages;
use App\Models\ContactUs;
use App\Models\UserReviews;
use App\Models\Messages;
use App\Models\ManageHome;
use App\Models\FacebookLogin;
use App\Models\Project;
use App\Models\ProjectTasks;
use App\Models\ProjectDetails;
use App\Models\ProjectEdits;
use Carbon\Carbon;
use Mail;
use Hash;
use Session;
use Stripe\Customer;
use Stripe\Token;
use Stripe\Stripe;
use Stripe\Error\Base as StripeException;
use Facebook\Facebook;

class HomeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function addvideo(Request $request)
    {

        if ($files = $request->file('video')) {
            $destinationPath = 'asset/user_profile/'; // upload path
            $profilefile = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profilefile);


            StoreVideo::insert([
                'title'=>$request->title,
                'description'=>$request->description,
                'video'=>$profilefile
            ]);
         }
        return redirect()->back();
    }

    public function updatevideo(Request $request)
    {

        if ($files = $request->file('video')) {
            unlink(public_path('asset/user_profile').'/'.$request->filename);
            $destinationPath = 'asset/user_profile/'; // upload path
            $profilefile = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profilefile);
            StoreVideo::where('id',$request->id)->update([
                'title'=>$request->title,
                'description'=>$request->description,
                'video'=>$profilefile
            ]);
        }
         else
         {
            StoreVideo::where('id',$request->id)->update([
                'title'=>$request->title,
                'description'=>$request->description
            ]);
         }
        return redirect()->back();
    }

    public function removevideo(Request $request)
    {
        unlink(public_path('asset/user_profile').'/'.$request->filename);
        StoreVideo::where('id',$request->id)->delete();
        return redirect()->back();
    }

    public function index() {
        $matrix = ManageHome::select('home_status')->where('id', 1)->first();
        return view('index', ['matrix' => $matrix]);
    }

    public function sidenav() {
        return view('test-sidenav');
    }

    public function mainPage() {
        return view('main-page');
    }

    public function pricing() {
        return view('side_menu_items.pricing');
    }

    public function howToConnect() {
        return view('side_menu_items.how_to_connect');
    }

    public function contactUs() {
        return view('side_menu_items.contact_us');
    }

    /**
     * private videos page
     */
    public function videos() {

        $videodata = StoreVideo::orderBy('id','desc')->paginate(5);
        return view('videos')->with('videodata',$videodata);
    }

    public function submitContactUs(Request $request) {
        if ($request->isMethod('post')) {
            $posts = $request->post();

            // Verify captcha
            $post_data = http_build_query(
                array(
                    'secret' => '6LfWuc8ZAAAAAJtDkdReDdjtcXRPg9SeYSdH34Bd',
                    'response' => $_POST['g-recaptcha-response'],
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                )
            );
            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $post_data
                )
            );
            $context  = stream_context_create($opts);
            $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
            $result = json_decode($response);
            if (!$result->success) return redirect()->back()->withErrors(['Could not verify that you are a human, please try again.']);

            if (!empty($posts)) {
                $contact = new ContactUs();
                $contact->firstname = $posts['name'];
                $contact->lastname = $posts['surname'];
                $contact->email = $posts['email'];
                $contact->mobile_number = $posts['phone'];
                $contact->message = $posts['message'];
                $contact->forget_hash = Slug::generate();
                $contact->save();

                $set = array('email' => $contact->email, 'name' => $contact->firstname, 'token' => $contact->forget_hash);
                echo Mail::send('email.contact-us-email', $set, function($msg)use($set) {
                    $msg->to('admin@connecteonetwork.com')->subject('New Contact Submission from ConnectEO');
                    $msg->from('admin@connecteonetwork.com', 'ConnectEO Network');
                });
                return redirect()->back()->with('success', 'Message has been sent. You will hear back from a ConnectEO Network representative shortly.');
            }
        }
    }

    public function login() {
        session_start();
        $fb = new Facebook([
            'app_id' => '425719181652515',
            'app_secret' => 'bcb58a9e5fcc421a9fbdacdc79df4b8f',
            'default_graph_version' => 'v3.2',
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'public_profile'];
        $loginUrl = $helper->getLoginUrl(route('checkIsFB'), $permissions);

        if (Auth::check()) {
            return redirect('business');
        } else {
            return view('registration.login', ['loginUrl' => $loginUrl]);
        }
    }

    public function checkIsFB() {
        session_start();
        $fb = new Facebook([
            'app_id' => '425719181652515',
            'app_secret' => 'bcb58a9e5fcc421a9fbdacdc79df4b8f',
            'default_graph_version' => 'v3.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId('425719181652515'); // Replace {app-id} with your app id

        // If you know the user ID this access token belongs to, you can validate it here
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }

            echo '<h3>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;
        return redirect('facebook-login');
    }

    public function facebookLogin() {
        session_start();
        $fb = new Facebook([
            'app_id' => '425719181652515', // Replace {app-id} with your app id
            'app_secret' => 'bcb58a9e5fcc421a9fbdacdc79df4b8f',
            'default_graph_version' => 'v3.2',
        ]);

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name,email,picture,birthday,gender,location', $_SESSION['fb_access_token']);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $fb_user_data = $response->getGraphUser();
        $data = User::where(['email' => $fb_user_data['email']])->first();
        if (!empty($data)) {
            $id = User::select('id')->where(['facebook_id' => $fb_user_data['id']])->first();
            $id->facebook_id = isset($fb_user_data['id']) ? $fb_user_data['id'] : "";
            $id->save();
            Auth::loginUsingId($id['id']);
            return redirect('survey');
        } else {
            return view('registration.facebook-login', ['fb_user_data' => $fb_user_data]);
        }
    }

    public function signup() {
        session_start();
        $fb = new Facebook([
            'app_id' => '425719181652515', // Replace {app-id} with your app id
            'app_secret' => 'bcb58a9e5fcc421a9fbdacdc79df4b8f',
            'default_graph_version' => 'v3.2',
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'public_profile']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(route('checkIsFB'), $permissions);
        if (Auth::check()) {
            return redirect('business');
        } else {
            return view('registration.sign_up', ['loginUrl' => $loginUrl]);
        }
    }

    public function facebookSignup(Request $request) {
        if ($request->isMethod('post')) {
            $posts = $request->post();
            $UserRegister = new User();
            $findEmail = User::where('email', $posts['email'])->exists();
            if (!empty($findEmail)) {
                return redirect()->back()->with('Email already exists');
                exit;
            }
            $UserRegister->fullname = $posts['fullname'];
            $UserRegister->email = $posts['email'];
            $UserRegister->password = bcrypt($posts['email']);
            $UserRegister->account_type_id = 2;
            $UserRegister->facebook_id = $posts['facebook-id'];
            $UserRegister->subscription_type = 1;
            $UserRegister->status = 1;
            $UserRegister->token = Slug::generate();
            $UserRegister->save();
            if (!empty($UserRegister)) {
                Auth::loginUsingId($UserRegister->id);
                return redirect()->route('home');
            } else {
                return redirect()->back()->with('Email already exists');
            }
        }
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function termsOfUse() {
        return view('terms_of_use');
    }

    public function privacyPolicy() {
        return view('privacy-policy');
    }

    public function ResetPassword() {
        return view('password.reset-password');
    }

    public function passwordEmail(Request $request) {
        if ($request->isMethod('post')) {
            $posts = request()->post();
            $user = User::where('email', $posts['reset_email'])->first();
            if (empty($user)) {
                return redirect()->back()->with('error', "We can't find a user with that e-mail address.");
            } else {
                $user->forget_hash = Slug::generate();
                $user->forget_created_at = date('Y-m-d H:i:s');
                $user->save();
                $set = array('email' => $user->email, 'name' => $user->fullname, 'token' => $user->forget_hash);
                echo Mail::send('password.verify-email', $set, function($msg)use($set) {
                    $msg->to($set['email'])->subject('Change Password');
                    $msg->from('admin@connecteonetwork.com', 'ConnectEO Network');
                });
                return redirect()->back()->with('isSubmit', 'Reset password link has been sent to your email.');
            }
        }
    }

    public function showResetForm(Request $request, $token = null) {
        $user = User::select('email', 'forget_hash')->where('forget_hash', $token)->first();
        return view('password.create-new-password')->with(['user' => $user, 'token' => $token]);
    }

    public function ajaxUserSearch(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            $users = User::select('*')->where("fullname", "Like", $request['keyword'] . "%")
                    ->orWhere("email", "Like", $request['keyword'] . "%")
                    ->limit(10)
                    ->get();
            $array = array();
            foreach ($users as $key => $dt) {
                $array[$key]['user_id'] = $dt['id'];
                $array[$key]['email'] = $dt['email'];
                $array[$key]['name'] = ($dt['fullname']) ? $dt['fullname'] : "unknown";
                $array[$key]['profile_pic'] = isset($dt['profile_pic']) ? asset($dt['profile_pic']) : asset('asset/noimage_person.png');
                $array[$key]['token'] = $dt['token'];
            }
            return view('ajaxUserSearch')->with(['array' => $array]);
        }
    }

    public function projectTaskDetails(Request $request) {
        $posts = $request->post();
        $projectEdits = ProjectTasks::where([
            "project_id" => $posts['projectId'],
            "id" => $posts['id'],
        ])->first();
        return response()->json(['method' => 'details', 'status' => 'success', 'title' => $projectEdits->title, 'description' => $projectEdits->description, 'id' => $posts['id']]);
    }

    public function project(Request $request) {

        $data = array();
        $serverURI = $_SERVER['REQUEST_URI'];
        $projectId = preg_split('/\//', $serverURI);
        $projectId = array_pop($projectId);
        $data['projectId'] = $projectId;

        // make sure the user has permission to view the project by being in either party
        $posts = $request->post();
        $project = Project::where([
            "id" =>$projectId,
        ])->first();
        if (!$project) return abort(404);
        if ($project['to_user_id'] !== Auth::id() && $project['from_user_id'] !== Auth::id()) return abort(404);

        $data['myUserId'] = Auth::id();

        // get who the other party is in the project to approve oustanding edits
        $data['otherPartyUserId'] = 0;
        if ($project->to_user_id == Auth::id()) {
            $data['otherPartyUserId'] = $project->from_user_id;
        } else {
            $data['otherPartyUserId'] = $project->to_user_id;
        }

        // get account profile pictures for display
        $myAccount = User::where('id', Auth::id())->first();
        $data['my_profile_picture'] = $myAccount->profile_pic;

        $otherAccount = User::where('id', $data['otherPartyUserId'])->first();
        $data['other_profile_picture'] = $otherAccount->profile_pic;

        // get existing project data
        $project = Project::where([
            "id" => $data['projectId'],
        ])->first();

        $data['start_date'] = $project->start_date;
        $data['end_date'] = $project->end_date;
        $data['money_exchanged'] = $project->money_exchanged;
        $data['is_paid'] = $project->is_paid;
        $data['amount'] = $project->amount;
        $data['title'] = '';
        $data['description'] = '';
        $projectDetails = ProjectDetails::where([
            "project_id" =>$data['projectId'],
        ])->first();

        if ($projectDetails) {
            $data['title'] = $projectDetails->title;
            $data['description'] = $projectDetails->description;
        }

        // get any existing edits for project
        $projectEdits = ProjectEdits::where([
            "project_id" =>$data['projectId'],
        ])->get();
        $data['projectEdits'] = $projectEdits;


        // get any existing project tasks for todo lists
        $projectEdits = ProjectTasks::where([
            "project_id" =>$data['projectId'],
        ])->orderBy('priority', 'asc')->get();
        $data['projectTasks'] = $projectEdits;
        return view('project')->with(['data' => $data]);
    }

    /**
     * user approves outstanding edits to current project
     */
    public function projectApprove(Request $request) {
        $posts = $request->post();
        $this->authorizeEditProject($posts['projectId']);
        $projectEdits = ProjectEdits::where([
            "project_id" => $posts['projectId'],
            "user_id" =>  $posts['userEditId']
        ])->delete();
        return redirect()->back();
    }

    /**
     * get list of drag and drop list items from jquery draggable to save to DB
     */
    protected function parseListItems($listItems = array()) {
        $items = [];
        $listItems = preg_split('/<li/', $listItems);
        foreach ($listItems as $item) {
            $item = str_replace('>', '', strip_tags($item));
            $item = preg_replace('/\"(.*?)\"/', '', strip_tags($item));
            $item = preg_replace('/class=/', '', strip_tags($item));
            $item = preg_replace('/style=/', '', strip_tags($item));
            $items[] = trim($item);
        }
        return $items;
    }

    /**
     * update task in project to be in a certain list "todo" "finished" etc.
     */
    protected function updateListItemsStatus($projectId, $todoItemTitle, $status, $orderNumber) {
        $projectTodoTasks = ProjectTasks::where([
            "project_id" => $projectId,
            "title" => $todoItemTitle
        ])->update(['status' => $status, 'priority'=> $orderNumber]);
    }

    public function projectTaskEdit(Request $request) {
        $posts = $request->post();
        $this->authorizeEditProject($posts['projectId']);
        if ($posts['method'] == 'add') {
            $projectTasks = new ProjectTasks();
            $projectTasks->project_id = $posts['projectId'];
            $projectTasks->status = $posts['status'];
            $projectTasks->title = $posts['title'];
            $projectTasks->description = '';
            $projectTasks->save();
            return response()->json(['method' => 'add', 'status' => 'success', 'task_id' => $projectTasks->id]);
        }

        if ($posts['method'] == 'sort') {

            $todoSort = [];
            $todoOrder = 0;
            if (!empty($posts['todo'])) $todoSort = $this->parseListItems($posts['todo']);
            foreach ($todoSort as $todoItemTitle) {
                $todoOrder = $todoOrder + 1;
                if (!empty($todoItemTitle)) $this->updateListItemsStatus($posts['projectId'], $todoItemTitle, 'todo', $todoOrder);
            }

            $progressSort = [];
            $progressOrder = 0;
            if (!empty($posts['progress'])) $progressSort = $this->parseListItems($posts['progress']);
            foreach ($progressSort as $todoItemTitle) {
                $progressOrder = $progressOrder + 1;
                if (!empty($todoItemTitle)) $this->updateListItemsStatus($posts['projectId'], $todoItemTitle, 'progress', $progressOrder);
            }

            $finishedSort = [];
            $finishedOrder = 0;
            if (!empty($posts['finished'])) $finishedSort = $this->parseListItems($posts['finished']);
            foreach ($finishedSort as $todoItemTitle) {
                $finishedOrder = $finishedOrder + 1;
                if (!empty($todoItemTitle)) $this->updateListItemsStatus($posts['projectId'], $todoItemTitle, 'finished', $finishedOrder);
            }
            return response()->json(['method' => 'sort', 'status' => 'success']);
        }

        if ($posts['method'] == 'edit') {
            try {
                $projectTodoTasks = ProjectTasks::where([
                "project_id" => $posts['projectId'],
                "id" => $posts['id']
            ])->update(['title' => $posts['title'], 'description' => $posts['description']]);
            } catch (Exception $e) {
                return response()->json(['method' => 'edit', 'status' => 'error']);
            }
            return response()->json(['method' => 'edit', 'status' => 'success']);
        }

        if ($posts['method'] == 'delete') {
            $projectTodoTasks = ProjectTasks::where([
                "project_id" => $posts['projectId'],
                "id" => $posts['id']
            ])->delete();
            return response()->json(['method' => 'delete', 'status' => 'success']);
        }
    }

    public function authorizeEditProject($projectId) {
        $project = Project::where([
            "id" =>$projectId,
        ])->first();

        if ($project['to_user_id'] !== Auth::id() && $project['from_user_id'] !== Auth::id()) die('unauthorized');
    }

    public function projectEdit(Request $request) {

        $allowedFields = array('start_date', 'end_date', 'money_exchanged', 'project-title-edit', 'project-description-edit', 'is_paid', 'amount');
        if ($request->ajax() && $request->isMethod('post')) {

            // make sure the user has permission to view the project by being in either party
            $posts = $request->post();
            $this->authorizeEditProject($posts['projectId']);
            $project = Project::where([
                "id" =>$posts['projectId'],
            ])->first();

            if(isset($posts['fieldName']) && in_array($posts['fieldName'], $allowedFields)) {
                if (in_array($posts['fieldName'], array('start_date', 'end_date'))) {
                    $project->{$posts['fieldName']} = date('Y-m-d', strtotime($posts[$posts['fieldName']]));
                } elseif ($posts['fieldName'] == 'money_exchanged') {
                    $project->{$posts['fieldName']} = ($posts[$posts['fieldName']] == 'true') ? 1 : 0;
                } elseif ($posts['fieldName'] == 'is_paid') {
                    $project->{$posts['fieldName']} = ($posts[$posts['fieldName']] == 'true') ? 1 : 0;
                } elseif ($posts['fieldName'] == 'amount') {
                    $project->{$posts['fieldName']} = $posts[$posts['fieldName']];
                } elseif (in_array($posts['fieldName'], array('project-title-edit', 'project-description-edit'))) {

                    // upsert project details
                    $projectDetails = ProjectDetails::where([
                        "project_id" =>$posts['projectId'],
                    ])->first();
                    if (!$projectDetails) {
                        $projectDetails = new ProjectDetails();
                        $projectDetails->project_id = $posts['projectId'];
                        $projectDetails->save();
                        $projectDetails = ProjectDetails::where([
                            "project_id" =>$posts['projectId'],
                        ])->first();
                    }
                    $projectDetails->title = $posts['project-title-edit'];
                    $projectDetails->description = $posts['project-description-edit'];
                    $projectDetails->save();
                }
                $project->save();

                // save that there was an edit that the other user has to confirm
                $projectEdits = ProjectEdits::where([
                    "project_id" =>$posts['projectId'],
                    "user_id" => Auth::id(),
                    "field" => $posts['fieldName']
                ])->first();
                if (!$projectEdits) {
                    $projectEdits = new ProjectEdits();
                    $projectEdits->project_id = $posts['projectId'];
                    $projectEdits->user_id = Auth::id();
                    $projectEdits->field = $posts['fieldName'];
                    $projectEdits->save();
                }

                return response()->json(['status' => 'success', 'fieldName' => $posts['fieldName']]);
            }
        }
    }

    ///////////////////////// TESTING MESSAGES
    public function testing() {
        $auth = Auth::id();
        $users = Messages::select('sender_id', 'receiver_id')
                        ->where('receiver_id', [Auth::id()])
                        ->orWhere('sender_id', [Auth::id()])
                        ->groupBy('receiver_id', 'sender_id')->get();
        $user = [];
        foreach ($users as $key => $data) {
            if (!in_array($data['sender_id'], $user) || !in_array($data['receiver_id'], $user)) {
                array_push($user, $data['sender_id']);
                array_push($user, $data['receiver_id']);
            }
        }
        $userData = User::select('id')
                        ->distinct($user)
                        ->whereIn('id', $user)
                        ->whereNotIn('id', [$auth])
                        ->whereNotIn('account_type_id', [1])->get();
        $i = 0;
        $aa = [];
        foreach ($userData as $zz) {
            print_r($zz['id']);
            $allData = Messages::where(['receiver_id' => $zz['id']])
                            ->orWhere(['sender_id' => $zz['id']])
                            ->orderBy('id', 'desc')
                            ->with('getSenderData')
                            ->with('getReceiverData')->first();

            $user = User::where('id', $zz['id'])->whereNotIn('id', [$auth])->first();
            $aa[$i]['message_id'] = $allData['id'];
            $aa[$i]['message'] = $allData['message'];
            $aa[$i]['message_time'] = ($allData['created_at']->diffForHumans() ?: '');
            $aa[$i]['name'] = ($user['fullname']) ?: "Unknown";
            $aa[$i]['image'] = ($user['profile_pic']) ?: 'image';
            $aa[$i]['sender_id'] = $allData->getSenderData['id'];
            $aa[$i]['receiver_id'] = $allData->getReceiverData['id'];
            $i++;
        }
        print_r($aa);
        exit;
        $history = Messages::select()
                        ->where('receiver_id', [Auth::id()])
                        ->whereOr('sender_id', [Auth::id()])
                        ->with('getReceiverData')
                        ->with('getSenderData')->get();

        $all = Messages::where('receiver_id', Auth::user()->id)->get()->pluck('sender_id')->toArray();
        $unique = array_unique($all);
        $inbox = array();
        $k = 0;
        if (!empty($unique)) {
            foreach ($unique as $msg) {
                $data = Messages::where(['receiver_id' => Auth::user()->id, 'sender_id' => $msg])
                                ->orderBy('id', 'desc')
                                ->with('getSenderData')->first();

                $inbox[$k]['message_id'] = '';
                $inbox[$k]['message'] = $data['message'];
                $inbox[$k]['message_time'] = $data['created_at']->diffForHumans();
                $inbox[$k]['name'] = ($data->getSenderData['fullname']) ?: "Unknown";
                $inbox[$k]['image'] = $data->getSenderData['profile_pic'];
                $inbox[$k]['sender_id'] = $data->getSenderData['id'];
                $k++;
            }
        }
        return view('message_testing', ['history' => $history, 'inbox' => $inbox]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

    }

}
