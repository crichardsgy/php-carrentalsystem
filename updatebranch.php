<?php
    include_once 'header.php';
?>

<section>
    <h3>Update Branch</h3>
    <form action="controllers/Branches.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="updatebranch">
        <input type="hidden" name="branchid" value="<?php echo $_GET['branchid']; ?>">

        <label for="branchaddress">Street (*): </label>
        <input type="text" name="branchaddress" placeholder="e.g 27 Alexander Street, Kitty, Georgetown" value="<?php echo $_GET['branchaddress']; ?>">
        <br/>

        <button class='btn btn-primary' type="submit" name="submit">Update Branch</button> 
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