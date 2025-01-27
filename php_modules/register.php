<?php
// Change this to your connection info.
$DATABASE_HOST = 'ilmira';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
$DATABASE_NAME = 'phplogin';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data was submitted, isset() function will check if the data exists.

//if (!isset($_POST['username'], $_POST['password'], $_POST['name']), $_POST['surname']) {
	// Could not get the data that should have been sent.
	//exit('Please complete the registration form!');
//}

// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['name']) || empty($_POST['surname'])) {
	// One or more values are empty.
	exit('Please complete the registration form');
}
// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE nick = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Username exists, please choose another!';
	} else {
		// Username doesnt exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO accounts (nick, password, name, surname) VALUES (?, ?, ?, ?)')) {
	        // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
	        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	        $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['name'], $_POST['surname']);
	        $stmt->execute();
	        echo 'You have successfully registered, you can now login!';
            header('Location: ../index.html'); 
        } else {
	        // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	        echo 'Could not prepare statement!1';
        }
	}
	$stmt->close();
} else {
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	echo 'Could not prepare statement!2';
}
$con->close();
?>