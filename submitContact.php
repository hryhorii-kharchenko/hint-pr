<meta charset="utf-8">
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    // apache_setenv('no-gzip', 1);
    // ini_set('zlib.output_compression', 0);

    $response = "";
    $responseFlag = 0;

    if (isset($_POST['action']) && !(empty($_POST['action']))
        && !(empty($_POST['contactEmail']))) {

        $from = $_POST['contactEmail'];

        $subject = "Contact form from hintpr.com";
        $body = "Имейл из контактной формы сайта: " . $from;

        $responseFlag = 1;
        
        sendEmail($subject, $body);
                        

        if (!$responseFlag) {
            header('X-Accel-Buffering: no');
            echo $response;

            //Begin code from link
            ob_end_clean();
            header("Connection: close");
            ignore_user_abort(true);
            ob_start();
            echo $response;
            // header("Content-Length: " . mb_strlen($response));
            ob_end_flush();
            flush();
            //End code from link
        }
    }

    $response = "Пожалуйста, заполните все поля.";

    if (!$responseFlag) {
        header('X-Accel-Buffering: no');
        echo $response;

        //Begin code from link
        ob_end_clean();
        header("Connection: close");
        ignore_user_abort(true);
        ob_start();
        echo $response;
        // header("Content-Length: " . mb_strlen($response));
        ob_end_flush();
        flush();
        //End code from link
    }


    function sendEmail($subject, $body) {
        $mail = new PHPMailer();  
        
        // $mail->Encoding = "utf-8";
        // $mail->Host = "smtp.gmail.com";
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Username = "hintprcom@gmail.com";
        $mail->Password = "rmDu1xUC55Hzzb0";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 587;
        
        $mail->Host = 'tls://smtp.gmail.com:587';
        $mail->SMTPOptions = array(
           'ssl' => array(
             'verify_peer' => false,
             'verify_peer_name' => false,
             'allow_self_signed' => true
            )
        );

        // $mail->addAddress("theshadow212@gmail.com");
        $mail->addAddress("hello@hintpr.com");
        $mail->setFrom("hintprcom@gmail.com", "hintpr.com");
        $mail->Subject = $subject;
        $mail->isHTML(false);
        $mail->Body = $body;

        if(!$mail->send()) {
            error_log('Message could not be sent.');
            error_log('Error code: ' . $mail->ErrorInfo);
            error_log("Subject: " . $subject);
            error_log("Body: " . $body);

            $response = "Произошла ошибка. Пожалуйста, попробуйте ещё раз." . $mail->ErrorInfo;
            echo $response;
        } else {
            $response = "Ваше сообщение отправлено.";
            echo $response;
        }
    }
?>