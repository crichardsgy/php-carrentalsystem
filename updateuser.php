<?php
    include_once 'header.php';
?>

<section>
    <h3>Update Account</h3>
    <form action="controllers/Users.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="updateuser">
        <input type="hidden" name="userid" value="<?php echo $_GET['userid']; ?>">
        
        <label for="userfname">First Name (*): </label>
        <input type="text" name="userfname" placeholder="First Name" value="<?php echo $_GET['userfname']; ?>">
        <br/>

        <label for="userlname">Last Name (*): </label>
        <input type="text" name="userlname" placeholder="Last Name" value="<?php echo $_GET['userlname']; ?>">
        <br/>

        <label for="userpassword">Password (Leave Blank To Keep Unchanged): </label>
        <input type="password" name="userpassword" placeholder="Password">
        <br/>

        <label for="userpasswordconfirm">Repeat Password (Leave Blank To Keep Unchanged): </label>
        <input type="password" name="userpasswordconfirm" placeholder="Repeat Password">
        <br/>

        <label for="useraddress">Address (*): </label>
        <input type="text" name="useraddress" placeholder="Address" value="<?php echo $_GET['useraddress']; ?>">
        <br/>

        <label for="userphonenumber">Phone Number (*): </label>
        <input type="text" name="userphonenumber" placeholder="Phone Number" value="<?php echo $_GET['userphonenumber']; ?>">
        <br/>

        <label for="useremail">Email Address (*): </label>
        <input type="text" name="useremail" placeholder="Email Address" value="<?php echo $_GET['useremail']; ?>">
        <br/>
        
        <?php if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin"): ?>
            <label for="usertype">Account Type (*): </label>
            <select id="usertype" name="usertype">
                <option value="admin" <?php if($_GET["usertype"] == "admin"){echo "selected";} ?>>Admin</option>
                <option value="user"<?php if($_GET["usertype"] == "user"){echo "selected";} ?>>Regular User</option>
            </select>
        <?php endif ?>
        
        <br/><br/>

        <button class='btn btn-primary' type="submit" name="submit">Update User</button> 
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