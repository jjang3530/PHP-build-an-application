<?php
/* 
 * vendors.php
 * Assignment5: vendors page
 *
 * Revision History
 *       group8, 2017.07.28: Created
 */
	session_start();
	
	//Connection
	include("connection.php");
	
	//Validation
	$messageArray = array();
	
	
	// validate Vendor Number
	if(empty($_POST["vendorNo"]))
	{
		array_push($messageArray, "Vendor Number is required.");
	}else{
		$connection = ConnectToDatabase();		
		$queryValue = $_POST['vendorNo'];
		$querySelect = "SELECT count(VendorNo) as cnt FROM Vendors WHERE VendorNo = ?"; 
		$preparedQuerySelect = $connection -> prepare($querySelect);
		$param = array($queryValue);
		$preparedQuerySelect -> execute($param);

		while ($row = $preparedQuerySelect -> fetch())
		{			
			if($row["cnt"] > 0)
			{
				array_push($messageArray, "Vendor Number is already exist.");
			}
		}
	}	
		
	if(is_nan($_POST["vendorNo"]))
	{
		array_push($messageArray, "Vendor Number must be number only.");
	}else{

		if(strlen(trim($_POST["vendorNo"])) > 4)
		{
			array_push($messageArray, "Vendor Number must be less than 5 characters in length.");
		}
	}

	// validate Vendor Name
	if(empty($_POST["vendorName"]))
	{
		array_push($messageArray, "Vendor Name is required.");
	}else{
	
		if(strlen(trim($_POST["vendorName"])) > 30)
		{
			array_push($messageArray, "Vendor Name must be less than 30 characters in length.");
		}
	}

	// validate Address1
	if(empty($_POST["address1"]))
	{
		array_push($messageArray, "Address1 is required.");
	}else{
	
		if(strlen(trim($_POST["address1"])) > 50)
		{
			array_push($messageArray, "Address1 must be less than 50 characters in length.");
		}
	}	
	
	// validate Address2
	if(empty($_POST["address2"]))
	{
		array_push($messageArray, "Address2 is required.");
	}else{
	
		if(strlen(trim($_POST["address2"])) > 50)
		{
			array_push($messageArray, "Address2 must be less than 50 characters in length.");
		}
	}	

	// validate City
	if(empty($_POST["city"]))
	{
		array_push($messageArray, "City is required.");
	}else{
	
		if(strlen(trim($_POST["city"])) > 30)
		{
			array_push($messageArray, "City must be less than 30 characters in length.");
		}
	}		

	// validate Prov
	if(empty($_POST["prov"]))
	{
		array_push($messageArray, "Prov is required.");
	}	
	
	// validate PostCode
	if(empty($_POST["postCode"]))
	{
		array_push($messageArray, "PostCode is required.");
	}else{
	
		if(strlen(trim($_POST["postCode"])) != 6)
		{
			array_push($messageArray, "PostCode must be 6 characters in length.");
		}else{

			if(!preg_match_all("/[A-z]{1}\d{1}[A-z]{1}\d{1}[A-z]{1}\d{1}/", $_POST["postCode"]))
			{
				array_push($messageArray, "PostCode is not formatted correctly.");
			}
		}
	}

	// validate phone number
	if(empty($_POST["phone"]))
	{
		array_push($messageArray, "Phone Number is required.");
	}else{
	
		if(strlen(trim($_POST["phone"])) != 10)
		{
			array_push($messageArray, "Phone Number must be 10 characters in length.");
		}else{
			if(!preg_match('/[0-9]{10}/', $_POST["phone"]))
			{
				array_push($messageArray, "Phone Number is not formatted correctly.");
			}
		}
	}

	// validate fax number
	if(empty($_POST["fax"]))
	{
		array_push($messageArray, "Fax Number is required.");
	}else{
	
		if(strlen(trim($_POST["fax"])) != 10)
		{
			array_push($messageArray, "Fax Number must be 10 characters in length.");
		}else{
			if(!preg_match('/[0-9]{10}/', $_POST["fax"]))
			{
				array_push($messageArray, "Fax Number is not formatted correctly.");
			}
		}
	}	
	
	if(!empty($messageArray))
	{
		$message = "";
		for($i=0; $i<count($messageArray); $i++)
		{
			if($i!=0)
			{
				$message = $message."<BR>";
			}
			$message = $message.$messageArray[$i];
		}
		
		$_SESSION['errorMessage'] = $message;
		header("location:index.php");
		exit;
	}
	
	//Insert New Vendor Record
	function NewVendorRecord()
	{
		$vendorNo = $_POST['vendorNo'];
		$vendorName = $_POST['vendorName'];
        $address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$prov = $_POST['prov'];
		$postCode = $_POST['postCode'];
		$country = $_POST['country'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];

		$connection = ConnectToDatabase();
		$sql = "INSERT INTO Vendors (VendorNo, VendorName, Address1, Address2, City, Prov, PostCode, Country, Phone, Fax) VALUES($vendorNo, '$vendorName', '$address1', '$address2', '$city', '$prov', '$postCode', '$country', $phone, $fax)";
		$preparedQueryInsert = $connection -> prepare($sql);
		$preparedQueryInsert -> execute();
	}

	function FillVendorTable()
	{

		$tableBodyText = "";

		$connection = ConnectToDatabase();

		$querySelect = "SELECT VendorNo, VendorName, Address1, Address2, City, Prov, PostCode, Country, Phone, Fax FROM Vendors";
		$preparedQuerySelect = $connection -> prepare($querySelect);
		$preparedQuerySelect -> execute();

		while ($row = $preparedQuerySelect -> fetch())
		{

			$vendorNo = number_format($row['VendorNo'], 0, "","");
			$vendorName = $row['VendorName'];
			$address1 = $row['Address1'];
			$address2 = $row['Address2'];
			$city = $row['City'];
			$prov = $row['Prov'];
			$postCode = $row['PostCode'];
			$country = $row['Country'];
			$phone = $row['Phone'];
			$fax = $row['Fax'];				

			$tableBodyText .= "<tr>";
			$tableBodyText .= "<td class='text'>$vendorNo</td>";
			$tableBodyText .= "<td class='text'>$vendorName</td>";
			$tableBodyText .= "<td class='text'>$address1</td>";
			$tableBodyText .= "<td class='text'>$address2</td>";
			$tableBodyText .= "<td class='text'>$city</td>";
			$tableBodyText .= "<td class='text'>$prov</td>";
			$tableBodyText .= "<td class='text'>$postCode</td>";
			$tableBodyText .= "<td class='text'>$country</td>";
			$tableBodyText .= "<td class='text'>$phone</td>";
			$tableBodyText .= "<td class='text'>$fax</td>";
			$tableBodyText .= "</tr>";

		}

		echo $tableBodyText;

	}


	function CreateVendorTableHeader()
	{

		$text = "<tr id='tableHeader'>";
		$text .= "<th>VendorNo</th>";
		$text .= "<th>VendorName</th>";
		$text .= "<th>Address1</th>";
		$text .= "<th>Address2</th>";
		$text .= "<th>City</th>";
		$text .= "<th>Prov</th>";
		$text .= "<th>PostCode</th>";
		$text .= "<th>Country</th>";
		$text .= "<th>Phone</th>";
		$text .= "<th>Fax</th>";
		$text .= "</tr>";

		echo $text;

	}	
?>

<html>

	<head>

		<link rel="stylesheet" href="css/assignment5.css" />

	</head>

	<body>
	<fieldset id="fieldset">
                    <legend id="legend">Input New Data</legend>
                    <table>
                        <tr>
                            <th>Vendor Number</td>
							<th>Vendor Name</th>
							<th>Address1</th>
							<th>Address2</th>
							<th>City</th>
							<th>Prov</th>
							<th>PostCode</th>
							<th>Country</th>
							<th>Phone</th>
							<th>Fax</th>
                        </tr>
                        <tr>
							<td><?php echo $_POST["vendorNo"]; ?></td>
							<td><?php echo $_POST["vendorName"]; ?></td>
							<td><?php echo $_POST["address1"]; ?></td>
							<td><?php echo $_POST["address2"]; ?></td>
							<td><?php echo $_POST["city"]; ?></td>
							<td><?php echo $_POST["prov"]; ?></td>
							<td><?php echo $_POST["postCode"]; ?></td>
							<td><?php echo $_POST["country"]; ?></td>
							<td><?php echo $_POST["phone"]; ?></td>
							<td><?php echo $_POST["fax"]; ?></td>
						</tr>
                    </table>
        </fieldset>
		<br>
		<div>
			<a href="index.php"><input id="home" type="button" value="HOME"></a>
		</div>
		<br>
		<div id="datatable">
		<table>

			<?php
				NewVendorRecord();
				CreateVendorTableHeader();
				FillVendorTable();
			?>

		</table>
		</div>
	</body>

</html>
<?php session_unset(); ?>
