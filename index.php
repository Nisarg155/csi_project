
<?php


require_once "config.php";

$pass_error = $email_error = $confirm_error  = $error = "" ;
$email = $password = $confirm = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password_'];
    $confirm = $_POST['confirm'];


    

    if(empty(trim($email)))
    {
        $email_error =  "Please enter email";
    }
    else{
        $sql = "SELECT  * FROM login_details WHERE email = ?";
        $stmt = mysqli_prepare($link,$sql);

        if($stmt)
        {
            mysqli_stmt_bind_param($stmt,"s",$param_email);
            $param_email = trim($email);
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $email_error = "This email is already taken";
                }
                else{
                    $email = trim($email);
                }
            }
            else{
                echo "Something went wrong";
            }
            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($password)))
    {
        $pass_error  = "Please enter password";
    }
    // else if(strlen((trim($password) < 6)))
    // {
    //     $pass_error =  "password is less than 6 length";
    // }
    else{
        if(empty(trim($confirm)))
        {
            $confirm_error = "Please enter confirm password";
        }
        if(trim($password) != trim($confirm))
        {
            $confirm_error = "Password did not match";
        }
        else{
            $password = trim($password);
        }
    }

    if(empty($email_error) && empty($pass_error) && empty($confirm_error))
    {
        $sql = "INSERT INTO login_details (email,password_) VALUES (?,?)";
        $stmt = mysqli_prepare($link,$sql);

        if($stmt)
        {
            mysqli_stmt_bind_param($stmt,"ss",$param_email,$param_password);
            $param_email = $email;
            $param_password = $password;
            mysqli_stmt_execute($stmt);
            header("location: welcome.html");
        }
    }
    else{
        echo "Something went wrong";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body >
    <div id="login">
        <label for="email" >Email</label>
        <p><?php echo $email_error ?></p>
        <input type="email" id="email" name="email">
        <br>
        <label for="password" >Password</label>
        <p><?php echo $pass_error ?></p>
        <input type="password" id="password_" name="password_">
        <br>
        <lable  for="confirm" >Confirm Password</lable>
        <p><?php echo $confirm_error ?></p>
        <input type="password" id="confirm" name="confirm">
        <br>
        <button   type="submit" id="form">Login</button>
    </div>

    <script src="s.js"></script>
</body>
</html>