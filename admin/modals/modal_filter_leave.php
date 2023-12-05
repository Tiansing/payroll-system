<?php
date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d");
if (isset($_POST['apply1'])) {
  $filterStat = $_POST['leave_status'];
  echo "<script>window.location.href='attendance.php?filter=$date&lfilter=$filterStat'</script>";
}

?>


<div id="modal-filter-leave" class="modal" data-backdrop="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Leave Status Filter</h5>
      </div>
      <form action="" method="post">
        <div class="modal-body p-lg">
          <div class="col-md-12">
            <div style="padding-left: 0px;" class="">
              <div class="form-group justify_content_center">
                <label class="form-label">Filter</label>
                <select required="" name="leave_status" class="form-control custom-select">

                  <option value="" disabled selected>Select Status</option>
                  <option value="Pending">Pending</option>
                  <option value="Approved">Approved</option>
                  <option value="Declined">Declined</option>
                </select>
              </div>

            </div>


          </div>

        </div>
        <div class="modal-footer">
          <div style="padding-right: 12px;">
            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Close</button>
            <button type="submit" name="apply1" class="btn success p-x-md">Apply</button>
          </div>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div>
</div>