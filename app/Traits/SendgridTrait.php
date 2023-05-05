<?php namespace App\Traits;

use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Arr;
use Ixudra\Curl\CurlService;
use SendGrid\Mail\Mail;
use App\Traits\AzureKeyVaultTrait;

trait SendgridTrait {

	private static $logapi = true;
	// HELPER FUNCTIONS

	public static function doLog() {
		return self::$logapi;
	}

	public static function sendEmail($options) {

		$sendgrid_api_key = env('SENDGRID_API_KEY');

		//GET CURRENT YEAR
		$currentYear = date("Y");

		//GET WEBSITE
		$website  = config('constants.website');

		//GET BASE URL
		$baseUrl = url('/');

		//CREATE SENDGRID EMAIL OBJECT
        $email = new Mail();

		//GET SUBJECT WITHOUT EMAIL TEMPLATE
		$subject = Arr::get($options, 'subject');

		//SET IF SUBJECT IS NOT EMPTY
		if(!empty($subject)) {

			$email->setSubject($subject);

		}

		//GET RECIVER DATA
		$toData = Arr::get($options, 'to', []);
		loginfo($toData);
		//CHECK RECIVER DATA EMPTY OR NOT
		if(!empty($toData)) {

			$toEmail = $toData['to_email'];
			$toName  = $toData['to_name'];

			//CHECK RECIVER EMAIL IS EMPTY OR NOT
			if(empty($toEmail)){
				loginfo('RECIVER EMAIL IS EMPTY');
			}

			if(empty($toName)) {
				loginfo('RECIVER NAME IS EMPTY');
			}

			$email->addTo($toEmail, $toName);

		}
		else {
			loginfo('RECIVER DATA IS EMPTY');
		}

		//GET EMAIL TEMPLATEID
		$templateid = Arr::get($options, 'templateid');

		//SET TEMPLATEID
		if(!empty($templateid)) {

		    $email->setTemplateId($templateid);
		}
		else {
			$body = Arr::get($options, 'body');
			$email->addContent($body);

		}

		//GET SENER DATA
		$fromData = Arr::get($options, 'from', []);

		//CHECK SENDER DATA IS EMPTY OT NOT
		if(empty($fromData['from_email']) && empty($fromData['from_name'])){


			$fromEmail 	 = config('constants.adminemail');
			$fromName    = config('constants.adminname');

			//SET SENDER EMAIL AND NAME
			$email->setFrom($fromEmail, $fromName);
		}
		else {

			$fromEmail 	 = $fromData['from_email'];
			$fromName    = $fromData['from_name'];

			//SET SENDER EMAIL AND NAME
			$email->setFrom($fromEmail, $fromName);
		}

		$email->addDynamicTemplateData("copyright_year", $currentYear);
        $email->addDynamicTemplateData("base_url", $baseUrl);
        $email->addDynamicTemplateData("website", $website);

        //GET DYMNAIC DATA FOR REPLACE IN EMAIL TEMPLATE
		$data = Arr::get($options, 'data', []);

		if(!empty($data)) {
			$email->addDynamicTemplateDatas($data);
		}

		//GET SENDGRID API TOKEN FROM ENV FILE
        $sendgrid = new \SendGrid($sendgrid_api_key);

        //EXCEPTTION HANDLING
        try {
            //EMAIL SENDING
            $response = $sendgrid->send($email);


        } catch (Exception $e) {

        	$response = $e->getMessage();
        }

		if(self::doLog()) {
			$log['FUNCTION'] = 'sendEmail';
			$log['FUNCTION PARAMETERS'] = $email;
			$log['API RESPONSE CONTENT'] = $response;

			loginfo($log);
		}

		return $response;

	}
}