<?php
if (isset($_POST['registre'])) {
    if (isset($_POST['yourname']) && isset($_POST['youremail']) &&
        isset($_POST['password']) && isset($_POST['repeatpassword']) &&
       ) {
        
        $yourname = $_POST['yourname'];
        $youremail = $_POST['youremail'];
        $password = $_POST['password'];
        $repeatpassword = $_POST['repeatpassword'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "sign up";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM registration WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(yourname, youremail, password, repeatpassword) values(?, ?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $youremail);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssss",$yourname, $youremail, $password, $repeatpassword);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>