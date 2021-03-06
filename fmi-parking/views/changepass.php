<?php
session_start();
if(!isset($_SESSION['u_id'])) {
    header("Location: index.php?action=notauthorised");
    exit();
}
include_once 'header.php';
?>

<form class="form" autocomplete="off" action="/fmi-parking/controllers/api.php/changepass" method="POST">
    <h1 class="h3 mb-3 font-weight-normal">Промени паролата си</h1>

    <div class=form-group>
        <label for="oldPasswordInput" class="sr-only">Стара Парола</label>
        <input type="password" required name="pwd" class="form-control" id="oldPasswordInput" placeholder="Стара парола">
    </div>
    <div class=form-group>
        <label for="newPasswordInput" class="sr-only">Нова Парола</label>
        <input type="password" required name="newPwd" class="form-control" id="newPasswordInput" placeholder="Нова парола">

        <label for="repeatNewPasswordInput" class="sr-only">Повторете Новата Парола</label>
        <input type="password" required name="newPwd2" class="form-control" id="repeatNewPasswordInput" placeholder="Повторете новата парола">
    </div>

    <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Промени">

    <?php 
    $errorMsg = "";
    if(isset($_GET['changepass'])){
        $changepass = $_GET['changepass']; 
        
        switch ($changepass) {
            case "empty":
                $errorMsg = "Password is empty!";    
                break;
            case "passwordsMismatch":
                $errorMsg = "Passwords did not match";
                break;
            case "fail":
                $errorMsg = "Failed";
                break;
            case "success":
                $errorMsg = "Password is change successfully";
                break;
            
        }
    }
    
    ?>
    <div class="error"><?php print $errorMsg; ?></div>
     
</form>

 
