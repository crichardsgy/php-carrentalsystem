<?php
    //this integrates the navbar and the libraries used into this form
    include_once 'header.php';
    require_once 'models/Branch.php';

    $branchController = new Branch;
    $branches = $branchController->findAllBranches();
?>

<section>
    <h3>Add Vehicle</h3>

    <!-- Sends data from the form to controllers/Departments.ctrl.php via POST -->
    <form action="controllers/Vehicles.ctrl.php" enctype="multipart/form-data" method="post">

        <!-- the hidden input that tells the Vehicles controller what function to call (check the bottom of the controllers/Vehicles.ctrl.php file to see what I mean) -->
        <input type="hidden" name="formtype" value="addvehicle">

        <!-- normal form elements -->
        <label for="vehiclevin">Vehicle Identification Number (VIN) (*): </label>
        <input type="text" name="vehiclevin" placeholder="Vehicle Identification Number (VIN)">
        <br/>

        <label for="vehiclelicenseplate">Vehicle License Plate (*): </label>
        <input type="text" name="vehiclelicenseplate" placeholder="Vehicle License Plate">
        <br/>

        <label for="vehiclelicenseexpiration">Vehicle License Expiration: </label>
        <input type="date" name="vehiclelicenseexpiration" placeholder="Vehicle License Expiration">
        <br/>

        <label for="vehiclefitnessexpiration">Vehicle Fitness Expiration: </label>
        <input type="date" name="vehiclefitnessexpiration" placeholder="Vehicle Fitness Expiration">
        <br/>

        <label for="vehiclecolour">Colour: </label>
        <input type="text" name="vehiclecolour" placeholder="Colour">
        <br/>

        <label for="vehiclebrand">Brand (*): </label>
        <input type="text" name="vehiclebrand" placeholder="Brand">
        <br/>

        <label for="vehiclemodel">Model (*): </label>
        <input type="text" name="vehiclemodel" placeholder="Model">
        <br/>

        <label for="vehicleyear">Year (*): </label>
        <input type="text" name="vehicleyear" placeholder="Year">
        <br/>

        <label for="vehicletype">Type (*): </label>
        <select id="vehicletype" name="vehicletype">
            <option value="Car">Car</option>
            <option value="Bike">Bike</option>
            <option value="Bus/Van">Bus/Van</option>
            <option value="SUV">SUV</option>
            <option value="Pick-Up">Pick-Up</option>
            <option value="Truck">Truck</option>
        </select>
        <br/>

        <label for="vehiclelocation">Location (*): </label>
        <select id="vehiclelocation" name="vehiclelocation">
            <?php 
                foreach ($branches as $branch)
                {
                    echo "<option value='$branch->branchaddress'>$branch->branchaddress</option>"; 
                }
            ?>
        </select>
        <br/>

        <label for="vehicleimages">Images: </label>
        <input type="file" name="vehicleimages" accept="image/png, image/jpeg">
        <br/>
        
        <br/><br/>

        <button class='btn btn-primary' type="submit" name="submit">Add Vehicle</button> 
        <a class='btn btn-danger' href="index.php">Cancel</a>  
    </form>
    <br/>
    <?php
        //this reads GET variables and shows error messages (the controller sets the GET variables when an error is found during validation)
        include_once 'includes/errorhandler.inc.php'
    ?>
</section>


<?php
    include_once 'footer.php';
?>