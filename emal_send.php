<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "dietplan";
$tableName = "diet_plan_email";
$conn = new mysqli($servername, $username, $password ,$databaseName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Create database if it does not exist
$createDbQuery = "CREATE DATABASE IF NOT EXISTS $databaseName";
if ($conn->query($createDbQuery) === TRUE) {
    echo "Database '$databaseName' created or already exists successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}
// $conn->close();
// $conn = new mysqli($servername, $username, $password, $databaseName);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
$sql = "CREATE TABLE IF NOT EXISTS $tableName (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(30) NOT NULL,
    Email VARCHAR(50),
    Weight VARCHAR(50),
    Height VARCHAR(50),
    Age VARCHAR(50),
    Vegan VARCHAR(50),
    Gender VARCHAR(50),
    Goal VARCHAR(50),
    Activity_Level VARCHAR(50),
    Updates INT(6) DEFAULT 0,
    CreatedDate DATETIME
)";
if ($conn->query($sql) === TRUE) {
    echo "Table '$tableName' created or already exists successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $weight = $_POST["weight"];
    $height = $_POST["height"];
    $age = $_POST["age"];
    $vegan = $_POST["vegan"];
    $gender = $_POST["gender"];
    $goal = $_POST["goal"];
    $exercise = $_POST["exercise"];   
    // $updates = $_POST["updates"]; 
    $date = date('Y-m-d H:i:s');
    $checkEmailQuery = "SELECT * FROM diet_plan_email WHERE Email = '$email'";
    $result = $conn->query($checkEmailQuery);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
        $currentUpdates = $row['Updates'];
        $newUpdates = $currentUpdates + 1;
      $updateSql = "UPDATE $tableName SET 
      Name='$name', Weight='$weight', Height='$height', Age='$age', Vegan='$vegan', 
      Gender='$gender', Goal='$goal', Activity_Level='$exercise', Updates='$newUpdates', 
      CreatedDate='$date' WHERE Email='$email'";

  if ($conn->query($updateSql) === TRUE) {
      echo "Record updated successfully";
  } else {
      echo "Error updating record: " . $conn->error;
  }
    } else {
        $sql = "INSERT INTO diet_plan_email (Name, Email,Weight,Height,Age,Vegan,Gender,Goal,Activity_Level,CreatedDate) 
        VALUES ('$name','$email','$weight','$height','$age','$vegan','$gender','$goal','$exercise','$date')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";

        
            $to = $_POST["email"];
            $name = $_POST["name"];
            $subject = "Diet Plan ";
            $message = "Dear $name,\n\nThank you for registering for the diet plan.";

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'kulwantbytecode25@gmail.com'; 
                $mail->Password   = 'jdfbcwdzryepsmmu'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                $mail->Port       = 587; 

                $mail->setFrom('kulwantbytecode25@gmail.com');
                $mail->addAddress($to);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message;

                $mail->send();
                echo "Email sent successfully";
            } catch (Exception $e) {
                echo "Error: Unable to send email. {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>
