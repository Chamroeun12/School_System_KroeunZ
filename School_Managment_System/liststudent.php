<?php
  include_once 'connection.php';

  if (isset($_POST['btnsearch'])) {
    $sql = "SELECT * FROM student ";
    if ($_POST['searchby'] != 'allfield' ){
      $sql.= "WHERE ".$_POST['searchby']." like '%".$_POST['searchtext']."%' ";
      $stmt=$conn->prepare($sql);
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }else{
      $sql.= "WHERE stuname like '%".$_POST['searchtext']."%' ";
      $sql.= "OR address like '%".$_POST['searchtext']."%' ";
      $sql.= "OR phone like '%".$_POST['searchtext']."%' ";
      $stmt=$conn->prepare($sql);
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }else{
  $sql = "SELECT * FROM student LIMIT 10";
  if (isset($_GET['page'])) {
    if($_GET['page']>1){
      $sql .= " OFFSET " .($_GET['page']-1)*10;
    }
  }
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$sql  = "SELECT COUNT(*) AS CountRecords FROM student";
$stmt=$conn->prepare($sql);
$stmt->execute();
$temp = $stmt->fetch(PDO::FETCH_ASSOC);

$maxpage = 1;
if ($temp) {
  $maxpage = ceil($temp['CountRecords']/10);
}
?>

<?php include_once 'header.php';?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>List Students</h1>
          </div>
          <div class="col-sm-6">
            <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Simple Tables</li>
            </ol> -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <!-- <pre><?php print_r($temp) ;?></pre> -->
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
              <form name="formsearch" method="post" action="">
                <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputField">Search By</label>
                          <select class="form-control" id="inputField" name="searchby">
                            <option value="allfield" selected>-All Field-</option>
                            <option value="stuname">Student Name</option>
                            <option value="address">Address</option>
                            <option value="phone">Phone</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputSearch">Search Text</label>
                          <div class="input-group">
                            <input type="text" id="inputSearch" class="form-control" name="searchtext">
                            <span class="input-group-append">
                              <button type="submit" name="btnsearch" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                          </div>
                        </div>
                      </div>
                 </div>
                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Student Name</th>
                      <th>Gender</th>
                      <th>Date of Birth</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($data as $key => $value) {?>
                    <tr>
                      <td><?php
                      if(isset($_GET['page']) && $_GET['page']>1)
                        echo ($_GET['page']-1)*10+($key+1);
                        else
                          echo ($key+1);

                      ?></td>
                      <td><?php echo $value['Stuname'];?></td>
                      <td><?php echo $value['Gender'];?></td>
                      <td><?php echo date('d-M-Y', strtotime($value['DOB']) );?></td>
                      <td><?php echo $value['Address'];?></td>
                      <td><?php echo $value['Phone'];?></td>
                      <td><a href="addstudent.php?student_id=<?php echo $value['Stuid']
                      ?>"><i class="fa fa-edit"></i> Edit</a></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a class="page-link" href="liststudent.php?page=
                     <?php
                      if(isset($_GET['page']) && $_GET['page']>1)

                        echo $_GET['page']-1;
                      else
                        echo 1;

                     ?>
                    ">&laquo;</a></li>
                    <?php for ($i=1; $i<=$maxpage ; $i++) { ?>
                      <li class="page-item
                      <?php
                        if(isset($_GET['page'])){
                          if($i==$_GET['page'])
                          echo ' active ';
                        }else{
                          if($i==1)
                          echo ' active ';
                        }
                      ?>"><a class="page-link"
                      href="liststudent.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>
                    <?php }?>
                    <li class="page-item"><a class="page-link" href="liststudent.php?page=
                     <?php
                      if(isset($_GET['page'])){
                        if($_GET['page']==$maxpage){
                          echo $maxpage;
                        }else{
                          echo $maxpage+1;
                        }
                      }else{
                        echo 2;
                      }


                     ?>">&raquo;</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include_once 'footer.php';?>
