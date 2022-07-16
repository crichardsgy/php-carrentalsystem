<?php
    include_once 'header.php';
    require_once "models/Vehicle.php";

    $vehicleModel = new Vehicle;
    $vehiclelist = $vehicleModel->findAllVehicles();

?>

<?php if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin"): ?>
    <section>
        <h3>All Vehicles</h3>
        <br/>
        <a href="addvehicle.php"><button class="btn-primary">Add Vehicle</button></a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>VIN</th>
                <th>License Plate</th>
                <th>Vehicle License Expiration</th>
                <th>Vehicle Fitness Expiration</th>
                <th>Colour</th>
                <th>Type</th>
                <th>Location</th>
                <th>Status</th>
            </tr>
            </thead>
            <?php if(!empty($vehiclelist)):?>
            <tbody>
                <?php
                    foreach($vehiclelist as $vehicle) 
                    {
                        echo "<tr>";
                            echo "<td>$vehicle->vehiclebrand</td>";
                            echo "<td>$vehicle->vehiclemodel</td>";
                            echo "<td>$vehicle->vehicleyear</td>";
                            echo "<td>$vehicle->vehiclevin</td>";
                            echo "<td>$vehicle->vehiclelicenseplate</td>";
                            echo "<td>$vehicle->vehiclelicenseexpiration</td>";
                            echo "<td>$vehicle->vehiclefitnessexpiration</td>";
                            echo "<td>$vehicle->vehiclecolour</td>";
                            echo "<td>$vehicle->vehicletype</td>";
                            echo "<td>$vehicle->vehiclelocation</td>";
                            echo "<td>$vehicle->vehiclestatus</td>";
                            echo "<td>
                            <a href='updatevehicle.php?vehicleid=$vehicle->vehicleid&vehiclebrand=$vehicle->vehiclebrand&vehiclemodel=$vehicle->vehiclemodel&vehicleyear=$vehicle->vehicleyear&vehiclevin=$vehicle->vehiclevin&vehiclelicenseplate=$vehicle->vehiclelicenseplate&vehiclelicenseexpiration=$vehicle->vehiclelicenseexpiration&vehiclefitnessexpiration=$vehicle->vehiclefitnessexpiration&vehicletype=$vehicle->vehicletype&vehiclecolour=$vehicle->vehiclecolour&vehiclelocation=$vehicle->vehiclelocation&vehiclestatus=$vehicle->vehiclestatus'><button class='btn btn-warning'>Edit</button></a>
                            </td>";
                            if ($vehicle->vehiclestatus !== "On-Lease")
                            {
                                echo "<td>
                                <form action='controllers/Vehicles.ctrl.php' method='post'>
                                <input type='hidden' name='formtype' value='deletevehicle'>
                                <button class='btn btn-danger' type='submit' name='vehicleid' value='$vehicle->vehicleid'>Delete</button>
                                </form>
                                </td>";
                            }
                        echo "</tr>";
                    }  
                ?>
            </tbody>
            <?php endif;?>
        </table>
    </section>

<?php endif;?>

<?php
    include_once 'footer.php';
?>