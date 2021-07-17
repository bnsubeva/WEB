<?php include_once 'views/header.php'; ?>

<?php
require_once 'controllers/ParkingSpotController.php';
require_once 'models/ParkingSpotService.php';

$parking_spots = ParkingSpotController::getAllParkingSpots();
$free_spots = ParkingSpotController::countFreeParkingSpots($parking_spots);
?>

<div class="container">
    <?php if (is_logged_in()) { ?>
        <h1>Статус на паркинга</h1>
        <div class="row">
            <?php foreach ($parking_spots as $spot) : ?>
                <div class="col col-xs-2 col-sm-2 col-md-2 col-lg-1 mb-4" style="min-width: 105px;">
                    <div class="card text-white <?php echo $spot->isFree() ? 'bg-success' : 'bg-danger' ?>">
                        <div class="card-header"><?php echo $spot->getNumber() ?></div>
                        <div class="card-body">
                            <p class="card-text">
                                <?php if ($spot->isFree()) { ?>
                                    <p>Free</p>
                                <?php } else { ?>
                                    <p>Busy</p>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php } else { ?>
        <h1>Добре дошли!</h1>
        <h3>В момента има <?php echo $free_spots ?> свободни места.</h3>
        <h3>За  повече информация или за да влезете/излезете, моля влезте в профила си.</h3>
    <?php } ?>
</div>

 