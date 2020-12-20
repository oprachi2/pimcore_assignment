<?php
session_start();

function is_user_logged_in(){
    // return true if user is already logged in
    // otherwise return false
if($_SESSION['uname']=="")
{
return false;
}
else
{
return true;
}    
}

function make_user_session($userdata){
    // set user details in session
  $_SESSION['uname'] = $userdata;

}

function destroy_user_session(){
    // destroy session and redirect to login page
                  session_destroy();
	header('location:index.php');
	exit();

   
}

?>