<?php
echo "<pre>";
print_r($_FILES);
echo "</pre>";
echo "<br>";


$server_name = "localhost";
$user_name = "root";
$password = "";
$database = "practice";

$conn = new mysqli($server_name, $user_name, $password, $database);


$name = $_POST['name'];
$file = $_FILES['file'];
$file_extension = explode(".", $file['name']);
$file_ext = strtolower(end($file_extension));

$expected_ext = array('jpg', 'png', 'jpeg');
if (in_array($file_ext, $expected_ext)) {
//    echo __LINE__;
    $target = $_FILES['file']['tmp_name'];
    $destination = "./uploaded_file/" . $_FILES['file']['name'];
    $is_file_moved = move_uploaded_file($target, $destination);
    if ($is_file_moved) {
        echo "file moved successfully";
        $sql = "INSERT INTO `image_upload` (`name`, `image`) VALUES ('$name', '$destination')";
        $conn-> query($sql);
    } else {
        echo "file not moved";
        echo "<br> $target<br> $destination";
    }
}
//echo __LINE__;


/*
$server_name = "localhost";
$user_name = "root";
$password = "";
$database = "ocpl";

$conn = new mysqli($server_name, $user_name, $password, $database);


if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO `admission` (`id`, `department`, `program`, `firstname`, `lastname`, `fathersName`, `mothersName`, `email`,
                         `contactNumber`, `gender`, `birthDate`, `nationality`, `addressline`, `district`, `state`,
                         `postCode`, `registrationNumber`, `sscExam`, `sscRollNumber`, `sscBoard`, `sscGpa`, `sscGroup`,
                         `sscPassingYear`, `hscExam`, `hscRollNumber`, `hscBoard`, `hscGpa`, `hscGroup`,
                         `hscPassingYear`)
VALUES (NULL, '$department', '$program', '$firstname', '$lastname', '$fathersName', '$mothersName', '$email', '$contactNumber', '$gender',
        '$birthDate', '$nationality', '$addressline ', '$district', '$state', '$postCode', '$registrationNumber',
        '$sscExam', '$sscRollNumber', '$sscBoard', '$sscGpa', '$sscGroup', '$sscPassingYear', '$hscExam', '$hscRollNumber', '$hscBoard', '$hscGpa',
        '$hscGroup', '$hscPassingYear')";

$conn->query($sql);
if($conn){
    echo "Inserted Successfully";
}
else{
    echo "Not inserted, something wrong";
}
*/