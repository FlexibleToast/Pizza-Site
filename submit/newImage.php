<!doctype html>
<html lang="en">
<title>Pizza Tour</title>
<head>
    <?php
    #Connect to database
    #require_once('./scripts/pdoConnect.php');
    # Load bootstrap
    require_once('../scripts/bootstrap-head.php');
    #Load Navbar
    require_once('../navbar.php');?>
    <style type="text/css">
        .alert{
            margin-bottom: 0 !important;
            text-align: center !important;
        }
    </style>
</head>
<body>
<?php
    $var = "23";
    if(!empty($_FILES['uploadImage']['tmp_name'][0])) {
        mkdir("/usr/share/nginx/html/pizza/images/test/".$var."/");
        $target_dir = "/usr/share/nginx/html/pizza/images/test/".$var."/";
        foreach ($_FILES["uploadImage"]["tmp_name"] as $key => $value) {
            $target_file = $target_dir . basename($_FILES["uploadImage"]["name"][$key]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["uploadImage"]["tmp_name"][$key]);
            if ($check == false) {
                echo '<div class="alert alert-danger rounded-0" role="alert">Is not an image</div>';
                $uploadOk = 0;
            }
            if (file_exists($target_file)) {
                echo '<div class="alert alert-danger rounded-0" role="alert">Image '. $_FILES['uploadImage']['name'][$key] . ' already exists</div>';
                $uploadOk = 0;
            } if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif")
            {
                echo '<div class="alert alert-danger rounded-0" role="alert">Only jpg, jpeg, gif, and png allowed</div>';
                $uploadOk = 0;
            }
            if ($uploadOk == 0)
            {
                echo '<div class="alert alert-danger rounded-0" role="alert">Image '. $_FILES['uploadImage']['name'][$key] . ' upload failed</div>';
            } else {
                if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"][$key], $target_file)) {
                    echo '<div class="alert alert-success rounded-0" role="alert">Image '. $_FILES['uploadImage']['name'][$key] . ' successfully uploaded</div>';
                } else {
                    echo '<div class="alert alert-danger rounded-0" role="alert">Image '. $_FILES['uploadImage']['name'][$key] . ' upload failed(move)</div>';
                }
            }
        }
    } else {
        echo '<h1>Array is empty</h1>';
    }
?>
    <div class="container" align="center" style="padding-top: 20px;"><h1>Test Image Uploading</h1></div>
    <div class="container">
        <form action="./newImage.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Image(s) to Upload</label>
                <input type="file" class="form-control" name="uploadImage[]" id="uploadImage" multiple value="">
            </div>
            <div class="d-flex justify-content-end btn-group">
                <input type="submit" class="btn btn-primary" name="submit">
            </div>
        </form>
    </div>
<?php
#Load bootstrap dependencies
require_once('../scripts/bootstrap-body.php'); ?>
</body>
</html>
