<?php
    include_once 'header.php';
?>

<section>
    <h3>Submit Rent Request</h3>
    <form action="controllers/Requests.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="submitrentrequest">
        <input type="hidden" name="vehicleid" value="<?php echo($_GET['vehicleid']); ?>">

        <label for="rentstart">Rent Start Date (*): </label>
        <input type="date" name="rentstart" placeholder="Rent Start Date">
        <br/>

        <label for="rentend">Rent End Date (*): </label>
        <input type="date" name="rentend" placeholder="Rent End Date">
        <br/><br/>

        <button class='btn btn-primary' type="submit" name="submit">Submit Rent Request</button> 
        <a class='btn btn-danger' href="index.php">Cancel</a>  
    </form>
    <br/>
    <?php
        include_once 'includes/errorhandler.inc.php'
    ?>
</section>

<?php
    include_once 'footer.php';
?>