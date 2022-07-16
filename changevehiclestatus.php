<?php
    include_once 'header.php';
    require_once 'models/Branch.php';

    $branchController = new Branch;
    $branches = $branchController->findAllBranches();
?>

<section>
    <h3>Change Vehicle Status</h3>
    <form action="controllers/Vehicles.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="changevehiclestatus">
        <input type="hidden" name="vehicleid" value="<?php echo($_GET['vehicleid']); ?>">

        <label for="vehiclestatus">Status (*): </label>
        <select name="vehiclestatus">
            <option value="On-Lot">On-Lot</option>
            <option value="On-Lease">On-Lease</option>
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
        <br/><br/>

        <button class='btn btn-primary' type="submit" name="submit">Change Status</button> 
        <a class='btn btn-danger' href="managevehicles.php">Cancel</a>  
    </form>
    <br/>
    <?php
        include_once 'includes/errorhandler.inc.php'
    ?>
</section>

<?php
    include_once 'footer.php';
?>