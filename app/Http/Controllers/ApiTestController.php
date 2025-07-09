<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\FPSHelper;

class ApiTestController extends Controller
{
    protected $fps;

    public function __construct(FPSHelper $fps)
    {
    	$this->fps = $fps;
    }

    public function index()
    {
        $response = [];
    	//$response = $this->fps->api_status();
        $login_response = $this->fps->login();
        if($login_response != null && $login_response->status == true ){

    	    $response = $this->fps->nid_verification(['token' => $login_response->result->token,'NID'=>'2694803582593', 'DOB' => '1986-01-01']);

            //$response = $this->fps->get_miller(['token' => $login_response->result->token,'NID'=>'1234567891012']);

            /*$response = $this->fps->add_miller(['NID'=>'11000000000000010',"Name_Bangla"=>"1",
            "Name_English"=>"1",
            "Mother_Name"=>"1",
            "Father_Name"=>"1",
            "Gender"=>"male",
            "DOB"=>"1990-10-01",
            "Permanent_Address"=>"1",
            "Current_Address"=>"1",
            "Status"=>"active"]);*/

            /*$response = $this->fps->update_miller(['NID'=>'11000000000000010',"Name_Bangla"=>"1",
            "Name_English"=>"1",
            "Mother_Name"=>"1",
            "Father_Name"=>"1",
            "Gender"=>"male",
            "DOB"=>"1990-10-01",
            "Permanent_Address"=>"1",
            "Current_Address"=>"1",
            "Status"=>"active"]);*/

            //$response = $this->fps->get_mill(['token' => $login_response->result->token,'License'=>'121312']);

            /*$response = $this->fps->add_mill(['NID'=>'11000000000000010',"Name"=>"1",
            "Address"=>"1",
            "District"=>"Dhaka",
            "Upazila"=>"Savar",
            "Mill_Type"=>"Automatic",
            "Capacity"=>"100",
            "License"=>"100001",
            "Issue_Date"=>"2020-09-01",
            "Renew_Date"=>"2020-10-01",
            "Status"=>"active",
            "Rice_Type"=>"white",
            "Mobile"=>"01911323656",
            "Meter"=>"123",
            "Remark"=>"ok"]);*/

            /*$response = $this->fps->update_mill(['NID'=>'11000000000000010',"Name"=>"1",
            "Address"=>"1",
            "District"=>"Dhaka",
            "Upazila"=>"Savar",
            "Mill_Type"=>"Automatic",
            "Capacity"=>"100",
            "License"=>"100001",
            "Issue_Date"=>"2020-09-01",
            "Renew_Date"=>"2020-10-01",
            "Status"=>"active",
            "Rice_Type"=>"white",
            "Mobile"=>"01911323656",
            "Meter"=>"123",
            "Remark"=>"ok"]);*/
        }
        else
            $response = ["API Login Failed."];

    	return json_encode($response);
    }

}
