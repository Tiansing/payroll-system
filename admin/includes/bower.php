<!-- daterangepicker -->
<script src="../bower_components/moment/min/moment.min.js"></script>
<script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">


<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>

<link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">

<script>
  $(function() {
    // $('#example1').DataTable({
    //   responsive: true
    // })
    $('#example2').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': false,
      'ordering': true,
      'info': true,
      'autoWidth': false,
      "iDisplayLength": 5
    })
    $('#example1').DataTable({
      responsive: true,
      "order": [
        [0, "desc"]
      ],
      "aLengthMenu": [
        [5, 25, 50, 75, 100],
        [5, 25, 50, 75, 100]
      ],
      "iDisplayLength": 5
    })
    $('#attndTable').DataTable({
      responsive: true,
      "order": [
        [5, "desc"]
      ]
    })
    $('#otTable').DataTable({
      responsive: true,
      "order": [
        [6, "desc"]
      ]
    })
  })
</script>
<script>
  $(function() {
    /** add active class and stay opened when selected */
    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
      return this.href == url;
    }).parent().addClass('active');

    // for treeview
    $('ul.treeview-menu a').filter(function() {
      return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

  });
</script>

<script>
  $(function() {
    //Date picker
    $('#datepicker_add').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    })
    $('#datepicker_edit').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false, // Hide manual input fields
      minuteStep: 1,

      upArrowStyle: 'bi bi-caret-up-fill',
      downArrowStyle: 'bi bi-caret-down-fill',
      format: 'LT',

    })

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      format: 'MM/DD/YYYY h:mm A'
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function(start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

  });
</script>