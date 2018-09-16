<!doctype html>
<html lang="en">
    <title>Pizza Tour Test</title>
    <head>
        <?php
        #Connect to database
        #require_once('./scripts/pdoConnect.php');
        #Load bootstrap
        require_once('./scripts/bootstrap-head.php');
        require_once('./navbar.php'); ?>
        <style type="text/css">
            .carousel{
                height: 60vh;
                width: auto;
                overflow: hidden;
            }
            @media only screen and (max-width: 1500px) {
                .carousel{
                    height: 80vh;
                    width: auto;
                    overflow: hidden;
                }
            }
            @media (max-width: 700px) and (orientation: portrait) {
                .carousel{
                    height: 40vh;
                    width: auto;
                    overflow: hidden;
                }
            }
        </style>
    </head>
    <body>
    <div class="container" align="center"><h1>Pizza Tour's Test Page</h1></div>
    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col-8">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut culpa distinctio doloremque eaque eius, error hic ipsa ipsum labore laudantium maiores minima molestiae nisi optio reprehenderit similique sit unde voluptatem.</div>
            <div class="col-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta eaque earum eius error quidem repellat ullam. At beatae commodi culpa doloremque in inventore, obcaecati optio, quod unde ut veniam voluptas.</div>
        </div>
    </div>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-flex w-100 align-items-center justify-content-center" src="https://mcdade.info/pizza/images/test/FullSizeR_01.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-flex w-100 align-items-center justify-content-center" src="https://mcdade.info/pizza/images/test/FullSizeR_02.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-flex w-100 align-items-center justify-content-center" src="https://mcdade.info/pizza/images/test/test.gif" alt="Third slide">
            </div>
            <div class="carousel-item">
                <img class="d-flex w-100 align-items-center justify-content-center" src="https://mcdade.info/pizza/images/test/MVIMG_20180507_182122.jpg" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <?php
    #Load bootstrap dependencies
    require_once('./scripts/bootstrap-body.php'); ?>
    </body>
</html>