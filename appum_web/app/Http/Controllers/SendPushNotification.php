<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transporter;
use Exception;
use Log;
use Setting;
use App\Notification;
use PushNotification;
use App\Shop;

/*use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use App\Notifications\WebPush;*/
class SendPushNotification extends Controller
{
	

    /**
     * Money added to user wallet.
     *
     * @return void
     */
    public function WalletMoney($user_id, $money){

        Log::info($user_id);

        return $this->sendPushToUser($user_id, $money.' '.trans('form.push.added_money_to_wallet'));
    }

    /**
     * Money charged from user wallet.
     *
     * @return void
     */
    public function ChargedWalletMoney($user_id, $money){

        return $this->sendPushToUser($user_id, $money.' '.trans('form.push.charged_from_wallet'));
    }

    /**
     * Sending Push to a user Device.
     *
     * @return void
     */
    public function sendPushToUser($user_id, $push_message,$page = null){

    	try{

	    	$user = User::findOrFail($user_id);
                Notification::create([
                    'user_id' => $user_id,
                    'message' => $push_message
                ]);
            $message = \PushNotification::Message($push_message,array(
                'badge' => 1,
                'sound' => 'example.aiff',
                
                'actionLocKey' => 'Action button title!',
                'locKey' => 'localized key',
                'locArgs' => array(
                    'localized args',
                    'localized args',
                ),
                'launchImage' => 'image.jpg',
                
                'custom' => array('custom data' => array(
                    $page
                ))
            ));
            if($user->device_token != ""){

                \Log::info($page);
    	    	if($user->device_type == 'ios'){

    	    		return \PushNotification::app('IOSUser')
    		            ->to($user->device_token)
    		            ->send($message);

    	    	}elseif($user->device_type == 'android'){
    	    		
    	    		return \PushNotification::app('AndroidUser')
    		            ->to($user->device_token)
    		            ->send($push_message);

    	    	}
            }

    	} catch(Exception $e){
    		return $e;
    	}

    }

     /**
     * Sending Push to a user Device.
     *
     * @return void
     */
    public function sendPushToShop($user_id, $push_message,$page = null){

        try{

            $user = Shop::findOrFail($user_id);
                Notification::create([
                    'user_id' => $user_id,
                    'message' => $push_message
                ]);
            $message = PushNotification::Message($push_message,array(
                'badge' => 1,
                'sound' => 'example.aiff',
                
                'actionLocKey' => 'Action button title!',
                'locKey' => 'localized key',
                'locArgs' => array(
                    'localized args',
                    'localized args',
                ),
                'launchImage' => 'image.jpg',
                
                'custom' => array('custom data' => array(
                    $page
                ))
            ));
            if($user->device_token != ""){

                \Log::info('sending push for user : '. $user->name);
                if($user->device_type == 'ios'){

                    return PushNotification::app('IOSShop')
                        ->to($user->device_token)
                        ->send($message);

                }elseif($user->device_type == 'android'){
                    
                    return PushNotification::app('AndroidUser')
                        ->to($user->device_token)
                        ->send($message);

                }
            }

        } catch(Exception $e){
            return $e;
        }

    }

    /**
     * Sending Push to a user Device.
     *
     * @return void
     */
    public function sendPushToProvider($provider_id, $push_message,$page){

    	try{

	    	$provider = Transporter::findOrFail($provider_id);
                Notification::create([
                    'transporter_id' => $provider_id,
                    'message' => $push_message
                ]);

            $message = PushNotification::Message($push_message,array(
                'badge' => 1,
                'sound' => 'example.aiff',
                
                'actionLocKey' => 'Action button title!',
                'locKey' => 'localized key',
                'locArgs' => array(
                    'localized args',
                    'localized args',
                ),
                'launchImage' => 'image.jpg',
                
                'custom' => array('custom data' => array(
                    $page
                ))
            ));
            if($provider->device_token != ""){
                
                \Log::info('sending push for provider : '. $provider->name);

            	if($provider->device_type == 'ios'){

            		return \PushNotification::app('IOSProvider')
        	            ->to($provider->device_token)
        	            ->send($message);

            	}elseif($provider->device_type == 'android'){
            		
            		return \PushNotification::app('AndroidUser')
        	            ->to($provider->device_token)
        	            ->send($message);

            	}
            }

    	} catch(Exception $e){
    		return $e;
    	}

    }

}
