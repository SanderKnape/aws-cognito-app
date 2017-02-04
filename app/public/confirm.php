<?php
require '../vendor/autoload.php';

use AWSCognitoApp\AWSCognitoWrapper;

$wrapper = new AWSCognitoWrapper();
$wrapper->initialize();

if(isset($_POST['action'])) {
    $username = $_POST['username'] ?? '';
    $confirmation = $_POST['confirmation'] ?? '';

    $error = $wrapper->confirmSignup($username, $confirmation);

    if(empty($error)) {
        header('Location: secure.php');
    }
}

$username = $_GET['username'] ?? '';
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
        <h1>Confirm signup</h1>
        <form method='post' action=''>
            <input type='text' placeholder='Username' name='username' value='<?php echo $username;?>' /><br />
            <input type='text' placeholder='Confirmation code' name='confirmation' /><br />
            <input type='hidden' name='action' value='confirm' />
            <input type='submit' value='Confirm' />
        </form>
    </body>
</html>
