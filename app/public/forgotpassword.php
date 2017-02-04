<?php
require '../vendor/autoload.php';

use AWSCognitoApp\AWSCognitoWrapper;

$wrapper = new AWSCognitoWrapper();
$wrapper->initialize();

$entercode = false;

if(isset($_POST['action'])) {

    if($_POST['action'] === 'code') {
        $username = $_POST['username'] ?? '';

        $error = $wrapper->sendPasswordResetMail($username);

        if(empty($error)) {
            header('Location: forgotpassword.php?username=' . $username);
        }
    }

    if($_POST['action'] == 'reset') {

        $code = $_POST['code'] ?? '';
        $password = $_POST['password'] ?? '';
        $username = $_GET['username'] ?? '';

        $error = $wrapper->resetPassword($code, $password, $username);

        // TODO: show message on new page that password has been reset
        if(empty($error)) {
            header('Location: index.php?reset');
        }
    }
}

if(isset($_GET['username'])) {
    $entercode = true;
}
?>

<!doctype html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='x-ua-compatible' content='ie=edge'>
        <title>AWS Cognito App - Register and Login</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
    </head>
    <body>
        <h1>Menu</h1>
        <ul>
            <li><a href='/'>Index</a></li>
            <li><a href='/secure.php'>Secure page</a></li>
            <li><a href='/confirm.php'>Confirm signup</a></li>
            <li><a href='/forgotpassword.php'>Forgotten password</a></li>
            <li><a href='/logout.php'>Logout</a></li>
        </ul>
        <p style='color: red;'><?php echo $error;?></p>
        <?php if($entercode) { ?>
        <h1>Reset password</h1>
        <p>If your account was found, an e-mail has been sent to the associated e-mailadres. Enter the code and your new password.</p>
        <form method='post' action=''>
            <input type='text' placeholder='Code' name='code' /><br />
            <input type='password' placeholder='Password' name='password' /><br />
            <input type='hidden' name='action' value='reset' />
            <input type='submit' value='Reset password' />
        </form>
        <?php } else { ?>
        <h1>Forgotten password</h1>
        <p>Enter your username and we will sent you a reset code to your e-mailadres.</p>
        <form method='post' action=''>
            <input type='text' placeholder='Username' name='username' /><br />
            <input type='hidden' name='action' value='register' />
            <input type='hidden' name='action' value='code' />
            <input type='submit' value='Receive code' />
        </form>
        <?php }?>
    </body>
</html>
