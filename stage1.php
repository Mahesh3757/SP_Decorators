<?php
// include 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = array('name', 'email', 'phone', 'eventdate', 'address', 'info');
    $missing_fields = array();
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        $missing_fields_str = implode(', ', $missing_fields);
        echo "<script type='text/javascript'> alert('Form fields are missing: $missing_fields_str'); </script>";
    } else {
        // All required fields are present, proceed with data insertion
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $eventdate = $_POST['eventdate'];
        $address = $_POST['address'];
        $eventType = $_POST['EventType'];
        $info = $_POST['info'];

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'decoration');
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("INSERT INTO tblbooking (Name, Email, MobileNumber, EventDate, VenueAddress, EventType, AdditionalInformation) VALUES (?, ?,?, ?, ?, ?, ?)");
            
            if ($stmt) {
                $stmt->bind_param("sssssss", $name, $email, $phone, $eventdate, $address, $eventType, $info);
                $execval = $stmt->execute();
                
                if ($execval) {
                    echo "<script type='text/javascript'> alert('Data stored successfully'); 
                        window.location='payment.html';</script>";
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error in the prepared statement: " . $conn->error;
            }

            $conn->close();
        }
    }
} else {
    echo "<script type='text/javascript'> alert('Invalid request method.'); </script>";
}
?>
