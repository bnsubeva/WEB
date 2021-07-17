<?php
    session_start();
    if(!isset($_SESSION['u_id']) || $_SESSION['u_role'] != 'admin') {
        header("Location: index.php?action=notauthorised");
        exit();
    }
    include_once 'header.php';
?>

<form class="form" autocomplete="off" action="/fmi-parking/controllers/api.php/addcourse" method="POST">
	<h1 class="h3 mb-3 font-weight-normal">Добавяне на курс</h1>
	<div class=form-group>
		<label for="emailInput" class="sr-only"><p>Имейл на преподавателя</p></label>
		<input type="email" required name="email" class="form-control" id="emailInput" placeholder="Имейл на преподавателя">
    </div>
    <div class=form-group>
        <label for="nameInput" class="sr-only"><p>Име на курса</p></label>
		<input type="text" required name="name" class="form-control" id="nameInput" placeholder="Име на курса">
    </div>
    
    <div class=form-row>
        <div class="form-group col-md-6">
            <label for="fromInput"><p>Начален час</p></label>
            <input type="time" required name="from" class="form-control" id="fromInput" min="07:15" max="20:15" placeholder="Начален час">
        </div>
        <div class="form-group col-md-6">
            <label for="toInput"><p>Краен час</p></label>
            <input type="time" required name="to" class="form-control" id="toInput" min="08:00" max="23:00" placeholder="Краен час">
   
        </div>

    </div>    
    <div class="form-group">
        <label class="button-container"><p>Пн</p>
            <input type="radio" checked="checked" name="day" value="Monday">
            <span class="checkmark"></span>
        </label>
        <label class="button-container"><p>Вт</p>
            <input type="radio" name="day" value="Tuesday">
            <span class="checkmark"></span>
        </label>
        <label class="button-container"><p>Ср</p>
            <input type="radio" name="day" value="Wednesday">
            <span class="checkmark"></span>
        </label>
        <label class="button-container"><p>Чтв</p>
            <input type="radio" name="day" value="Thursday">
            <span class="checkmark"></span>
        </label>
        <label class="button-container"><p>П</p>
            <input type="radio" name="day" value="Friday">
            <span class="checkmark"></span>
        </label>
        <label class="button-container"><p>С</p>
            <input type="radio" name="day" value="Saturday">
            <span class="checkmark"></span>
        </label>
        <label class="button-container"><p>Н</p>
            <input type="radio" name="day" value="Sunday">
            <span class="checkmark"></span>
        </label>
    </div>

	<input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Добавяне">
    
</form>

 