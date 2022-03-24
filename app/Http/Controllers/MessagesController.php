<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users\User;
use App\Models\Messages;
use App\Models\Notification;
use App\Models\Node;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Slug;
use Mail;

class MessagesController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function messages($searchId) {
        $user = User::select()->where('id', $searchId)->first();
        return view('messages.messages', ['user' => $user]);
    }

    //////////////chat History
    public function chatHistory(Request $request) {
        if ($request->isMethod('post') && $request->ajax()) {
            $posts = $request->post();

            $senderUserId = User::select()->where('id', Auth::id())->first();
            $receiverUserId = User::select()->where('id', $posts['receiver_id'])->first();

            $messages = array();
            $i = 0;
            $history = Messages::select()
                            ->whereIn('sender_id', [$senderUserId->id, '||', $receiverUserId->id])
                            ->whereIn('receiver_id', [$senderUserId->id, '||', $receiverUserId->id])
                            ->get()->toArray();

            foreach ($history as $msg) {
                $readStatus = Messages::where('id', $msg['id'])->first();
                if ($msg['receiver_id'] == Auth::id()) {
                    $readStatus->read = 1;
                }
                $readStatus->save();
                
                if (!empty($msg['message'])) {
                    $messages[$i]['message_id'] = $msg['id'];
                    $messages[$i]['sender_id'] = $msg['sender_id'];
                    $messages[$i]['receiver_id'] = $msg['receiver_id'];
                    $messages[$i]['message'] = $msg['message'];
                    $messages[$i]['created_at'] = Carbon::parse($msg['created_at'])->diffForHumans();
                    $messages[$i]['timing'] = Carbon::parse($msg['created_at'])->format('g:i A');
                }   
                $i++;
            }
            return response()->json(array('status' => 'success', 'message' => 'Successfully', 'data' => $messages));
        }
    }

    // sendMessage
    public function sendMessage(Request $request) {
        if ($request->isMethod('post') && $request->ajax()) {
            $posts = $request->post();
            $senderUserId = User::select()->where('id', Auth::id())->first();
            $receiverUserId = User::select()->where('id', $posts['receiver_id'])->first();
            if (!empty($senderUserId['id'] && $receiverUserId['id']) && !empty($posts['message'])) {
                $messeges = new Messages();
                $messeges->sender_id = $senderUserId['id'];
                $messeges->receiver_id = $receiverUserId['id'];
                $messeges->message = $posts['message'];
                $messeges->save();
                $userPic = isset($senderUserId['profile_pic']) ? asset($senderUserId['profile_pic']) : asset('asset/noimage_person.png');
                $html = '  <div class="dropdown-item preview-item">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="preview-thumbnail">
                                            <img src="' . $userPic . '" alt="image" class="profile-pic" style="width: 35px;height: 35px;border-radius: 50%;">
                                        </div>                              
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="preview-item-content flex-grow w-100">                                                      
                                            <h6 class="preview-subject ellipsis font-weight-medium text-dark text-capitalize mb-0" style="font-size: 14px;font-weight: 700;">' . $senderUserId['fullname'] . '
                                                <span class="float-right small-text" style="color:#000;font-size:10px;font-weight: 500;">Just now</span>
                                            </h6> 
                                            <p>' . $posts['message'] . '</p>
                                        </div>
                                    </div>
                                </div>
                            </div>';

                $messeges['timing'] = Carbon::parse($messeges['created_at'])->format('g:i A');
                return response()->json(array('status' => 'success', 'message' => 'Successfully', 'chat' => $messeges));
            }
        }
    }

    public function inbox() {
        $history = Messages::select()
                ->where('receiver_id', [Auth::id()])
                ->whereOr('sender_id', [Auth::id()])
                ->with('getReceiverData')
                ->with('getSenderData')
                ->get();
        $supportUser = [];
        $all = Messages::where('receiver_id', Auth::user()->id)
                ->get()
                ->pluck('sender_id')
                ->toArray();
        $unique = array_unique($all);
        $inbox = array();
        $k = 0;

        if (!empty($unique)) {
            foreach ($unique as $msg) {
                $data = Messages::where(['receiver_id' => Auth::user()->id, 'sender_id' => $msg])
                        ->orderBy('id', 'desc')
                        ->with('getSenderData')
                        ->first();
                $inbox[$k]['message_id'] = '';
                $inbox[$k]['message'] = $data['message'];
                $inbox[$k]['message_time'] = $data['created_at']->diffForHumans();
                $inbox[$k]['name'] = isset($data->getSenderData['fullname']) ? $data->getSenderData['fullname'] : "Name";
                $inbox[$k]['image'] = isset($data->getSenderData['profile_pic']) ? $data->getSenderData['profile_pic'] : "asset/noimage_person.png";
                $inbox[$k]['sender_id'] = isset($data->getSenderData['id']) ? $data->getSenderData['id'] : "0";
                $k++;
            }
        }
        return view('messages.inbox', ['history' => $history, 'inbox' => $inbox, 'supportUser' => $supportUser]);
    }

}
