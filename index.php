<?php
    include_once 'header.php';
    include_once 'models/Init.php';
    include_once 'models/Vehicle.php';

    $vehiclesController = new Vehicle;
    $vehiclelist = $vehiclesController->findAllAvailableVehicles();

    if (isset($_SESSION["userfullname"]))
    {
      echo "<h2>Welcome " . $_SESSION["userfullname"] . "</h2>";
      echo "<br/>";
    }
?>

<?php if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin"): ?>
    <a href="addvehicle.php"><button class="btn-primary">Add Vehicle</button></a>
    </br>  

<?php elseif(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "user"): ?>
    <h5>Hello Regular User</h5>

<?php endif ?>

<?php
    echo("<div class='container'>");
    echo ("<div class='row'>");
    $count = 1;

    if (!empty($vehiclelist))
    {
        foreach($vehiclelist as $vehicle) 
        {
            if ($count % 7 == 0)
            {
                $count = 1;
                echo ("</div>");
                echo ("<div class='row'>");
            }

            echo "<a href='vehicledetails.php?vehicleid=$vehicle->vehicleid'>";
                echo ("<div class='col-sm'>");

                ob_start();
                fpassthru($vehicle->vehicleimages);
                $contents = ob_get_contents();
                ob_end_clean(); 
                $dataUri = "data:image/png;base64," . base64_encode($contents);
                echo "<img style='margin-top: 30px; width: 300px; height: 300px; object-fit: cover;' src='$dataUri'/>";
                echo "<br/>";
                echo($vehicle->vehicleyear);
                echo (" ");
                echo($vehicle->vehiclebrand);
                echo (" ");
                echo($vehicle->vehiclemodel);
                echo (" ");
                $count = $count + 1;
                echo ("</div>");
            echo "</a>";

        }
        echo ("</div>");
    }
?>


<?php
    include_once 'footer.php';
?>