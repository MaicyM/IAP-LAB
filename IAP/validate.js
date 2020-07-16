function validateForm(){
	var fname=document.forms["user_details"]["first_name"].value;
	var lname=document.forms["user_details"]["last_name"].value;
	var city=document.forms["user_details"]["city"].value;

	if(fname==null||lname==null||city==null){
		alert("All details required are not provided.");
		return false;
	}
	return true;
}