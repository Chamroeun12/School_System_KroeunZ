<?php
include_once 'connection.php';

if (isset($_POST['btnsave'])) {
  if (isset($_GET['student_id'])) {
    $sql = "UPDATE student SET Stuname=:Stuname, Gender=:Gender, DOB=:DOB, Address=:Address,
    Phone=:Phone WHERE Stuid=:Stuid";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":Stuname", $_POST['stuname'], PDO::PARAM_STR);
    $stmt->bindParam(":Gender", $_POST['gender'], PDO::PARAM_STR);
    $stmt->bindParam(":DOB", $_POST['dob'], PDO::PARAM_STR);
    $stmt->bindParam(":Address", $_POST['address'], PDO::PARAM_STR);
    $stmt->bindParam(":Phone", $_POST['phone'], PDO::PARAM_STR);
    $stmt->bindParam(":Stuid", $_GET['student_id'], PDO::PARAM_INT);
    $stmt->execute();
  } else {
    $sql = "INSERT INTO student(Stuname, Gender, DOB, Address, Phone )
              VALUES(:Stuname, :Gender, :DOB, :Address, :Phone)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":Stuname", $_POST['stuname'], PDO::PARAM_STR);
    $stmt->bindParam(":Gender", $_POST['gender'], PDO::PARAM_STR);
    $stmt->bindParam(":DOB", $_POST['dob'], PDO::PARAM_STR);
    $stmt->bindParam(":Address", $_POST['address'], PDO::PARAM_STR);
    $stmt->bindParam(":Phone", $_POST['phone'], PDO::PARAM_STR);
    $stmt->execute();
  }

  if ($stmt->rowCount()) {
    header('Location: liststudent.php');
    exit;
  }
}

if (isset($_POST['btndelete'])) {
  $sql = "DELETE FROM student WHERE Stuid=:Stuid";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":Stuid", $_GET['student_id'], PDO::PARAM_INT);
  $stmt->execute();
  if ($stmt->rowCount()) {
    header('Location: liststudent.php');
    exit;
  }
}

if (isset($_GET['student_id'])) {
  $sql = "SELECT * FROM student WHERE stuid=:id ";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":id", $_GET['student_id'], PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$data) {
    die("Can not find student with this ID.");
  }
}
?>


<?php include_once 'header.php'; ?>






<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <!-- <pre><?php print_r($data); ?></pre> -->
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Form</h1>
                </div>
                <div class="col-sm-6">
                    <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Project Add</li>
            </ol> -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Student Information</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <form name="studentform" method="post" action="">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Student Name</label>
                                <input type="text" id="inputName" name="stuname" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Stuname']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Gender</label>
                                <select id="inputStatus" name="gender" class="form-control custom-select">
                                    <option selected disabled>Select one</option>
                                    <option value="Male"
                                        <?php echo !isset($data) ? '' : ($data['Gender'] == 'Male' ? 'selected' : ''); ?>>
                                        Male</option>
                                    <option value="Female"
                                        <?php echo !isset($data) ? '' : ($data['Gender'] == 'Female' ? 'selected' : ''); ?>>
                                        Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputDateOfBirth">Date Of Birth</label>
                                <input type="date" id="inputDateOfBirth" name="dob" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['DOB']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Address</label>
                                <textarea id="inputDescription" name="address" class="form-control"
                                    rows="4"><?php echo !isset($data) ? '' : $data['Address']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputPhone">Phone</label>
                                <input type="text" id="inputPhone" name="phone" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Phone']; ?>">
                            </div>
                            <input type="submit" value="Save" name="btnsave" class="btn btn-success float-right">
                            <?php if (isset($_GET['student_id'])) { ?>
                            <input type="submit" value="Delete" name="btndelete" class="btn btn-danger">
                            <?php } ?>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once 'footer.php'; ?>