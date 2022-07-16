<?php
    include_once 'header.php';
    require_once "models/Branch.php";

    $branchModel = new Branch;
    $branchlist = $branchModel->findAllBranches();
?>

<?php if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin"): ?>

    <section>
        <h3>Branch List</h3>
        <br/>
        <a href="createbranch.php"><button class="btn-primary">Create Branch</button></a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Address</th>
            </tr>
            </thead>
            <?php if(!empty($branchlist)):?>
            <tbody>
                <?php
                    foreach($branchlist as $branch) 
                    {
                        echo "<tr>";
                            echo "<td>$branch->branchaddress</td>";
                            echo "<td>
                            <a href='updatebranch.php?branchid=$branch->branchid&branchaddress=$branch->branchaddress'><button class='btn btn-warning'>Edit</button></a>
                            </td>";
                            echo "<td>
                            <form action='controllers/Branches.ctrl.php' method='post'>
                            <input type='hidden' name='formtype' value='deletebranch'>
                            <button class='btn btn-danger' type='submit' name='branchid' value='$branch->branchid'>Delete</button>
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