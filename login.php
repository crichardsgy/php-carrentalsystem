<?php
    include_once 'header.php';
?>

<section class="loginform">
    <h3>Log In</h3>
    <form action="controllers/Users.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="login">
        <input type="text" name="useruid" placeholder="Username">
        <input type="password" name="userpassword" placeholder="Password">
        <br/><br/>
        <button class='btn btn-primary' type="submit" name="submit">Log In</button> 
    </form>
    <br/>
    <a href="createuser.php"><button class='btn btn-secondary'>Create Account</button></a>


    <?php
        include_once 'includes/errorhandler.inc.php'
    ?>
</section>
 
<?php
    include_once 'footer.php';
?>