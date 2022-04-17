<?php

namespace App\Controller;

use PDO;
use PDOException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



class DBController
{
    public function connectToDataBase(){
        $params = parse_ini_file('../config/params.ini', true);
        $dsn = "mysql:host=" . $params['host'] . ";dbname=" . $params['db'];
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            return new PDO($dsn, $params['user'], $params['pass'], $opt);
        } catch (PDOException $e) {
            print "Has errors: " . $e->getMessage();
            die();
        }
    }

    public function addAppToDB(PDO $PDO,$first_name, $second_name, $last_name = null, $email, $phone, $comment){
        $prep = $PDO->
        prepare("INSERT INTO `users` 
            (`first_name`, `second_name`, `last_name` ,`email`, `phone`, `comment`) 
            VALUES
            (:fname, :sname, :lname, :email, :phone, :comm)");
        $prep->execute([
            'fname' => $first_name,
            'sname' => $second_name,
            'lname' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'comm' => $comment
        ]);
    }

    public function getUserWithActiveReplyByEmail(PDO $PDO, $email, $datatime){
        $prep = $PDO->prepare("SELECT * FROM `users` WHERE `email` = :email and `add_time` > :datatime");
        $prep->execute([
            'email' => $email,
            'datatime' => $datatime
        ]);
        return $prep->fetch();
    }

    public function getUserCountByEmail(PDO $PDO, $email){
        $prep = $PDO->prepare("SELECT count(*) FROM `users` WHERE `email` = :email");
        $prep->execute([
            'email' => $email,
        ]);
        return $prep->fetch()['count(*)'];
    }

    public function getUserIdByEmail(PDO $PDO, $email){
        $prep = $PDO->prepare("SELECT `id` FROM `users` WHERE `email` = :email");
        $prep->execute([
            'email' => $email,
        ]);
        return $prep->fetch()['id'];
    }

    public function deleteUserById($PDO, $id){
        $prep = $PDO->prepare("DELETE FROM `users` WHERE `id` = :id");
        $prep->execute([
            'email' => $id,
        ]);
    }

    public function sendToEmail(string $name, string $email, string $phone, string $comment)
    {
        $params = parse_ini_file('../config/email.ini', true);
        $mail = new PHPMailer(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $params['host'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $params['email'];                     //SMTP username
            $mail->Password   = $params['pass'];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->setFrom($params['email'], 'IntaroLabMailer');
            $mail->addAddress($email, $name);     //Add a recipient
            $mail->addReplyTo($params['email'], 'Обратная связь');

            $mail->isHTML(true);
            $mail->Subject = 'New Message from PHPMailer!';
            $mail->Body = "Было оставлено сообщение в форме обратной связи.<br>Автор:<b>{$name}</b>.<br>Email автора:<b>{$email}</b>.<br>Телефон:<b>{$phone}</b>.<br>Сообщение: <b>{$comment}</b>.";
            $mail->AltBody = "Было оставлено сообщение в форме обратной связи. Автор: {$name}, Email автора: {$email}, Телефон: {$phone}, Сообщение: {$comment}.";

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}