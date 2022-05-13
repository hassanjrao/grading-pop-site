<?php
ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['admin_id'])) {

        header('year:login.php');
    }
}


if (isset($_POST['submit'])) {

    $cert_number = $_POST["cert_number"];
    $year = $_POST["year"];
    $brand = $_POST["brand"];
    $sport_tcg = $_POST["sport_tcg"];
    $card_number = $_POST["card_number"];
    $player_character = $_POST["player_character"];
    $set = $_POST["set"];
    $grade = $_POST["grade"];
    $autograph = $_POST["autograph"];
    $corners = $_POST["corners"];
    $edges = $_POST["edges"];
    $surface = $_POST["surface"];
    $centering = $_POST["centering"];
    $variant = $_POST["variant"];
    $numbered_card = $_POST["numbered_card"];



    $folder = "../images/";

    try {
        //code...
        $stmt = $conn->prepare("INSERT INTO `cards`(`cert_number`,`year`,`brand`,`sport_tcg`,`card_number`,`player_character`,`set`,`grade`,`autograph`,`corners`,`edges`,`surface`,`centering`,`variant`,`numbered_card`) VALUES (:cert_number,:year,:brand,:sport_tcg,:card_number, :player_character, :set, :grade,:autograph,:corners,:edges,:surface,:centering,:variant,:numbered_card)");


        $stmt->bindParam(':cert_number', $cert_number);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':brand', $brand);
        $stmt->bindParam(':sport_tcg', $sport_tcg);
        $stmt->bindParam(':card_number', $card_number);
        $stmt->bindParam(':player_character', $player_character);
        $stmt->bindParam(':set', $set);
        $stmt->bindParam(':grade', $grade);
        $stmt->bindParam(':autograph', $autograph);
        $stmt->bindParam(':corners', $corners);
        $stmt->bindParam(':edges', $edges);
        $stmt->bindParam(':surface', $surface);
        $stmt->bindParam(':centering', $centering);
        $stmt->bindParam(':variant', $variant);
        $stmt->bindParam(':numbered_card', $numbered_card);


        $stmt->execute();

        $last_card_id = $conn->lastInsertId();



        foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {

            if ($_FILES['images']['name'][$key] != "") {
                $card_image =  time() . $_FILES['images']['name'][$key];
                $path = $folder . $card_image;
                move_uploaded_file($_FILES['images']['tmp_name'][$key], $path);


                $stmt = $conn->prepare("INSERT INTO `card_images`( `card_id`,`card_image`) VALUES (:card_id,:card_image)");

                $stmt->bindParam(':card_id', $last_card_id);
                $stmt->bindParam(':card_image', $card_image);

                $stmt->execute();
            }
        }

        $response = "success";
    } catch (PDOException $e) {
        //throw $th;

        $response = $e->getMessage();
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("includes/head.php"); ?>



    <title>Cards</title>
</head>

<body class="page-body" data-url="http://neon.dev">

    <div class="page-container">
        <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

        <!-- leftbar starts -->

        <?php include_once("includes/left-bar.php"); ?>

        <!-- leftbar ends -->


        <div class="main-content">

            <div class="row">

                <!-- header starts-->
                <?php include_once("includes/header.php"); ?>
                <!-- header ends -->



            </div>

            <hr />

            <ol class="breadcrumb bc-3">
                <li>
                    <a href="index.php"><i class="fa-home"></i>Home</a>
                </li>
                <li class="active">

                    <a href="all_categorys.php"> <strong>Cards</strong></a>
                </li>

            </ol>



            <?php

            if (isset($_GET["status"])) {


                if ($_GET["status"] == "del_succ") {

            ?>
                    <br>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong>Congrats!</strong> Successfully Deleted
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                } else {

                ?>
                    <br>
                    <div class="alert alert-success alert-danger" role="alert">
                        <strong>Congrats!</strong> Something Went Wrong, <?php echo $_GET["request"]; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            <?php
                }
            }

            ?>

            <h2>Cards</h2>
            <br>
            <a href="javascript:;" onclick="jQuery('#modal-6').modal('show', {backdrop: 'static'});" class="btn btn-primary">Add Card</a>

            <br>
            <br>

            <?php


            $query = $conn->prepare(
                "SELECT * from cards order by id desc LIMIT 1"
            );
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);



            if ($result) {
                $id = intval($result["cert_number"]) + 1;

                $cn = $id;

                if ($id < 10) {
                    $cert_number = "000000000" . $id;
                } else if ($id >= 10 && $id < 100) {
                    $cert_number = "00000000" . $id;
                } else if ($id >= 100 && $id < 1000) {
                    $cert_number = "0000000" . $id;
                } else if ($id >= 1000 && $id < 10000) {
                    $cert_number = "000000" . $id;
                } else if ($id >= 10000 && $id < 100000) {
                    $cert_number = "00000" . $id;
                } else if ($id >= 100000 && $id < 1000000) {
                    $cert_number = "0000" . $id;
                } else if ($id >= 1000000 && $id < 10000000) {
                    $cert_number = "000" . $id;
                } else if ($id >= 10000000 && $id < 100000000) {
                    $cert_number = "00" . $id;
                } else if ($id >= 100000000 && $id < 1000000000) {
                    $cert_number = "0" . $id;
                } else if ($id >= 1000000000 && $id < 10000000000) {
                    $cert_number = $id;
                } else if ($id >= 10000000000) {
                    $cert_number = $id;
                }
            } else {
                $cert_number = "0000000001";
            }



            ?>


            <!-- Modal 6 (Long Modal)-->
            <div class="modal fade" id="modal-6" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Add New Card</h4>
                        </div>

                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="modal-body">

                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="form-group">


                                            <div class="input-field">
                                                <label class="active">Add Images</label>
                                                <div class="input-images-1" style="padding-top: .5rem;"></div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="field-1" class="control-label">Cert Number</label>

                                            <input required type="text" value="<?php echo $cert_number ?>" readonly class="form-control" id="field-1" name="cert_number" placeholder="Cert Number">
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="field-2" class="control-label">Year</label>

                                            <input required type="text" class="yearpicker form-control" id="field-2" name="year" placeholder="Year">
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Brand</label>

                                            <input required type="text" class="form-control" id="field-3" name="brand" placeholder="Brand">
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="field-4" class="control-label">Sport/TCG</label>

                                            <input required type="text" class="form-control" id="field-4" name="sport_tcg" placeholder="Sport/TCG">
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="field-5" class="control-label">Card Number</label>

                                            <input required type="text" class="form-control" id="field-5" name="card_number" placeholder="Card Number">
                                        </div>

                                    </div>


                                </div>

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="field-6" class="control-label">Player/Character</label>

                                            <input required type="text" class="form-control" id="field-6" name="player_character" placeholder="Player/Character">
                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="field-6" class="control-label">Set</label>

                                            <input required type="text" class="form-control" id="field-6" name="set" placeholder="Set">
                                        </div>

                                    </div>


                                </div>

                                <div class="row">


                                    <div class="col-md-6">

                                        <div class="form-group no-margin">
                                            <label for="field-7" class="control-label">Grade</label>

                                            <input required type="text" class="form-control" id="field-6" name="grade" placeholder="Grade">
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group no-margin">
                                            <label for="field-7" class="control-label">Autograph</label>

                                            <input type="text" class="form-control" id="field-6" name="autograph" placeholder="Autograph">
                                        </div>

                                    </div>


                                </div>

                                <div class="row">


                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="field-6" class="control-label">Corners</label>

                                            <input required type="text" class="form-control" id="field-6" name="corners" placeholder="Corners">
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group no-margin">
                                            <label for="field-7" class="control-label">Edges</label>

                                            <input required type="text" class="form-control" id="field-6" name="edges" placeholder="Edges">
                                        </div>

                                    </div>



                                </div>

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="field-6" class="control-label">Surface</label>

                                            <input required type="text" class="form-control" id="field-6" name="surface" placeholder="Surface">
                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group no-margin">
                                            <label for="field-7" class="control-label">Centering</label>

                                            <input required type="text" class="form-control" id="field-6" name="centering" placeholder="Centering">
                                        </div>

                                    </div>
                                </div>



                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="field-6" class="control-label">Variant</label>

                                            <input type="text" class="form-control" id="field-6" name="variant" placeholder="Variant">
                                        </div>

                                    </div>
                                    
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="field-6" class="control-label">Numbered Card</label>

                                            <input type="text" class="form-control" id="field-6" name="numbered_card" placeholder="Numbered Card">
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-info">Add Card</button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>




            <div id="notification-div">

                <?php if (isset($response)) {

                    if ($response == "success") {
                ?>

                        <div class="alert alert-success alert-dismissible" role="alert">
                            <strong>Congrats! Successfully Added</strong>


                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <?php

                    } else {
                    ?>

                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>OOPs! <?php echo $response . "Please try again!"; ?></strong>


                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                <?php
                    }
                } ?>

            </div>


            <!-- <h3>Table without DataTable Header</h3> -->


            <table class="table table-bordered datatable  dt-responsive nowrap" id="table-1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cert Number</th>
                        <th>Year</th>
                        <th>Brand</th>
                        <th>Sport/TCG</th>
                        <th>Card Number</th>
                        <th>Player/Character</th>
                        <th>Set</th>
                        <th>Grade</th>
                        <th>Autograph</th>
                        <th>Corners</th>
                        <th>Edges</th>
                        <th>Surface</th>
                        <th>Centering</th>
                        <th>Variant</th>
                        <th>Numbered Card</th>

                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>
                    <?php


                    $i = 1;

                    $query = $conn->prepare(
                        "SELECT * from cards order by id desc"
                    );
                    $query->execute();


                    while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                    ?>

                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $result["cert_number"]; ?></td>
                            <td><?php echo $result["year"]; ?></td>
                            <td><?php echo $result["brand"]; ?></td>
                            <td><?php echo $result["sport_tcg"]; ?></td>
                            <td><?php echo $result["card_number"]; ?></td>
                            <td><?php echo $result["player_character"]; ?></td>
                            <td><?php echo $result["set"]; ?></td>
                            <td><?php echo $result["grade"]; ?></td>
                            <td><?php echo $result["autograph"]; ?></td>
                            <td><?php echo $result["corners"]; ?></td>
                            <td><?php echo $result["edges"]; ?></td>
                            <td><?php echo $result["surface"]; ?></td>
                            <td><?php echo $result["centering"]; ?></td>
                            <td><?php echo $result["variant"]; ?></td>
                            <td><?php echo $result["numbered_card"]; ?></td>

                            <td>
                                <a href="edit_card.php?id=<?php echo $result["id"] ?>" class="btn btn-default btn-sm btn-icon icon-left">
                                    <i class="entypo-pencil"></i>
                                    Edit
                                </a>

                                <a href="delete_cards.php?id=<?php echo $result["id"]
                                                                ?>" class="btn btn-danger btn-sm btn-icon icon-left">
                                    <i class="entypo-cancel"></i>
                                    Delete
                                </a>

                            </td>
                        </tr>

                    <?php
                    } ?>







                </tbody>
            </table>








            <br />





            <!-- Footer starts -->
            <?php include_once("includes/footer.php"); ?>
            <!-- Footer end -->
        </div>




    </div>





    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="assets/js/datatables/datatables.css">
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="assets/js/select2/select2.css">

    <!-- Imported scripts on this page -->
    <script src="assets/js/datatables/datatables.js"></script>
    <script src="assets/js/select2/select2.min.js"></script>


    <!-- Bottom scripts (common) -->
    <script src="assets/js/gsap/TweenMax.min.js"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>

    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/joinable.js"></script>
    <script src="assets/js/resizeable.js"></script>
    <script src="assets/js/neon-api.js"></script>


    <!-- Imported scripts on this page -->
    <script src="assets/js/neon-chat.js"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js"></script>



    <script src="assets/image-uploader/image-uploader.min.js"></script>


    <script>
        $('.input-images-1').imageUploader({
            imagesInputName: 'images',
        });

        jQuery(document).ready(function($) {
            var $table1 = jQuery('#table-1');

            // Initialize DataTable
            $table1.DataTable({
                "aLengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "bStateSave": true
            });

            // Initalize Select Dropdown after DataTables is created
            $table1.closest('.dataTables_wrapper').find('select').select2({
                minimumResultsForSearch: -1
            });
        });
    </script>





</body>

</html>