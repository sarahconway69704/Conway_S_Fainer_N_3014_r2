<?php 
require '../phpmailer/PHPMailerAutoload.php';
function createUser($fname, $username, $email){
    $pdo = Database::getInstance()->getConnection();
    
    //TODO: finish the below so that it can run a SQL query
    // to create a new user with provided data
    $create_user_query = 'INSERT INTO tbl_user(user_fname, user_name, user_pass, user_email, user_ip)';
    $create_user_query .= ' VALUES(:fname, :username, :password, :email, "no" )';
    
    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $randPassword = randString($string, 8);


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
     //TODO: redirect to index.php if creat user successfully
    // otherwise, return a error message
    if($create_user_result){
    

        $mail = new PHPMailer;

        // use this line only for local host. 
        $mail->isSMTP();
        // ^^^^^^^^^^^^^^^^^

        $mail->Host='smtp.gmail.com';
        $mail->Port=587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        
        $mail->Username='cfs.noahfainer@gmail.com';
        $mail->Password='bimcheese123';
        
        $mail->setFrom('cfs.noahfainer@gmail.com');
        $mail->addAddress($email);
        $mail->addReplyTo('cfs.noahfainer@gmail.com');

        $mail->isHTML(true);
        $mail->Subject='PHP Mailer';
        $mail->Body='<h1 align=center>Noah and Sarah says hi </h1>
        <h1>Your username is: </h1>' . $username . 
        '<h1>Your password is: </h1>' . $randPassword . 
        '<h2>To login, go here: http://localhost:8888/Conway_S_Fainer_N_3014_r2/admin/admin_login.php</h2>';

        if(!$mail->send()){
            echo 'message was not able to send';
        } else{
            echo 'great success';
        }

        redirect_to('index.php');


    }else{
        return 'The user did not go through';
    }

}