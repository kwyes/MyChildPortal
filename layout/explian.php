<div class="main-panel">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <div class="page-title">Bodwell Explained</div>
      </div>
    </div>
  </nav>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><i class="material-icons-outlined card-icon">videocam</i>A video library to answer
              common questions & concerns</h4>
            <div class="card-category">
              <p class="mg-b-0"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></p>
              <p><span class="gradebook-classinfo"></span></p>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 text-center">
                <h6>ACADEMICS</h6>
                <hr class="mg-b-40 mg-t-0" style="border-bottom:2px #252422 solid; width:20%">
                <div class="academicList text-left"></div>
              </div>
              <div class="col-md-6 text-center">
                <h6>STUDENT LIFE</h6>
                <hr class="mg-b-40 mg-t-0" style="border-bottom:2px #252422 solid; width:20%">
                <div class="stuLifeList text-left"></div>
              </div>
            </div>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <div end row -->
    </div>
    <footer class="footer footer-black  footer-white ">
      <div class="container-fluid">
        <div class="row">
          <div class="credits ml-auto">
            <span class="copyright">
              ©
              <script>
                document.write(new Date().getFullYear())
              </script>, Bodwell High School. All rights reserved. v1.0.6
            </span>
          </div>
        </div>
      </div>
    </footer>
  </div>
</div>
<?php include_once('layout/videoModal.html'); ?>
<script>
  $(document).ready(function () {
    var academic = [];
    var stuLife = [];

    for (let i = 0; i < explainedtext_academic.length; i++) {
      academic.push(
        '<ul style="list-style-type: none;"><li><a class="videoLink" href="#" data-toggle="modal" data-src="' +
        explainedtext_academic[
          i].value + '" data-caption='+JSON.stringify(explainedtext_academic[i].caption)+' data-target="#videoModal" >' + explainedtext_academic[i].text + '</a></li></ul>')
    }
    $('.academicList').html(academic);

    for (let i = 0; i < explainedtext_studentLife.length; i++) {
      stuLife.push(
        '<ul style="list-style-type: none;"><li><a class="videoLink" href="#" data-toggle="modal" data-src="' +
        explainedtext_studentLife[i].value + '" data-caption='+JSON.stringify(explainedtext_studentLife[i].caption)+' data-target="#videoModal">' + explainedtext_studentLife[i].text +
        '</a></li></ul>')
    }
    $('.stuLifeList').html(stuLife);
  });
</script>
<script src="js/video.js" charset="utf-8"></script>
