<?php

if (!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])) {
  header("location:index.php?utm_campaign=expired");
}

$numbers = '';
for ($i = 0; $i < 10; $i++) {
  $numbers .= $i;
}

$empl_id = substr(str_shuffle($numbers), 0, 9);

if (isset($_POST['add_new'])) {
}

?>
<script type="text/javascript">
  function limitKeypress(event, value, maxLength) {
    if (value != undefined && value.toString().length >= maxLength) {
      event.preventDefault();
    }
  }
</script>

<div id="modal-delete-employee" class="modal fade animate" data-backdrop="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Delete Record</h5>
      </div>
      <div class="modal-body p-lg">
        <div class="col-md-12">
          <form class="" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="modal-body " style="max-height: 350px; overflow-y: auto;">

                <input type="hidden" name="img_id" id="delete_id">

                <h4> Do you want to Delete this Data ?</h4>
              </div>

            </div>
        </div>
        <div class="modal-footer">
          <div style="padding-right: 12px;">
            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
            <button type="submit" name="add_new" class="btn danger p-x-md">Yes</button>
          </div>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div>
  </div>
</div>