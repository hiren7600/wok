<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder {

	public function run()
	{

		$items = [
			[
				'user_id' 		=> 1,
				'usertype' 		=> 1,
				'issuperadmin' 	=> 1,
				'email' 		=> 'admin@admin.com',
				'password'  	=> '$2y$10$xuOdtgvXw1jeBDBrqOyZxOH4UXVeOOdY/Lo84n/1Rjtj1n./iGdrO', // 123
				'firstname'		=> 'Admin',
				'lastname'		=> 'Admin',
				'phoneno' 		=> '898989898',
				'status'    	=> 1
			]
		];

		foreach($items as $item) {

			$user_id			= $item['user_id'];
			$email			= $item['email'];
			$usertype		= $item['usertype'];
			$issuperadmin	= $item['issuperadmin'];
			$password		= $item['password'];
			$firstname		= $item['firstname'];
			$lastname		= $item['lastname'];
			$phoneno		= $item['phoneno'];
			$status 		= $item['status'];

			$dbitem = User::where([
				'user_id' => $user_id
			])->first();
			if(empty($dbitem)) {
				$dbitem 		= new User();
			}

			$dbitem->user_id 		= $user_id;
			$dbitem->email 			= $email;
			$dbitem->usertype 		= $usertype;
			$dbitem->issuperadmin 	= $issuperadmin;
			$dbitem->password 		= $password;
			$dbitem->firstname 		= $firstname;
			$dbitem->lastname 		= $lastname;
			$dbitem->phoneno 		= $phoneno;
			$dbitem->status 		= $status;

			$dbitem->save();
		}

	}

}