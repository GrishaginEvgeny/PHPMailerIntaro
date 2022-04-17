<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;

class HomeController extends BaseController
{

    private DBController $DBController;

    public function __construct(Request $request)
    {
        $this->DBController = new DBController();
    }

    public function homepage() : Response{
        return $this->renderTemplate('homepage.php', [
        ]);
    }

    public function sendApp(){
        $fname = htmlspecialchars($_POST["first_name"]);
        $sname = htmlspecialchars($_POST["second_name"]);
        $lname = htmlspecialchars($_POST["last_name"]);
        $email = htmlspecialchars($_POST["email"]);
        $phone = htmlspecialchars($_POST["phone"]);
        $comm = htmlspecialchars($_POST["comm"]);
        $PDO = $this->DBController->connectToDataBase();
        if($this->DBController->getUserCountByEmail($PDO, $email) > 0){
            $dateFromDB =  DateTime::createFromFormat('Y-m-d H:i:s',$this->
            DBController->
            getUserWithActiveReplyByEmail($PDO, $email, date('Y-m-d H:i:s'))['add_time']);
            $now = new \DateTime();
            //Время отправки ещё не истекло
            if($dateFromDB > $now){
                $interval = $now->diff($dateFromDB);
                return new JsonResponse(['status'=>false, 'h'=>$interval->h, 'm'=>$interval->i, 's' => $interval->s]);
            } else {
                $this->DBController->deleteUserById($PDO,$this->DBController->getUserIdByEmail($PDO, $email));
                $this->DBController->addAppToDB($PDO, $fname, $sname, $lname, $email, $phone, $comm);
                $this->DBController->sendToEmail($fname.' '.$sname.' '.$lname,$email,$phone,$comm);
                return new JsonResponse(['status'=>true]);
            }
        }
        else {
            $this->DBController->addAppToDB($PDO, $fname, $sname, $lname, $email, $phone, $comm);
            $this->DBController->sendToEmail($fname.' '.$sname.' '.$lname,$email,$phone,$comm);
            return new JsonResponse(['status'=>true]);
        }
    }

}