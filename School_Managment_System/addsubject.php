<?php
include_once 'connection.php';
if(isset($_POST['btnsave'])){
  $sql = "INSERT INTO subjects(SubjectID, SubjectName)
  VALUES('".$_POST['subjectcode']."', '".$_POST['subjectname']."')";
  $stmt= $conn->prepare($sql);
  $stmt->execute();
  if($stmt->rowCount()){
    header('Location: listsubject.php');
    exit;
  }

}

?>

  <?php include_once 'header.php';?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <!-- <pre><?php print_r($stmt);?></pre> -->
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Subject Form</h1>
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
              <h3 class="card-title">Subject Information</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <form name="subjectform" method="post" action="">
             <div class="card-body">
              <div class="form-group">
                <label for="inputCode">Subject Code</label>
                <input type="text" id="inputCode" name="subjectcode" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputName">Subject Name</label>
                <input type="text" id="inputName" name="subjectname" class="form-control">
              </div>
              <input type="submit" value="Save" name="btnsave" class="btn btn-success float-right">
              <input type="submit" value="Delete" name="btndelete" class="btn btn-danger">
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


  <?php include_once 'footer.php';?>
