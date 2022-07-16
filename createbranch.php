<?php
    include_once 'header.php';
?>

<section>
    <h3>Create Branch</h3>
    <form action="controllers/Branches.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="createbranch">

        <label for="branchstreet">Street (*): </label>
        <input type="text" name="branchstreet" placeholder="e.g 27 Alexander Street">
        <br/>

        <label for="brancharea">Area (*): </label>
        <input type="text" name="brancharea" placeholder="eg. Eccles, Timehri">
        <br/>

        <label for="branchsector">Sector (*): </label>
        <input type="text" name="branchsector" placeholder="eg. ECD, EBD, WBD, WBD, etc">
        <br/>

        <button class='btn btn-primary' type="submit" name="submit">Create Branch</button> 
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