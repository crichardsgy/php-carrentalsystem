<?php
    include_once 'header.php';
    require_once "models/User.php";

    $userModel = new User;
    $userlist = $userModel->findAllUsers();
?>

<?php if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin"): ?>

    <section>
        <h3>User List</h3>
        <br/>
        <a href="createuser.php"><button class="btn-primary">Create User</button></a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Type</th>
            </tr>
            </thead>
            <?php if(!empty($userlist)):?>
            <tbody>
                <?php
                    foreach($userlist as $user) 
                    {
                        echo "<tr>";
                            $userfullnameanduid = $user->userfname . " " . $user->userlname . " (" . $user->useruid . ")";
                            echo "<td>$userfullnameanduid</td>";
                            echo "<td>$user->useraddress</td>";
                            echo "<td>$user->useremail</td>";
                            echo "<td>$user->userphonenumber</td>";
                            echo "<td>$user->usertype</td>";

                            echo "<td>
                            <a href='updateuser.php?userid=$user->userid&userfname=$user->userfname&userlname=$user->userlname&useruid=$user->useruid&useraddress=$user->useraddress&userphonenumber=$user->userphonenumber&useremail=$user->useremail&usertype=$user->usertype'><button class='btn btn-warning'>Edit</button></a>
                            </td>";
                            echo "<td>
                            <form action='controllers/Users.ctrl.php' method='post'>
                            <input type='hidden' name='formtype' value='deleteuser'>
                            <button class='btn btn-danger' type='submit' name='userid' value='$user->userid'>Delete</button>
                            </form>
                            </td>";
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