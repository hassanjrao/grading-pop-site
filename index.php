<?php

if (isset($_POST["submit"])) {

    $cert_number=$_POST["cert_number"];

    $url = preg_replace('/[^a-z0-9-]+/', '/', trim(strtolower("card/$cert_number")));

    header("location: $url");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Home</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="images/vga-fav.png" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    
    <?php include_once("g-analytics.php"); ?>
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src="images/newlogo.png" width="100px" height="55px"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">

            </div>
        </div>
    </nav>
    <!-- Page Content-->
    <section class="py-5">


        <div class="container">
            
           


            <div class="row justify-content-center">

                <div class="col-lg-8 text-center">
                    <h1>Cert Verification</h1>
                    <br>
                    <p>Verify the validity of VGA certification numbers using the form field. Always confirm certification numbers for collectibles purchased online.</p>


                    <form method="POST">

                        <div class="form-group mx-sm-3 mb-2">

                            <input required type="text" class="form-control" name="cert_number" placeholder="Enter Cert Number">
                        </div>

                        <button type="submit" value="true" name="submit" class="btn btn-primary m-2 pl-5 pr-5">Verify</button>

                    </form>

                </div>

            </div>

        </div>



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
    <script src="js/scripts.js"></script>
</body>

</html>