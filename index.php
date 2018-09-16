<!doctype html>
<html lang="en">
    <title>Pizza Tour</title>
    <head>
        <?php
        # Connect to database
        require_once('./scripts/pdoConnect.php');
        # Load bootstrap
        require_once('./scripts/bootstrap-head.php');
        # Load navbar
        require_once('./navbar.php');
        # Load config for captcha
        require_once('./scripts/config.php');
        ?>
        <link rel="stylesheet" href="https://mcdade.info/pizza/CSS/index.css">
        <!-- Recaptcha for Suggestion Submission -->
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
    <?php
    if(isset($_POST['place']))
    {
        function post_captcha($user_response, $recaptcha_key) {
            $fields_string = '';
            $fields = array(
                'secret' => $recaptcha_key,
                'response' => $user_response
            );
            foreach($fields as $key=>$value)
                $fields_string .= $key . '=' . $value . '&';
            $fields_string = rtrim($fields_string, '&');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
            $result = curl_exec($ch);
            curl_close($ch);
            return json_decode($result, true);
        }
        # Call the function post_captcha
        $res = post_captcha($_POST['g-recaptcha-response'], $ReCAPTCHA_KEY);
        if (!$res['success']) { # if NOT success
            # Captcha not checked, redirect to home with alert
            header("Location: https://mcdade.info/pizza/index.php?success=captcha");
        } else {
            # If CAPTCHA is successfully completed...
            # Prepare insert statement
            $newPizza = $pdo->prepare("INSERT INTO suggestion(place, city, state, recommender)
                            values(:place, :city, :state, :recommender)");
            # Execute insert statement
            $newPizza->execute(array(
                place => $_POST['place'],
                city => $_POST['city'],
                state => $_POST['state'],
                recommender => $_POST['recommender']
            ));
            $get_info = "?success=true&place=".$_POST['place']."&city=".$_POST['city']."&state=".$_POST['state'];
            header("Location: ".$_SERVER['mcdade.info/pizza/index.php'].$get_info);
        }
    }
    elseif (isset($_GET['place']))
    {
        echo '<div id="alert" class="alert alert-success rounded-0" role="alert">',$_GET['place'].' of '.$_GET['city'].', '.$_GET['state']." successfully added</div>\n";
    }
    elseif ($_GET['success']=='captcha')
    {
        echo "<div id='alert' class='alert alert-danger rounded-0' role='alert'>Failed to Add: Must check captcha</div>\n";
    }
    ?>
        <div class="container-fluid background">
            <div class="container-fluid intro">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-sm-12">
                            <h1 align="center">Welcome to the Pizza Tour!</h1>
                            <h5>This is my journey to find a good local pizza place.
                                I honestly believe that pizza is the rare exception where chains seem to make the better product than a local place.
                                With all the love that local pizza places seem to get, I would hypothesize that this can't be true.
                                My goal is to find a local pizza I prefer over chain pizza. Supporting local business is always preferable.</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-success">
            <h2 align="center" style="padding-top: 20px">Upcoming Places</h2>
            <div class="container-fluid card-body">
                <div class="container-fluid card-text card-scroll">
                    <?php
                    $suggested = $pdo->query('SELECT place,city,state,recommender FROM suggestion');
                    $row = $suggested->fetch();
                    echo "<h6 align='center'>".$row['place'].' of '.$row['city'].', '.$row['state']."</h6>\n";
                    echo "<h6 align='center'>Recommended by <em>".$row['recommender']."</em></h6>\n";
                    while($row = $suggested->fetch()){
                        echo "<hr><h6 align='center'>".$row['place'].' of '.$row['city'].', '.$row['state']."</h6>\n";
                        echo "<h6 align='center'>Recommended by <em>".$row['recommender']."</em></h6>\n";
                    }
                    ?>
                    <br>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-white">
            <h2 align="center" style="padding-top: 20px">Visited Places</h2>
            <div class="container-fluid card-body">
                <div class="container-fluid card-text card-scroll">
                    <?php
                    #Generate list of locations available
                    $location = $pdo->query('SELECT name,city,state FROM pizza_shop ORDER BY name;');
                    $row = $location->fetch();
                    echo "<h6 align='center'>".$row['name'].' of '.$row['city'].', '.$row['state']."</h6>\n";
                    while ($row = $location->fetch()) {   #Populate locations as options from a drop down list.
                        echo "<hr>\n<h6 align='center'>".$row['name'].' of '.$row['city'].', '.$row['state']."</h6>\n";
                    }
                    ?>
                    <br>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-danger" style="min-height: 100%">
            <h2 align="center" style="padding-top: 20px">Suggest a Place</h2>
            <div class="container card-text">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h6 align="center" style="padding-top: 15px">Do you have a favorite local pizza place? Is it not on our upcoming list?
                            Please add it as a suggestion. I'm always looking for recommended places to go to.</h6>
                        <br>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <?php
                    require_once ('scripts/modalSuggest.php')
                    ?>
                </div>
                <br>
            </div>
        </div>
        <?php
        # Load bootstrap dependencies
        require_once ('./scripts/bootstrap-body.php');?>
    </body>
</html>
</html>
