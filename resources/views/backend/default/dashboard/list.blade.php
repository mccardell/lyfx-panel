@extends('backend.default.pages.2columns-left')

@section('content')

	<div class="row">
		<div class="col-xs-12">
			<div class="block-flat">
				<div class="header" style="display: flex;padding-bottom: 20px;">
					<?php
					if(!empty($request['daterangepicker_start'])){
						$date = $request['daterangepicker_start']." - ".$request['daterangepicker_end'];
					}else{
						$date = '';
					}
					if(!empty($request['zipSearch'])) $zipSearch = $request['zipSearch'];
					else $zipSearch = '';
					if(!empty($request['citySearch'])) $citySearch = 'citySearch';
					else $citySearch = '';
					if(!empty($request['stateSearch'])) $stateSearch = 'stateSearch';
					else $stateSearch = '';
					?>
					<!-- <h3 class="col-xs-6" style="float:none;display: inline-block;">Export</h3> -->
         			<div class="col-xs-9">Filters: 
         				<form method="GET" action="/panel/list/{{ $request['page'] }}" class="searchForm">
	           				<span class="add-on input-group-addon primary" style="display: inline-block;width:36px;height:34px;margin-top:-4px"><span class="glyphicon glyphicon-th"></span></span><input type="text" name="reservation" id="reservation" class="form-control {{ $request['page'] }}" value="{{ $date }}" placeholder="Date"> 
	           				<?php
	           				if($request['page'] == 'signup'){
	           				?>
		           				<select name="stateSearch" id="stateSearch" class="form-control">
		           					<option value="">-- State --</option>
		           					@foreach ($states as $key => $value)
		           						<?php if( empty($value) ) continue ?>
		           						<option value="{{ $value }}" <?php if($request['stateSearch'] == $value){echo "selected";} ?> > {{ $value }}</option>
		       						@endforeach
		           				</select>
		           				<select name="citySearch" id="citySearch" class="form-control">
		           					<option value="">-- City --</option>
		           					@foreach ($cities as $key => $value)
		           						<?php if( empty($value) ) continue ?>
		           						<option value="{{ $value }}" <?php if($request['citySearch'] == $value){echo "selected";} ?> > {{ $value }}</option>
		       						@endforeach
		           				</select>
		           				<input type="text" name="zipSearch" id="zipSearch" placeholder="Zip Code" class="form-control" value="{{ $zipSearch }}" maxlength="6" onblur="verifyZip(this.value)">
	           				<?php
	           				}
	           				?>
	           				<button class="applyBtn">Search</button>
           				</form>
         			</div>
         			<div class="col-xs-3" class="text-right">
						<form method="get" action="/panel/export/{{ $request['page'] }}" style="float: right">
							<input type="hidden" name="daterangepicker_start" value="{{ $request['daterangepicker_start'] }}">
							<input type="hidden" name="daterangepicker_end" value="{{ $request['daterangepicker_end'] }}">
							<input type="hidden" name="stateSearch" value="{{ $request['stateSearch'] }}">
							<input type="hidden" name="citySearch" value="{{ $request['citySearch'] }}">
							<input type="hidden" name="zipSearch" value="{{ $request['zipSearch'] }}">
							<button class="btn btn-primary" name="submit" value="export">Export</button>
						</form>
         			</div>
         		</div>
				<div class="content">
					<?php if ($consumers->count() > 0) { ?><h5 style="font-weight: 700"><?php echo $consumers->count(); ?> items found</h5><?php } ?>
					<table class="no-border list-consumers">
						<thead class="no-border">
							<tr>
				    			<!-- <th style="width:11%;">ID</th> -->
		           				<?php
		           				if($request['page'] == 'signup'){
		           				?>
				    				<th>Name</th>
		           				<?php
		           				}
		           				?>
			    				<th>Email</th>
		           				<?php
		           				if($request['page'] == 'signup'){
		           				?>
				    				<th>ZipCode</th>
					    			<th>City</th>
					    			<th>State</th>
					    			<th>Phone</th>
		           				<?php
		           				}
		           				?>
				    			<th>Date</th>
				    			<th></th>
							</tr>
						</thead>
						<tbody class="no-border-x no-border-y">
							<tr>
								<?php
						    		$tz = new DateTimeZone('America/Chicago');
						    		if($consumers->count() == 0){
								    	echo '<tr><td colspan="6" style="text-align:center;">Nothing to show.</td></tr>';
						    		}else{
									    foreach ($consumers as $consumer){
									    	if( is_array($consumer->createdAt) ) continue;
									    	/*echo '<pre>';
									    	var_dump($consumer);
									    	echo '</pre>';*/
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

									    	echo '<tr>';
									    	// echo '<td>'.$consumer->id.'</td>';
		           							if($request['page'] == 'signup') echo '<td>'.$name.'</td>';
									    	echo '<td>'.$email.'</td>';
		           							if($request['page'] == 'signup'){
										    	echo '<td>'.$zipCode.'</td>';
										    	echo '<td>'.$city.'</td>';
										    	echo '<td>'.$state.'</td>';
										    	echo '<td>'.$phone.'</td>';
									    	}

									    	if( is_string($consumer->createdAt) ){
									    		$datetime = new DateTime($consumer->createdAt);
									    	}else{
										    	$datetime = $consumer->createdAt->toDateTime();
										    }
									    	$datetime->setTimezone($tz);

									    	echo '<td>'.$datetime->format('m/d/Y').'</td>';
									    	echo '<td><form method="get" action="/panel/deleteList/'.$request['page'].'"><button class="btn btn-primary item-delete" name="submit" value="delete"><i class="fa fa-times-circle"></i></button><input type="hidden" name="idDelete" value="'.$consumer->id.'" /></form></td>';
									    	echo '</tr>';
									    }
									}
								?>
						</tbody>
					</table>
				</div>
			</div>
		</div>			
	</div>
@stop
