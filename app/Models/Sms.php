<?php

namespace App\Models;


use App\Http\Requests\SmsRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

use SMSApi\Client;
use SMSApi\Api\SmsFactory;
use SMSApi\Proxy\Http\Native;
use SMSApi\Exception\SmsapiException;




class Sms extends Model
{
     protected $fillable = [
         'text' => 'text',
         'phone' => 'phone'
     ];

    /**
     * @param SmsRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function sendSms(SmsRequest $request)
    {

        $client = Client::createFromToken(Config::get('smsConfig.token'));

        $proxy = new Native('https://api2.smsapi.pl'); // zapasowy serwer

        $smsapi = new SmsFactory($proxy);
        $smsapi->setClient($client);
        try {
            $actionSend = $smsapi->actionSend();

            $actionSend->setTo($request->get('phone'));
            $actionSend->setText($request->get('text'));
            $actionSend->setSender('Info');

            foreach ($actionSend->execute()->getList() as $status) {
                echo $status->getNumber() . ' ' . $status->getPoints() . ' ' . $status->getStatus();
            }
        } catch (SmsapiException $exception) {

            return redirect('admin/sms')->withErrors([$exception->getMessage()]);
        }
        return redirect('admin/sms')->with('status', 'Sms Send!');
    }


    public function getPrefix()
    {
        return new Prefix();
    }

}
