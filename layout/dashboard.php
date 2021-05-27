
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
    <div class="page-title">My Child</div>
  </div>
</div>
</nav>
<div class="content">
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <div class="card-text">
          <div class="row">
            <div class="col-md-9">
              <h4 class="card-title"><i class="material-icons-outlined card-icon">date_range</i><span
                  class="dashboard-semesterName"></span></h4>
              <p class="card-category"><span class="dashboard-termstatus"></span></p>
            </div>
            <div class="col-md-3 justify-align-center">
              <!-- <button class="btn btn-warning terms-card-btn btn-sm">Add</button> -->

            </div>
          </div>

        </div>
      </div>
      <div class="card-body">
        <div class="flex">
          <div class="width-75per mg-r-5per">
            <div class="flex justify-content-between">
              <!-- <div class="col-md-4 col-sm-4"> -->
              <div><label class="dashboard-startDate"></label></div>
              <!-- </div> -->
              <!-- <div class="col-md-4 col-sm-4 text-center"> -->
              <!-- <div><label class="dashboard-midCutoff"></label></div> -->
              <!-- </div> -->
              <!-- <div class="col-md-4 col-sm-4 text-right"> -->
              <div><label class="dashboard-endDate"></label></div>
              <!-- </div> -->
            </div>
            <div class="progress progress-striped active progress-custom">
              <div class="progress-bar">
                <span class="sr-only"></span>
              </div>
            </div>
          </div>
          <div class="width-20per justify-align-center pd-lr-10">
            <div class="termPer-text font-weight-bold color-30297E"><span class="dashboard-termPer"></span>%</div>
          </div>
        </div>

        <!-- <div style="display:inline-block;width:100%;overflow-y:auto;">
          <ul class="custom-tl custom-tl-horizontal">
          </ul>
        </div> -->

      </div>
    </div>
    <div class="card">
      <div class="card-header ">
        <div class="card-text">
          <h4 class="card-title"><i class="material-icons-outlined card-icon">assignment_ind</i><span
              class="dashboard-fullName"></span>
          </h4>
        </div>
      </div>
      <div class="card-body">
        <div class="text-center">
          <img class="dashboard-userPic img-md" src="" onerror="this.src='assets/img/student.png'" alt="" draggable="false">
        </div>
        <table class="table table-hover" id="student-inf">
          <tbody>
            <!-- <tr>
              <td>Student ID</td>
              <td class="dashboard-studentId"></td>
            </tr>
            <tr>
              <td>PEN</td>
              <td class="dashboard-pen"></td>
            </tr> -->
            <tr>
              <td>Current Grade </td>
              <td class="dashboard-grade"></td>
            </tr>
            <tr>
              <td>Counsellor</td>
              <td class="dashboard-Counsellor"></td>
            </tr>
            <tr>
              <td>Living Location</td>
              <td class="dashboard-location"></td>
            </tr>
            <tr class="custom-collapse">
              <td>House</td>
              <td class="dashboard-house"></td>
            </tr>
            <tr class="custom-collapse">
              <td>Hall</td>
              <td class="dashboard-hall"></td>
            </tr>
            <tr class="custom-collapse">
              <td>Room No</td>
              <td class="dashboard-room"></td>
            </tr>
            <tr class="custom-collapse">
              <td>Youth Advisor 1</td>
              <td class="dashboard-advisor1"></td>
            </tr>
            <tr class="custom-collapse">
              <td>Youth Advisor 2</td>
              <td class="dashboard-advisor2"></td>
            </tr>
            <tr class="custom-collapse">
              <td>Mentor Teacher</td>
              <td class="dashboard-mentor"></td>
            </tr>
            <tr class="custom-collapse">
              <td>Number of Terms</td>
              <td class="dashboard-terms"></td>
            </tr>
            <tr class="custom-collapse">
              <td>Number of AEP Terms</td>
              <td class="dashboard-aepTerms"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="card-footer text-center">
        <i class="material-icons-outlined collapseIcon cursor_pointer font42">expand_more</i>
      </div>
    </div>
    <!-- Hot Topic -->
    <div class="card">
      <div class="card-header">
        <div class="card-text">
          <h4 class="card-title"><i class="material-icons-outlined card-icon">info</i>Bodwell This Week
          </h4>
        </div>
      </div>
      <div class="card-body scroll text-center">
        <div id="carousel-hottopic" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">

          </div>
          <a class="carousel-control-prev" href="#carousel-hottopic" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carousel-hottopic" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>

  </div>
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <div class="card-text">
          <h4 class="card-title"><i class="material-icons-outlined card-icon">videocam</i>Weekly Video Message
          </h4>

        </div>
      </div>
      <div class="card-body scroll text-center">
        <video id="dashboard-weeklyMessage-video" controls="controls" autoplay>
          <source src="" type="video/mp4">
          <!-- <track kind="subtitles" src="sampleSubtitles_en.srt" srclang="en">
            <track kind="subtitles" src="sampleSubtitles_en.srt" srclang="kr"> -->
        </video>
      </div>
    </div>
    <div class="card">
      <div class="row">
        <div class="col-md-12 mg-15">
          <?php if($_SESSION['AEP'] == 'Y'){ ?>
          <button class="btn btn-warning tabs-btn custom-tabs-btn btn-sm" onclick="location.href = '?page=aep';"
            >AEP</button>
          <?php } ?>
          <button class="btn btn-warning academics-card-btn tabs-btn custom-tabs-btn btn-sm"
            disabled>Academics</button>
          <button class="btn btn-warning careerLife-card-btn tabs-btn custom-tabs-btn btn-sm">Career Life
            Pathway</button>
          <button class="btn btn-warning pHours-card-btn tabs-btn custom-tabs-btn btn-sm">Participation
            Hours</button>
        </div>
      </div>
      <div id="academics-card">
        <div class="card-header">
          <div class="card-text">
            <h4 class="card-title"><i class="material-icons-outlined card-icon">class</i>Academics</h4>
            <p class="card-category"><span class="dashboard-CurrentTerm"></span> - <span
                class="dashboard-termstatus"></span></p>
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input checkbox-credit" type="checkbox" value="" checked>
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
              <tbody class="text-center">

              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div id="pHours-card">
        <div class="card-header">
          <div class="card-text">
            <div class="row">
              <div class="col-md-6">
                <h4 class="card-title"><i
                    class="material-icons-outlined card-icon">accessibility_new</i>Participation
                  Hours</h4>
                <p class="card-category"><span class="dashboard-CurrentTerm"></span> - <span
                    class="dashboard-termstatus"></span></p>
              </div>
            </div>

          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover" id="dashboard-myparticipation" width="100%">
              <thead class="text-warning text-center">
                <tr>
                  <th></th>
                  <th>Category</th>
                  <th>Current Term</br>(<span class="dashboard-CurrentTerm"></span>)</th>
                  <th>Accumulated</br>(Since <span class="dashboard-EnrollmetTermName"></span>)</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr>
                  <td><i class="material-icons-outlined">directions_bike</i></td>
                  <td class="text-left">Physical, Outdoor & Recreation Education</td>
                  <td class="dashboard-PORE-C"></td>
                  <td class="dashboard-PORE-A"></td>
                </tr>
                <tr>
                  <td><i class="material-icons-outlined">school</i></td>
                  <td class="text-left">Academic, Interest & Skill Development</td>
                  <td class="dashboard-AISD-C"></td>
                  <td class="dashboard-AISD-A"></td>
                </tr>
                <tr>
                  <td><i class="material-icons-outlined">language</i></td>
                  <td class="text-left">Citizenship, Interaction & Leadership Experience</td>
                  <td class="dashboard-CILE-C"></td>
                  <td class="dashboard-CILE-A"></td>
                </tr>
                <tr>
                  <td><i class="material-icons-outlined">palette</i></td>
                  <td class="text-left">Arts, Culture & Local Exploration</td>
                  <td class="dashboard-ACLE-C"></td>
                  <td class="dashboard-ACLE-A"></td>
                </tr>
                <tr class="font-weight-bold">
                  <td></td>
                  <td class="text-left">Total Participation Hours</td>
                  <td class="dashboard-TOTAL-C"></td>
                  <td class="dashboard-TOTAL-A"></td>
                </tr>
                <tr class="font-weight-bold">
                  <td></td>
                  <td class="text-left">Total Volunteer & Work Experience</td>
                  <td class="dashboard-VLWE-C"></td>
                  <td class="dashboard-VLWE-A"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div id="display-career-card">
        <div class="card-header">
          <div class="card-text">
            <div class="row">
              <div class="col-md-6">
                <h4 class="card-title"><i class="material-icons-outlined card-icon">flag</i>Career Life Pathway</h4>
                <p class="card-category"><span class="dashboard-CurrentTerm"></span> - <span
                    class="dashboard-termstatus"></span></p>
                <input type="hidden" id="hidden-courseId">
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover" id="dashboard-Career" width="100%">
              <thead class="text-warning text-center">
                <tr>
                  <th>COURSE</th>
                  <th>TEACHER</th>
                  <th>CAPSTONE TOPIC</th>
                  <th>CAREER GUIDE</th>
                  <th>DATE</th>
                  <th>STATUS</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr>
                  <td>CLE<br />
                    <span class="span-CLE-coursename" style="font-size: 10px">Career Life Education</span>
                  </td>
                  <td class="dashboard-CLE-teacher italic color-9A9A9A">Not Submitted</td>
                  <td class="dashboard-CLE-topic italic color-9A9A9A">Not Submitted</td>
                  <td class="dashboard-CLE-guide italic color-9A9A9A">Not Submitted</td>
                  <td class="dashboard-CLE-date italic color-9A9A9A">Not Submitted</td>
                  <td class="dashboard-CLE-status italic color-9A9A9A">Not Submitted</td>
                </tr>
                <tr>
                  <td>CLC/Capstone<br /><span class="span-CLC-coursename" style="font-size: 10px">Career Life
                      Connections</span></td>
                  <td class="dashboard-CLC-teacher italic color-9A9A9A">Not Submitted</td>
                  <td class="dashboard-CLC-topic italic color-9A9A9A">Not Submitted</td>
                  <td class="dashboard-CLC-guide italic color-9A9A9A">Not Submitted</td>
                  <td class="dashboard-CLC-date italic color-9A9A9A">Not Submitted</td>
                  <td class="dashboard-CLC-status italic color-9A9A9A">Not Submitted</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="row">
        <div class="col-md-12 mg-15">
          <button class="btn btn-warning teacher-card-btn staffTabs-btn custom-tabs-btn btn-sm"
            disabled>Teachers</button>
          <button class="btn btn-warning counselor-card-btn staffTabs-btn custom-tabs-btn btn-sm">Counselor &
            Advisors</button>
          <button
            class="btn btn-warning principal-card-btn staffTabs-btn custom-tabs-btn btn-sm">Principals</button>
        </div>
      </div>
      <div class="card-header">
        <div class="card-text">
          <h4 class="card-title"><i class="material-icons-outlined card-icon">person</i>Involved Staff</h4>
        </div>
      </div>
      <div class="card-body scroll text-center">
        <div id="teacher-card">
          <div class="flex justify-content-between row">
            <div class="col-md-6">
              <h6>Credit Course</h6>
              <hr class="staffCard-title-border width-30per">
              <div class="credit-teacher flex"></div>
            </div>
            <div class="col-md-6">
              <h6>Non-Credit Course</h6>
              <hr class="staffCard-title-border width-33per">
              <div class="nonCredit-teacher flex"></div>
            </div>
          </div>
        </div>
        <div id="counselor-card">
          <div class="flex row justify-content-center">
            <div class="col-md-6">
              <h6>Counselor & Youth Advisors</h6>
              <hr class="staffCard-title-border width-55per">
              <div class="counselorsnadvisors flex col-md-12 row mg-lr-auto"></div>
            </div>
          </div>
        </div>
        <div id="principal-card">
          <div class="flex row justify-content-center">
            <div class="col-md-5">
              <h6>Principals</h6>
              <hr class="staffCard-title-border width-30per">
              <div class="principal flex row mg-lr-auto"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script src="js/modalControl.js?ver=0.3" charset="utf-8"></script>
<?php
include_once('layout/careerLifePathWaySelfSubmitModal.html');
include_once('layout/addTimelineModal.php');
?>


<script type="text/javascript">
$(document).ready(function () {
  isMinimizeSidebar = false;
  ajaxtoCurrentTerm();
  minimizeSidebar();
  getWeeklyMessage();
  getTimeline();
  getHottopic('N635I');
  $('.custom-collapse').css('display', 'none');
  var preCardId = "#academics-card"
  $(".tabs-btn").click(function (event) {
    var target = $(event.target);
    var currentCardId = "";
    var btn = "";
    $(".tabs-btn").prop('disabled', false)
    if (target.hasClass('academics-card-btn')) {
      btn = '.academics-card-btn'
      currentCardId = '#academics-card'
    } else if (target.hasClass('pHours-card-btn')) {
      btn = '.pHours-card-btn'
      currentCardId = '#pHours-card'
    } else if (target.hasClass('careerLife-card-btn')) {
      btn = '.careerLife-card-btn'
      currentCardId = '#display-career-card'
    }
    $(btn).prop('disabled', true)
    $(currentCardId).css("display", "block");
    $(preCardId).css("display", "none");
    preCardId = currentCardId
  });
  var preStaffCardId = "#teacher-card"
  $(".staffTabs-btn").click(function (event) {
    var target = $(event.target);
    var currentStaffCardId = "";
    var btn = "";
    $(".staffTabs-btn").prop('disabled', false)
    if (target.hasClass('teacher-card-btn')) {
      btn = '.teacher-card-btn'
      currentStaffCardId = '#teacher-card'
    } else if (target.hasClass('counselor-card-btn')) {
      btn = '.counselor-card-btn'
      currentStaffCardId = '#counselor-card'
    } else if (target.hasClass('principal-card-btn')) {
      btn = '.principal-card-btn'
      currentStaffCardId = '#principal-card'
    }
    $(btn).prop('disabled', true)
    $(currentStaffCardId).css("display", "block");
    $(preStaffCardId).css("display", "none");
    preStaffCardId = currentStaffCardId
  })
  $('.collapseIcon').click(function (event) {
    $('.custom-collapse').toggle();
    if ($('.custom-collapse').css('display') == 'none') {
      $('.collapseIcon').html('expand_more');
    } else {
      $('.collapseIcon').html('expand_less');
    }
  })
});
</script>
