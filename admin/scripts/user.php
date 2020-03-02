<?php 

// connect to mailer
require '../phpmailer/PHPMailerAutoload.php';

function createUser($fname, $username, $email){
    $pdo = Database::getInstance()->getConnection();
    

    // to create a new user with provided data
    $create_user_query = 'INSERT INTO tbl_user(user_fname, user_name, user_pass, user_email, user_ip)';
    $create_user_query .= ' VALUES(:fname, :username, :password, :email, "no" )';
    
    // Make a string variable
    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    // Call on the function that randomizes the string and set the length of it
    $randPassword = randString($string, 8);

    // encrypt password
    $encryptPw = password_hash($randPassword, PASSWORD_DEFAULT);

    $create_user_set = $pdo->prepare($create_user_query);
    $create_user_result = $create_user_set->execute(
        array(
            ':fname'=>$fname,
            ':username'=>$username,
            ':password'=>$encryptPw,
            ':email'=>$email,

         
        )
    );


    if($create_user_result){
    
        // send email to new user
        $mail = new PHPMailer;

        // use this line only for local host. 
        $mail->isSMTP();


        $mail->Host='smtp.gmail.com';
        $mail->Port=587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        
        $mail->Username='@gmail.com';
        $mail->Password='abcd';
        
        $mail->setFrom('@gmail.com');
        $mail->addAddress($email);
        $mail->addReplyTo('@gmail.com');

        $mail->isHTML(true);
        $mail->Subject='PHP Mailer';

        // email message w/ username, password, and link
        $mail->Body='<h1 align=center>Noah and Sarah says hi </h1>
        <h1>Your username is: </h1>' . $username . 
        '<h1>Your password is: </h1>' . $randPassword . 
        '<h2>To login, go here: http://localhost:8888/Conway_S_Fainer_N_3014_r2/admin/admin_login.php</h2>';

        if(!$mail->send()){
            echo 'message was not able to send';
        } else{
            echo 'great success';
        }

        //go back to welcome page
        redirect_to('index.php');


    }else{
        return 'The user did not go through';
    }

}