<?php 

session_start();

include '../library/process.php';

if (isset($_POST['save_menu'])) {
    // The path to srgtore the uploaded image
    $target         = __DIR__ . "/Images/Foods/";

    // Check file extension
    $file_extension = array('png', 'jpg', 'jpeg');
    // The path to store the uploaded images
    $picture        = $_FILES['images']['name'];
    print_r($picture);
    // get the file extension
    $x              = explode('.', $picture);
    $extension      = strtolower(end($x));
    // check images size
    $image_size     = $_FILES['images']['size'];
    $file_tmp       = $_FILES['images']['tmp_name'];

    // get others data
    $name = $_POST['name'];
    $address = $_POST['price'];
    $phone = $_POST['category_id'];

    if (in_array($extension, $file_extension) === true) {
        if ($image_size < 1044070) {
            move_uploaded_file($file_tmp, $target . "sasa.jpg");

            // Insert data to DB
            $query = mysqli_query($mysqli, "INSERT INTO author(nama, alamat, no_hp, foto) VALUES('$name', '$address', '$phone', '$picture') ") or die(mysqli_error($mysqli));

            if ($query) {
                $_SESSION['message']    = 'Success saved author to DB';
                $_SESSION['msg_type']   = 'success';
            } else {
                $_SESSION['message']    = 'Failed to saved author to DB';
                $_SESSION['msg_type']   = 'danger';
            }
        } else {
            $_SESSION['message']    = 'Images Size is too big !';
            $_SESSION['msg_type']   = 'warning';
        }
    } else {
        $_SESSION['message']    = 'File extension is not allowed';
        $_SESSION['msg_type']   = 'warning';
    }

    // Redirect to homepages
    // header("location: ../view/index_author.php");
}

if (isset($_GET['delete_menu'])) {
    $id = $_GET['delete_menu'];

    $query = "SELECT kopisop FROM Food WHERE id=$id";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $imagepath = $row['photo'];
    unlink($imagepath);

    $query = "DELETE FROM Food WHERE id=$id";
    $result = $mysqli->query($query);

    header('location:../view/menu.php');
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $food_pic = $_POST['food_pic'];

    $query = "UPDATE Food SET name=$name, price='$price', food_pic='$food_pic'";
     
    header('location:../view/menu.php');
}

?>