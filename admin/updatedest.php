<?php
session_start();
include('./include/config.php');
if(strlen($_SESSION['alogin'])==0){ 
  header('location:home.php');
}
else {
    
    if (isset($_POST['update'])) {
        // Ensure d_id exists
        if (!isset($_GET['d_id']) || empty($_GET['d_id'])) {
            die("Error: Destination ID is missing.");
        }
    
        $d_id = mysqli_real_escape_string($con, $_GET['d_id']);
    
        // Fetch the current status from the database
        $sql = "SELECT Status FROM destination WHERE Id='$d_id'";
        $result = mysqli_query($con, $sql);
    
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $currentStatus = $row['Status']; // Existing status from DB
    
            // If the user selects a new status, use it; otherwise, keep the existing status
            $newStatus = isset($_POST['newstatus']) ? $_POST['newstatus'] : $currentStatus;
    
            // Update status in the database only if it's changing
            if ($newStatus !== $currentStatus) {
                $updateQuery = "UPDATE destination SET Status='$newStatus' WHERE Id='$d_id'";
                if (mysqli_query($con, $updateQuery)) {
                    echo "<script>
                            alert('Status Updated Successfully');
                            window.location.href = '" . $_SERVER['PHP_SELF'] . "?d_id=$d_id';
                          </script>";
                    exit();
                } else {
                    die("Update Error: " . mysqli_error($con));
                }
            } else {
                echo "<script>alert('No changes made. Status remains $currentStatus.');</script>";
            }
        } else {
            die("Error fetching status: " . mysqli_error($con));
        }
    }
    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <script language="javascript" type="text/javascript">
    function f2()
    {
    window.close();
    }
    function f3()
    {
    window.print(); 
    }
  </script>
</head>
<body class="hold-transition">
    <div style="margin-left:50px;">
         <form name="updateticket" id="updatecomplaint" method="post"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php 
                    $d_id = mysqli_real_escape_string($con, $_GET['d_id']);
                    $sql=mysqli_query($con, "SELECT * FROM destination WHERE Id=$d_id"); 
                    while($row=mysqli_fetch_array($sql)){
                  ?>
                <tr>
                  <td  >&nbsp;</td>
                  <td >&nbsp;</td>
                </tr>
                <tr height="50">
                  <td><b>Destination Id: </b></td>
                  
                  <td><?php echo $row['Id']; ?></td>
                    
                </tr>
                <tr height="50">
                  <td><b>Current Status: </b></td>
                  <td><?php echo $row['Status']; ?></td>
                </tr>
                <tr height="50">
                  <td><b>Change Status:</b></td>
                  <td><select name="newstatus" required="required">
                    <option value="" disabled selected>Select Status</option>
                    <option value="Active">Live</option>
                    <option value="NotActive">Pause</option>
                    </select>
                  </td>
                </tr>
                <?php }?>
                <tr height="50">
                    <td>&nbsp;</td>
                    <td><input type="submit" name="update" value="update"></td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr>
                  <td></td>
                  <td >   
                    <input name="Submit2" type="submit" class="txtbox4" value="Close this window " onClick="return f2();" style="cursor: pointer;"  />
                  </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
<?php } ?>