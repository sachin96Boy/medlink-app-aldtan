<?php
// Check if the POST request contains the 'message' parameter
if (isset($_POST['message'])) {
    // Retrieve the 'message' parameter
    $fingerprintData = $_POST['message'];
    if (is_numeric($fingerprintData)) {
        userData($fingerprintData);

    } else {

        $date = date('Y-m-d H:i:s');
        insertData($fingerprintData,$date);
        echo '<script type="text/javascript">
            setTimeout(function () {
                location.reload();
            }, 500); // Reload after 5 seconds
        </script>';
    }
}

function insertData($fingerprintData, $date) {
    // Database connection settings
    $servername = "89.117.157.3";
    $username = "u991943496_medlink123";
    $password = "Aldtan2023@medlink";
    $dbname = "u991943496_medlink";

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize a transaction
    $conn->begin_transaction();

    // Get the current date
    $currentDate = date('Y-m-d');

    // Get the latest appointment for the current date
    $sql = "SELECT appointment_no FROM appoinments WHERE date = '$currentDate' ORDER BY appointment_no DESC LIMIT 1";
    $result = $conn->query($sql);

    // Calculate the new appointment number
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $appointment_no = $row['appointment_no'] + 1;
    } else {
        $appointment_no = 1;
    }

    // Get the next patient ID from the "patients" table
    $sql = "SELECT MAX(id) AS max_id FROM patients";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $patientId = $row['max_id'] + 1;

    $patientName = "patient" . $appointment_no;

    // Use a prepared statement to execute the INSERT query for "appoinments"
    $sql = "INSERT INTO appoinments (appointment_no, patient_id, patient_name, date,appdateTime, finger_print) VALUES (?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iissss", $appointment_no, $patientId, $patientName, $date,$date ,$fingerprintData);

        // Execute the prepared statement for "appoinments"
        if ($stmt->execute()) {
            // Continue with the "patients" table insertion
            $sql = "INSERT INTO patients (fingerprint_id,name) VALUES (?,?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ss", $fingerprintData,$patientName);

                // Execute the prepared statement for "patients"
                if ($stmt->execute()) {
                    // Both inserts were successful, commit the transaction
                    $conn->commit();
                    echo $patientId;
                } else {
                    // An error occurred during the "patients" insert, rollback the transaction
                    $conn->rollback();
                    echo "Error: " . $stmt->error;
                }
            } else {
                $conn->rollback();
                echo "Failed to prepare the SQL statement for 'patients'.";
            }
        } else {
            // An error occurred during the "appoinments" insert, rollback the transaction
            $conn->rollback();
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Failed to prepare the SQL statement for 'appoinments'.";
        $conn->rollback();
    }

    // Close the database connection
    $conn->close();
}



function userData($fingerprintData) {
    // Database connection settings
    $servername = "89.117.157.3";
    $username = "u991943496_medlink123";
    $password = "Aldtan2023@medlink";
    $dbname = "u991943496_medlink";

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use a prepared statement to execute the SELECT query
    $sql = "SELECT name, fingerprint_id FROM patients WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the fingerprintData value to the prepared statement
        $stmt->bind_param("i", $fingerprintData);

        // Execute the prepared statement
        $stmt->execute();

        // Bind the result to variables
        $stmt->bind_result($name, $fingerprint_id);

        // Fetch the result
        if ($stmt->fetch()) {
           
            $user = $name;
            $date = date('Y-m-d H:i:s');
            $userid=$fingerprintData;

            insertuser($fingerprint_id,$user, $date,$userid);
        } else {
            echo "No matching patient found.";
        }
        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }

    $conn->close();
}

function insertuser($fingerprintData,$user, $date,$userid) {
    // Database connection settings
    $servername = "89.117.157.3";
    $username = "u991943496_medlink123";
    $password = "Aldtan2023@medlink";
    $dbname = "u991943496_medlink";

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize a transaction
    $conn->begin_transaction();

    // Get the current date
    $currentDate = date('Y-m-d');

    // Get the latest appointment for the current date
    $sql = "SELECT appointment_no FROM appoinments WHERE date = '$currentDate' ORDER BY appointment_no DESC LIMIT 1";
    $result = $conn->query($sql);

    // Calculate the new appointment number
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $appointment_no = $row['appointment_no'] + 1;
    } else {
        $appointment_no = 1;
    }

    // Define variables and bind them to the prepared statement
    $patientName = "person" . $appointment_no;

    // Use a prepared statement to execute the INSERT query for "appoinments"
    $sql = "INSERT INTO appoinments (appointment_no, patient_id, patient_name, date,appdateTime, finger_print) VALUES (?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("iissss", $appointment_no, $userid, $user, $date,$date ,$fingerprintData);
        
        // Execute the prepared statement for "appoinments"
        if ($stmt->execute()) {
            // Both inserts were successful, commit the transaction
            $conn->commit();
            echo $userid;
        } else {
            // An error occurred during the "appoinments" insert, rollback the transaction
            $conn->rollback();
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement for 'appoinments'.";
    }

    // Close the database connection
    $conn->close();
}


?>


