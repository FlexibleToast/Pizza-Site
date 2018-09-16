<!doctype html>
<html lang="en">
<head>
        <?php
        # Connect to database
        require_once('../scripts/pdoConnect.php');
        # Load bootstrap
        require_once('../scripts/bootstrap-head.php');
        require_once('../scripts/tinymce.php');

        # Load navbar
        require_once ('../navbar.php');?>
    <style type="text/css">
        .alert{
            margin-bottom: 0 !important;
            text-align: center !important;
        }
    </style>
    <div class="container" style="padding-top: 20px;">
        <div class="container" align="center">
            <?php
            if(isset($_POST['newName']))
            {
                try
                {
                    # Start transaction
                    $pdo->beginTransaction();
                    # Prepare insert statement
                    $newLocation = $pdo->prepare("INSERT INTO pizza_shop(name, street, city, state, zip, link, recommender)
                                                  values(:name, :street, :city, :state,:zip, :link, :recommender)");
                    # Execute insertion
                    $newLocation->execute(array(
                        name => $_POST['newName'],
                        street => $_POST['newStreet'],
                        city => $_POST['newCity'],
                        state => $_POST['newState'],
                        zip => $_POST['newZip'],
                        link => $_POST['newLink'],
                        recommender => $_POST['newRecommender']
                    ));
                    # Commit changes
                    $pdo->commit();
                    # Generate success message
                    $get_info = "?success=true&name=" . $_POST['newName'];
                    header("Location: ".$_SERVER['mcdade.info/pizza/submit/newLocation.php'].$get_info);
                }
                catch (PDOException $e)
                {
                    $pdo->rollBack();
                    echo '<div class="alert alert-danger rounded-0" role="alert">Failed to add review, error: '.$e->getMessage().'</div>';
                }
            }
            elseif($_GET['success'] == "true") {
                echo '<div class="alert alert-success rounded-0" role="alert">'.$_GET['name'].' successfully added.</div>';
            }
            ?>
        </div>
    </div>
</head>
<body>
    <div class="container" align="center"><h2>Enter Location Information</h2></div>
    <div class="container">
        <form action="newLocation.php" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="newName" autocomplete="off" required class="form-control" maxlength="50">
            </div>
            <div class="form-group">
                <label>Street</label>
                <input type="text" name="newStreet" autocomplete="off" required class="form-control" maxlength="50">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>City</label>
                    <input type="text" name="newCity" autocomplete="off" required class="form-control" value="Rockford" maxlength="50">
                </div>
                <div class="form-group col-md-4">
                    <label>State</label>
                    <select  class="form-control" name="newState" required>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL" selected="selected">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>ZIP</label>
                    <input type="text" class="form-control" name="newZip" pattern="[0-9]{5}" title="Five digit zip code" autocomplete="off" required>
                </div>
            </div>
            <div class="form-group">
                <label>Website</label>
                <input type="text" class="form-control" name="newLink" autocomplete="off" placeholder="(Optional)" maxlength="500" value="">
            </div>
            <div class="form-group">
                <label>Recommended by</label>
                <input type="text" class="form-control" name="newRecommender" autocomplete="off" placeholder="(Optional)" maxlength="50" value="">
            </div>
            <div class="d-flex justify-content-end">
                <div class="btn-toolbar">
                    <div class="btn-group" style="padding-right: 10px;">
                        <input class="btn btn-secondary" onClick="window.location.href='review.php'" type="button" value="Back">
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
