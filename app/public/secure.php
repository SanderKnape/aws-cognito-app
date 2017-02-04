<?php
require '../vendor/autoload.php';

use AWSCognitoApp\AWSCognitoWrapper;

$wrapper = new AWSCognitoWrapper();
$wrapper->initialize();

if(!$wrapper->isAuthenticated()) {
    header('Location: /');
    exit;
}

$user = $wrapper->getUser();
$pool = $wrapper->getPoolMetadata();
$users = $wrapper->getPoolUsers();
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
        <h1>Secure page</h1>
        <p>Welcome <strong><?php echo $user->get('Username');?></strong>! You are succesfully authenticated. Some <em>secret</em> information about this user pool:</p>

        <h2>Metadata</h2>
        <p><b>Id:</b> <?php echo $pool['Id'];?></p>
        <p><b>Name:</b> <?php echo $pool['Name'];?></p>
        <p><b>CreationDate:</b> <?php echo $pool['CreationDate'];?></p>

        <h2>Users</h2>
        <ul>
        <?php
        foreach($users as $user) {
            $email_attribute_index = array_search('email', array_column($user['Attributes'], 'Name'));
            $email = $user['Attributes'][$email_attribute_index]['Value'];

            echo "<li>{$user['Username']} ({$email})</li>";
        }
        ?>
        </ul>
    </body>
</html>
