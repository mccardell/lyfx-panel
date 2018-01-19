<?php

namespace App\Helpers;

use DrewM\MailChimp\MailChimp;
use DrewM\MailChimp\Batch;
use App\Newsletter;
use App\Consumers;
use DateTime;

class MailchimpHelper{
	const API_KEY = '7b93bc5f0949f6b55b068e419471928c-us16';
	const LISTS = [
		'subscribers' => '52a77450ef',
		'newsletter' => 'ef9323608d'
	];

	public function submit($list, $data){
		$api = new MailChimp(self::API_KEY);
		$batchApi = $api->new_batch();

		$listId = self::LISTS[$list];

		foreach( $data as $entry ){
			$batchApi->post('id-'.rand(), 'lists/'.$listId.'/members', $entry);
		}

		$batchApi->execute();
	}

	public function submitConsumers(){
		$items = [];
		$itemsData = Consumers::whereNotNull('email')->orWhereNotNull('emailField')->get();

		foreach( $itemsData as $item ){
			$_item = [
				'email_address' => NULL,
				'status' => 'subscribed',
				'merge_fields' => [
					'EMAIL' => NULL,
					'FNAME' => NULL,
					'LNAME' => NULL,
					'PHONE' => NULL,
					'CITY'  => NULL,
					'STATE' => NULL,
					'ZIPCODE' => NULL
				]
			];

			// Email
			if( isset($item->email) && !empty($item->email) ){
				$_item['email_address'] = $item->email;
				$_item['merge_fields']['EMAIL'] = $item->email;
			}elseif( isset($item->emailField) && !empty($item->emailField) ){
				$_item['email_address'] = $item->emailField;
				$_item['merge_fields']['EMAIL'] = $item->emailField;
			}

			// Firstname
			if( isset($item->firstName) && !empty($item->firstName) ){
				$_item['merge_fields']['FNAME'] = $item->firstName;
			}elseif( isset($item->firstNameField) && !empty($item->firstNameField) ){
				$_item['merge_fields']['FNAME'] = $item->firstNameField;
			}

			// Lastname
			if( isset($item->lastName) && !empty($item->lastName) ){
				$_item['merge_fields']['LNAME'] = $item->lastName;
			}elseif( isset($item->lastNameField) && !empty($item->lastNameField) ){
				$_item['merge_fields']['LNAME'] = $item->lastNameField;
			}

			// Telephone
			if( isset($item->phone) && !empty($item->phone) ){
				$_item['merge_fields']['PHONE'] = $item->phone;
			}elseif( isset($item->telField) && !empty($item->telField) ){
				$_item['merge_fields']['PHONE'] = $item->telField;
			}

			// City
			if( isset($item->city) && !empty($item->city) ){
				$_item['merge_fields']['CITY'] = $item->city;
			}elseif( isset($item->cityField) && !empty($item->cityField) ){
				$_item['merge_fields']['CITY'] = $item->cityField;
			}

			// State
			if( isset($item->state) && !empty($item->state) ){
				$_item['merge_fields']['STATE'] = $item->state;
			}elseif( isset($item->stateField) && !empty($item->stateField) ){
				$_item['merge_fields']['STATE'] = $item->stateField;
			}

			// Zipcode
			if( isset($item->zipCode) && !empty($item->zipCode) ){
				$_item['merge_fields']['ZIPCODE'] = $item->zipCode;
			}elseif( isset($item->zipCodeField) && !empty($item->zipCodeField) ){
				$_item['merge_fields']['ZIPCODE'] = $item->zipCodeField;
			}

			$items[] = $_item;
		}

		$this->submit('subscribers', $items);
	}

	public function submitNewsletter(){
		$items = [];
		foreach( Newsletter::whereNotNull('email')->orWhereNotNull('emailField')->get() as $item ){
			// if( !isset($item->email) || empty($item->email) ) continue;

			// Email
			if( isset($item->email) && !empty($item->email) ){
				$email = $item->email;
			}elseif( isset($item->emailField) && !empty($item->emailField) ){
				$email = $item->emailField;
			}

			$items[] = [
				// 'email_address' => $item->email,
				'email_address' => $email,
				'status' => 'subscribed'
			];
		}

		$this->submit('newsletter', $items);
	}

	public function pullNewsletter(){
		$items = [];
		$existingEmails = [];

		foreach( Newsletter::whereNotNull('email')->orWhereNotNull('emailField')->get() as $item ){
			// Email
			if( isset($item->email) && !empty($item->email) ){
				$email = $item->email;
			}elseif( isset($item->emailField) && !empty($item->emailField) ){
				$email = $item->emailField;
			}

			if( !in_array($email, $existingEmails) ) $existingEmails[] = $email;
		}

		$api = new MailChimp(self::API_KEY);
		$listId = self::LISTS['newsletter'];

		$response = $api->get('/lists/'.$listId.'/members?count=100');
		
		foreach( $response['members'] as $member ){
			if( in_array($member['email_address'], $existingEmails) ) continue;

			$createdAt = new \MongoDB\BSON\UTCDateTime(new DateTime($member['last_changed']));

			$items[] = [
				'email' => $member['email_address'],
				'createdAt' => $createdAt,
				'updatedAt' => $createdAt
			];
		}

		if( count($items) > 0 ) Newsletter::insert($items);
	}

	public function pullConsumers(){
		$items = [];
		$existingEmails = [];

		foreach( Consumers::whereNotNull('email')->orWhereNotNull('emailField')->get() as $item ){
			// Email
			if( isset($item->email) && !empty($item->email) ){
				$email = $item->email;
			}elseif( isset($item->emailField) && !empty($item->emailField) ){
				$email = $item->emailField;
			}

			if( !in_array($email, $existingEmails) ) $existingEmails[] = $email;
		}

		$api = new MailChimp(self::API_KEY);
		$listId = self::LISTS['subscribers'];

		$response = $api->get('/lists/'.$listId.'/members?count=1000');
		
		foreach( $response['members'] as $member ){
			// var_dump($member);
			// var_dump(new DateTime($member['last_changed']));
			// break;
			// if( in_array($member['email_address'], $existingEmails) ) continue;

			$createdAt = new \MongoDB\BSON\UTCDateTime(new DateTime($member['last_changed']));
			// var_dump($createdAt);
			// break;

			/*$items[] = [
				'firstNameField' => $member['merge_fields']['FNAME'],
				'lastNameField' => $member['merge_fields']['LNAME'],
				'emailField' => $member['email_address'],
				'zipCodeField' => $member['merge_fields']['ZIPCODE'],
				'cityField' => $member['merge_fields']['CITY'],
				'stateField' => $member['merge_fields']['STATE'],
				'telField' => $member['merge_fields']['PHONE'],
				'createdAt' => $createdAt,
				'updatedAt' => $createdAt
			];*/
			// break;

			$consumer = Consumers::where('emailField', $member['email_address'])->orWhere('email', $member['email_address'])->first();
			if( empty($consumer) ) continue;
			if( $consumer->createdAt->toDateTime() > new DateTime('2017-12-01 00:00:00') ) continue;

			// var_dump($consumer->createdAt->toDateTime());
			// var_dump($consumer->createdAt->toDateTime() > new DateTime('2017-12-01 00:00:00'));
			// break;
			// if( empty($consumer) ) continue;

			// var_dump($consumer);
			$consumer->createdAt = $createdAt;
			// $consumer->updateAt = $createdAt;
			$consumer->save();
			// break;
		}

		// var_dump($items);
		// if( count($items) > 0 ) Consumers::insert($items);
		exit;
	}
}