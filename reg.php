<?php
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'sp');
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed: " . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone) VALUES (?, ?, ?, ?, ?)");
    
    // Check if the prepare statement was successful
    if ($stmt) {
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $phone);
        $execval = $stmt->execute();
        
        echo $execval;

        echo "<script type='text/javascript'> alert('Register Successfully'); 
                window.location='index.html';</script>";
        exit();

        $stmt->close();
    } else {
        echo "Error in the prepared statement: " . $conn->error;
    }

    $conn->close();
}
?>
