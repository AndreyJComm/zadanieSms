<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SmsRequest;
use App\Models\Sms;


class SmsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SmsRequest $request)
    {
            return view('Sms.index');
    }

    public function store(SmsRequest $request)
    {
        $smsModel = new Sms();
        $response = $smsModel->sendSms($request);

        return $response;
    }

}
