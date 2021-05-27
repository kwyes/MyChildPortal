<?php
// echo $_SESSION['numTerms'];
// if($_SESSION['numTerms'] < 2){
//   $previous = "javascript:history.go(-1)";
//   if(isset($_SERVER['HTTP_REFERER'])) {
//       $previous = $_SERVER['HTTP_REFERER'];
//   }
// }
 ?>
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
        <div class="page-title">Past Terms</div>
      </div>
    </div>
  </nav>
  <div class="content">
    <div class="card width-33per">
      <div class="card-header">
        <div class="card-text">
          <div class="row">
            <div class="col-md-9">
              <h4 class="card-title">
                <i class="material-icons-outlined card-icon">timeline</i>
                Past Terms</h4>
              <!-- <p class="card-category">
                Current Term :
                <span class="pastterm-semesterName"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></span></p> -->
            </div>
          </div>

        </div>
      </div>
      <div class="card-body ">
        <select id="pastterm-select" class="custom-select">

        </select>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <div class="card-text">
          <h4 class="card-title">
            <i class="material-icons-outlined card-icon">class</i>Academics</h4>
          <p class="card-category"></p>
          <div class="form-check">
            <label class="form-check-label">
              <input class="form-check-input checkbox-credit" type="checkbox" value="" checked="checked">
              Show all (including credits and non-credits)
              <span class="form-check-sign">
                <span class="check"></span>
              </span>
            </label>
          </div>
        </div>
      </div>
      <div class="card-body scroll">
        <div class="table-responsive">
          <table id="dashboard-mycourses" class="table table-hover" width="100%">
            <thead class="text-warning text-center">
              <tr>
                <th>Course</th>
                <th>Percent Grade</th>
                <th>Letter Grade</th>
                <th>Credit</th>
                <th>Teacher</th>
                <th>Room</th>
                <th>Late</th>
                <th>Absence</th>
              </tr>
            </thead>
            <tbody class="text-center"></tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <div class="card-text">
          <div class="row">
            <div class="col-md-6">
              <h4 class="card-title">
                <i class="material-icons-outlined card-icon">accessibility_new</i>Participation Hours
              </h4>
              <p class="card-category"></p>
            </div>
          </div>

        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover" id="pastterm-myparticipation" width="100%">
            <thead class="text-warning text-center">
              <tr>
                <th></th>
                <th>Category</th>
                <th>Selected Term</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr>
            <td>
              <i class="material-icons-outlined">directions_bike</i>
            </td>
            <td class="text-left">Physical, Outdoor & Recreation Education</td>
            <td class="pastterm-PORE-C"></td>
          </tr>
          <tr>
            <td>
              <i class="material-icons-outlined">school</i>
            </td>
            <td class="text-left">Academic, Interest & Skill Development</td>
            <td class="pastterm-AISD-C"></td>
          </tr>
          <tr>
            <td>
              <i class="material-icons-outlined">language</i>
            </td>
            <td class="text-left">Citizenship, Interaction & Leadership Experience</td>
            <td class="pastterm-CILE-C"></td>
          </tr>
          <tr>
            <td>
              <i class="material-icons-outlined">palette</i>
            </td>
            <td class="text-left">Arts, Culture & Local Exploration</td>
            <td class="pastterm-ACLE-C"></td>
          </tr>
          <tr class="font-weight-bold">
            <td></td>
            <td class="text-left">Total Participation Hours</td>
            <td class="pastterm-TOTAL-C"></td>
          </tr>
          <tr class="font-weight-bold">
            <td></td>
            <td class="text-left">Total Volunteer & Work Experience</td>
            <td class="pastterm-VLWE-C"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
  getPastTermList();
  let selectedTerm = $('#pastterm-select :selected').val();
  ajaxtoMyCourses(selectedTerm);
  ajaxtoMyGrades(selectedTerm);
  ajaxtoPastTermParticipation(selectedTerm)
  $('#pastterm-select').change(function(event) {
    var selectedIndex = $(event.target)[0].selectedIndex;
    var selectedText = $(event.target)[0][selectedIndex].text;

    $('#dashboard-mycourses tbody').html('');
    $('.card-category').html(selectedText)
    ajaxtoMyCourses(this.value);
    ajaxtoMyGrades(this.value);
    ajaxtoPastTermParticipation(this.value);
  });
});
</script>
