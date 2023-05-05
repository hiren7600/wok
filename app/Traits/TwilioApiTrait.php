<?php namespace App\Traits;

use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Arr;
use Ixudra\Curl\CurlService;
use App\Traits\AzureKeyVaultTrait;

trait TwilioApiTrait {

	private static $logapi = true;
	// HELPER FUNCTIONS
	public static function getAuthorizationHeader() {

		env('TWILIO_API_ENDPOINT');
		
		

        $twilio_account_sid = env('TWILIO_ACCOUNT_SID');;
        $twilio_auth_token = env('TWILIO_AUTH_TOKEN');

		$basicauthdata = base64_encode($twilio_account_sid.':'.$twilio_auth_token);
		return  "Authorization: Basic ".$basicauthdata;
	}

	public static function getEndpoint() {
		$endpoint 	= env('TWILIO_API_ENDPOINT');

		return $endpoint;
	}

	public static function doLog() {
		return self::$logapi;
	}

	public static function callApi($options) {

		// SET CURL WITH AUTHORIZATION
		$authheader = self::getAuthorizationHeader();
		$endpoint  = self::getEndpoint();

		// dd($authheader);

		$dataGet = Arr::get($options, 'data', []);

		$headers = Arr::get($options, 'headers', []);

        $from 		= env('TWILIO_PHONE');
        $to   		= $dataGet['To']; // twilio trial verified number
        $body 		= $dataGet['Body'];

        
    	$data = array (
            'From' => $from,
            'To' => $to,
            'Body' => $body
        );
        

        $post = http_build_query($data);

        $curl = curl_init($endpoint);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [$authheader]);

        $response = curl_exec($curl);

        curl_close($curl);


		$log = [];
		if(self::doLog()) {
			$log['FUNCTION'] = 'callApi';
			$log['FUNCTION PARAMETERS'] = $post;
			$log['API RESPONSE CONTENT'] = $response;
			/*$log['LAST ACTIVITY TIME'] = session('lastActivityTime');*/
			loginfo($log);
		}

		return $response;

	}

	public static function getLookupEndpoint($number) {
		$endpoint 	= 'https://lookups.twilio.com/v2/PhoneNumbers/'.$number.'?Fields=line_type_intelligence';

		return $endpoint;
	}

	public static function LookupApi($number) {

		// SET CURL WITH AUTHORIZATION
		$authheader = self::getAuthorizationHeader();
		$endpoint  = self::getLookupEndpoint($number);

		// // dd($authheader);

		// $dataGet = Arr::get($options, 'data', []);

		// $headers = Arr::get($options, 'headers', []);

  //       $from 		= env('TWILIO_PHONE');
  //       $to   		= $dataGet['To']; // twilio trial verified number
  //       $body 		= $dataGet['Body'];

        
  //   	$data = array (
  //           'From' => $from,
  //           'To' => $to,
  //           'Body' => $body
  //       );
        

        // $post = http_build_query($data);

        $curl = curl_init($endpoint);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [$authheader]);

        $response = curl_exec($curl);

        curl_close($curl);


		$log = [];
		if(self::doLog()) {
			$log['FUNCTION'] = 'callApi';
			//$log['FUNCTION PARAMETERS'] = $post;
			$log['API RESPONSE CONTENT'] = $response;
			/*$log['LAST ACTIVITY TIME'] = session('lastActivityTime');*/
			loginfo($log);
		}

		return $response;

	}


}