<?php

    /*****
    require_once __DIR__.'/../classes/pingpostCommon.php';

    if ($argv[1] != "")
	$leadid = $argv[1];
    else
	$leadid = $_POST["leadid"];

    $pingPost = new PingPostCommon();
    $lmsData = $pingPost->fetchLead($leadid);
    *****/

    function sendCurlRequest($url, $params = array())
    {
	$postVars = http_build_query($params);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		    curl_setopt($ch, CURLOPT_HEADER, 1);
		    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );

	$response = curl_exec($ch);
echo "<pre>";
var_dump( htmlentities($response) );
exit('debugging here');
	if(curl_errno($ch))
	{
	    $curlError = 'Curl error: ' . curl_error($ch);
	    return $curlError;
	}

	curl_close($ch);

	return $response;
    }

    function formatPhoneFax($phone)
    {
      $newPhoneFormat = explode('-', $phone);
      $newPhoneFormat = implode('', $newPhoneFormat);

      if( preg_match('/^(\d{3})(\d{3})(\d{4})$/', $newPhoneFormat, $matches) )
      {
	$newPhoneFormat = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
	return $newPhoneFormat;
      }
      else
	return false;

    }

    function getClosestWord($words = array(), $input)
    {
	// no shortest distance found, yet
	$shortest = -1;

	// loop through words to find the closest
	foreach ($words as $word) 
	{

	    // calculate the distance between the input word,
	    // and the current word
	    $lev = levenshtein($input, $word);

	    // check for an exact match
	    if ($lev == 0)
	    {

		// closest word is this one (exact match)
		$closest = $word;
		$shortest = 0;

		// break out of the loop; we've found an exact match
		break;
	    }

	    // if this distance is less than the next found shortest
	    // distance, OR if a next shortest word has not yet been found
	    if ($lev <= $shortest || $shortest < 0)
	    {
		// set the closest match, and shortest distance
		$closest  = $word;
		$shortest = $lev;
	    }
	}

	return ($shortest >= 0) ? ($closest) : (-1);
    }



    $lmsData =  '{"universal_leadid":"00000000-0000-0000-0000-000000000000",
		  "useragent":"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.94 Safari/537.36",
		  "ipaddress":"207.168.5.122",
		  "sid":"autoinsquote.us",
		  "AFID":"43074",
		  "firstname":"Rebeca",
		  "name":"Rebeca",
		  "lastname":"Pasillas",
		  "email":"beckypasillas@yahoo.com",
		  "emailaddress":"beckypasillas@yahoo.com",
		  "address":"16904 New Pine Drive",
		  "city":"Hacienda Heights",
		  "_City":"Hacienda Heights",
		  "state":"CA",
		  "st":"CA",
		  "_State":"CA",
		  "zip":"91745",
		  "_PostalCode":"91745",
		  "country_code":"1",
		  "homephone":"626-201-2360",
		  "homephone_area":"626",
		  "homephone_prefix":"201",
		  "homephone_suffix":"2360",
		  "ueid":"fbso_0517af506af937_ad1_pp_6",
		  "currentpolicyexpiration":"2013-08-01",
		  "vertical":"ains",
		  "cam":"ad1_pp_6",
		  "referer":"https://www.facebook.com/",
		  "leadtype":"ShortForm",
		  "keyword":"social",
		  "CURRENTINSURANCECOMPANY":"Infinity Insurance",
		  "desiredcoveragetype":"State_Min",
		  "desiredcollisiondeductible":"500",
		  "desiredcomprehensivedeductible":"500",
		  "driver1edulevel":"HighSchoolDiploma",
		  "driver1firstname":"Rebeca",
		  "driver1lastname":"Pasillas",
		  "driver1dob_day":"07",
		  "driver1dob_month":"02",
		  "driver1dob_year":"1957",
		  "driver1gender":"Female",
		  "driver1maritalstatus":"Single",
		  "driver1occupation":"AdministrativeClerical",
		  "driver1sr22":"No",
		  "driver1credit":"Good",
		  "driver1yearsemployed":"4",
		  "driver1age":"51",
		  "driver1licenseage":"18",
		  "driver1yearsatresidence":"10",
		  "driver2edulevel":"AA",
		  "vehicle1year":"2010",
		  "vehicle1make":"Hyundai",
		  "vehicle1model":"ACCENT",
		  "vehicle1commuteAvgMileage":"20",
		  "vehicle1annualMileage":"25000",
		  "vehicle1primaryUse":"Commute_Work",
		  "vehicle1leased":"Owned",
		  "vehicle1trim":"Blue",
		  "vehicle1garageType":"Full Garage",
		  "vehicle1alarm":"Alarm",
		  "vehicle1ownership":"Leased",
		  "vehicle1distance":"9",
		  "vehicle1commutedays":"5",
		  "vendoremail":"facebook",
		  "vendorpassword":"ueint",
		  "vendorid":"underground",
		  "variant":"gadget_copy",
		  "currentlyinsured":"1",
		  "currentresidence":"Own",
		  "yearsatresidence":"10",
		  "sourcedeliveryid":"3",
		  "cookie":"2f42075a6151eec7cb8424be36d5cf4a",
		  "keyword_id":"2712",
		  "keywords":"social|facebook|||social|gadget_copy",
		  "variant_id":"25214",
		  "site_id":"233",
		  "hid":"nvt-node12",
		  "dynotrax_id":"51ae795b91e1e77b45000005",
		  "contact":"Morning",
		  "propertydamage":"25000",
		  "bodilyinjury":"50/100",
		  "policystart":"2012-08-06",
		  "insuredsince":"2011-02-12"
		  }';
    
    $lmsDataJsonDecoded = json_decode($lmsData, true);

    $testMode = 1;
    $newPhoneFormat = formatPhoneFax($lmsDataJsonDecoded['homephone']);
    $homeOwnedOrRented =  ('Own' === $lmsDataJsonDecoded['currentresidence']) ? 'Owned' : 'Rented';
    $driverCount = 1; // we dont have a mapping for this
    $driverVehiclesCount = 1; // we dont have a mapping for this
    $possibleOccupations = array('Employed', 'Homemaker', 'Retired', 'Student', 'Unemployed', 'Military');
    $possibleVehicleMake = array("AC Bristol","AMGL","ACUR","ALFA","AMC","ASTN","Audi","AUST","Austin-Healy","Avanti","BMW","BERT","Borgward","BUIK","CADI","Capri","CHEC","CHEV","CHRY","Citroen",
				 "Colt","Crosley","DAF","DKW","DAEW","DAIH","Daimler","Datsun","DeSoto","DELO","DODG","EAGL","Excalibur","FERR","Fiat","Fisker","Ford","Ford (England)","Frazer","GMC",
				 "Geo","Hillman","HOND","Hudson","Hummer","HYUN","Imperial","INFI","INTL","ISZU","Italia","JAG","Jeep","Kia","LANC","ROVR","LEXS","LINC","LOTS","MG","MASS","MAZD","MBNZ",
				 "MERC","Merkur","MINI","MITS","Moretti","Morgan","Morris","Moskvitch","Nash","Nash Metropolitan","Nash-Healey","NSSN","Nsu Prinz","OLDS","Opel","Packard","Pantera","PEUG",
				 "PLYM","PONT","PORS","Ram","Rambler","RNLT","Riley","Rolls Royce","Saab","SATN","Simca","Singer","STER","Studebaker","SUBA","Sunbeam","SUZU","TVR","Taunus","TYTA","TRIU",
				 "Vauxhall","Vespa","VLKS","VLVO","Willys","Yugo");

    if(FALSE == $newPhoneFormat)
    {
      return false;
    }

    // building the GENERAL info and CONTACT info part
    $params = array('CampaignId'   => 1166, // 1167 for Exclusive
		    'SRCID'	   => $lmsDataJsonDecoded['AFID'],
		    'SRCID2'	   => '',
		    'SourceDescr'  => 'We do not have this Source Description',
		    'VendorLeadId' => $lmsDataJsonDecoded['vendorid'],
		    'TestMode' 	   => $testMode,
		    'FirstName'	   => $lmsDataJsonDecoded['name'],
		    'MiddleName'   => '',
		    'LastName'	   => $lmsDataJsonDecoded['lastname'],
		    'Address1'	   => $lmsDataJsonDecoded['address'],
		    'Address2'	   => '',
		    'City'	   => $lmsDataJsonDecoded['city'],
		    'State'	   => $lmsDataJsonDecoded['state'],
		    'Zipcode'	   => $lmsDataJsonDecoded['zip'],
		    'HomePhone'	   => $newPhoneFormat,
		    'WorkPhone'	   => '',
		    'Fax'	   => '',
		    'Email'	   => $lmsDataJsonDecoded['email'],
		    'HomeOwner'	   => $homeOwnedOrRented,
		    'YearsAtResidence' => $lmsDataJsonDecoded['yearsatresidence'],
		    'YearsAtPrevResidence' => 1, // we dont have a mapping for this but this is a required field
		    'NumDrivers'   => $driverCount,
		    'NumVehicles'  => $driverVehiclesCount
		   );

     
    for($driverCounter = 1; $driverCounter <= $driverCount; $driverCounter++)  // building the DRIVER info part
    {
      $drvFirstname 	     = 'Drv' . $driverCounter . 'FirstName';
      $drvMiddleName 	     = 'Drv' . $driverCounter . 'MiddleName';
      $drvLastName 	     = 'Drv' . $driverCounter . 'LastName';
      $drvGender 	     = 'Drv' . $driverCounter . 'Gender';
      $drvDOB 		     = 'Drv' . $driverCounter . 'DOB';
      $drvMaritalStatus      = 'Drv' . $driverCounter . 'MaritalStatus';
      $drvRelationship 	     = 'Drv' . $driverCounter . 'Relationship';
      $drvOccupation 	     = 'Drv' . $driverCounter . 'Occupation';
      $drvLicenseState 	     = 'Drv' . $driverCounter . 'LicenseState';
      $drvLicenseStatus      = 'Drv' . $driverCounter . 'LicenseStatus';
      $drvAgeLicensed 	     = 'Drv' . $driverCounter . 'AgeLicensed';
      $driverViolationsCount = 2; // we dont have this, this is the counter for the number of violations for a particular driver
      //$driverVehiclesCount = 2; // we dont have this, this is the counter for the number of violations for a particular driver

      $params[$drvFirstname] 	 = $lmsDataJsonDecoded['driver'.$driverCounter.'lastname'];
      $params[$drvMiddleName] 	 = '';
      $params[$drvLastName] 	 = $lmsDataJsonDecoded['driver'.$driverCounter.'lastname'];
      $params[$drvGender] 	 = ($lmsDataJsonDecoded['driver'.$driverCounter.'gender'] === 'Female') ? 'F' : 'M';
      $params[$drvDOB]    	 = $lmsDataJsonDecoded['driver'.$driverCounter.'dob_year'] . '-' . $lmsDataJsonDecoded['driver'.$driverCounter.'dob_month'] . '-' . $lmsDataJsonDecoded['driver'.$driverCounter.'dob_day'];
      $params[$drvMaritalStatus] = ($lmsDataJsonDecoded['driver'.$driverCounter.'maritalstatus'] === 'Single') ? 'S' : 'M';
      $params[$drvRelationship]  = 'IN'; //$lmsDataJsonDecoded[''];

      $params[$drvOccupation]    = getClosestWord($possibleOccupations, $lmsDataJsonDecoded['driver'.$driverCounter.'occupation']);

      if( $params[$drvOccupation] === -1 )
      {
	$params[$drvOccupation] = 'Employed';
      }

      $params[$drvLicenseState]  = $lmsDataJsonDecoded['state'];
      $params[$drvLicenseStatus] = 'Valid';	// we dont have a mapping for this
      $params[$drvAgeLicensed]   = $lmsDataJsonDecoded['driver'.$driverCounter.'licenseage'];

      //echo $drvFirstname . '-' . $drvMiddleName . '-' . $drvLastName . '-' . $drvGender . '-' . $drvDOB . '-' . $drvMaritalStatus . '-' . $drvRelationship . '-' . $drvOccupation . '-' . $drvLicenseState . '-' . $drvLicenseStatus . '-' . $drvAgeLicensed;

      for($violationCounter = 1; $violationCounter <= $driverViolationsCount; $violationCounter++) //building the Violations info part
      {
	break;  // skip this part first since we dont have a mapping for this
	//$drvViolationCd = 'Drv' . $driverCounter . 'Violation' . $violationCounter . 'Cd';
	//$drvViolationDt = 'Drv' . $driverCounter . 'Violation' . $violationCounter . 'Dt';
      } //building the Violations info part

      for(;false;) //building the Accidents info part
      {

      } //building the Accidents info particular

      for(;false;)  //building the Claims info part
      {

      } //building the Claims info part

      for(;false;)  //building the Suspensions info part
      {

      } //building the Suspensions info part

      //$params[''] = 
    }  // building the DRIVER info part

    for($vehicleCounter = 1; $vehicleCounter <= $driverVehiclesCount; $vehicleCounter++) // building the Vehicle info part
    {
      $params['Veh'.$vehicleCounter.'ModelYear'] 	  = $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'year'];
      $params['Veh'.$vehicleCounter.'Make'] 		  = getClosestWord($possibleVehicleMake, $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'make']);

      if($params['Veh'.$vehicleCounter.'Make'] == -1)
      {
	$params['Veh'.$vehicleCounter.'Make'] = 'AC Bristol';
      }

      $params['Veh'.$vehicleCounter.'Model'] 		  = $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'model'];
      $params['Veh'.$vehicleCounter.'BodyStyle'] 	  = $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'trim'];
      $params['Veh'.$vehicleCounter.'AutomaticSeatBelts'] = 'None'; // we dont have a mapping for this
      $params['Veh'.$vehicleCounter.'AntiLockBrakes'] 	  = 'None'; // we dont have a mapping for this
      $params['Veh'.$vehicleCounter.'NumAirbags'] 	  = 'FrontBoth'; 
      $params['Veh'.$vehicleCounter.'SecuritySystem'] 	  = 'A';
      $params['Veh'.$vehicleCounter.'Leased'] 		  = ($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'leased'] == 'Owned') ? 'Y' : 'N';
      
      if( stripos($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'primaryUse'], 'work') )
      {
	$params['Veh'.$vehicleCounter.'VehicleUse'] = 'DW';
      }
      elseif( stripos($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'primaryUse'], 'school') )
      {
	$params['Veh'.$vehicleCounter.'VehicleUse'] = 'DS';
      }
      elseif( stripos($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'primaryUse'], 'pleasure') )
      {
	$params['Veh'.$vehicleCounter.'VehicleUse'] = 'PL';
      }
      elseif( stripos($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'primaryUse'], 'business') )
      {
	$params['Veh'.$vehicleCounter.'VehicleUse'] = 'BU';
      }
      elseif( stripos($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'primaryUse'], 'farm') )
      {
	$params['Veh'.$vehicleCounter.'VehicleUse'] = 'FM';
      }

      $params['Veh'.$vehicleCounter.'CommuteDays'] 	  = $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'commutedays'];
      $params['Veh'.$vehicleCounter.'CommuteMiles'] 	  = $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'commuteAvgMileage'];
      $params['Veh'.$vehicleCounter.'VIN'] 		  = 0;  // we dont have a mapping for this
      $params['Veh'.$vehicleCounter.'CompDeductible'] 	  = $lmsDataJsonDecoded['desiredcomprehensivedeductible'];
      
      if($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] <= 5000)
      {
	$params['Veh'.$vehicleCounter.'AnnualMiles'] = 2500;
      }
      elseif($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] >= 5001 && $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] <= 5000)
      {
	 $params['Veh'.$vehicleCounter.'AnnualMiles'] = 6250;
      }
      elseif($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] >= 7501 && $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] <= 10000)
      {
	 $params['Veh'.$vehicleCounter.'AnnualMiles'] = 8750;
      }
      elseif($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] >= 10001 && $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] <= 12500)
      {
	 $params['Veh'.$vehicleCounter.'AnnualMiles'] = 11250;
      }
      elseif($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] >= 12501 && $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] <= 15000)
      {
	 $params['Veh'.$vehicleCounter.'AnnualMiles'] = 13750;
      }
      elseif($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] >= 15001 && $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] <= 18000)
      {
	 $params['Veh'.$vehicleCounter.'AnnualMiles'] = 16500;
      }
      elseif($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] >= 18001 && $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] <= 25000)
      {
	 $params['Veh'.$vehicleCounter.'AnnualMiles'] = 21500;
      }
      elseif($lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] >= 25001 && $lmsDataJsonDecoded['vehicle'.$vehicleCounter.'annualMileage'] <= 50000)
      {
	 $params['Veh'.$vehicleCounter.'AnnualMiles'] = 37500;
      }

      $params['Veh'.$vehicleCounter.'CollDeductible'] 	  = $lmsDataJsonDecoded['desiredcollisiondeductible'];
      $params['Veh'.$vehicleCounter.'PrimaryDriver'] 	  = 1;	// we dont have a mapping for this

      if( $lmsDataJsonDecoded['bodilyinjury'] == "15/30" )
      {
	$params['Veh'.$vehicleCounter.'BIPerPerson']   = 15000;
	$params['Veh'.$vehicleCounter.'BIPerAccident'] = 30000;
      }
      elseif( $lmsDataJsonDecoded['bodilyinjury'] == "25/50" )
      {
	$params['Veh'.$vehicleCounter.'BIPerPerson']   = 25000;
	$params['Veh'.$vehicleCounter.'BIPerAccident'] = 50000;
      }
      elseif( $lmsDataJsonDecoded['bodilyinjury'] == "50/100" )
      {
	$params['Veh'.$vehicleCounter.'BIPerPerson']   = 50000;
	$params['Veh'.$vehicleCounter.'BIPerAccident'] = 100000;
      }
      elseif( $lmsDataJsonDecoded['bodilyinjury'] == "100/300" )
      {
	$params['Veh'.$vehicleCounter.'BIPerPerson']   = 100000;
	$params['Veh'.$vehicleCounter.'BIPerAccident'] = 300000;
      }
      elseif( $lmsDataJsonDecoded['bodilyinjury'] == "250/500" )
      {
	$params['Veh'.$vehicleCounter.'BIPerPerson']   = 250000;
	$params['Veh'.$vehicleCounter.'BIPerAccident'] = 300000;
      }
      elseif( $lmsDataJsonDecoded['bodilyinjury'] == "300000" )
      {
	$params['Veh'.$vehicleCounter.'BIPerPerson']   = 100000;
	$params['Veh'.$vehicleCounter.'BIPerAccident'] = 300000;
      }
      elseif( $lmsDataJsonDecoded['bodilyinjury'] == "500000" )
      {
	$params['Veh'.$vehicleCounter.'BIPerPerson']   = 250000;
	$params['Veh'.$vehicleCounter.'BIPerAccident'] = 500000;
      }

      $params['Veh'.$vehicleCounter.'PDAmount'] = (int)$lmsDataJsonDecoded['propertydamage']; // maybe this part here needs error trapping, not sure though

    } // building the Vehicle info part


    $params['PriorCarrierName'] 	    = 'AIG'; // we do not have a mapping for this

    if( $lmsDataJsonDecoded['bodilyinjury'] == "15/30" )
    {
      $params['PriorCarrierBiLimitPerPerson'] = 15000;
      $params['PriorCarrierBiLimitPerAcc']    = 30000;
    }
    elseif( $lmsDataJsonDecoded['bodilyinjury'] == "25/50" )
    {
      $params['PriorCarrierBiLimitPerPerson'] = 25000;
      $params['PriorCarrierBiLimitPerAcc']    = 50000;
    }
    elseif( $lmsDataJsonDecoded['bodilyinjury'] == "50/100" )
    {
      $params['PriorCarrierBiLimitPerPerson'] = 50000;
      $params['PriorCarrierBiLimitPerAcc']    = 100000;
    }
    elseif( $lmsDataJsonDecoded['bodilyinjury'] == "100/300" )
    {
      $params['PriorCarrierBiLimitPerPerson'] = 100000;
      $params['PriorCarrierBiLimitPerAcc']    = 300000;
    }
    elseif( $lmsDataJsonDecoded['bodilyinjury'] == "250/500" )
    {
      $params['PriorCarrierBiLimitPerPerson'] = 250000;
      $params['PriorCarrierBiLimitPerAcc']    = 500000;
    }
    elseif( $lmsDataJsonDecoded['bodilyinjury'] == "300000" )
    {
      $params['PriorCarrierBiLimitPerPerson'] = 300000;
      $params['PriorCarrierBiLimitPerAcc']    = 500000;
    }
    elseif( $lmsDataJsonDecoded['bodilyinjury'] == "500000" )
    {
      $params['PriorCarrierBiLimitPerPerson'] = 500000;
      $params['PriorCarrierBiLimitPerAcc']    = 1000000;
    }

    $params['TimewithCarrier'] 		    = date_diff(new DateTime($lmsDataJsonDecoded['insuredsince']), new DateTime(date('Y-m-d')))->y;
    $params['PriorCarrierExpirationDate']   = $lmsDataJsonDecoded['currentpolicyexpiration'];

    $url = "https://Leads.Convergetrack.com/LeadPost.aspx";
    
    $response = sendCurlRequest($url, $params);
    var_dump( htmlentities($response) );