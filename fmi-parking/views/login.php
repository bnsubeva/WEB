<?php
	session_start();
    if(isset($_SESSION['u_id'])) {
        header("Location: index.php?action=notauthorised");
        exit();
    }

    include_once 'header.php';
?>

<form class="form" autocomplete="off" action="/fmi-parking/controllers/api.php/login" method="POST">
	<h1 class="h3 mb-3 font-weight-normal">Влезте в профила си</h1>

	<div class="form-group">
		<label for="emailInput" class="sr-only">Имейл Адрес</label>
		<input type="email" required name="email" class="form-control grouped" id="emailInput" placeholder="Имейл Адрес">

		<label for="passwordInput" class="sr-only">Парола</label>
		<input type="password" required name="pwd" class="form-control" id="passwordInput" placeholder="Парола">
	</div>

	<input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Вход">
	<?php 
    $errorMsg = "";
    if(isset($_GET['login'])){
        $login = $_GET['login']; 
        switch ($login) {
                 
				case "wrongCredentials":
                $errorMsg = "Invalid credentials!";
				break;    
               
    }
}
    
    ?>
    <div class="error"><?php print $errorMsg; ?></div>
</form>

 