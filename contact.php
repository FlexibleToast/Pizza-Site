<!doctype html>
<html lang="en">
    <title>Contact Form</title>
    <head>
        <?php
        # Include PHPMailer libraries
        require ('./phpmailer/PHPMailer.php');
        require ('./phpmailer/SMTP.php');
        # Load bootstrap
        require_once('./scripts/bootstrap-head.php');
        # TinyMCE for WYSIWYG editor
        require_once('./scripts/tinymce.php');
        # Load navbar
        require_once('navbar.php');
        # Load config for captcha key
        require_once('./scripts/config.php');
        ?>
        <!-- Recaptcha for Suggestion Submission -->
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <style type="text/css">
            .alert{
                margin-bottom: 0 !important;
                text-align: center !important;
            }
        </style>
    </head>
    <body>
    <?php
    if(isset($_POST['name']))
    {
        if(empty($_POST['message']))
        {
            # If message is empty redirect to fail
            # Post redirect get
            header("Location: https://mcdade.info/pizza/contact.php?success=message");
        }
        else{
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
                header("Location: https://mcdade.info/pizza/contact.php?success=captcha");
            } else {
                # If CAPTCHA is successfully completed...
                # Send email
                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);                              // Passing `true` enables exceptions
                try {
                    //Server settings
                    #$mail->SMTPDebug = 2;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = $SMTP_USERNAME;                 // SMTP username
                    $mail->Password = $SMTP_PASSWORD;                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom($_POST['return'], $_POST['name']);
                    $mail->addAddress('Joseph@mcdade.info', 'Site Admin');     // Add a recipient
                    $mail->addReplyTo($_POST['return']);

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Pizza Tour user '.$_POST['name'];
                    $mail->Body    = $_POST['message'];
                    $mail->AltBody = strip_tags($_POST['message']);

                    $mail->send();
                    $mail->ClearAllRecipients();
                    # Post redirect get
                    header("Location: https://mcdade.info/pizza/contact.php?success=true");
                } catch (Exception $e) {
                    echo "<div id='alert' class='alert alert-danger rounded-0' role='alert'>Message could not be sent. Mailer Error: ".$mail->ErrorInfo."</div>\n";
                }
            }
        }
    }
    elseif ($_GET['success']=='true')
    {
        echo "<div id='alert' class='alert alert-success rounded-0' role='alert'>Message sent successfully!</div>\n";
    }
    elseif ($_GET['success']=='captcha')
    {
        echo "<div id='alert' class='alert alert-danger rounded-0' role='alert'>Failed to Add: Must check captcha</div>\n";
    }
    elseif ($_GET['success']=='message')
    {
        echo "<div id='alert' class='alert alert-danger rounded-0' role='alert'>Message can not be empty</div>\n";
    }
    ?>
        <div class="container" style="padding-top: 20px;">
            <h1 align="center">Contact Us Form</h1>
        </div>
        <div class="container">
            <form action="contact.php" method="post">
                <div class="row">
                    <div class="col-lg form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-lg form-group">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="return" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" rows="10"></textarea>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="d-flex justify-content-center">
                            <div class="g-recaptcha" data-sitekey="6LeHw2EUAAAAAC5RFTT2Sz7udt8iRwNPETrnDwNZ"></div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="d-flex justify-content-center" style="padding-top: 20px">
                            <div class="btn-toolbar">
                                <div class="btn-group" style="padding-right: 10px;">
                                    <input class="btn btn-secondary" onClick="window.location.href='index.php'" type="button" value="Cancel">
                                </div>
                                <div class="btn-group">
                                    <input class="btn btn-primary" type="submit" name="save" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><br>
        <?php
        #Load bootstrap dependencies
        require_once('./scripts/bootstrap-body.php'); ?>
    </body>
</html>
