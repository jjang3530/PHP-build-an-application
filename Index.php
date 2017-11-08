<?php
/* 
 * index.php
 * Assignment5: index page
 *
 * Revision History
 *       group8, 2017.07.28: Created
 */
	session_start();
	
	#Error Message check
	$errorMessage = empty($_SESSION['errorMessage']) ? "" : $_SESSION['errorMessage'];
	
		
	#Database Connection
	include("connection.php");
	
	#VendorNumber query
	function FillvendorNumber()
	{

		$tableBodyText = "";

		$connection = ConnectToDatabase();

		$querySelect = "SELECT VendorNo, VendorName FROM Vendors";
		$preparedQuerySelect = $connection -> prepare($querySelect);
		$preparedQuerySelect -> execute();

		while ($row = $preparedQuerySelect -> fetch())
		{

			$vendorNo = $row['VendorNo'];
			$vendorName = $row['VendorName'];

			$tableBodyText .= "<option value='$vendorNo'>$vendorName</option>";

		}

		echo $tableBodyText;

	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Assignment5</title>
    <link rel="stylesheet" type="text/css" href="css/index.css"  />
    <script src="js/main.js"></script>

</head>
<body onload="provCAUS()">

    <!-- header start -->
    <header>

		<h1>Assignment5 - PHP and Database</h1>

	</header>
    <!-- header end -->
	
	<!-- section: display message -->
	<section id="errorArea"></section>
	<?php 
		if(!empty($errorMessage))
		{
			echo "<div class='message'><h3>$errorMessage</h3></div>";
		}
	?>

    <!-- main start -->
    <main>
		<ul>
			<li>Please choose the form between 1 and 3</li>
			<li>Please complete the all record fields of you chose the form.</li>
			<li>Click the Submit button to check the records.</li>
			<li>(<span class="red">*</span>)All mandatory fields must be filled in.</li>
		</ul>
		<!-- 1st input form -->
        <form onsubmit="return ValidatePart();" action="parts.php" method="post">
            <div>
                <fieldset id="fieldset">
                    <legend id="legend">1.New Part Input</legend>
                    <table>
						<tr>
                            <td><label id="partVendorNoLB" class="required">Vendor Number:</label></td>
                            <td>
                                <select id="partVendorNo" name="partVendorNo">
                                    <option value="">Choose a Vendor Number</option>
                                    <?php FillvendorNumber() ?>
                                </select>
                            </td>
                        </tr>
			
                        <tr>
                            <td><label id="descriptionLB" class="required">Description:</label></td>
                            <td><input type="text" name="description" value="" id="description" onblur="this.value = RemoveWhiteSpace(this.value);"></td>
                        </tr>

                        <tr>
                            <td><label id="onHandLB" class="required">OnHand:</label></td>
                            <td><input type="text" name="onHand" value="" id="onHand" onblur="this.value = RemoveWhiteSpace(this.value);"></td>
                        </tr>

                        <tr>
                            <td><label id="onOrderLB" class="required">OnOrder:</label></td>
                            <td><input type="text" name="onOrder" value="" id="onOrder" onblur="this.value = RemoveWhiteSpace(this.value);"></td>
                        </tr>

                        <tr>
                            <td><label id="costLB" class="required">Cost:</label></td>
                            <td><input type="text" name="cost" value="" id="cost" onblur="this.value = toCurrency(this.value);"></td>
                        </tr>

                        <tr>
                            <td><label id="listPriceLB" class="required">List Price:</label></td>
                            <td><input type="text" name="listPrice" value="" id="listPrice" onblur="this.value = toCurrency(this.value);"></td>
                        </tr>
                    </table>
	            <div id="submit" name="registForm">
                <input type="submit" id="checkout" value="New Part Submit">
            </div>
                </fieldset>
            </div>
        </form><br>
		
		
		<!-- 2nd input form -->
		<form name ="vendor" onsubmit="return ValidateVendor();" action="vendors.php" method="post">
		    <div>
				<fieldset id="fieldset">
					<legend id="legend">2.New Vendor Input</legend>
					<table>
						<tr>
							<td><label id="vendorNoLB" class="required">Vendor Number:</label></td>
							<td><input type="text" name="vendorNo" value="" id="vendorNo" onblur="this.value = RemoveWhiteSpace(this.value);"></td>
						</tr>

						<tr>
							<td><label id="vendorNameLB" class="required">Vendor Name:</label></td>
							<td><input type="text" name="vendorName" value="" id="vendorName" onblur="this.value = RemoveWhiteSpace(this.value);"></td>
						</tr>
						
						<tr>
							<td><label id="address1LB" class="required">Address1:</label></td>
							<td><input type="text" name="address1" value="" id="address1" onblur="this.value = RemoveWhiteSpace(this.value); this.value = ToUpper(this.value);"></td>
						</tr>

						<tr>
							<td><label id="address2LB"  class="required">Address2:</label></td>
							<td><input type="text" name="address2" value="" id="address2" onblur="this.value = RemoveWhiteSpace(this.value); this.value = ToUpper(this.value);"></td>
						</tr>

						<tr>
							<td><label id="cityLB" class="required">City:</label></td>
							<td><input type="text" name="city" value="" id="city" onblur="this.value = RemoveWhiteSpace(this.value); this.value = ToUpper(this.value);"></td>
						</tr>

						<tr>
							<td><label id="countryLB" class="required">Country:</label></td>
							<td>
								<input onClick="provCAUS()" type="radio" name="country" id="country" value="CA" checked="checked"><span>&nbsp;Canada&nbsp;&nbsp;&nbsp;</span>
								<input onClick="provCAUS()" type="radio" name="country" id="country" value="US"><span>&nbsp;United States</span>
							</td>
						</tr>
							
						<tr>
							<td><label id="provLB" class="required">Prov:</label></td>
							<td>
								<select id="prov" name="prov">		
							</td>
						</tr>

						<tr>
							<td><label id="postCodeLB" class="required">PostCode:</label></td>
							<td><input type="text" name="postCode" value="" id="postCode" placeholder="ex) A1AB2B" onblur="this.value = RemoveWhiteSpace(this.value); this.value = ToUpper(this.value);"></td>
						</tr>
						
						<tr>
							<td><label id="phoneLB" class="required">Phone Number:</label></td>
							<td><input type="text" name="phone" value="" id="phone" placeholder="ex) 1002003456" onblur="this.value = RemoveWhiteSpace(this.value);"></td>
						</tr>
						
						<tr>
							<td><label id="faxLB"  class="required">Fax Number:</label></td>
							<td><input type="text" name="fax" value="" id="fax" placeholder="ex) 1002003456" onblur="this.value = RemoveWhiteSpace(this.value);"></td>
						</tr>
					</table>
				<div id="submit" name="registForm">
				<input type="submit" id="checkout" value="New Vendor Submit">
			</div>
				</fieldset>
			</div>
		</form><br>



		
		<!-- 3rd input form -->
		<form action="parameter.php" method="post">
			<div id="shippingInfo">
				<fieldset id="fieldset">
					<legend id="legend">3.Find Country Vendors</legend>

					<table>
						<tr>
							<td><label id="countryQrLB" class="required">Country:</label></td>
							<td>
								<input type="radio" name="countryQr" id="countryQr" value="CA" checked="checked"><span>&nbsp;Canada&nbsp;&nbsp;&nbsp;</span><br>
								<input type="radio" name="countryQr" id="countryQr" value="US"><span>&nbsp;United States</span>
							</td>
						</tr>

					</table>
				<div id="submit" name="registForm">
				<input type="submit" id="checkout" value="Find Vendors">
			</div>
				</fieldset>
			</div>
		</form>			
        <div class="clear"></div>
    </main>
    <!-- main end -->

    <!-- footer start-->
    <footer>
        <hr />
        <p>
            Copyright &copy; 2017 Group 8 Hyungseok & Jay All rights reserved.
        </p>
    </footer>
    <!-- footer end -->

</body>
</html>
<?php session_unset(); ?>
