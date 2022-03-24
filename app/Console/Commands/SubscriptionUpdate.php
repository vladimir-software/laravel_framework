<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Users\User;
use Carbon\Carbon;
use Mail;

class SubscriptionUpdate extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        try {
            $updateSubsC = User::select('id', 'email', 'fullname', 'token')->whereDate('subscription_date', '>', Carbon::now())->get();
            if (!empty($updateSubsC)) {
                foreach ($updateSubsC as $user) {
                    try {
                        User::where('id', $user->id)->update(['subscription_type' => 1, 'subscription_date' => null]);
                        $set = array('email' => $user->email, 'name' => $user->fullname, 'token' => $user->token, 'url' => route('subscription'));
                        echo Mail::send('email.update_subscription', $set, function($msg)use($set) {
                            $msg->to($set['email'])->subject
                                    ('Your Premium Subscription has Expired');
                            $msg->from('admin@connecteonetwork.com', 'ConnectEO Network');
                        });
                    } catch (\Exception $ex) {
                        exit;
                    }
                }
            }
        } catch (\Exception $ex) {
            exit;
        }
    }

}
