<!doctype html>
<html lang="en">
    <title>Pizza Tour</title>
    <head>
        <?php
        #Connect to database
        #require_once('./scripts/pdoConnect.php');
        #Load bootstrap
        require_once('./scripts/bootstrap-head.php');
        require_once('./navbar.php'); ?>
        <style type="text/css">
            #alert{
                margin-bottom: 0 !important;
                text-align: center !important;
            }
        </style>
    </head>
    <body>
    <div class="container" align="center" style="padding-top: 20px;"><h1>Template</h1></div>
    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col-8">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut culpa distinctio doloremque eaque eius, error hic ipsa ipsum labore laudantium maiores minima molestiae nisi optio reprehenderit similique sit unde voluptatem.</div>
            <div class="col-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta eaque earum eius error quidem repellat ullam. At beatae commodi culpa doloremque in inventore, obcaecati optio, quod unde ut veniam voluptas.</div>
        </div>
    </div>
    <?php
    #Load bootstrap dependencies
    require_once('./scripts/bootstrap-body.php'); ?>
    </body>
</html>