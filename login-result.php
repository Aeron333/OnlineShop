<?php
function detectInputError(){
    global $userID,$password,$emailphone;

    $error=array();

    if($userID==null || $emailphone==null )
        $error['stuid']="A valid  ID is required.";
    elseif(!preg_match('/^[A-Za-z0-9]+$/', $stuid))
        $error['stuid']="There are invalid characters in your ID.";

  if($password==null)
        $error['password']="Please enter your password.";
  elseif(!preg_match('/^[<A-Za-z0-9></A-Za-z0-9> @,\'\.\-\/+$/', $password))
        $error['password']="There are something wrong in your password.";    
        return $error;

}


$userID=$_POST['userID'];
$password=$_POST['password'];

$error = detectInputError();
if(empty($error))
{
    // Success message
    header('Location: main.php');
}
else
{
    // Error message
    printf('
        <h1 style="text-align:center;text-decoration:underline">There are input errors</h1>
        <ul style ="color:red;text-align: center;list-style-type: none;font-size: 30px;font-family:Tahoma, Geneva, Verdana, sans-serif;">%s</ul>
        <p style="text-align: center;"><a href="javascript:history.back()" style="font-size: 40px;padding:5px;font-weight: bold;color: aliceblue;background-color: black;">Back</a></p>',
        implode('', array_map(function ($e) { return "<li>{$e}</li>"; }, $error)));
}
