<?php
//echo "<pre>";
//print_r($_FILES);
//print_r($_FILES['file']);
//echo "</pre>";
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
        if($conn-> query($sql)){
            ?>
            <div class="bg-success text-center text-white">
                <?php echo "Image Inserted"; ?>
            </div>
            <?php
        }
    } else {
        echo "file not moved";
        echo "<br> $target<br> $destination";
    }
}
else{
    ?>
    <div class="bg-danger text-center text-white">
        <?php echo "file format not corrrect"; ?>
    </div>
    <?php
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>display images </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1 class="text-center mb-3 pt-5">Image Upload</h1>
    <div>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>Name</th>
                <th>Image</th>
            </tr>

            <?php
            $display = "SELECT * FROM image_upload";
            $sql = mysqli_query($conn, $display);

            while($data = mysqli_fetch_array($sql)){
                ?>
                <tr>
                    <td><?php echo $data['name'];?></td>
                    <td><img src="<?php echo $data['image'];?>" alt="#" height="100px" width="100px"></td>
                </tr>
            <?php
            }
            ?>


        </table>
    </div>
</div>
</body>
</html>

