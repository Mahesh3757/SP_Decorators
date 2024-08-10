<?php
include('includes/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<?php @include("includes/head.php"); ?>
<body>
  <div class="container-scroller">
    <?php @include("includes/header.php"); ?>
    <div class="container-fluid page-body-wrapper">
      <?php @include("includes/sidebar.php"); ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="modal-header">
                  <h5 class="modal-title" style="float: left;">Approved Bookings</h5>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th>Booking ID</th>
                        <th class="d-none d-sm-table-cell">Customer Name</th>
                        <th class="d-none d-sm-table-cell">Mobile Number</th>
                        <th class="d-none d-sm-table-cell">Email</th>
                        <th class="d-none d-sm-table-cell">Booking Date</th>
                        <th class="d-none d-sm-table-cell">Status</th>
                        <th class="text-center" style="width: 15%;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      try {
                        include('includes/dbconnection.php'); // Ensure DB connection
                        $sql = "SELECT * from tblbooking where Status='Approved'";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;

                        if ($query->rowCount() > 0) {
                          foreach ($results as $row) {
                            ?>
                            <tr>
                              <td class="text-center"><?php echo htmlentities($cnt); ?></td>
                              <td class="font-w600"><?php echo htmlentities($row->BookingID); ?></td>
                              <td class="font-w600"><?php echo htmlentities($row->Name); ?></td>
                              <td class="font-w600">0<?php echo htmlentities($row->MobileNumber); ?></td>
                              <td class="font-w600"><?php echo htmlentities($row->Email); ?></td>
                              <td class="font-w600">
                                <span class="badge badge-info"><?php echo htmlentities($row->BookingDate); ?></span>
                              </td>
                              <td class="d-none d-sm-table-cell">
                                <span class="badge badge-info"><?php echo htmlentities($row->Status); ?></span>
                              </td>
                              <td class="text-center">
                                <a href="#" class="edit_data4" id="<?php echo ($row->ID); ?>" title="click to view"><i class="mdi mdi-eye" aria-hidden="true"></i></a>
                                <a href="invoice_generating.php?invid=<?php echo htmlentities($row->ID); ?>"><i class="mdi mdi-printer" aria-hidden="true"></i></a>
                              </td>
                            </tr>
                            <?php
                            $cnt = $cnt + 1;
                          }
                        } else {
                          echo "<tr><td colspan='8' class='text-center'>No approved bookings found</td></tr>";
                        }
                      } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php @include("includes/footer.php"); ?>
      </div>
    </div>
  </div>
  <?php @include("includes/foot.php"); ?>
  <script type="text/javascript">
    $(document).ready(function () {
      $(document).on('click', '.edit_data4', function () {
        var edit_id4 = $(this).attr('id');
        $.ajax({
          url: "view_newbookings.php",
          type: "post",
          data: { edit_id4: edit_id4 },
          success: function (data) {
            $("#info_update4").html(data);
            $("#editData4").modal('show');
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + error);
          }
        });
      });
    });
  </script>
</body>
</html>
