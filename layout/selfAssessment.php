<div class="main-panel">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-minimize">
          <button id="minimizeSidebar" class="btn btn-icon btn-round">
            <i class="nc-icon nc-minimal-right text-center visible-on-sidebar-mini"></i>
            <i class="nc-icon nc-minimal-left text-center visible-on-sidebar-regular"></i>
          </button>
        </div>
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <div class="page-title">Self Assessment</div>
      </div>
    </div>
  </nav>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><i class="material-icons-outlined card-icon">class</i>Self Assessment</h4>
            <div class="card-category">
              <p class="mg-b-0"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></p>
              <!-- <p class="mg-b-0"><span class="gradebook-currentterm"></span><span class="currentTerm-status"></span></p> -->
              <p><span class="gradebook-classinfo"></span></p>
            </div>
          </div>
          <div class="card-body">
              <table id="datatables-selfAssessments" class="table dataTable table-striped table-hover display ellipsis-table"
                cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>CreateDATE</th>
                    <th>Term</th>
                    <th>STUDENT ID</th>
                    <th>STUDENT NAME</th>
                    <th>Grade</th>
                    <th>ModifyDate</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
  </div>

  <script src="js/modalControl.js?ver=1.0"></script>
  <?php
    include_once('layout/selfAssessmentsModal.php');
  ?>
  <script type="text/javascript">
    $(document).ready(function () {
      pagerNumResize();
      getSelfAssessments();

    });
  </script>
