<?php

$Orders = Doctrine_Core::getTable('Orders');
	if (isset($_GET['oID'])){
		$NewOrder = $Orders->find((int) $_GET['oID']);
		if(sysConfig::get('EXTENSION_ORDER_CREATOR_TELEPHONE_NUMBER_REQUIRED') == 'True'){
			if(isset($_POST['telephone']) && !empty($_POST['telephone'])){
				$Editor->setTelephone($_POST['telephone']);
			}else{
				$Editor->addErrorMessage('Telephone Number not set');
			}
		}else{
			$Editor->setTelephone($_POST['telephone']);
		}
	}else{
		$NewOrder = new Orders();
		$createAccount = false;
		if (isset($_POST['customers_id'])){
			$NewOrder->customers_id = $_POST['customers_id'];
		}elseif ((isset($_POST['account_password']) && !empty($_POST['account_password'])) || sysConfig::get('EXTENSION_ORDER_CREATOR_AUTOGENERATE_PASSWORD') == 'True'){
			if($_POST['isType'] == 'walkin'){
				if(isset($_POST['email']) && !empty($_POST['email'])){
					$Editor->setEmailAddress($_POST['email']);
				}else{
					if(sysConfig::get('EXTENSION_ORDER_CREATOR_AUTOGENERATE_EMAIL') == 'True'){
						$Editor->setEmailAddress('autogenerated_'.tep_create_random_value(8));
					}else{
						$Editor->addErrorMessage('Email address not set');
					}
				}
				if(sysConfig::get('EXTENSION_ORDER_CREATOR_TELEPHONE_NUMBER_REQUIRED') == 'True'){
					if(isset($_POST['telephone']) && !empty($_POST['telephone'])){
						$Editor->setTelephone($_POST['telephone']);
					}else{
						$Editor->addErrorMessage('Telephone Number not set');
					}
				}else{
					$Editor->setTelephone($_POST['telephone']);
				}
			}else{
				if(isset($_POST['room_number']) && !empty($_POST['room_number'])){
					if(isset($_POST['email']) && !empty($_POST['email'])){
						$Editor->setEmailAddress($_POST['email']);
					}else{
						$Editor->setEmailAddress('roomnumber'.'_'.$Editor->getData('store_id').'_'.$_POST['room_number']);
					}

					if(isset($_POST['telephone']) && !empty($_POST['telephone'])){
						$Editor->setTelephone($_POST['telephone']);
					}

					$NewOrder->customers_room_number = $_POST['room_number'];
				}else{
					$Editor->addErrorMessage('You need to have a room number setup');
				}
			}

			$Editor->createCustomerAccount($NewOrder->Customers);
		}else{
			$Editor->addErrorMessage('You need to setup a password');
		}
	}
	
	$NewOrder->customers_email_address = $Editor->getEmailAddress();
	$NewOrder->customers_telephone = $Editor->getTelephone();
	if(isset($_POST['estimateOrder'])){
		$NewOrder->orders_status  = sysConfig::get('ORDERS_STATUS_ESTIMATE_ID');
	}else{
		if($_POST['status'] != sysConfig::get('ORDERS_STATUS_ESTIMATE_ID')){
		$NewOrder->orders_status = $_POST['status'];
		}else{
			$NewOrder->orders_status = sysConfig::get('ORDERS_STATUS_PROCESSING_ID');
		}
	}
	if(sysConfig::get('EXTENSION_ORDER_CREATOR_NEEDS_LICENSE_PASSPORT') == 'True' && $_POST['isType'] == 'walkin'){
		$hasData = false;
		if(isset($_POST['drivers_license']) && !empty($_POST['drivers_license'])){
			$NewOrder->customers_drivers_license = $_POST['drivers_license'];
			$hasData = true;
		}
		if(isset($_POST['passport']) && !empty($_POST['passport'])){
			$NewOrder->customers_passport = $_POST['passport'];
			$hasData = true;
		}
		if($hasData === false){
			$Editor->addErrorMessage('You need to have a drivers license or passport setup');
		}
	}

	$NewOrder->currency = $Editor->getCurrency();
	$NewOrder->currency_value = $Editor->getCurrencyValue();
	$NewOrder->shipping_module = $Editor->getShippingModule();
	$NewOrder->usps_track_num = $_POST['usps_track_num'];
	$NewOrder->usps_track_num2 = $_POST['usps_track_num2'];
	$NewOrder->ups_track_num = $_POST['ups_track_num'];
	$NewOrder->ups_track_num2 = $_POST['ups_track_num2'];
	$NewOrder->fedex_track_num = $_POST['fedex_track_num'];
	$NewOrder->fedex_track_num2 = $_POST['fedex_track_num2'];
	$NewOrder->dhl_track_num = $_POST['dhl_track_num'];
	$NewOrder->dhl_track_num2 = $_POST['dhl_track_num2'];
	$NewOrder->ip_address = $_SERVER['REMOTE_ADDR'];
	$NewOrder->admin_id = Session::get('login_id');
//	$NewOrder->payment_module = $Editor->getPaymentModule();

	$Editor->AddressManager->updateFromPost();
	$Editor->AddressManager->addAllToCollection($NewOrder->OrdersAddresses);
    //updateCustomerAccount with new customer information

$CustomerAddress = $Editor->AddressManager->getAddress('customer');
if($CustomerAddress){
	$NewOrder->Customers->customers_firstname = $CustomerAddress->getFirstName();
	$NewOrder->Customers->customers_lastname = $CustomerAddress->getLastName();
	$NewOrder->Customers->customers_email_address = $Editor->getEmailAddress();
	$NewOrder->Customers->customers_telephone = $Editor->getTelephone();
	$AddressBook = Doctrine::getTable('AddressBook')->find($NewOrder->Customers->customers_default_address_id);
	if($AddressBook){
		$AddressBook->entry_gender = $CustomerAddress->getGender();
		if(sysConfig::get('ACCOUNT_COMPANY') == 'true'){
			$AddressBook->entry_company = $CustomerAddress->getCompany();
		}
		$AddressBook->entry_firstname = $CustomerAddress->getFirstName();
		$AddressBook->entry_lastname = $CustomerAddress->getLastName();
		$AddressBook->entry_street_address = $CustomerAddress->getStreetAddress();
		$AddressBook->entry_suburb = $CustomerAddress->getSuburb();
		$AddressBook->entry_postcode = $CustomerAddress->getPostcode();
		$AddressBook->entry_city = $CustomerAddress->getCity();
		$AddressBook->entry_state = $CustomerAddress->getState();
		$AddressBook->entry_country_id = $CustomerAddress->getCountryId();
		$AddressBook->entry_zone_id = $CustomerAddress->getZoneId();
		$AddressBook->save();
	}
}
//$NewOrder->Customers->AddressBook->add($AddressBook);
    /*End Update Customer Account*/
	$Editor->ProductManager->updateFromPost();
	$Editor->ProductManager->addAllToCollection($NewOrder->OrdersProducts);

	$NewOrder->OrdersTotal->clear();
	$Editor->TotalManager->clear();
	$Editor->TotalManager->updateFromPost();
	$Editor->TotalManager->addAllToCollection($NewOrder->OrdersTotal);

EventManager::notify('OrderSaveBeforeSave', &$NewOrder);
	//echo '<pre>';print_r($NewOrder->toArray());itwExit();
    $hasPayment = false;
	if($Editor->hasErrors()){
		$success = false;
	}else{
		$success = true;
		if (isset($_GET['oID']) && isset($NewOrder->orders_id)){
			Doctrine_Query::create()
			->delete('OrdersTotal')
			->where('orders_id = ?', $NewOrder->orders_id)
			->execute();
		}
		$NewOrder->save();
		if (!isset($_GET['oID'])){
			$NewOrder->bill_attempts = 1;
			if(!isset($_POST['estimateOrder'])){
				if(floatval($_POST['payment_amount']) > 0){
				$NewOrder->payment_module = $_POST['payment_method'];
					$hasPayment = true;
				$success = $Editor->PaymentManager->processPayment($_POST['payment_method'], $NewOrder);
				$Editor->addErrorMessage($success['error_message']);
				}
			}else{
				$success = true;
			}
		}
	}
	
	if ($success === true){

		$StatusHistory = new OrdersStatusHistory();
		if(!isset($_POST['estimateOrder'])){
			if(!$hasPayment){
				if($_POST['status'] != sysConfig::get('ORDERS_STATUS_ESTIMATE_ID')){
			$StatusHistory->orders_status_id = $_POST['status'];
				}else{
					$StatusHistory->orders_status_id = sysConfig::get('ORDERS_STATUS_PROCESSING_ID');
				}
			}
		}else{
			$StatusHistory->orders_status_id = sysConfig::get('ORDERS_STATUS_ESTIMATE_ID');
		}
		$StatusHistory->customer_notified = (int) (isset($_POST['notify']));
		$StatusHistory->comments = $_POST['comments'];
			
		$NewOrder->OrdersStatusHistory->add($StatusHistory);

		$terms = '<p>Terms and conditions:</p><br/>';
		if (sysConfig::get('EXTENSION_PAY_PER_RENTALS_SAVE_TERMS') == 'True'){
			$infoPages = $appExtension->getExtension('infoPages');
			$termInfoPage = $infoPages->getInfoPage('conditions');
			$terms .= str_replace("\r",'',str_replace("\n",'',str_replace("\r\n",'',$termInfoPage['PagesDescription'][Session::get('languages_id')]['pages_html_text'])));
		}

		$NewOrder->terms = $terms;

		$NewOrder->save();

		if($Editor->hasData('store_id') && $appExtension->isInstalled('multiStore') && $appExtension->isEnabled('multiStore')){
			$NewOrder->OrdersToStores->stores_id = $_POST['customers_store'];//$Editor->getData('store_id');
			if (!isset($_GET['oID'])){
				$NewOrder->Customers->CustomersToStores->stores_id = $_POST['customers_store'];//$Editor->getData('store_id');
			}
		}

		if (!isset($_GET['oID'])){
			$NewOrder->Customers->customers_default_address_id = $NewOrder->Customers->AddressBook[0]->address_book_id;
			$NewOrder->save();
			if(isset($_POST['notify'])){
				if(!isset($_POST['estimateOrder'])){
					$Editor->sendNewOrderEmail($NewOrder);
				}else{
					$Editor->sendNewEstimateEmail($NewOrder);
				}
			}
		}else{
			if(isset($_POST['notify'])){
				$Editor->sendUpdateOrderEmail($NewOrder);
			}
		}
		if(!isset($_POST['estimateOrder'])){

			$startDate = strtotime(date('Y-m-d'));
			$endDate = strtotime(date('Y-m-d'));
			$hasRes = false;
			foreach($NewOrder->OrdersProducts as $orderp){
				foreach($orderp->OrdersProductsReservation as $ores){
					if(strtotime($ores['start_date']) < $startDate){
						$startDate = strtotime($ores['start_date']);
					}
					$hasRes = true;
					if(strtotime($ores['end_date']) > $endDate){
						$endDate = strtotime($ores['end_date']);
					}
				}
			}
			$startDate = date('Y-m-d H:i:s', $startDate);
			$endDate = date('Y-m-d H:i:s', $endDate);
			if(sysConfig::get('EXTENSION_ORDER_CREATOR_MESSAGE_ON_SAVE') == 'True'){
				if(isset($_POST['estimateOrder'])){
					$estpdf = '&isEstimate=1';
				}else{
					$estpdf = '';
				}
				$messageStack->addSession('pageStack','Order successfully saved.<a style="font-size:14px;color:red" target="_blank" href="'.itw_catalog_app_link('appExt=pdfPrinter'.$estpdf.'&oID=' . $NewOrder->orders_id, 'generate_pdf', 'default').'">Print Invoice</a><br/>'.(($hasRes)?'<a style="font-size:14px;color:red" href="'.itw_app_link('appExt=payPerRentals&start_date='.$startDate.'&end_date='.$endDate.'&highlightOID='.$NewOrder->orders_id, 'send', 'default').'">Checkout Reservation</a>':''), 'success');
			}

			EventManager::attachActionResponse(itw_app_link('oID=' . $NewOrder->orders_id, 'orders', 'details'), 'redirect');
		}else{
			EventManager::attachActionResponse(itw_app_link('oID=' . $NewOrder->orders_id.'&isEstimate=1', 'orders', 'details'), 'redirect');
		}

	}else{
		if(isset($_POST['estimateOrder'])){
			$est = '&isEstimate=1';
		}else{
			$est = '';
		}
		if (isset($_GET['oID'])){
			EventManager::attachActionResponse(itw_app_link('appExt=orderCreator&isType='.$_POST['isType'].'&error=true&oID=' . $_GET['oID'].$est, 'default', 'new'), 'redirect');
		}else{
			EventManager::attachActionResponse(itw_app_link('appExt=orderCreator&isType='.$_POST['isType'].'&error=true'.$est, 'default', 'new'), 'redirect');
		}
	}
?>