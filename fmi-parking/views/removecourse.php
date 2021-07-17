<?php
    session_start();
    if(!isset($_SESSION['u_id']) || $_SESSION['u_role'] != 'admin') {
        header("Location: index.php?action=notauthorised");
        exit();
    }
    include_once 'header.php';
?>

<form class="form" autocomplete="off" action="/fmi-parking/controllers/api.php/removecourse" method="POST">
	<h1 class="h3 mb-3 font-weight-normal">Изтрий курс</h1>

	<div class="form-group">
		<label for="id" class="sr-only">Course ID</label>
		<input type="text" required name="id" class="form-control" id="id" placeholder="Course ID">
    </div>
    <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Премахване</button>
</form>

 