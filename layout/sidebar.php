<?php
  $page = $_GET['page'];
 ?>
<div class="sidebar" data-color="blue" data-active-color="white">
  <div class="logo text-center">
    <img src="img/schoollogo.png"
      alt="logo_small" class="sidebar-logo pd-tb-10" />
  </div>
  <div class="sidebar-wrapper">
    <div class="user">
      <div class="photo">
        <img src="assets/img/logo_xs.png" alt="logo_xs" />
      </div>
      <div class="info">
        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
          <span class='bst-title-mini'>
            Parent Portal
          </span>
        </a>
        <div class="clearfix"></div>

      </div>
    </div>
    <ul class="nav">
      <li class="<?php echo ($page=='dashboard' || $page == '')?"active":"";?>">
        <a href="?page=dashboard">
          <i class="material-icons-outlined">dashboard</i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="<?php echo ($page=='academic')?"active":"";?>">
        <a href="?page=academic">
          <i class="material-icons-outlined">class</i>
          <p>
            Academics Record
          </p>
        </a>
      </li>
      <?php if($_SESSION['AEP'] == 'Y'){ ?>
      <li class="<?php echo ($page=='aep')?"active":"";?>">
        <a href="?page=aep">
          <i class="material-icons-outlined">book</i>
          <p>
            AEP
          </p>
        </a>
      </li>
      <?php } ?>
      <!-- <li class="<?php echo ($page=='assessments')?"active":"";?>">
      <a href="?page=assessments">
        <i class="material-icons-outlined">assessment</i>
        <p>
          Assessments
        </p>
      </a>
    </li> -->
      <li class="<?php echo ($page=='studentlife')?"active":"";?>">
        <a href="?page=studentlife">
          <i class="material-icons-outlined">accessibility_new</i>
          <p>
            Student Life Record
          </p>
        </a>
      </li>
      <li class="<?php echo ($page=='explian')?"active":"";?>">
        <a href="?page=explian">
          <i class="material-icons-outlined">videocam</i>
          <p>
            Bodwell Explained
          </p>
        </a>
      </li>
      <!-- <li class="<?php echo ($page=='media')?"active":"";?>">
        <a href="?page=media">
          <i class="material-icons-outlined">photo_library</i>
          <p>
            Media
          </p>
        </a>
      </!-->
      <li class="<?php echo ($page=='calendar')?"active":"";?>">
        <a href="https://bodwell.edu/calendar/" target="_blank">
          <i class="material-icons-outlined">alarm</i>
          <p>
            School Calendar
          </p>
        </a>
      </li>
      <li class="<?php echo ($page=='documents')?"active":"";?>">
        <a href="?page=documents">
          <i class="material-icons-outlined">description</i>
          <p>
            Documents
          </p>
        </a>
      </li>
      <li class="">
        <a href="https://bodwell.edu/cafeteria-menu/" target="_blank">
          <i class="material-icons-outlined">restaurant</i>
          <p>
            Weekly Cafeteria Menu
          </p>
        </a>
      </li>
      <li class="past-term-menu <?php if($_SESSION['numTerms']){if($_SESSION['numTerms'] < 2) echo 'no-show'; } ?> <?php echo ($page=='past')?"active":"";?>">
        <a href="?page=past">
          <i class="material-icons-outlined">timeline</i>
          <p>
            Past Terms
          </p>
        </a>
      </li>

      <!-- <li class="<?php echo ($page=='selfAssessment')?" active":"";?>">
          <a href="?page=selfAssessment">
              <i class="material-icons-outlined">flag</i>
              <p> Self Assessments </p>
          </a>
      </li> -->

      <li class="past-term-menu"  "<?php echo ($page=='reportcard')?"active":"";?>">
        <a href="?page=reportcard">
          <i class="material-icons-outlined">credit_card</i>
          <p>
            Report Card
          </p>
        </a>
      </li>

      <li>
        <a href="?page=logout">
          <i class="material-icons-outlined">power_settings_new</i>
          <p>
            Logout
          </p>
        </a>
      </li>
    </ul>
  </div>
</div>
<script>
  $(document).ready(function () {
    if ($('body').hasClass('sidebar-mini')) {
      console.log("mini")
    }

  });
</script>
