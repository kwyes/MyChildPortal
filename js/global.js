var capstoneCategory = [
  "Agriculture, Food and Natural Resources",
  "Architecture and Construction",
  "Arts, Audio/Video Technology and Communications",
  "Business, Management and Administration",
  "Education and Training",
  "Finance",
  "Government and Public Administration",
  "Health Science",
  "Hospitality and Tourism",
  "Human Services",
  "Information Technology",
  "Law, Public Safety, Corrections and Security",
  "Manufacturing",
  "Marketing, Sales and Service",
  "Science, Technology, Engineering and Mathematics",
  "Transportation, Distribution and Logistics",
  "Other (Specify below)"
];

var explainedtext_academic = [
  {
    value: "https://bodwell.canto.com/download/video/1o3dqicu110159vl4pjpuluf6s/original",
    text: "How is my child graded and evaluated?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/jna0cp2gah5g31n2en3lm2sg3s/original",
    text: "Why is my child in AEP?",
    caption: {
      0: {
        lang: "English",
        path: "vtt/Why_is_my_child_in_AEP_en.vtt"
      },
      1: {
        lang: "Japanese",
        path: "vtt/Why_is_my_child_in_AEP_jp.vtt"
      },
      2: {
        lang: "S-Chinese",
        path: "vtt/Why_is_my_child_in_AEP_sc.vtt"
      },
      3: {
        lang: "T-Chinese",
        path: "vtt/Why_is_my_child_in_AEP_tc.vtt"
      }
    }
  }, {
    value: "https://bodwell.canto.com/download/video/lqsnk0ml7d11r473iud2la5r3q/original",
    text: "How long will my child be in AEP?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/v04asekto13knei69c9c9oka6d/original",
    text: "What must students do to improve English skills?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/ik7jj6d83t5crcn49eeka2n80d/original",
    text: "What is an AEP rubric?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/m02q4qg6f95tl8d35gqt0f546m/original",
    text: "How do AEP teachers help improve students’ English skills?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/ib1tbudgjt32tcg5qgu0mp5f21/original",
    text: "Canadian Universities Event",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/j3u9ee70q56qvdklevgsd1h173/original",
    text: "What is the process for applying to university?",
    caption: ""
  }
];

var explainedtext_studentLife = [
  {
    value: "https://bodwell.canto.com/download/video/b5u2464p5l3952p8a0481plp1g/original",
    text: "What is E-block?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/vpnj0vjktp38jf5nndruao594c/original",
    text: "What are the benefits of school clubs?",
    caption: ""
  }, {
    value: "",
    text: "Why do students have study hall?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/vrmkpfo61t6qp08vkpgm063m4m/original",
    text: "Is it possible to change rooms in boarding?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/cvn03cnolh6m5d7d2a9ju3oa5v/original",
    text: "Student Art Show",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/keq83cq3qh3ev5dktor8k0hq40/original",
    text: "Clubs - Senior Music Band",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/bo5ti3t6t14s90vi0oqfk9773n/original",
    text: "Graduation Day - 2018",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/no7qo6jjvh37p7tun5o2ki893e/original",
    text: "Is my child safe when outside the school?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/kujld1jnop2cvchejduheruu1j/original",
    text: "How are weekdays planned in boarding?",
    caption: {
      0: {
        lang: "English",
        path: "vtt/How_are_weekdays_planned_in_boarding_en.vtt"
      }
    }
  }, {
    value: "https://bodwell.canto.com/download/video/1l131ijact1nr5f6i0njp2k81b/original",
    text: "What is the importance of volunteering?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/rn2a86abth2lr66pvk452s0f79/original",
    text: "When can my child move from boarding to homestay?",
    caption: ""
  }, {
    value: "https://bodwell.canto.com/download/video/cor6skje255tbfvgpbmhkmgg0g/original",
    text: "What can students and parents expect during orientation?",
    caption: ""
  }
];

var monthList = [
  {
    key: "01",
    value: "Jan"
  }, {
    key: "02",
    value: "Feb"
  }, {
    key: "03",
    value: "Mar"
  }, {
    key: "04",
    value: "Apr"
  }, {
    key: "05",
    value: "May"
  }, {
    key: "06",
    value: "Jun"
  }, {
    key: "07",
    value: "Jul"
  }, {
    key: "08",
    value: "Aug"
  }, {
    key: "09",
    value: "Sep"
  }, {
    key: "10",
    value: "Oct"
  }, {
    key: "11",
    value: "Nov"
  }, {
    key: "12",
    value: "Dec"
  }
];

var galleryFolderArr = ["RLJ5G", "LM37O", "H8J7M"];

function chkLocation(res, hom) {
  var subCategoryTxt;
  if (hom == "Y" && res == "Y") {
    subCategoryTxt = "Boarding";
  } else if (hom == "N" && res == "N") {
    subCategoryTxt = "Day Program";
  } else if (hom == "Y" && res == "N") {
    subCategoryTxt = "Homestay";
  } else if (hom == "N" && res == "Y") {
    subCategoryTxt = "Boarding";
  } else {
    subCategoryTxt = "Error";
  }
  return subCategoryTxt;
}

function getGradeLetter(rate) {
  if (rate >= 0.86) {
    return "A";
  } else if (rate >= 0.73 && rate < 0.86) {
    return "B";
  } else if (rate >= 0.67 && rate < 0.73) {
    return "C+";
  } else if (rate >= 0.6 && rate < 0.67) {
    return "C";
  } else if (rate >= 0.5 && rate < 0.6) {
    return "C-";
  } else {
    return "F";
  }
}

function getEnrollmentTerm(semesterid, semestername) {
  if (semesterid <= 70) {
    return "WINTER 2018";
  } else {
    return semestername;
  }
}

function GetCategoryIcon(categoryname) {
  var categoryIcon;
  if (categoryname == "10") {
    categoryIcon = '<i class="material-icons-outlined">directions_bike</i>';
  } else if (categoryname == "11") {
    categoryIcon = '<i class="material-icons-outlined">school</i>';
  } else if (categoryname == "12") {
    categoryIcon = '<i class="material-icons-outlined">language</i>';
  } else if (categoryname == "13") {
    categoryIcon = '<i class="material-icons-outlined">palette</i>';
  } else if (categoryname == "21") {
    categoryIcon = '<i class="material-icons-outlined">all_inclusive</i>';
  } else {
    categoryIcon = "err";
  }
  return categoryIcon;
}

function GetCategoryText(categoryId) {
  var categoryText;
  if (categoryId == "10") {
    categoryText = "Physical, Outdoor & Recreation Education";
  } else if (categoryId == "11") {
    categoryText = "Academic, Interest & Skill Development";
  } else if (categoryId == "12") {
    categoryText = "Citizenship, Interaction & Leadership Experience";
  } else if (categoryId == "13") {
    categoryText = "Arts, Culture & Local Exploration";
  } else if (categoryId == "21") {
    // categoryText = 'CREX';
  } else {
    categoryText = "err";
  }
  return categoryText;
}

function GetStatusIcon(statusid) {
  var statusIcon;
  if (statusid == 10) {
    // statusIcon = '<i class="fas fa-pen-alt text-warning"></i>';
  } else if (statusid == 20) {
    // joined
    statusIcon = '<i class="material-icons-outlined">date_range</i>';
  } else if (statusid == 60) {
    // pending approval
    statusIcon = '<i class="material-icons-outlined">hourglass_empty</i>';
  } else if (statusid == 70) {
    // in Progress
    statusIcon = '<i class="material-icons-outlined">play_arrow</i>';
  } else if (statusid == 80) {
    // hours approval
    statusIcon = '<i class="material-icons-outlined">done_outline</i>';
  } else if (statusid == 90) {
    // cancelled
    statusIcon = '<i class="material-icons-outlined">link_off</i>';
  } else {
    statusIcon = "err";
  }
  return statusIcon;
}

function GetStatusText(statusid) {
  var statusText;
  if (statusid == 10) {
    // statusIcon = '<i class="fas fa-pen-alt text-warning"></i>';
  } else if (statusid == 20) {
    // joined
    statusText = "Joined";
  } else if (statusid == 60) {
    // pending approved
    statusText = "Pending Approval";
  } else if (statusid == 80) {
    // hours approved
    statusText = "Hours Approved";
  } else if (statusid == 90) {
    // cancelled
    statusText = "Cancelled";
  } else {
    statusText = "err";
  }
  return statusText;
}

function GetVlweIcon(statusid) {
  var statusIcon;
  if (statusid == 1) {
    statusIcon = '<i class="material-icons-outlined">check_box</i>';
  } else if (statusid == 0) {
    statusIcon = "";
  } else {
    statusIcon = "err";
  }
  return statusIcon;
}

function findClassInfo(arr, val) {
  for (var i = 0; i < arr.length; i++) {
    if (arr[i][0] == val) {
      var roomNo = arr[i][1];
      var teacherName = arr[i][2];
      break;
    } else {
      var roomNo = "";
      var teacherName = "";
    }
  }
  var fullTxt = "Teacher : " + teacherName + ", Room : " + roomNo;
  return fullTxt;
}

function makeProgress(i) {
  var j = 100 - i;
  j = j + 1;
  $(".progress-bar").css("width", j + "%");
}

function getAllValInForm(formId) {
  return $("#" + formId).serializeArray();
}

function generateSelector(select, arr, arr2, def_val, disable) {
  var options = "";

  for (let i = 0; i < arr.length; i++) {
    options += '<option value="' + arr2[i] + '">' + arr[i] + "</option>";
  }
  $(select).html(options);
  if (def_val != "none") {
    $(select).val(def_val).prop("selected", true);
  } else {
    $(select).val("").prop("selected", true);
  }

  $(select).prop("disabled", disable);
}

$.extend($.fn.dataTableExt.oSort, {
  "num-html-asc": function (a, b) {
    return a < b
      ? -1
      : a > b
        ? 1
        : 0;
  },

  "num-html-desc": function (a, b) {
    return a < b
      ? 1
      : a > b
        ? -1
        : 0;
  }
});

$(document).ready(function () {
  $(".checkbox-credit").click(function () {
    if ($("input.checkbox-credit").is(":checked")) {
      $(".tr-nonCredit").show();
    } else {
      $(".tr-nonCredit").hide();
    }
  });
});

$(document).on("mouseover", ".showTooltip", function (event) {
  var $this = $(this);

  if (this.offsetWidth < this.scrollWidth && !$this.attr("title")) {
    $('[data-toggle="tooltip"]').tooltip({
      title: function () {
        return $(this).text();
      }
    });
  }
});

///if student insert self submit value -> self always
///if staff enter then it can be chosen

$(document).on("click", ".career-link-CLE, .career-link-CLC", function (event) {
  var target = $(event.target);
  var dataid = target.attr("data-id");
  var courseCd = "";
  if (target.hasClass("career-link-CLE")) {
    courseCd = "CLE";
  } else if (target.hasClass("career-link-CLC")) {
    courseCd = "CLC";
  }

  for (let i = 0; i < career.length; i++) {
    if (career[i].ProjectID == dataid) {
      $("#hidden-projectId").val(dataid);
      $("#career-course").val(career[i].SubjectName + "(" + career[i].FirstName + " " + career[i].LastName + ")");
      $("#career-topic").val(career[i].ProjectTopic);
      $("#career-guide-fName").val(career[i].MentorFName);
      $("#career-guide-lName").val(career[i].MentorLName);
      $("#career-guide-email").val(career[i].MentorEmail);
      $("#career-guide-phone").val(career[i].MentorPhone);
      $("#career-guide-position").val(career[i].MentorDesc);
      $("#career-description").val(career[i].ProjectDesc);

      const isInArray = capstoneCategory.includes(career[i].ProjectCategory);
      if (isInArray == true) {
        $("#career-capCategory").val(career[i].ProjectCategory).change();
      } else {
        $("#career-capCategory").val("Other (Specify below)").change();
        $("#career-capCategory-other").val(career[i].ProjectCategory);
      }

      var modifyText = career[i].ModifyDate + " by " + career[i].ModifyUserName;
      var createText = career[i].CreateDate + " by " + career[i].CreateUserName;

      $("#career-modifiedBy").html(modifyText);
      $("#career-createdBy").html(createText);
    }
  }

  defaltForm = getAllValInForm("form-careerLife");
});

function getDetailofMyParticipation(dataid) {
  for (let i = 0; i < myParticirationResponse.length; i++) {
    var participation = myParticirationResponse[i];
    if (participation.activityId === dataid) {
      console.log(participation);
      $("#sSubmitMdl-student-img").attr("src", "https://asset.bodwell.edu/OB4mpVpg/student/bhs" + participation.studentId + ".jpg");
      var imgsrc = "https://asset.bodwell.edu/OB4mpVpg/staff/" + participation.staffId + ".jpg";
      $("#sSubmitMdl-approverPic").attr("src", imgsrc);
      $("#sSubmitMdl-student-name").val(participation.FullName);
      $("#sSubmitMdl-studentId").val(participation.studentId);
      $("#sSubmitMdl-approver").val(participation.FullStaffName);
      var statusText = GetStatusText(participation.ActivityStatus);
      $("#sSubmitMdl-status").val(statusText);
      $("#sSubmitMdl-title").val(participation.title);
      var categoryText = GetCategoryText(participation.category);
      $("#sSubmitMdl-category").val(participation.category).change();
      $("input[name='vlwe'][value='" + participation.VLWE + "']").prop("checked", true);
      $("#sSubmitMdl-location").val(participation.location);
      $("#sSubmitMdl-sDate").val(participation.sDate.substring(0, 10));
      $("#sSubmitMdl-eDate").val(participation.eDate.substring(0, 10));
      $("#sSubmitMdl-hours").val(participation.hours);
      $("#sSubmitMdl-aprComment").val(participation.approverComment1);
      $("#sSubmitMdl-stuComment1").val(participation.stuComment1);
      $("#sSubmitMdl-stuComment2").val(participation.stuComment2);
      $("#sSubmitMdl-stuComment3").val(participation.stuComment3);
    }
  }
}

function getMonthAndDay(date) {
  var mon = date.split("-")[1];
  var day = date.split("-")[2];
  for (let i = 0; i < monthList.length; i++) {
    if (monthList[i].key == mon) {
      return monthList[i].value + " " + day;
    }
  }
}

function convertToMin(time) {
  var roundedSec = Math.round(parseFloat(time));
  var min = Math.floor(roundedSec / 60);
  var sec = Math.round(roundedSec % 60).toString().padStart(2, "0");

  var duration = min + ":" + sec;
  return duration;
}

function toggleSpinner() {
  if ($(".mask").is(":hidden")) {
    $(".mask").show();
  } else {
    $(".mask").hide();
  }
}

function post_to_url(path, params) {
  method = "POST";
  var form = document.createElement("form");
  form.setAttribute("method", method);
  form.setAttribute("action", path);
  for (var key in params) {
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", key);
    hiddenField.setAttribute("value", params[key]);
    form.appendChild(hiddenField);
  }
  document.body.appendChild(form);
  form.submit();
}

function formatTerms(num) {
  var text = "";
  switch (num) {
    case '0':
      text = "";
      break;
    case '1':
      text = "st Term";
      break;
    case '2':
      text = "nd Term";
      break;
    case '3':
      text = "rd Term";
      break;
    default:
      text = "th Term";
      break;
  }

  return num + text;
}

function convertNulltoNA(val){
  var str = '';
  if(val == null) {
    str = 'n/a';
  } else {
    str = parseFloat(val).toFixed(2);
  }
  return str;
}

function calculateAEPAVG(val1,val2,val3,val4){
  var sum = 0;
  var num = 0;
  if(val1 !== null){
    num += 1;
    sum += parseFloat(val1);
  }
  if(val2 !== null){
    num += 1;
    sum += parseFloat(val2);
  }
  if(val3 !== null){
    num += 1;
    sum += parseFloat(val3);
  }
  if(val4 !== null){
    num += 1;
    sum += parseFloat(val4);
  }
  var avg = (isNaN(parseFloat(sum/num)) == true) ? 'n/a' : parseFloat(sum/num).toFixed(2);

  return avg;
}

function getFullName(ename, lastname, firstname){
  var fullName;
  if (ename) {
    fullName = lastname + ', ' + firstname + ' (' + ename + ')';
  } else {
    fullName = lastname + ', ' + firstname;
  }
  return fullName;
}

function chkNull(val) {
  var str = "";
  if(val == null) {
    str = "<span class='color-grey italic'>n/a</span>";
  } else {
    str = val;
  }
  return str;
}

function calculateGPA(credit, letter){
  var ltrGrade = letter.replace(/\s+/g, '');
  var totalCredit = 0;
  if(ltrGrade == 'A'){
    totalCredit = credit * 4;
  } else if (ltrGrade == 'B') {
    totalCredit = credit * 3;
  } else if (ltrGrade == 'C+') {
    totalCredit = credit * 2.5;
  } else if (ltrGrade == 'C') {
    totalCredit = credit * 2;
  } else if (ltrGrade == 'C-') {
    totalCredit = credit * 1;
  } else {
    totalCredit = 0;
  }
  return totalCredit;
}

function roundToTwo(num) {
   return num.toFixed(2);
    // return +(Math.round(num + "e+2")  + "e-2").toFixed(2);
}

function getDetailofSelfassessments(dataid,name, grade,selfAssessmentsResponse){
  $('#selfAssessmentsModal  .selfAssessments-wrapper').html('');
  $('span.studentName').html(name);
  $('span.grade').html(grade);


  for (let i = 0; i < selfAssessmentsResponse.length; i++) {
    let selfAssessmentsDetail = selfAssessmentsResponse[i];
    if (selfAssessmentsDetail.AssessmentID == dataid) {
      $('#selfAssessmentsModal  .selfAssessments-wrapper').html(selfAssessmentsDetail.FormHtml);

      if(selfAssessmentsDetail.Grade == '10,11,12') {
        displayStudentAssessment10(selfAssessmentsDetail);
      } else if (selfAssessmentsDetail.Grade == '8,9') {
        displayStudentAssessment8(selfAssessmentsDetail);
      } else {
        alert('Contact IT');
      }

    }
  }
}

function displayStudentAssessment10(response){
  $('#AssessmentID').val(response.AssessmentID);
  var str = response.PersonalText;
  var res = str.split(":*:");

  $("[name='communication']").val(response.CommunicationText);
  $("[name='thinking']").val(response.ThinkingText);
  $("[name='personal']").val(res[0]);
  $("[name='personal1']").val(res[1]);

  $("[name='cRate']").val(response.CommunicationRate);
  $("[name='tRate']").val(response.ThinkingRate);
  $("[name='pRate']").val(response.PersonalRate);

}

function displayStudentAssessment8(response) {
  $('#AssessmentID').val(response.AssessmentID);
  var p = response.PersonalText;
  var res_p = p.split(":*:");
  var t = response.ThinkingText;
  var res_t = t.split(":*:");
  var c = response.CommunicationText;
  var res_c = c.split(":*:");
  for(var i = 0; i < res_c.length; i++){
    var inum = parseInt(i+1);
    var cName = 'Communication'+inum;
    $("[name="+cName+"]").val(res_c[i]);
  }

  for(var i = 0; i < res_t.length; i++){
    var inum = parseInt(i+1);
    var cName = 'Thinking'+inum;
    $("[name="+cName+"]").val(res_t[i]);
  }

  for(var i = 0; i < res_p.length; i++){
    var inum = parseInt(i+1);
    var cName = 'Personal'+inum;
    $("[name="+cName+"]").val(res_p[i]);
  }



  $("[name='cRate']").val(response.CommunicationRate);
  $("[name='tRate']").val(response.ThinkingRate);
  $("[name='pRate']").val(response.PersonalRate);

}

function post(path, params, method='post') {

  // The rest of this code assumes you are not using a library.
  // It can be made less verbose if you use one.
  const form = document.createElement('form');
  form.method = method;
  form.action = path;

  for (const key in params) {
    if (params.hasOwnProperty(key)) {
      const hiddenField = document.createElement('input');
      hiddenField.type = 'hidden';
      hiddenField.name = key;
      hiddenField.value = params[key];

      form.appendChild(hiddenField);
    }
  }

  document.body.appendChild(form);
  form.submit();
}

function redirectToReportCard(type) {

  var t = $('#reportcardTerm').val();
  if(!t) {
    alert('Please choose Term');
    return;
  }
    if(type == 'M') {
      post('?page=reportcardMidterm', {sId: t});
    } else {
      post('?page=reportcardFinalterm', {sId: t});
    }

  }
