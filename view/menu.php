<?php session_start();
if (!isset($_SESSION['login'])) {
    header('location:./auth/login.php');
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Menu</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/alert.css">

    <link rel="stylesheet" href="../styles/menu.css">
</head>

<body>
    <?php
    include "../component/navbar.php";
    ?>
    
    <div class="bg-custom">
        <?php include "../component/alert.php";?>
        <div class="container mt-5 mb-5">
            <div class="bg-menu p-3 p-lg-5">
                <?php if ($_SESSION['role'] === "1") { ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd">
                        Add Food Here
                    </button>
                    <?php include '../component/modal/modal_menu/modal_add.php' ?>
                <?php } ?>

                <?php
                require '../library/process.php';
                $query = "SELECT * FROM Food";
                $result = $mysqli->query($query);
                ?>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="col mt-4">
                            <div class="card rounded mb-4">
                                <div class="view overlay">
                                    <img class="card-img-top" src="<?php echo $row['food_pic'] ?>">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><b><?php echo $row['name']; ?></b></h4>
                                    <p class="card-text">
                                        Price : <?php echo "Rp" . number_format($row['price'], 0, ".", "."); ?>
                                    </p>
                                    <?php if ($_SESSION['role'] === "1") { ?>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?= $row['food_id'] ?>">Edit</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDel<?= $row['food_id'] ?>">Delete</button>
                                        <?php
                                        include '../component//modal/modal_menu/modal_delete.php';
                                        include '../component/modal/modal_menu/modal_edit.php'
                                        ?>
                                    <?php } else { ?>
                                        <form action="../model/Menu_Controller.php" method="POST">
                                            <div class="form-row">
                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>">
                                                <input type="hidden" name="food_id" value="<?php echo $row['food_id'] ?>">
                                                <div class="col-4">
                                                    <input type="number" name="quantity" class="form-control mb-2 mr-sm-2" min=1 value=1 required>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-custom mb-2" name="add_cart">
                                                        <span class="fas fa-cart-plus"></span>
                                                        Add to Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>


            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>