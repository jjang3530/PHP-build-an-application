<?php
/* 
 * parts.php
 * Assignment5: parts page
 *
 * Revision History
 *       group8, 2017.07.28: Created
 */
 	session_start();

	$messageArray = array();
	
	// validate Vendor Number
	if(empty($_POST["partVendorNo"]))
	{
		array_push($messageArray, "Vendor Number is required.");
	}

	// validate Description
	if(empty($_POST["description"]))
	{
		array_push($messageArray, "Description is required.");
	}else{
	
		if(strlen(trim($_POST["description"])) > 30)
		{
			array_push($messageArray, "Description must be less than 30 characters in length.");
		}
	}

	// validate OnHand
	if(empty($_POST["onHand"]))
	{
		array_push($messageArray, "OnHand is required.");
	}else{
	
		if(is_nan($_POST["onHand"]))
		{
			array_push($messageArray, "OnHand must be number only.");
		}else{
	
			if(strlen(trim($_POST["onHand"])) > 5)
			{
				array_push($messageArray, "OnHand must be less than 6 characters in length.");
			}
		}
	}
	
	// validate OnOrder
	if(empty($_POST["onOrder"]))
	{
		array_push($messageArray, "OnOrder is required.");
	}else{
	
		if(is_nan($_POST["onOrder"]))
		{
			array_push($messageArray, "OnOrder must be number only.");
		}else{
	
			if(strlen(trim($_POST["onOrder"])) > 5)
			{
				array_push($messageArray, "OnOrder must be less than 6 characters in length.");
			}
		}
	}
	
	// validate Cost
	if(empty($_POST["cost"]))
	{
		array_push($messageArray, "Cost is required.");
	}else{
	
		if(is_nan($_POST["cost"]))
		{
			array_push($messageArray, "Cost must be number only.");
		}
	}
	
	// validate List Price
	if(empty($_POST["listPrice"]))
	{
		array_push($messageArray, "List Price is required.");
	}else{
	
		if(is_nan($_POST["listPrice"]))
		{
			array_push($messageArray, "List Price must be number only.");
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

	// Connection
	include("connection.php");
	
	// Insert New Record
	function NewPartRecord()
	{
		$partVendorNo = $_POST['partVendorNo'];
        $description = $_POST['description'];
		$onHand = $_POST['onHand'];
		$onOrder = $_POST['onOrder'];
		$cost = $_POST['cost'];
		$listPrice = $_POST['listPrice'];

		$connection = ConnectToDatabase();
		$sql = "INSERT INTO Parts (VendorNo, Description, OnHand, OnOrder, Cost, ListPrice) VALUES($partVendorNo, '$description', $onHand, $onOrder, $cost, $listPrice)";
		$preparedQueryInsert = $connection -> prepare($sql);
		$preparedQueryInsert -> execute();
	}

	//Write table data
	function FillPartTable()
	{

		$tableBodyText = "";

		$connection = ConnectToDatabase();

		$querySelect = "SELECT PartID, VendorNo, Description, OnHand, OnOrder, Cost, ListPrice FROM Parts";
		$preparedQuerySelect = $connection -> prepare($querySelect);
		$preparedQuerySelect -> execute();

		while ($row = $preparedQuerySelect -> fetch())
		{

			$partID = $row['PartID'];
			$vendorNo = number_format($row['VendorNo'], 0, "","");
			$description = $row['Description'];
			$onHand = $row['OnHand'];
			$onOrder = $row['OnOrder'];
			$cost = $row['Cost'];
			$listPrice = $row['ListPrice'];

			$tableBodyText .= "<tr>";
			$tableBodyText .= "<td class='text'>$partID</td>";
			$tableBodyText .= "<td class='text'>$vendorNo</td>";
			$tableBodyText .= "<td class='text'>$description</td>";
			$tableBodyText .= "<td class='text'>$onHand</td>";
			$tableBodyText .= "<td class='text'>$onOrder</td>";
			$tableBodyText .= "<td class='text'>$cost</td>";
			$tableBodyText .= "<td class='text'>$listPrice</td>";
			$tableBodyText .= "</tr>";

		}

		echo $tableBodyText;

	}


	function CreatePartTableHeader()
	{

		$text = "<tr id='tableHeader'>";
		$text .= "<th>PartID</th>";
		$text .= "<th>VendorNo</th>";
		$text .= "<th>Description</th>";
		$text .= "<th>OnHand</th>";
		$text .= "<th>OnOrder</th>";
		$text .= "<th>Cost</th>";
		$text .= "<th>ListPrice</th>";
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
							<th>Description</th>
							<th>OnHand</th>
							<th>OnOrder</th>
							<th>Cost</th>
							<th>List Price</th>
                        </tr>
                        <tr>
							<td><?php echo number_format($_POST["partVendorNo"], 0, "",""); ?></td>
							<td><?php echo $_POST["description"]; ?></td>
							<td><?php echo $_POST["onHand"]; ?></td>
							<td><?php echo $_POST["onOrder"]; ?></td>
							<td><?php echo $_POST["cost"]; ?></td>
							<td><?php echo $_POST["listPrice"]; ?></td>
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
				NewPartRecord();
				CreatePartTableHeader();
				FillPartTable();
			?>

		</table>
		</div>
	</body>

</html>
<?php session_unset(); ?>
