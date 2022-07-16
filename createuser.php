<?php
    include_once 'header.php';
?>

<section>
    <h3>Create Account</h3>
    <form action="controllers/Users.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="register">

        <label for="useruid">Username (*): </label>
        <input type="text" name="useruid" placeholder="Username">
        <br/>

        <label for="userfname">First Name (*): </label>
        <input type="text" name="userfname" placeholder="First Name">
        <br/>

        <label for="userlname">Last Name (*): </label>
        <input type="text" name="userlname" placeholder="Last Name">
        <br/>

        <label for="userpassword">Password (*): </label>
        <input type="password" name="userpassword" placeholder="Password">
        <br/>

        <label for="userpasswordconfirm">Repeat Password (*): </label>
        <input type="password" name="userpasswordconfirm" placeholder="Repeat Password">
        <br/>

        <label for="useraddress">Address (*): </label>
        <input type="text" name="useraddress" placeholder="Address">
        <br/>

        <label for="userphonenumber">Phone Number (*): </label>
        <input type="text" name="userphonenumber" placeholder="Phone Number">
        <br/>

        <label for="useremail">Email Address (*): </label>
        <input type="text" name="useremail" placeholder="Email Address">
        <br/>
        
        <?php if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin"): ?>
            <label for="usertype">Account Type (*): </label>
            <select id="usertype" name="usertype">
                <option value="admin">Admin</option>
                <option value="user">Regular User</option>
            </select>
        <?php endif ?>
        
        <br/><br/>

        <button class='btn btn-primary' type="submit" name="submit">Create User</button> 
        <a class='btn btn-danger' href="manageusers.php">Cancel</a>  
    </form>
    <br/>
    <?php
        include_once 'includes/errorhandler.inc.php'
    ?>
</section>


<?php
    include_once 'footer.php';
?>