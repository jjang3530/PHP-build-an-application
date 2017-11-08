/* Const Area */
// Regular Expression
const REG_EXP_EMAIL = /[A-z0-9]+[\-\.\_]?[A-z0-9]+[\@]{1}[A-z0-9]{2,}[\.]+[A-z0-9]{2,}/;
const REG_EXP_PASSWORD_NUMBER = /[0-9]+/;
const REG_EXP_PASSWORD_UPPER = /[A-Z]+/;
const REG_EXP_PASSWORD_LOWER = /[a-z]+/;
const REG_EXP_ON_NUMBER = /\D+/;
const REG_EXP_PHONE_NUMBER = /\D+/;
const REG_EXP_ZIPCODE = /[A-z]{1}\d{1}[A-z]{1}\d{1}[A-z]{1}\d{1}/;
//const REG_EXP_USCODE = /\d{1}\d{1}\d{1}\d{1}\d{1}\d{1}/;

// Message
const MSG_REQUIRED = "{0} is required."; //empty field required
const MSG_NUMBER = "{0} must be number only.";
const MSG_LENGTH_LESS = "{0} must be less than {1} characters in length.";
const MSG_LENGTH_EQUAL = "{0} must be {1} characters in length.";
const MSG_LENGTH_BETWEEN = "{0} must be between {1} and {2} characters in length.";
const MSG_FORMAT = "{0} is not formatted correctly.";
const MSG_CONFIRM = "{0} must be the same as {1}.";

/* Global variable */
// error message
var errorMessage;


function Init()
{

	errorMessage = new Array();
	SetFocus("");

}	

function ValidatePart()
{

	errorMessage = new Array();

	CheckPartVendorNumber();
	CheckDescription();
	CheckOnHand();
	CheckOnOrder();
	CheckCost();
	CheckListPrice();
	
	if(errorMessage.length > 0)
	{
		DisplayErrorMessage();
		return false;
	}
}

function ValidateVendor()
{

	errorMessage = new Array();

	CheckVendorNumber();
	CheckVendorName();
	CheckAddress1();
	CheckAddress2();
	CheckCity();
	CheckProv();
	CheckPostCode();
	CheckPhone();
	CheckFax();
	
	if(errorMessage.length > 0)
	{
		DisplayErrorMessage();
		return false;
	}
}

function CheckPartVendorNumber()
{	
	// vendorNumber
	var id = "partVendorNo";
	var fieldName = "Vendor Number";
	var partVendorNo = document.getElementById(id).value;
	if(IsEmpty(partVendorNo))
	{
	    SetError(id, MSG_REQUIRED, [fieldName]);
		return;
	}

	ClearColor(id);
}

function CheckDescription()
{	
	// description
	var id = "description";
	var fieldName = "Description";
	var description = document.getElementById(id).value;
	if(IsEmpty(description))
	{
	    SetError(id, MSG_REQUIRED, [fieldName]);
		return;
	}
	
	if(description.trim().length > 30){
		SetError(id, MSG_LENGTH_LESS , [fieldName, "30"]);
		return;
	}

	ClearColor(id);
}

function CheckOnHand()
{
	//onHand
    var id = "onHand";
	var fieldName = "OnHand";
    var onHand = document.getElementById(id).value;

    if (IsEmpty(onHand)) {
        SetError(id, MSG_REQUIRED, [fieldName]);
        return;
    }
	
	if (isNaN(onHand)) {
		SetError(id, MSG_NUMBER, [fieldName]);
		return;
    }
	
	if(onHand.trim().length > 5){
		SetError(id, MSG_LENGTH_LESS, [fieldName, "6"]);
		return;
	}
	
	if(REG_EXP_ON_NUMBER.test(onHand)){
		SetError(id, MSG_FORMAT, [fieldName]);
		return;
	}
	ClearColor(id);
}

function CheckOnOrder()
{
	//onOrder
    var id = "onOrder";
	var fieldName = "OnOrder";
    var onOrder = document.getElementById(id).value;

    if (IsEmpty(onOrder)) {
        SetError(id, MSG_REQUIRED, [fieldName]);
        return;
    }
	
	if (isNaN(onOrder)) {
		SetError(id, MSG_NUMBER, [fieldName]);
		return;
    }
	
	if(onOrder.trim().length > 5){
		SetError(id, MSG_LENGTH_LESS, [fieldName, "6"]);
		return;
	}
	
	if(REG_EXP_ON_NUMBER.test(onOrder)){
		SetError(id, MSG_FORMAT, [fieldName]);
		return;
	}
	
	
	ClearColor(id);
}

function CheckCost()
{
	//cost
    var id = "cost";
	var fieldName = "Cost";
    var cost = document.getElementById(id).value;

    if (IsEmpty(cost)) {
        SetError(id, MSG_REQUIRED, [fieldName]);
        return;
    }
	if (isNaN(cost)) {
        SetError(id, MSG_NUMBER, [fieldName]);
        return;
    }
	if(cost <= 0 || cost >=10000)
	{
		SetError(id, MSG_LENGTH_BETWEEN, [fieldName, "0", "10,000"]);
		return;
	}
	
	ClearColor(id);
}

function CheckListPrice()
{
	//listPrice
    var id = "listPrice";
	var fieldName = "List Price";
    var listPrice = document.getElementById(id).value;

    if (IsEmpty(listPrice)) {
        SetError(id, MSG_REQUIRED, [fieldName]);
        return;
    }
	if (isNaN(listPrice)) {
        SetError(id, MSG_NUMBER, [fieldName]);
        return;
    }
	if(listPrice <= 0 || listPrice >=10000)
	{
		SetError(id, MSG_LENGTH_BETWEEN, [fieldName, "0", "10,000"]);
		return;
	}
	
	ClearColor(id);
}




//2nd input validation
function CheckVendorNumber()
{	
	// vendorNumber
	var id = "vendorNo";
	var fieldName = "Vendor Number";
	var vendorNo = document.getElementById(id).value;
	if(IsEmpty(vendorNo))
	{
	    SetError(id, MSG_REQUIRED, [fieldName]);
		return;
	}
	if (isNaN(vendorNo)) {
        SetError(id, MSG_NUMBER, [fieldName]);
        return;
    }
	if(vendorNo.trim().length > 4){
		SetError(id, MSG_LENGTH_LESS, [fieldName, "5"]);
		return;
	}

	ClearColor(id);
}

function CheckVendorName()
{	
	// name
	var id = "vendorName";
	var fieldName = "Vendor Name";
	var vendorName = document.getElementById(id).value;
	if(IsEmpty(vendorName))
	{
	    SetError(id, MSG_REQUIRED, [fieldName]);
		return;
	}
	
	if(vendorName.trim().length > 30){
		SetError(id, MSG_LENGTH_LESS , [fieldName, "30"]);
		return;
	}

	ClearColor(id);
}

function CheckAddress1()
{
	var id = "address1";
	var fieldName = "Address1";
	var address1 = document.getElementById(id).value;
	
    // Address
	if (IsEmpty(address1)) {
	    SetError(id, MSG_REQUIRED, [fieldName]);
	    return;
	}
	if(!IsEmpty(address1) && address.trim().length > 50)
	{
	    SetError(id, MSG_LENGTH_LESS, [fieldName, "50"]);
		return;
	}
	    ClearColor(id);

}

function CheckAddress2()
{
	var id = "address2";
	var fieldName = "Address2";
	var address2 = document.getElementById(id).value;
	
    // Address
	if (IsEmpty(address2)) {
	    SetError(id, MSG_REQUIRED, [fieldName]);
	    return;
	}
	if(!IsEmpty(address2) && address.trim().length > 50)
	{
	    SetError(id, MSG_LENGTH_LESS, [fieldName, "50"]);
		return;
	}
	    ClearColor(id);
}

function CheckCity()
{
    var id = "city";
    var fieldName = "City";
    var city = document.getElementById(id).value;

    // City
    if (IsEmpty(city)) {
        SetError(id, MSG_REQUIRED, [fieldName]);
        return;
    }
    if (!IsEmpty(city) && city.trim().length > 30) {
        SetError(id, MSG_LENGTH_LESS, [fieldName, "30"]);
    } else {
        ClearColor(id);
    }
}

function CheckProv()
{
    
	var id = "prov";
	var fieldName = "Prov";
    var prov = document.getElementById(id).value;

    // Prov	
    if (IsEmpty(prov)) {
        SetError(id, MSG_REQUIRED, [fieldName]);
        return;
    }
	ClearColor(id);
}

function CheckPostCode()
{
    var id = "postCode";
    var fieldName = "PostCode";
    var postCode = document.getElementById(id).value;

    // postCode	
    if (IsEmpty(postCode)) {
        SetError(id, MSG_REQUIRED, [fieldName]);
        return;
    }
        if (postCode.trim().length != 6) {
            SetError(id, MSG_LENGTH_EQUAL, [fieldName, "6"]);

        } else {

            if (!REG_EXP_ZIPCODE.test(postCode)) {
                SetError(id, MSG_FORMAT, [fieldName]);
            } else {
                ClearColor(id);
            }
        }
}

function CheckPhone()
{

	// phone
	var id = "phone";
	var fieldName = "Phone Number";
	var phone = document.getElementById(id).value;
	if(IsEmpty(phone))
	{
		SetError(id, MSG_REQUIRED, [fieldName]);
		return;
	}
	if (isNaN(phone)) {
        SetError(id, MSG_NUMBER, [fieldName]);
        return;
    }
	if(phone.trim().length != 10){
		SetError(id, MSG_LENGTH_EQUAL, [fieldName, "10"]);
		return;
	}
	
	if(REG_EXP_PHONE_NUMBER.test(phone)){
		SetError(id, MSG_FORMAT, [fieldName]);
		return;
	}
	
	ClearColor(id);

}

function CheckFax()
{

	// fax
	var id = "fax";
	var fieldName = "Fax Number";
	var fax = document.getElementById(id).value;
	
	if(IsEmpty(fax))
	{
		SetError(id, MSG_REQUIRED, [fieldName]);
		return;
	}
	if (isNaN(fax)) {
        SetError(id, MSG_NUMBER, [fieldName]);
        return;
    }	
	if(fax.trim().length != 10){
		SetError(id, MSG_LENGTH_EQUAL, [fieldName, "10"]);
		return;
	}
	
	if(REG_EXP_PHONE_NUMBER.test(fax)){
		SetError(id, MSG_FORMAT, [fieldName]);
		return;
	}
	
	ClearColor(id);

}



// function separate.



function DisplayErrorMessage()
{
	var message = "";
	for(var i=0; i<errorMessage.length; i++)
	{
		message += errorMessage[i] + "<BR>";
	
	}
	
	// display error messages
	document.getElementById("errorArea").innerHTML = message;
	document.getElementById("errorArea").style = "display: block;";
}


function SetError(id, messageID, argArray)
{
	SetFocus(id);
	// set message;
	errorMessage.push(GetMessage(messageID, argArray));
	// set color
	SetErrorStyle(id);

}


function SetErrorStyle(id)
{
	// set color
	document.getElementById(id).style="background-color:pink; border-color: red;";
	var labelID = id + "LB";
	document.getElementById(labelID).style="color:red;";
			
}

function ClearColor(id)
{
	// set color
	document.getElementById(id).style="";
	var labelID = id + "LB";
	document.getElementById(labelID).style="";

}

/*
 * 
 */
function SetFocus(id)
{
	if(errorMessage.length == 0)
	{
		document.getElementById(id).focus();
	}
	
}		

function Capitalize(str)
{
	if(IsEmpty(str))
	{
		return str;
	}
	
	var strArray = str.split(" ");
	var ret = "";
	
	for(var i=0; i<strArray.length; i++)
	{
		if(i != 0)
		{
			ret += " ";
		}
		ret += strArray[i].charAt(0).toUpperCase() + strArray[i].slice(1).toLowerCase();
	}
	
	return ret;
}

function RemoveWhiteSpace(str)
{
	return str == null ? str : str.trim();
}

function toCurrency(str)
{
	return IsEmpty(str) ? str : parseFloat(str).toFixed(2)
}



function ToUpper(str)
{
	return IsEmpty(str) ? str : str.toUpperCase();
}

function GetMessage(messageID, argArray)
{
	var message = messageID;
	if(argArray != null && argArray.length > 0 )
	{
		for(var i=0; i<argArray.length; i++)
		{
			
			message = message.replace("{" + i + "}", argArray[i]);
		}		
	}

	return message;
}

function IsEmpty(str)
{
	return str == null || str.trim().length == 0;
}		

function provCAUS()
{
	if(document.vendor.country.value == "CA")
	{
		document.getElementById('prov').innerHTML = "";
		document.getElementById('prov').innerHTML += '<option value="">Choose a province</option>';
		document.getElementById('prov').innerHTML += '<option value="AB">Alberta</option>';
		document.getElementById('prov').innerHTML += '<option value="BC">British Columbia</option>';
		document.getElementById('prov').innerHTML += '<option value="MN">Manitoba</option>';
		document.getElementById('prov').innerHTML += '<option value="NB">New Brunswick</option>';
		document.getElementById('prov').innerHTML += '<option value="NL">Newfoundland and Labrador</option>';
		document.getElementById('prov').innerHTML += '<option value="NS">Nova Scotia</option>';
		document.getElementById('prov').innerHTML += '<option value="ON">Ontario</option>';
		document.getElementById('prov').innerHTML += '<option value="PE">Prince Edward Island</option>';
		document.getElementById('prov').innerHTML += '<option value="SC">Saskatchewan</option>';
		document.getElementById('prov').innerHTML += '<option value="QC">Quebec</option>';
		document.getElementById('prov').innerHTML += '<option value="NT">Northwest Territories</option>';
		document.getElementById('prov').innerHTML += '<option value="NU">Nunavut</option>';
		document.getElementById('prov').innerHTML += '<option value="YT">Yukon</option>';
		document.getElementById('prov').innerHTML += '</select>';	
	}
	else if(document.vendor.country.value == "US")
	{
		document.getElementById('prov').innerHTML = "";
		document.getElementById('prov').innerHTML += '<option value="">Choose a province</option>';
		document.getElementById('prov').innerHTML += '<option value="AL">Alabama</option>';
		document.getElementById('prov').innerHTML += '<option value="AK">Alaska</option>';
		document.getElementById('prov').innerHTML += '<option value="AZ">Arizona</option>';
		document.getElementById('prov').innerHTML += '<option value="AR">Arkansas</option>';
		document.getElementById('prov').innerHTML += '<option value="CA">California</option>';
		document.getElementById('prov').innerHTML += '<option value="CO">Colorado</option>';
		document.getElementById('prov').innerHTML += '<option value="CT">Connecticut</option>';
		document.getElementById('prov').innerHTML += '<option value="DE">Delaware</option>';
		document.getElementById('prov').innerHTML += '<option value="FL">Florida</option>';
		document.getElementById('prov').innerHTML += '<option value="GA">Georgia</option>';
		document.getElementById('prov').innerHTML += '<option value="HI">Hawaii</option>';
		document.getElementById('prov').innerHTML += '<option value="ID">Idaho</option>';
		document.getElementById('prov').innerHTML += '<option value="IL">Illinois</option>';
		document.getElementById('prov').innerHTML += '<option value="IN">Indiana</option>';
		document.getElementById('prov').innerHTML += '<option value="IA">Iowa</option>';
		document.getElementById('prov').innerHTML += '<option value="KS">Kansas</option>';
		document.getElementById('prov').innerHTML += '<option value="KY">Kentucky</option>';
		document.getElementById('prov').innerHTML += '<option value="LA">Louisiana</option>';
		document.getElementById('prov').innerHTML += '<option value="ME">Maine</option>';
		document.getElementById('prov').innerHTML += '<option value="MD">Maryland</option>';
		document.getElementById('prov').innerHTML += '<option value="MA">Massachusetts</option>';
		document.getElementById('prov').innerHTML += '<option value="MI">Michigan</option>';
		document.getElementById('prov').innerHTML += '<option value="MN">Minnesota</option>';
		document.getElementById('prov').innerHTML += '<option value="MS">Mississippi</option>';
		document.getElementById('prov').innerHTML += '<option value="MO">Missouri</option>';
		document.getElementById('prov').innerHTML += '<option value="MT">Montana</option>';
		document.getElementById('prov').innerHTML += '<option value="NE">Nebraska</option>';
		document.getElementById('prov').innerHTML += '<option value="NV">Nevada</option>';
		document.getElementById('prov').innerHTML += '<option value="NH">New Hampshire</option>';
		document.getElementById('prov').innerHTML += '<option value="NJ">New Jersey</option>';
		document.getElementById('prov').innerHTML += '<option value="NM">New Mexico</option>';
		document.getElementById('prov').innerHTML += '<option value="NY">New York</option>';
		document.getElementById('prov').innerHTML += '<option value="NC">North Carolina</option>';
		document.getElementById('prov').innerHTML += '<option value="ND">North Dakota</option>';
		document.getElementById('prov').innerHTML += '<option value="OH">Ohio</option>';
		document.getElementById('prov').innerHTML += '<option value="OK">Oklahoma</option>';
		document.getElementById('prov').innerHTML += '<option value="OR">Oregon</option>';
		document.getElementById('prov').innerHTML += '<option value="PA">Pennsylvania</option>';
		document.getElementById('prov').innerHTML += '<option value="RI">Rhode Island</option>';
		document.getElementById('prov').innerHTML += '<option value="SC">South Carolina</option>';
		document.getElementById('prov').innerHTML += '<option value="SD">South Dakota</option>';
		document.getElementById('prov').innerHTML += '<option value="TN">Tennessee</option>';
		document.getElementById('prov').innerHTML += '<option value="TX">Texas</option>';
		document.getElementById('prov').innerHTML += '<option value="UT">Utah</option>';
		document.getElementById('prov').innerHTML += '<option value="VT">Vermont</option>';
		document.getElementById('prov').innerHTML += '<option value="VA">Virginia</option>';
		document.getElementById('prov').innerHTML += '<option value="WA">Washington</option>';
		document.getElementById('prov').innerHTML += '<option value="WV">West Virginia</option>';
		document.getElementById('prov').innerHTML += '<option value="WI">Wisconsin</option>';
		document.getElementById('prov').innerHTML += '<option value="WY">Wyoming</option>';	
		document.getElementById('prov').innerHTML += '</select>';
	}
}