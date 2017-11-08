<?php
/* 
 * parameter.php
 * Assignment5: parameter page
 *
 * Revision History
 *       group8, 2017.07.28: Created
 */

	include("connection.php");
	
	function FillVendorTable()
	{

		$tableBodyText = "";

		$connection = ConnectToDatabase();
		
		$queryValue = $_POST['countryQr'];
		
		$querySelect = "SELECT VendorNo, VendorName, Address1, Address2, City, Prov, PostCode, Country, Phone, Fax FROM Vendors ";
		$querySelect .= "WHERE Country = ?"; 
		$preparedQuerySelect = $connection -> prepare($querySelect);
		$param = array($queryValue);
		$preparedQuerySelect -> execute($param);

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
                    <legend id="legend"><?php echo $_POST['countryQr'] ?> Vendors</legend>
		<div id="datatable">
		<table>

			<?php
				CreateVendorTableHeader();
				FillVendorTable();
			?>

		</table>
		</div>
        </fieldset>
		<br>
		<div>
			<a href="index.php"><input id="home" type="button" value="HOME"></a>
		</div>
	</body>

</html>

