<?php
    //this integrates the navbar and the libraries used into this form
    include_once 'header.php';
    require_once 'models/Branch.php';

    $branchController = new Branch;
    $branches = $branchController->findAllBranches();
?>

<section>
    <h3>Update Vehicle</h3>

    <!-- Sends data from the form to controllers/Departments.ctrl.php via POST -->
    <form action="controllers/Vehicles.ctrl.php" enctype="multipart/form-data" method="post">

        <!-- the hidden input that tells the Vehicles controller what function to call (check the bottom of the controllers/Vehicles.ctrl.php file to see what I mean) -->
        <input type="hidden" name="formtype" value="updatevehicle">
        <input type="hidden" name="vehicleid" value="<?php echo $_GET['vehicleid']; ?>">

        <!-- normal form elements -->
        <label for="vehiclevin">Vehicle Identification Number (VIN) (*): </label>
        <input type="text" name="vehiclevin" placeholder="Vehicle Identification Number (VIN)" value="<?php echo $_GET['vehiclevin']; ?>">
        <br/>

        <label for="vehiclelicenseplate">Vehicle License Plate (*): </label>
        <input type="text" name="vehiclelicenseplate" placeholder="Vehicle License Plate" value="<?php echo $_GET['vehiclelicenseplate']; ?>">
        <br/>

        <label for="vehiclelicenseexpiration">Vehicle License Expiration: </label>
        <input type="date" name="vehiclelicenseexpiration" placeholder="Vehicle License Expiration" value="<?php echo $_GET['vehiclelicenseexpiration']; ?>">
        <br/>

        <label for="vehiclefitnessexpiration">Vehicle Fitness Expiration: </label>
        <input type="date" name="vehiclefitnessexpiration" placeholder="Vehicle Fitness Expiration" value="<?php echo $_GET['vehiclefitnessexpiration']; ?>">
        <br/>

        <label for="vehiclecolour">Colour: </label>
        <input type="text" name="vehiclecolour" placeholder="Colour" value="<?php echo $_GET['vehiclecolour']; ?>">
        <br/>

        <label for="vehiclebrand">Brand (*): </label>
        <input type="text" name="vehiclebrand" placeholder="Brand" value="<?php echo $_GET['vehiclebrand']; ?>">
        <br/>

        <label for="vehiclemodel">Model (*): </label>
        <input type="text" name="vehiclemodel" placeholder="Model" value="<?php echo $_GET['vehiclemodel']; ?>">
        <br/>

        <label for="vehicleyear">Year (*): </label>
        <input type="text" name="vehicleyear" placeholder="Year" value="<?php echo $_GET['vehicleyear']; ?>">
        <br/>

        <label for="vehicletype">Type (*): </label>
        <select id="vehicletype" name="vehicletype">
            <option value="Car" <?php if($_GET["vehicletype"] == "Car"){echo "selected";} ?>>Car</option>
            <option value="Bike" <?php if($_GET["vehicletype"] == "Bike"){echo "selected";} ?>>Bike</option>
            <option value="Bus/Van" <?php if($_GET["vehicletype"] == "Bus/Van"){echo "selected";} ?>>Bus/Van</option>
            <option value="SUV" <?php if($_GET["vehicletype"] == "SUV"){echo "selected";} ?>>SUV</option>
            <option value="Pick-Up" <?php if($_GET["vehicletype"] == "Pick-Up"){echo "selected";} ?>>Pick-Up</option>
            <option value="Truck" <?php if($_GET["vehicletype"] == "Truck"){echo "selected";} ?>>Truck</option>
        </select>
        <br/>

        <label for="vehiclelocation">Location (*): </label>
        <select id="vehiclelocation" name="vehiclelocation">
            <?php 
                foreach ($branches as $branch)
                {
                    echo "<option value='$branch->branchaddress'>$branch->branchaddress</option>"; 
                }
                echo "<option value=" . $_GET["vehiclelocation"] . ">" . $_GET["vehiclelocation"] . "</option>"; 
            ?>
        </select>
        <br/>

        <label for="vehicleimages">Images (Leave To Keep Unchanged): </label>
        <input type="file" name="vehicleimages" accept="image/png, image/jpeg">
        <br/>
        
        <br/><br/>

        <button class='btn btn-primary' type="submit" name="submit">Update Vehicle</button> 
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