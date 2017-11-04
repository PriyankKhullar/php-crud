// delete conformation method
function deleteFunction() {
	$confirm = confirm("Are you sure want to delete this blog????") ;
	if ( $confirm == true) {
		alert("Record deleted!!!!");
	} else {
		alert("Record not deleted!!!!");
	}
	return $confirm;
}
//show password on signup page
function showPassword() {
	var show_pwd = document.getElementById("password");
	if (show_pwd.type === "password") {
		show_pwd.type = "text";
	} else {
		show_pwd.type = "password";
	}
}
//Update Conformation
function updateFunction() {
	$confirm = confirm("Are you sure want to update this blog????") ;
	return $confirm;
}