<?php

include_once("admin/includes/db.php");

if (isset($_GET["cert_number"])) {
    $cert_number = $_GET["cert_number"];
} else {
    header("location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Card</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../images/vga-fav.png" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />

    <?php include_once("g-analytics.php"); ?>
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php"><img src="../images/newlogo.png" width="100px" height="55px"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">

            </div>
        </div>
    </nav>
    <!-- Page Content-->
    <section class="py-5">


        <?php

        $query = $conn->prepare(
            "SELECT * from cards where cert_number='$cert_number'"
        );
        $query->execute();
        if ($result = $query->fetch(PDO::FETCH_ASSOC)) {

            $brand = $result["brand"];
            $grade = $result["grade"];
            $card_id = $result["id"];
            $player_character = $result["player_character"];
            $set = $result["set"];
            $card_number = $result["card_number"];
            $autograph = $result["autograph"];
            $year = $result["year"];
            $variant = $result["variant"];
            $numbered_card = $result["numbered_card"];
            
            $created_at = $result["created_at"];


        ?>
            <div class="container d-flex h-100">

                <div class="row justify-content-center ">

                    <div class="col-lg-9 mb-5 text-center">
                        <h4>According to the VGA database, the requested certification number is defined as the following:</h4>
                        <br>

                        <table class="table table-fixed table-header-right text-medium">
                            <tbody>
                                <tr>
                                    <th class="no-border">Certification Number</th>
                                    <td class="no-border"><?php echo $result["cert_number"] ?></td>
                                </tr>

                                <tr>
                                    <th>Year</th>
                                    <td><?php echo $year ?></td>
                                </tr>
                                <tr>
                                    <th>Brand</th>
                                    <td><?php echo $brand ?></td>
                                </tr>
                                <tr>
                                    <th>Sport/TCG</th>
                                    <td><?php echo $result["sport_tcg"] ?></td>
                                </tr>
                                <tr>
                                    <th>Card Number</th>
                                    <td><?php echo $card_number ?></td>
                                </tr>
                                <tr>
                                    <th>Player/Character</th>
                                    <td><?php echo  $player_character ?></td>
                                </tr>

                                <tr>
                                    <th>Set</th>
                                    <td><?php echo  $set ?></td>
                                </tr>

                                <tr>
                                    <th>Overall Grade</th>
                                    <td><?php echo $grade ?></td>
                                </tr>

                                <?php

                                if ($autograph != "") {
                                ?>

                                    <tr>
                                        <th>Autograph</th>
                                        <td><?php echo $autograph ?></td>
                                    </tr>
                                <?php
                                }

                                ?>

                                <tr>
                                    <th>Corners</th>
                                    <td><?php echo $result["corners"] ?></td>
                                </tr>
                                <tr>
                                    <th>Edges</th>
                                    <td><?php echo $result["edges"] ?></td>
                                </tr>
                                <tr>
                                    <th>Surface</th>
                                    <td><?php echo $result["surface"] ?></td>
                                </tr>
                                <tr>
                                    <th>Centering</th>
                                    <td><?php echo $result["centering"] ?></td>
                                </tr>


                                <?php

                                if ($variant != "") {
                                ?>

                                    <tr>
                                        <th>Variant</th>
                                        <td><?php echo $variant ?></td>
                                    </tr>
                                <?php
                                }

                                ?>
                                
                                
                                <?php

                                if ($numbered_card) {
                                ?>

                                    <tr>
                                        <th>Numbered Card</th>
                                        <td><?php echo $numbered_card ?></td>
                                    </tr>
                                <?php
                                }

                                ?>


                               
                                <tr>
                                    <th>Created at</th>
                                    <td><?php echo $created_at ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>



            <?php

            $query = $conn->prepare(
                "SELECT COUNT(id) as population from cards where grade=$grade and  brand='$brand' and year='$year' and card_number='$card_number' "
            );
            $query->execute();
            if ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                $population = $result["population"];
            } else {
                $population = 0;
            }



            $query = $conn->prepare(
                "SELECT COUNT(id) as population_higher from cards where grade>$grade and  brand='$brand' and year='$year' and card_number='$card_number' "
            );

            $query->execute();
            if ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                $population_higher = $result["population_higher"];
            } else {
                $population_higher = 0;
            }

            ?>

            <div class="container mt-4">
                <div class="row justify-content-center text-center pb-5">

                    <div class="col-lg-6">
                        <h3 class="text-uppercase">Population</h3>
                        <div class="text-xlarge">
                            <h2 class="text-xlarge text-success"><?php echo $population ?></h2>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h3 class="text-uppercase">Population Higher</h3>
                        <div class="text-xlarge">
                            <h2 class="text-xlarge text-info"><?php echo $population_higher ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="container d-flex h-100 mt-4">

                <div class="row justify-content-center ">


                    <?php



                    $query_images = $conn->prepare(
                        "SELECT * from card_images where card_id='$card_id'"
                    );
                    $query_images->execute();

                    while ($result_images = $query_images->fetch(PDO::FETCH_ASSOC)) {

                    ?>
                        <div class="col-lg-4">

                            <img src="../images/<?php echo $result_images["card_image"] ?>" class="img-fluid" alt="images">

                        </div>

                    <?php

                    }

                    ?>



                </div>

            </div>


        <?php

        } else {
        ?>

            <div class="container mt-5">
                <div class="row justify-content-center text-center pt-5">

                    <div class="col-lg-6">

                        <h2><a href="../index.php">Sorry, No result found, back to Home Page</a></h2>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>



        <br><br>
    </section>

    <!-- Footer-->
    <!-- <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p>
        </div>
    </footer> -->
    <!-- Bootstrap core JS-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
</body>

</html>