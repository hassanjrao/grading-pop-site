<?php
ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['admin_id'])) {

        header('location:login.php');
    }
}
if (!isset($_GET["id"])) {
    header('location:index.php');
} else {
    $card_id = $_GET["id"];
}



$response = null;


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

        $stmt = $conn->prepare("UPDATE `cards` SET cert_number=:cert_number,year=:year, brand=:brand,sport_tcg=:sport_tcg,card_number=:card_number,player_character=:player_character, `set`=:set ,grade=:grade, autograph=:autograph ,corners=:corners,edges=:edges,surface=:surface,centering=:centering, variant=:variant,numbered_card=:numbered_card WHERE id=:id");

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

        $stmt->bindParam(':id', $card_id);

        $stmt->execute();


        # code...


        $query = $conn->prepare(
            "SELECT * from card_images where card_id='$card_id'"
        );
        $query->execute();


        if (isset($_POST["old"])) {

            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                if (!in_array($result["id"], $_POST["old"])) {

                    unlink("$folder/" . $result["card_image"]);

                    $del = $conn->prepare("DELETE FROM card_images WHERE id=" . $result["id"] . "");
                    $del->execute();
                }
            }
        } else {
            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                unlink("$folder/" . $result["card_image"]);
            }
            $del = $conn->prepare("DELETE FROM card_images WHERE card_id='$card_id'");
            $del->execute();
        }




        $folder = "../images/";





        foreach ($_FILES["photos"]["tmp_name"] as $key => $tmp_name) {


            if ($_FILES['photos']['name'][$key] != "") {
                $image = $_FILES['photos']['name'][$key];
                $path = $folder . $image;



                if (file_exists($path)) {
                    unlink($path);
                }


                $image = time() . $_FILES['photos']['name'][$key];
                $path = $folder . $image;

                move_uploaded_file($_FILES['photos']['tmp_name'][$key], $path);

                $stmt = $conn->prepare("INSERT INTO `card_images`( `card_id`,`card_image`) VALUES (:card_id,:card_image)");

                $stmt->bindParam(':card_id', $card_id);
                $stmt->bindParam(':card_image', $image);

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

    <title>Edit Card</title>
</head>

<body class="page-body">

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
                <li>

                    <a href="#">Cards</a>
                </li>
                <li class="active">

                    <strong>Edit Card</strong>
                </li>
            </ol>

            <h2>Edit Card</h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                    <div id="notification-div">

                        <?php if (isset($response)) {

                            if ($response == "success") {

                        ?>

                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <strong>Congrats! Successfully Updated</strong> <br><br>

                                    <a href="cards.php">Back To All cards</a>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                            <?php

                            } else {
                            ?>

                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <strong>OOPs! <?php echo $response; ?></strong> <br><br>

                                    <a href="cards.php">Back To All cards</a>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                        <?php
                            }
                        } ?>

                    </div>

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Edit Card Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">

                            <?php

                            $query = $conn->prepare(

                                "SELECT *
                                    FROM cards 
                                    Where id='$card_id'"

                            );

                            $query->execute();

                            $result = $query->fetch(PDO::FETCH_ASSOC);

                            ?>




                            <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-groups-bordered">

                                <div class="form-group">

                                    <label for="field-0" class="col-sm-3 control-label">Images</label>

                                    <div class="col-sm-8">

                                        <div class="input-images-1" style="padding-top: .5rem;"></div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Cert Number</label>

                                    <div class="col-sm-5">
                                        <input required type="text" value="<?php echo $result["cert_number"] ?>" readonly class="form-control" id="field-1" name="cert_number" placeholder="Cert Number">
                                        <div id="fname_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-2" class="col-sm-3 control-label">Year</label>

                                    <div class="col-sm-5">
                                        <input required type="text" value="<?php echo $result["year"] ?>" class="yearpicker form-control" id="field-2" name="year" placeholder="Year">
                                        <div id="lname_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-3" class="col-sm-3 control-label">Brand</label>

                                    <div class="col-sm-5">
                                        <input required type="text" value="<?php echo $result["brand"] ?>" class="form-control" id="field-3" name="brand" placeholder="Brand">
                                        <div id="email_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-4" class="col-sm-3 control-label">Sport/TCG</label>

                                    <div class="col-sm-5">
                                        <input required type="text" value="<?php echo $result["sport_tcg"] ?>" class="form-control" id="field-4" name="sport_tcg" placeholder="Sport/TCG">
                                        <div id="contact_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-5" class="col-sm-3 control-label">Card Number</label>

                                    <div class="col-sm-5">
                                        <input required type="text" value="<?php echo $result["card_number"] ?>" class="form-control" id="field-5" name="card_number" placeholder="Card Number">
                                        <div id="education_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="field-6" class="col-sm-3 control-label">Player/Character</label>
                                    <div class="col-sm-5">
                                        <input required type="text" value="<?php echo $result["player_character"] ?>" class="form-control" id="field-6" name="player_character" placeholder="Player/Character">
                                        <div id="prior_experience_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="field-6" class="col-sm-3 control-label">Set</label>
                                    <div class="col-sm-5">
                                        <input required type="text" value="<?php echo $result["set"] ?>" class="form-control" id="field-6" name="set" placeholder="Set">
                                        <div id="prior_experience_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="field-7" class="col-sm-3 control-label">Grade</label>
                                    <div class="col-sm-5">
                                        <input required type="text" class="form-control" value="<?php echo $result["grade"] ?>" id="field-7" name="grade" placeholder="Grade">
                                        <div id="prior_experience_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="field-7" class="col-sm-3 control-label">Autograph</label>
                                    <div class="col-sm-5">
                                        <input  type="text" class="form-control" value="<?php echo $result["autograph"] ?>" id="field-7" name="autograph" placeholder="Autograph">
                                        <div id="prior_experience_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="field-7" class="col-sm-3 control-label">Corners</label>
                                    <div class="col-sm-5">
                                        <input required type="text" class="form-control" value="<?php echo $result["corners"] ?>" id="field-7" name="corners" placeholder="Corners">
                                        <div id="prior_experience_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="field-7" class="col-sm-3 control-label">Edges</label>
                                    <div class="col-sm-5">
                                        <input required type="text" class="form-control" value="<?php echo $result["edges"] ?>" id="field-7" name="edges" placeholder="Edges">
                                        <div id="prior_experience_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="field-7" class="col-sm-3 control-label">Surface</label>
                                    <div class="col-sm-5">
                                        <input required type="text" class="form-control" value="<?php echo $result["surface"] ?>" id="field-7" name="surface" placeholder="Surface">
                                        <div id="prior_experience_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="field-7" class="col-sm-3 control-label">Centering</label>
                                    <div class="col-sm-5">
                                        <input required type="text" class="form-control" value="<?php echo $result["centering"] ?>" id="field-7" name="centering" placeholder="Centering">
                                        <div id="prior_experience_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="field-7" class="col-sm-3 control-label">Variant</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="<?php echo $result["variant"] ?>" id="field-7" name="variant" placeholder="Variant">
                                        <div id="prior_experience_error"></div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">

                                    <label for="field-7" class="col-sm-3 control-label">Numbered Card</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="<?php echo $result["numbered_card"] ?>" id="field-7" name="numbered_card" placeholder="Numbered Card">
                                        <div id="prior_experience_error"></div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" name="submit" class="btn btn-default">Update card</button>
                                    </div>
                                </div>
                            </form>




                        </div>

                    </div>

                </div>
            </div>





            <!-- Footer starts -->
            <?php include_once("includes/footer.php"); ?>
            <!-- Footer end -->

        </div>




    </div>


    <?php

    $query = $conn->prepare(
        "SELECT id, card_image
    FROM card_images
    Where card_id='$card_id'"
    );

    $query->execute();
    $result = json_encode($query->fetchALL());

    ?>


    <!-- Bottom scripts (common) -->
    <script src="assets/js/gsap/TweenMax.min.js"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/joinable.js"></script>
    <script src="assets/js/resizeable.js"></script>
    <script src="assets/js/neon-api.js"></script>


    <!-- Imported scripts on this page -->
    <script src="assets/js/bootstrap-switch.min.js"></script>
    <script src="assets/js/neon-chat.js"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js"></script>

    <script src="assets/js/jquery.validate.min.js"></script>

    <script src="assets/image-uploader/image-uploader.min.js"></script>




    <script>
        // var res = $.parseJSON(data);
        let images = <?php echo $result ?>;


        let im = [];


        // console.log(images);

        images.forEach((item, index) => {

            // console.log(item);
            im[index] = {
                id: parseInt(item[0]),
                src: "../images/" + item[1]
            };


        });

        // console.log(im);

        let preloaded = im;

        console.log(preloaded);
        $('.input-images-1').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'photos',
            preloadedInputName: 'old'
        });
    </script>

</body>

</html>