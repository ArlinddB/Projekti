<?php 

include_once('./controllers/RegisterController.php');
include_once('./controllers/LoginController.php');

if(isset($_POST['email']) && isset($_POST['password'])){
    function validate($input){

        $input = trim($input);
        
        $input = stripslashes($input);
        
        $input = htmlspecialchars($input);
        
        return $input;
        
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    $auth = new LoginController;
    $checkLogin = $auth->userLogin($email, $password);

    if($checkLogin){
        header("Location: index.php?msg=<script>alert('Welcome, $email')</script>");
    }
    else{
        header("Location: SignInPage.php?msg1=Email or password is invalid");
    }

}

if(isset($_POST['register_btn'])){

    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $dob=date('Y-m-d', strtotime($_POST['date']));
    $gender=$_POST['Gender'];

    $register = new RegisterController;

    $result_username = $register->UsernameExists($username);

    $result_email = $register->EmailExists($email);

    if($result_username){
        header("Location: SignUpPage.php?u-msg=Username already exists");
        exit();

    }
    else{
        if($result_email){
            header("Location: SignUpPage.php?e-msg=Email already exists");
            exit();
        }
        else{
            $register_query = $register->registration($firstname,$lastname,$username,$email,$password,$dob,$gender);
            if($register_query){
                header("Location: SignInPage.php");
                exit();
            }
        }
    }
}

?>