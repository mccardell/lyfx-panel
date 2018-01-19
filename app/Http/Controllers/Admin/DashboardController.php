<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Consumers;
use App\Newsletter;
use App\States;
use App\Cities;
use \DateTimeZone;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends Controller
{
	public function fillConsumersAddressData(){
		$items = Consumers::whereNull('city')->whereNull('cityField')->where(function($query){
    		$query->whereNotNull('zipCodeField')
    			  ->orWhereNotNull('zipCode');
    	})->get();

    	exit;

    	foreach( $items as $item ){
    		$zipcode = NULL;
    		if( isset($item->zipCodeField) && !empty($item->zipCodeField) ){
    			$zipcode = preg_replace('/\D/', '', $item->zipCodeField);
    		}elseif( isset($item->zipCode) && !empty($item->zipCode) ){
    			$zipcode = preg_replace('/\D/', '', $item->zipCode);
    		}

    		if( empty($zipcode) ) continue;

    		$client = new \GuzzleHttp\Client();
	    	$response = $client->get('https://www.zipcodeapi.com/rest/Per6lxf5pNZExzGkTSx3CTH1OjhLMcdvMGEOY5eJmj41s9cubqjkXFzEWZGRWTVh/info.json/'.$zipcode.'/degrees');
	    	$data = json_decode($response->getBody());

	    	if( isset($data->city) && isset($data->state) ){
	    		$item->stateField = $data->state;
	    		$item->cityField = $data->city;
	    		$item->save();
	    	}
    	}
    	
    	var_dump('ok');
    	exit;
	}

    public function index(){
    	return view('backend.default.dashboard.default');
    }

    public function list(Request $request){
    	if($request['reservation']){
			$verifyDate = explode(' - ', $request['reservation']);

			$request['daterangepicker_start'] = $verifyDate[0];
			$request['daterangepicker_end'] = $verifyDate[1];
		}

    	$consumers = DashboardController::listConsumers($request);

    	// $states = States::orderBy('city','asc')->get();

    	$statesFields = Consumers::groupBy('stateField')->orderBy('stateField')->pluck('stateField')->toArray();
    	$_statesFields = Consumers::groupBy('state')->orderBy('state')->pluck('state')->toArray();
    	$states = array_unique(array_merge($statesFields, $_statesFields));
    	sort($states);
    	
    	$citiesFields = Consumers::groupBy('cityField')->orderBy('cityField')->pluck('cityField')->toArray();
    	$_citiesFields = Consumers::groupBy('city')->orderBy('city')->pluck('city')->toArray();
    	$cities = array_unique(array_merge($citiesFields, $_citiesFields));
    	sort($cities);

    	return view('backend.default.dashboard.list', compact('consumers','request','states', 'cities'));
    }

    public function loadCities($state_id){

    	if(!empty($state_id)){
    		$cities = Cities::select('city')
    						->where('state_code',$state_id)
    						->groupBy('city')
    						->orderBy('city','asc')->get();
    	}
	    return $cities;
    }

    public function deleteList(Request $request){
    	if($request['reservation']){
			$verifyDate = explode(' - ', $request['reservation']);

			$request['daterangepicker_start'] = $verifyDate[0];
			$request['daterangepicker_end'] = $verifyDate[1];
		}

    	if(!empty($request->idDelete)){
    		if($request->page == 'signup'){
    			$deleteConsumer = Consumers::where('_id',$request->idDelete)->delete();
    		}else if($request->page == 'newsletter'){
    			$deleteNewsletter = Newsletter::where('_id',$request->idDelete)->delete();
    		}
    	}

    	$consumers = DashboardController::listConsumers($request);

    	return redirect()->action('Admin\DashboardController@list',['page' => $request->page]);
    }

    public function export(Request $request){
    	if($request['reservation']){
			$verifyDate = explode(' - ', $request['reservation']);

			$request['daterangepicker_start'] = $verifyDate[0];
			$request['daterangepicker_end'] = $verifyDate[1];
		}

    	$consumers = DashboardController::listConsumers($request);

    	if( $request->page == 'signup' ){
	    	$data = [
	    		[
	    			'ID',
	    			'Name',
	    			'Email',
	    			'Zipcode',
	    			'City',
	    			'State',
	    			'Phone',
	    			'What is your passion?',
					'When did you realize you loved this?',
					'How often do you practice?',
					'Describe the adventure you want to create in a few words?',
					'How often will you take your travellers out?',
					'How many travellers can your adventure accomodate?',
					'What makes your adventure unique?',
					'Tell us about the location where your adventure will take place and what makes it special',
					'Created At'
				]
	    	];
	    	
		    foreach ($consumers as $consumer){
		    	$rowData = [];

		    	// ID
		    	$rowData[] = $consumer->id;
		    	
		    	// Name
		    	if(!empty($consumer->firstName)) $rowData[] = $consumer->firstName.' '.$consumer->lastName;
		    	elseif(!empty($consumer->firstNameField)) $rowData[] = $consumer->firstNameField.' '.$consumer->lastNameField;
		    	else $rowData[] = $consumer->MERGE1.' '.$consumer->MERGE2;

		    	// Email
		    	if(!empty($consumer->MERGE0)) $rowData[] = $consumer->MERGE0;
		    	elseif(!empty($consumer->email)) $rowData[] = $consumer->email;
		    	else $rowData[] = $consumer->emailField;

		    	// ZipCode
		    	if(!empty($consumer->MERGE4)) $rowData[] = $consumer->MERGE4;
		    	elseif(!empty($consumer->zipCodeField)) $rowData[] = $consumer->zipCodeField;
		    	else $rowData[] = $consumer->zipCode;

		    	// City
		    	if(!empty($consumer->city)) $rowData[] = $consumer->city;
		    	else $rowData[] = $consumer->cityField;

		    	// State
		    	if(!empty($consumer->state)) $rowData[] = $consumer->state;
		    	else $rowData[] = $consumer->stateField;

		    	// Telephone
		    	if(!empty($consumer->MERGE3)) $rowData[] = $consumer->MERGE3;
		    	elseif(!empty($consumer->phone)) $rowData[] = $consumer->phone;
		    	else $rowData[] = $consumer->telField;

		    	// Questions
		    	$rowData[] = $consumer['what-is-your-passion'];
		    	$rowData[] = $consumer['when-did-you-realize-you-loved-this'];
		    	$rowData[] = $consumer['how-often-do-you-practice'];
		    	$rowData[] = $consumer['describe-the-adventure-you-want-to-create-in-a-few-words'];
		    	$rowData[] = $consumer['how-often-will-you-take-your-travellers-out'];
		    	$rowData[] = $consumer['how-many-travellers-can-your-adventure-accomodate'];
		    	$rowData[] = $consumer['what-makes-your-adventure-unique'];
		    	$rowData[] = $consumer['tell-us-about-the-location-where-your-adventure-will-take-place-and-what-makes-it-special'];

		    	$datetime = $consumer->createdAt->toDateTime();
		    	$datetime->setTimezone(new DateTimeZone('America/Chicago'));
		    	$rowData[] = $datetime->format('m/d/Y');

		    	$data[] = $rowData;
		    }
    	}else{
    		$data = [
	    		[
	    			'ID',
	    			'Email',
					'Created At'
				]
	    	];
	    	
		    foreach ($consumers as $consumer){
		    	$rowData = [];

		    	// ID
		    	$rowData[] = $consumer->id;

		    	// Email
		    	if(!empty($consumer->MERGE0)) $rowData[] = $consumer->MERGE0;
		    	elseif(!empty($consumer->email)) $rowData[] = $consumer->email;
		    	else $rowData[] = $consumer->emailField;

		    	$datetime = $consumer->createdAt->toDateTime();
		    	$datetime->setTimezone(new DateTimeZone('America/Chicago'));
		    	$rowData[] = $datetime->format('m/d/Y');

		    	$data[] = $rowData;
		    }
    	}


		

		/*$html = "<table width='90%' border='1'><tr>
    			<th style='width:11%;'>ID</th>";
    	if($request->page == 'signup') $html .= "<th>Name</th>";
    	$html .= "<th>Email</th>";
    	if($request->page == 'signup'){
    		$html .= "<th>ZipCode</th>
					<th>City</th>
					<th>State</th>
					<th>Phone</th>";
		}

    	if($request->page == 'signup') $html .= "
    			<th>What is your passion?</th>
    			<th>When did you realize you loved this?</th>
    			<th>How often do you practice?</th>
    			<th>Describe the adventure you want to create in a few words?</th>
    			<th>How often will you take your travellers out?</th>
    			<th>How many travellers can your adventure accomodate?</th>
    			<th>What makes your adventure unique?</th>
    			<th>Tell us about the location where your adventure will take place and what makes it special</th>";

    	$html .= "</tr>";

		$tz = new DateTimeZone('America/Chicago');
	    
	    foreach ($consumers as $consumer){
	    	if(!empty($consumer->firstName)) $name = $consumer->firstName.' '.$consumer->lastName;
	    	elseif(!empty($consumer->firstNameField)) $name = $consumer->firstNameField.' '.$consumer->lastNameField;
	    	else $name = $consumer->MERGE1.' '.$consumer->MERGE2;

	    	if(!empty($consumer->MERGE0)) $email = $consumer->MERGE0;
	    	elseif(!empty($consumer->email)) $email = $consumer->email;
	    	else $email = $consumer->emailField;

	    	if(!empty($consumer->MERGE3)) $phone = $consumer->MERGE3;
	    	elseif(!empty($consumer->phone)) $phone = $consumer->phone;
	    	else $phone = $consumer->telField;

	    	if(!empty($consumer->MERGE4)) $zipCode = $consumer->MERGE4;
	    	elseif(!empty($consumer->zipCodeField)) $zipCode = $consumer->zipCodeField;
	    	else $zipCode = $consumer->zipCode;

	    	if(!empty($consumer->city)) $city = $consumer->city;
	    	else $city = $consumer->cityField;

	    	if(!empty($consumer->state)) $state = $consumer->state;
	    	else $state = $consumer->stateField;


	    	$html .= '<tr>';
		    	$html .= '<td>'.$consumer->id.'</td>';
		    	if($request->page == 'signup') $html .= '<td>'.$name.'</td>';
		    	$html .= '<td>'.$email.'</td>';
		    	if($request->page == 'signup'){
			    	$html .= '<td>'.$zipCode.'</td>';
			    	$html .= '<td>'.$city.'</td>';
			    	$html .= '<td>'.$state.'</td>';
			    	$html .= '<td>'.$phone.'</td>';
			    }

	    	if($request->page == 'signup'){
		    	$html .= '<td>'.$consumer['what-is-your-passion'].'</td>';
		    	$html .= '<td>'.$consumer['when-did-you-realize-you-loved-this'].'</td>';
		    	$html .= '<td>'.$consumer['how-often-do-you-practice'].'</td>';
		    	$html .= '<td>'.$consumer['describe-the-adventure-you-want-to-create-in-a-few-words'].'</td>';
		    	$html .= '<td>'.$consumer['how-often-will-you-take-your-travellers-out'].'</td>';
		    	$html .= '<td>'.$consumer['how-many-travellers-can-your-adventure-accomodate'].'</td>';
		    	$html .= '<td>'.$consumer['what-makes-your-adventure-unique'].'</td>';
		    	$html .= '<td>'.$consumer['tell-us-about-the-location-where-your-adventure-will-take-place-and-what-makes-it-special'].'</td>';
	    	}

		    	$datetime = $consumer->createdAt->toDateTime();
		    	$datetime->setTimezone($tz);

		    	$html .= '<td>'.$datetime->format('m/d/Y').'</td>';
	    	$html .= '</tr>';
	    }*/

	   	// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$request->page.'_'.date('Ymd').'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	$sheet->fromArray($data);

    	$writer = new Xlsx($spreadsheet);
	   	$writer->save('php://output');
	   	exit;
    }

    public function listConsumers(Request $request){
    	if($request->page == 'signup'){
	    	if(($request['daterangepicker_start'])&&($request['daterangepicker_end'])){
	    		// $dateFrom = new \MongoDB\BSON\UTCDateTime(\DateTime::createFromFormat('d/m/Y', $request['daterangepicker_start']));
	    		// $dateTo = new \MongoDB\BSON\UTCDateTime(\DateTime::createFromFormat('d/m/Y', $request['daterangepicker_end']));
	    		$dateFrom = \DateTime::createFromFormat('m/d/Y H:i:s', $request['daterangepicker_start'].' 00:00:00');
	    		$dateTo = \DateTime::createFromFormat('m/d/Y H:i:s', $request['daterangepicker_end'].' 23:59:59');
				// $dateFrom = new \DateTime();
				// $dateTo = new \DateTime();

				// $from 	= explode('/',$request['daterangepicker_start']);
				// $to 	= explode('/',$request['daterangepicker_end']);

				// dd($request['daterangepicker_start']);
				// echo '<pre>';
				// var_dump($dateFrom);
				// var_dump($dateTo);
				// echo '</pre>';
				// exit;

				// $dateFrom->setDate($from[2], $from[0], $from[1]);
				// $dateTo->setDate($to[2], $to[0], $to[1]);

				$consumers = Consumers::where(function ($query) use ($dateFrom,$dateTo) {
				    $query->where('createdAt', '>=', $dateFrom);
				    $query->where('createdAt', '<=', $dateTo);
				});
				// ->where(['what-is-your-passion' => ['$exists' => true]]);

	    	}else{
		    	$consumers = Consumers::where(['what-is-your-passion' => ['$exists' => true]])->orderBy('createdAt', 'desc');
	    	}

	    	if($request['zipSearch']){
	    		$verifyZip = preg_replace('/\D/', '', $request['zipSearch']);
	    		$request['zipSearch'] = $verifyZip;

	    		if( !empty($verifyZip) ){
					$consumers = $consumers->where('zipCodeField','=',$request['zipSearch'])->orderBy('createdAt', 'desc');
				}
	    	}else if($request['citySearch']){
				$consumers = $consumers->where('cityField','=',$request['citySearch'])->orderBy('createdAt', 'desc');
	    	}
	    	if($request['stateSearch']){
				$consumers = $consumers->where('stateField','=',$request['stateSearch'])->orderBy('createdAt', 'desc');
	    	}

	    	$consumers = $consumers->orderBy('createdAt', 'DESC')->get();
    	}else{
    		// echo '<pre>';
    		// foreach( Consumers::all() as $item ){
    		// 	var_dump($item->createdAt->toDateTime());
    		// }
    		// exit;
	    	if(($request['daterangepicker_start'])&&($request['daterangepicker_end'])){

				$dateFrom = new \DateTime();
				$dateTo = new \DateTime();

				$from 	= explode('/',$request['daterangepicker_start']);
				$to 	= explode('/',$request['daterangepicker_end']);

				$dateFrom->setDate($from[2], $from[0], $from[1]);
				$dateTo->setDate($to[2], $to[0], $to[1]);

				$consumers = Newsletter::where(function ($query) use ($dateFrom,$dateTo) {
				    $query->where('createdAt', '>=', $dateFrom);
				    $query->where('createdAt', '<=', $dateTo);
				});

	    	}else{
		    	$consumers = Newsletter::orderBy('createdAt', 'desc');
	    	}
	    	$consumers = $consumers->get();
    	}
			return $consumers;
    }
}
