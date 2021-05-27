$(document).ready(function () {
  $("#career-cancel-btn, #sSubmitMdl-close-btn, #aepScoresMdl-close-btn, #iapMdl-close-btn, #aepCommentMdl-close-btn").click(function (event) {
    var target = $(event.target);
    var id = target.attr("id");
    var modal = "";
    switch (id) {
      case "career-cancel-btn":
        modal = "#careerLifeModal";
        break;
      case "sSubmitMdl-close-btn":
        modal = "#selfSubmitDetailModal";
        break;
      case "aepScoresMdl-close-btn":
        modal = "#aepScoresMdl";
        break;
      case "iapMdl-close-btn":
        modal = "#iapMdl";
        break;
      case "aepCommentMdl-close-btn":
        modal = "#aepCommentMdl";
        break;
      default:
        break;
    }
    $(modal).modal("hide");
  });
});

$(document).on("click", ".modalLink", function (event) {
  var target = $(event.target);
  var dataid = target.attr("data-id");
  if (target.hasClass("modalLink")) {
    // target.attr({href: "#selfSubmitDetailModal", "data-target": "#selfSubmitDetailModal"});
    $('#selfSubmitDetailModal').modal('show');
    var id = dataid.split(",")[0];
    var status = dataid.split(",")[1];
    getDetailofMyParticipation(id);

    defaltForm = getAllValInForm("selfSubmitDetailForm");
  }
});

$(document).on("click", ".selfAssessmentsMdlLink", function (event) {
  var target = $(event.target);
  var dataid = target.attr("data-id");
  if (target.hasClass("selfAssessmentsMdlLink")) {
    $('#selfAssessmentsModal').modal('show');
    var name = target.attr("data-name");
    var grade = target.attr("data-grade");
    getDetailofSelfassessments(dataid,name, grade,selfAssessmentsResponse);


  }
});


$(document).on("click", ".btn-midComment, .btn-final", function (event) {
  var aep_id = $("#aep-subject").val();
  var data = aepCourses[aep_id];
  var tmp_c;
  var txt = '';
  var str = '';
  var comment = "Record not found.";
  var target = $(event.target);
  var dataid = target.attr("data-id");
  if (target.hasClass("btn-midComment")) {
    tmp_c = data.CommentMidterm;
    $('.aep-modalTitle').html("Mid-Term Comment");
  } else if (target.hasClass("btn-final")) {
    tmp_c = data.CommentFinal;
    $('.aep-modalTitle').html("Final Comment");
  }

  if (tmp_c != null) {
    comment = tmp_c;
    txt = tmp_c.split("\n");
    console.log(txt);
    if(txt.length < 3) {
      str = comment;
    } else {
      var s = txt.splice(2);
      for (var i = 0; i < s.length; i++) {
        str += s[i];
      }
    }

    $(".aep-comment").html(str);
  } else {
    $(".aep-comment-error").html(comment);
  }
});
