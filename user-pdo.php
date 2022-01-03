<?php

class User {

    private $id;

    public $login;

    public $password;

    public $email;

    public $firstname;

    public $lastname;

    public function __construct($login,$password,$email,$firstname,$lastname)
    {
        // $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this ->lastname = $lastname;
    }

    public function register($login,$password,$email,$firstname,$lastname)
    {
        try{
           $db = new PDO ('mysql:host=localhost;dbname=classes','root','');
        } catch(PDOexception $e){
            echo "Une erreur est survenue";
        }
        
        
        $req = $db-> exec("INSERT INTO `utilisateurs`(`login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login','$password','$email','$firstname','$lastname')");
        
        var_dump($req);

        $tab = [$login,$email,$firstname,$lastname];
            
        return $tab;
            
            
       

    }

    public function connect($login,$password)
    {
        try{
            $db = new PDO ('mysql:host=localhost;dbname=classes','root','');
         } catch(PDOexception $e){
             echo "Une erreur est survenue";
         }

        $req_connect = $db->query("SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'");

        $rows = $req_connect->row_count();

        if($rows == 1){
            session_start();
            $_SESSION['login'] = $login;
            echo 'Vous êtes connecté'.$login ;
        } else{
            echo 'mdp ou login incorrect';
        }
    }

    public function disconnect()
    {
        session_destroy();
    }

    public function delete($login)
    {
        try{
            $db = new PDO ('mysql:host=localhost;dbname=classes','root','');
        } catch(PDOexception $e){
            echo "une erreur est survenue";
        }
        
        $delete = $db->query("DELETE FROM `utilisateurs` WHERE login = '$login'");

        if(isset($_SESSION['login'])){
            session_destroy();
        }
        
    }

    public function update($login,$password,$mail,$firstname,$lastname)
    {   
        try{
            $db = new PDO ('mysql:host=localhost;dbname=classes','root','');
        } catch(PDOexception $e){
            echo "une erreur est survenue";
        }

        $update =$db->query("UPDATE `utilisateurs` SET `login`='$login',`password`='$password',`email`='$mail',`firstname`='$firstname',`lastname`= '$lastname'");
    }

    public function isconnected()
    {
        if(isset($_SESSION['login'])){
            return true;
        } else {
            return false;
        }
    }

    public function getallinfos()
    {
        try{
            $db = new PDO ('mysql:host=localhost;dbname=classes','root','');
        } catch(PDOexception $e){
            echo "une erreur est survenue";
        }

        $infos =$db-> prepare("SELECT * FROM `utilisateurs`");
        $infos->execute();
        $u = $infos->fetchAll(PDO::FETCH_ASSOC);

        var_dump($u);

        foreach($u as $key => $value){
            echo $value['id'].' '.$value['login'].' '.$value['password'].' '.$value['email'].' '.$value['firstname'].' '.$value['lastname'].'</br>';
    }
    }
}

$user = new User("John117","Johnny","jonh@hotmlail.com","John","Spartan");



// $user->connect("John117","Johnny");

$user->getallinfos();





var_dump($user);