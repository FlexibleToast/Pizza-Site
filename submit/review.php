<!doctype html>
<html lang="en">
    <title>Pizza Tour</title>
    <head>
        <?php
        # Connect to database
        require_once('../scripts/pdoConnect.php');
        # Load bootstrap
        require_once('../scripts/bootstrap-head.php');
        # TinyMCE for WYSIWYG editor
        require_once('../scripts/tinymce.php');
        # Load navbar
        require_once('../navbar.php');?>
        <style type="text/css">
            .alert{
                margin-bottom: 0 !important;
                text-align: center !important;
            }
        </style>
    </head>
    <body>
    <div class="container" style="padding-top: 20px;">
        <div class="container" align="center">
            <?php
            if(isset($_POST['save']))
            {
                try{
                    if(empty($_POST['overall']))
                    {
                        echo '<div class="alert alert-danger rounded-0" role="alert">Failed to add review, Overall thoughts required</div>';
                    }
                    else {
                        # Start transaction
                        $pdo->beginTransaction();
                        # Prepare insert statement
                        $newPizza = $pdo->prepare("INSERT INTO pizza(shop_id, title, style, crust, sauce, cheese, toppings, summary, rating, price)
                            values(:shop, :title, :style, :crust, :sauce, :cheese, :toppings, :summary, :rating, :price)");
                        # Execute insert statement
                        $newPizza->execute(array(
                            shop => $_POST['location'],
                            title => $_POST['title'],
                            style => $_POST['style'],
                            crust => $_POST['crust'],
                            sauce => $_POST['sauce'],
                            cheese => $_POST['cheese'],
                            toppings => $_POST['toppings'],
                            summary => $_POST['overall'],
                            rating => $_POST['rating'],
                            price => $_POST['price']
                        ));
                        # Get last ID
                        $last_id = $pdo->lastInsertId();
                        # Upload pictures pictures if any
                        if(!empty($_FILES['uploadImage']['tmp_name'][0])) {
                            mkdir("/usr/share/nginx/html/pizza/images/p/" . $last_id . "/");
                            $target_dir = "/usr/share/nginx/html/pizza/images/p/" . $last_id . "/";
                            foreach ($_FILES["uploadImage"]["tmp_name"] as $key => $value) {
                                $target_file = $target_dir . basename($_FILES["uploadImage"]["name"][$key]);
                                $uploadOk = 0;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $check = getimagesize($_FILES["uploadImage"]["tmp_name"][$key]);
                                if ($check == false) { # If not an image, fail
                                    $uploadOk = 1;
                                }
                                if (file_exists($target_file)) { # If image already uploaded, fail
                                    echo '<div class="alert alert-danger rounded-0" role="alert">Image ' . $_FILES['uploadImage']['name'][$key] . ' already exists</div>';
                                    $uploadOk = 0;
                                }
                                if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
                                    #If image is not a supported type, fail
                                    echo '<div class="alert alert-danger rounded-0" role="alert">Only jpg, jpeg, gif, and png allowed</div>';
                                    $uploadOk = 0;
                                }
                                if ($uploadOk == 0) { #If image#######################################################
                                    # Need to figure out how to pass message in get redirect
                                    if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"][$key], $target_file)) {
                                        # If not failed and moved successfully, alert
                                        echo '<div class="alert alert-success rounded-0" role="alert">Image ' . $_FILES['uploadImage']['name'][$key] . ' successfully uploaded</div>';
                                    } else {# If move fails, alert
                                        echo '<div class="alert alert-danger rounded-0" role="alert">Image ' . $_FILES['uploadImage']['name'][$key] . ' upload failed(move)</div>';
                                    }
                                }
                            }
                        }
                        # Prepare insert to review table
                        $newReview = $pdo->prepare("INSERT INTO review(shop_id, pizza_id, username, date)
                              values(:shop, :pizza, :username, :date);");
                        # Execute insert
                        $newReview->execute(array(
                            shop => $_POST['location'],
                            pizza => $last_id,
                            username => $_SERVER['PHP_AUTH_USER'],
                            date => $_POST['reviewDate']
                        ));
                        #Commeit transaction and add review
                        $pdo->commit();
                        $locationAdded = $pdo->prepare("SELECT * FROM pizza_shop WHERE shop_id = :location");
                        $locationAdded->execute([location => $_POST['location']]);
                        $result = $locationAdded->fetch();
                        $get_info = "?success=true&title=" . $_POST['title'] . "&loc=" . $result['name'];
                        header("Location: ".$_SERVER['mcdade.info/pizza/submit/review.php'].$get_info);
                    }
                }
                catch(PDOException $e){
                    $pdo->rollBack();
                    echo '<div class="alert alert-danger rounded-0" role="alert">Failed to add review, error: '.$e->getMessage().'</div>';
                }
            }
            elseif($_GET['success'] == "true") {
            echo '<div class="alert alert-success rounded-0" role="alert">Review of ' . $_GET['title'] . ' at ' . $_GET['loc'] . ' added.</div>';
            }
            ?>
        </div>
        <div class="row">
            <div class="col-sm">
                <h2 align="center">Submission Form</h2>
            </div>
            <div class="col-sm">
                <div class="contianer" align="center">
                    <h5>Reviewer</h5>
                    <?php
                    $user = $pdo->prepare("SELECT * FROM reviewer WHERE username=:username;");
                    $user->execute([username => $_SERVER['PHP_AUTH_USER']]);
                    $result = $user->fetch();
                    echo '<p><b>Username: </b>' . $result['username'] . '<br><b>Name: </b>' . $result['fname'] . ' ' . $result['lname'] . '<br /></p>' . "\n";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <form action="review.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <!-- Lccation Selection -->
                <label for="locationSelect">Location</label>
                <div class="input-group">
                    <?php #Generate list of locations available
                    $location = $pdo->query('SELECT shop_id,name,city FROM pizza_shop ORDER BY name;');
                    echo '<select class="form-control input" name="location" id="locationSelect" required>
                                                    <option value="" selected disabled hidden>Select Location</option> ' . "\n";
                    while ($row = $location->fetch()) {   #Populate locations as options from a drop down list.
                        echo '<option value="' . $row['shop_id'] . '">' . $row['name'] . ' of ' . $row['city'] . '</option>' . "\n";
                    }
                    ?>
                    </select>
                    <div class="input-group-append">
                        <input class="btn btn-default" onClick="window.location.href='newLocation.php'" type="button" value="Add New" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <!-- Pizza Name Input -->
                <label for="title">Pizza</label>
                <input type="text" name="title" class="form-control" maxlength="50" id="title"
                       placeholder="Name of the pizza." required autocomplete="off">
            </div>
            <div class="row">
                <div class="col-lg">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <!-- Date Input -->
                                <label for="reviewDate">Date</label>
                                <input type="date" name="reviewDate" max="3000-12-31"
                                       min="2018-01-01" class="form-control" id="reviewDate" required>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <!-- Price Input -->
                                <label for="price">Price</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" name="price" min="0" max="99" step="0.01" size="4"
                                           title="Price of Pizza in 0.00 format with cents being optional"
                                           style="text-align:right;" placeholder="3.50" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <!-- Crust Selection -->
                                <label for="style">Crust Style</label>
                                <select name="style" id="style" class="form-control" required>
                                    <option value="" selected disabled hidden>Select Crust Style</option>
                                    <option value="Cracker Thin">Cracker Thin</option>
                                    <option value="Thin">Thin</option>
                                    <option value="Hand Tossed">Hand Tossed</option>
                                    <option value="Deep Dish">Deep Dish</option>
                                    <option value="Pan">Pan</option>
                                    <option value="Stuffed">Stuffed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <!-- Rating Selection -->
                                <label for="rating">Overall Rating</label>
                                <select name="rating" id="rating" class="form-control" required>
                                    <option value="" selected disabled hidden>Select a Rating</option>
                                    <option value="5">Six Slices</option>
                                    <option value="5">Five Slices</option>
                                    <option value="4">Four Slices</option>
                                    <option value="3">Three Slices</option>
                                    <option value="2">Two Slices</option>
                                    <option value="1">One Slice</option>
                                    <option value="0">Crumbs...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <!-- Overall Review -->
                <label for="overall">Overall Thoughts</label>
                <textarea name="overall" id="overall" rows="10"></textarea>
            </div>
            <div class="row">
                <div class="col-md">
                    <div class="form-group">
                        <!-- Crust Review -->
                        <label for="crust">Crust Thoughts (optional)</label>
                        <textarea name="crust" id="crust" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <!-- Sauce Review -->
                        <label for="sauce">Sauce Thoughts (optional)</label>
                        <textarea name="sauce" id="sauce" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <div class="form-group">
                        <!-- Cheese Review -->
                        <label for="cheese">Cheese Thoughts (optional)</label>
                        <textarea name="cheese" id="cheese" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <!-- Overall Review -->
                        <label for="toppings">Toppings Thoughts (optional)</label>
                        <textarea name="toppings" id="toppings" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <div class="btn-toolbar">
                    <div class="btn-group" style="padding-right: 10px;">
                        <input class="btn btn-secondary" onClick="window.location.href='review.php'" type="button" value="Cancel">
                    </div>
                    <div class="btn-group">
                        <input class="btn btn-primary" type="submit" name="save" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div><br>
    <?php
    # Load bootstrap dependencies
    require_once('../scripts/bootstrap-body.php'); ?>
    </body>
</html>
