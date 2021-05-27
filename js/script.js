var globalAbsense;
var globalApprovalList
var myParticirationResponse;
var careerSubjectList;
var career;
var mediaGallery;
var pastTermList;
var numofTerms;
var aepCourses;
var globalAssessments;
var selfAssessmentsResponse;

function ajaxtologin() {
  var userID = $('#userID').val();
  var userPW = $('#userPW').val();
  if (userID == '' || userPW == '') {
    alert("Enter User Name and Password");
    return;
  }
  $.ajax({
    url: 'ajax_php/a.login.php',
    type: 'POST',
    dataType: "json",
    data: {
      "userID": userID,
      "userPW": userPW
    },
    success: function (response) {
      console.log(response);
      if (response[0]['status'] == 0) {
        location.href = "?page=dashboard";
        // //console.log(response[0]);
      } else {
        alert("You put Wrong Id or Wrong PW");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function ajaxtostudentinfo(StartDate, NextStartDate) {
  $.ajax({
    url: 'ajax_php/a.studentInfo.php',
    type: 'POST',
    async: false,
    dataType: "json",
    success: function (response) {
      console.log(response);
      var fullName;
      if (response[0].englishName) {
        fullName = response[0].lastName + ', ' + response[0].firstName + ' (' + response[0].englishName + ')';
      } else {
        fullName = response[0].lastName + ', ' + response[0].firstName;
      }
      $('.dashboard-fullName').html(fullName);
      $('#student-inf .dashboard-studentId').html(response[0].studentId);
      var imgsrc = response[0].imgsrc;
      $('.dashboard-userPic').attr("src", imgsrc);
      $('#student-inf .dashboard-pen').html(response[0].pen);
      $('#student-inf .dashboard-grade').html(response[0].currentGrade);
      $('#student-inf .dashboard-Counsellor').html(response[0].counsellor);
      var location = chkLocation(response[0].residence, response[0].homestay);
      $('#student-inf .dashboard-location').html(location);
      $('#student-inf .dashboard-house').html(response[0].houses);
      $('#student-inf .dashboard-hall').html(response[0].halls);
      $('#student-inf .dashboard-room').html(response[0].roomNo);
      $('#student-inf .dashboard-advisor1').html(response[0].youthAdvisor);
      $('#student-inf .dashboard-advisor2').html(response[0].youthAdvisor2);
      $('#student-inf .dashboard-mentor').html(response[0].mentor);
      $('#student-inf .dashboard-terms').html(formatTerms(response[0].numTerms));
      numofTerms = response[0].numTerms;
      if(response[0].numTerms < 2) {
        if($(".past-term-menu").hasClass("no-show") == false){
          $(".past-term-menu").addClass("no-show");
        }
      }
      $('#student-inf .dashboard-aepTerms').html(formatTerms(response[0].numOfAepTerm));
      ajaxtoEnrollTerm(response[0].EnrollmentDate);
      ajaxtoMyParticipation(StartDate, NextStartDate, response[0].EnrollmentDate);

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}


function ajaxtoCurrentTerm() {
  $.ajax({
    url: 'ajax_php/a.CurrentTerm.php',
    type: 'POST',
    dataType: "json",
    async: true,
    success: function (response) {
      //console.log(response);
      $('.dashboard-startDate').html(getMonthAndDay(response[0].StartDate));
      $('.dashboard-midCutoff').html(getMonthAndDay(response[0].MidCutOffDate));
      $('.dashboard-endDate').html(getMonthAndDay(response[0].EndDate));
      $('.dashboard-CurrentTerm').html(response[0].SemesterName);
      $('.dashboard-semesterName').html(response[0].SemesterName);
      $('.dashboard-termstatus').html(response['text']);

      var EndDate = new Date(response[0].EndDate).getTime()
      var StartDate = new Date(response[0].StartDate).getTime()
      var Today = new Date().getTime();
      var Total = EndDate - StartDate;
      var per = EndDate - Today;
      var param = per / Total * 100;
      var pParam = param.toFixed(2);
      console.log(pParam);

      if(pParam > 100){
        pParam = 100;
      } else if (pParam < 0) {
        pParam = 0;
      } else {
        pParam = pParam;
      }
      makeProgress(pParam);
      //
      $('.dashboard-termPer').html((100 - pParam).toFixed(0));

      ajaxtostudentinfo(response[0].StartDate, response[0].NextStartDate);
      ajaxtoMyCourses(response[0].SemesterID);
      ajaxtoMyGrades(response[0].SemesterID);
      getInvolvedStaff(response[0].SemesterID);
      // ajaxtoMyParticipation(response[0].SemesterID);
      // ajaxtoMyParticipation();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function ajaxtoMyAbsenseLate(globalAbsense) {
  // console.log(globalAbsense);
  if (globalAbsense) {
    var response = globalAbsense['Absense'];
    for (var i = 0; i < response.length; i++) {
      var studentCourseId = response[i].studentCourseId;
      var absenceCount = response[i].absenceCount;
      var lateCount = response[i].lateCount;

      $('.' + studentCourseId + '-absense').html(absenceCount);
      $('.' + studentCourseId + '-late').html(lateCount);
    }
  }
}

function ajaxtoMyGrades(SemesterID) {
  $.ajax({
    url: 'ajax_php/a.MyGrades.php',
    type: 'POST',
    async: true,
    dataType: "json",
    data: {
      "SemesterID": SemesterID
    },
    success: function (response) {
      console.log(response);
      for (var i = 0; i < response.length; i++) {
        var courseId = response[i].courseId;
        var courseRateScaled = response[i].courseRateScaled;
        var finalRate = (courseRateScaled * 100).toFixed(1) + '%';
        var finalLetter = getGradeLetter(courseRateScaled);

        $('.' + courseId + '-p').html(finalRate);
        $('.' + courseId + '-l').html(finalLetter);

        $('.' + courseId + '-p').removeClass('naText');
        $('.' + courseId + '-l').removeClass('naText');
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}


function ajaxtoMyCourses(SemesterID) {
  $.ajax({
    url: 'ajax_php/a.MyCourses.php',
    type: 'POST',
    async: false,
    dataType: "json",
    data: {
      "SemesterID": SemesterID
    },
    success: function (response) {
      console.log(response);
      var tr;
      var careerChk;
      var responseCourses = response['courses'];
      for (var i = 0; i < responseCourses.length; i++) {
        var courseType = responseCourses[i].courseType;
        var courseId = responseCourses[i].courseId;
        var studentCourseId = responseCourses[i].studentCourseId;
        var courseName = responseCourses[i].courseName;
        var courseCd = responseCourses[i].CourseCd;
        courseName = courseName.replace('YYY', '');
        courseName = courseName.replace('ZZZ', '');
        var credit = responseCourses[i].credit;
        var teacherName = responseCourses[i].teacherName;
        var roomNo = responseCourses[i].roomNo;
        var pGrade = 'n/a';
        var lGrade = 'n/a';
        var late = '';
        var absense = '';
        var trClass;
        if (courseType.toUpperCase() != 'P' && courseType.toUpperCase() != 'N') {
          trClass = 'tr-nonCredit';
        } else {
          trClass = 'tr-Credit';
        }
        if (!careerChk) {
          if (courseCd == 'CLC' || courseCd == 'CLE') {
            careerChk = 'C';
            $('.span-' + courseCd + '-coursename').html(courseName);
            $('.dashboard-' + courseCd + '-teacher').html(teacherName);
            $('.dashboard-' + courseCd + '-teacher').css("color", '#252422');
            $('.dashboard-' + courseCd + '-teacher').css("font-style", 'normal');
            $('#hidden-courseId').val(courseId);
          }
        }
        tr = '<tr class="' + trClass + '"><td class="text-left">' + courseName + '</td><td class="' + courseId + '-p naText">' + pGrade + '</td><td class="' + courseId + '-l naText">' + lGrade + '</td><td>' + credit + '</td><td class="text-left">' + teacherName + '</td><td>' + roomNo + '</td><td class="' + studentCourseId + '-late">' + late + '</td><td class="' + studentCourseId + '-absense">' + absense + '</td></tr>';
        $('#dashboard-mycourses tbody').append(tr);
      }
      ajaxtoMyAbsenseLate(response);
      if (careerChk == 'C') {
        ajaxtoMyCareerLife(SemesterID);
      }

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
  // only type p OR N = credit. except p Or N all non credit
}

function ajaxtoMyCareerLife(SemesterID) {
  $('.careerLife-card-btn').show();
  ajaxToGetListCareerSubejct(SemesterID);
  $.ajax({
    url: 'ajax_php/a.GetCareerPath.php',
    type: 'POST',
    data: {
      "SemesterID": SemesterID
    },
    dataType: "json",
    success: function (response) {
      //console.log(response['data']);
      if (response.result == 0) {
        console.log("IT")
      } else {
        var CLEtr;
        var CLCtr;
        var errtr;
        career = response['data'];
        for (var i = 0; i < career.length; i++) {
          if (career[i].CourseCd == 'CLE') {
            CLEtr += '<tr>' +
              '<td><a href="#careerLifeModal" data-toggle="modal" class="career-link-CLE" data-id="' + career[i].ProjectID + '">CLE<br /></a>' +
              '<span style="font-size: 10px"><a href="#careerLifeModal" data-toggle="modal" class="career-link-CLE" data-id="' + career[i].ProjectID + '">' + career[i].SubjectName + '</a></span>' +
              '</td>' +
              '<td class="dashboard-CLE-teacher showTooltip" data-toggle="tooltip">' + career[i].FirstName + " " + career[i].LastName + '</td>' +
              '<td class="dashboard-CLE-topic text-left showTooltip" data-toggle="tooltip">' + career[i].ProjectTopic + '</td>' +
              '<td class="dashboard-CLE-guide showTooltip" data-toggle="tooltip">' + career[i].MentorFName + " " + career[i].MentorLName + '</td>' +
              '<td class="dashboard-CLE-date">' + career[i].CreateDateV + '</td>' +
              '<td class="dashboard-CLE-status">' + GetStatusIcon(career[i].ApprovalStatus) + '</td>' +
              '</tr>';
          } else if (career[i].CourseCd == 'CLC') {
            CLCtr += '<tr>' +
              '<td><a href="#careerLifeModal" data-toggle="modal" class="career-link-CLC" data-id="' + career[i].ProjectID + '">CLC/Capstone<br /></a>' +
              '<span style="font-size: 10px"><a href="#careerLifeModal" data-toggle="modal" class="career-link-CLC" data-id="' + career[i].ProjectID + '">' + career[i].SubjectName + '</a></span>' +
              '</td>' +
              '<td class="dashboard-CLC-teacher showTooltip" data-toggle="tooltip">' + career[i].FirstName + " " + career[i].LastName + '</td>' +
              '<td class="dashboard-CLC-topic text-left showTooltip" data-toggle="tooltip">' + career[i].ProjectTopic + '</td>' +
              '<td class="dashboard-CLC-guide showTooltip" data-toggle="tooltip">' + career[i].MentorFName + " " + career[i].MentorLName + '</td>' +
              '<td class="dashboard-CLC-date">' + career[i].CreateDateV + '</td>' +
              '<td class="dashboard-CLC-status">' + GetStatusIcon(career[i].ApprovalStatus) + '</td>' +
              '</tr>';
          } else {
            errtr += '<tr><td colspan="6">Err</td></tr>';
          }

        }
        var html;
        if (CLEtr) {
          html += CLEtr
        } else {
          html += '<tr>' +
            '<td>CLE<br />' +
            '<span style="font-size: 10px">Career Life Education</span>' +
            '</td>' +
            '<td class="dashboard-CLE-teacher italic color-9A9A9A">Not Submitted</td>' +
            '<td class="dashboard-CLE-topic italic color-9A9A9A">Not Submitted</td>' +
            '<td class="dashboard-CLE-guide italic color-9A9A9A">Not Submitted</td>' +
            '<td class="dashboard-CLE-date italic color-9A9A9A">Not Submitted</td>' +
            '<td class="dashboard-CLE-status italic color-9A9A9A">Not Submitted</td>' +
            '</tr>';
        }

        if (CLCtr) {
          html += CLCtr
        } else {
          html += '<tr>' +
            '<td>CLC/Capstone<br />' +
            '<span style="font-size: 10px">Career Life Connections</span>' +
            '</td>' +
            '<td class="dashboard-CLC-teacher italic color-9A9A9A">Not Submitted</td>' +
            '<td class="dashboard-CLC-topic italic color-9A9A9A">Not Submitted</td>' +
            '<td class="dashboard-CLC-guide italic color-9A9A9A">Not Submitted</td>' +
            '<td class="dashboard-CLC-date italic color-9A9A9A">Not Submitted</td>' +
            '<td class="dashboard-CLC-status italic color-9A9A9A">Not Submitted</td>' +
            '</tr>';
        }

        if (errtr) {
          html = errtr;
        }
        // console.log(html);
        $('#dashboard-Career tbody').html(html);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}


function ajaxToGetListCareerSubejct(SemesterID) {
  $.ajax({
    url: 'ajax_php/a.getListCareerSubject.php',
    type: 'POST',
    data: {
      "SemesterID": SemesterID
    },
    dataType: "json",
    success: function (response) {
      if (response.result == 0) {
        console.log("IT")
      } else {
        careerSubjectList = response['data'];
        $('#career-course').append('<option value="">Select..</option>');
        for (var i = 0; i < careerSubjectList.length; i++) {
          let TeacherID = careerSubjectList[i].TeacherID;
          let FullName = careerSubjectList[i].FullName;
          let SubjectID = careerSubjectList[i].SubjectID;
          let SubjectName = careerSubjectList[i].SubjectName;
          $('#career-course').append('<option value="' + SubjectID + '">' + SubjectName + ' (' + FullName + ')' + '</option>');
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function ajaxtoMyParticipation(StartDate, NextStartDate, EnrollmentDate) {
  $.ajax({
    url: 'ajax_php/a.ParticipationHours.php',
    type: 'POST',
    dataType: "json",
    success: function (response) {
      var currentAISD = 0;
      var currentACLE = 0;
      var currentCILE = 0;
      var currentPORE = 0;
      var currentVLWE = 0;
      var accumAISD = 0;
      var accumACLE = 0;
      var accumCILE = 0;
      var accumPORE = 0;
      var accumVLWE = 0;
      var currenthours = 0;
      var accumhours = 0;

      var dt = new Date(EnrollmentDate);
      dt.setDate(dt.getDate() - 1);
      var dateString = new Date(dt.getTime() - (dt.getTimezoneOffset() * 60000))
        .toISOString()
        .split("T")[0];
      console.log(dateString);
      for (var i = 0; i < response.length; i++) {
        var category = response[i].category;
        var termId = response[i].termId;
        var vlwe = response[i].VLWE;
        var hours = parseFloat(response[i].hours);
        var activityDate = response[i].activityDate;
        if (activityDate >= dateString) {
          if (category == '10') {
            accumPORE += hours;
          } else if (category == '11') {
            accumAISD += hours;
          } else if (category == '12') {
            accumCILE += hours;
          } else if (category == '13') {
            accumACLE += hours;
          }
          if (vlwe == 1) {
            accumVLWE += hours;
          }
        }

        // if (termId == SemesterID) {
        if (activityDate >= StartDate && NextStartDate >= activityDate) {
          if (vlwe == 1) {
            currentVLWE += hours;
          }
          if (category == '10') {
            currentPORE += hours;
          } else if (category == '11') {
            currentAISD += hours;
          } else if (category == '12') {
            currentCILE += hours;
          } else if (category == '13') {
            currentACLE += hours;
          }
        }
      }
      // accumCILE += accumVLWE;
      // currentCILE += currentVLWE;
      currenthours = currentPORE + currentAISD + currentCILE + currentACLE;
      accumhours = accumPORE + accumAISD + accumCILE + accumACLE;
      $('.dashboard-PORE-C').html(currentPORE.toFixed(1));
      $('.dashboard-AISD-C').html(currentAISD.toFixed(1));
      $('.dashboard-CILE-C').html(currentCILE.toFixed(1));
      $('.dashboard-ACLE-C').html(currentACLE.toFixed(1));
      $('.dashboard-TOTAL-C').html(currenthours.toFixed(1));
      $('.dashboard-VLWE-C').html(currentVLWE.toFixed(1));

      $('.dashboard-PORE-A').html(accumPORE.toFixed(1));
      $('.dashboard-AISD-A').html(accumAISD.toFixed(1));
      $('.dashboard-CILE-A').html(accumCILE.toFixed(1));
      $('.dashboard-ACLE-A').html(accumACLE.toFixed(1));
      $('.dashboard-TOTAL-A').html(accumhours.toFixed(1));
      $('.dashboard-VLWE-A').html(accumVLWE.toFixed(1));

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function ajaxtoEnrollTerm(EnrollmentDate) {
  $.ajax({
    url: 'ajax_php/a.EnrollTerm.php',
    type: 'POST',
    dataType: "json",
    data: {
      "EnrollmentDate": EnrollmentDate
    },
    success: function (response) {
      var EnrollTerm = getEnrollmentTerm(response[0].SemesterID, response[0].SemesterName);
      $('.dashboard-EnrollmetTermName').html(EnrollTerm);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function showGradeBySubject() {
  var table = $('#datatable-gradebook').DataTable();
  var html = "";
  var eData = [];
  var tData = [];
  $.ajax({
    url: 'ajax_php/a.GetGradeBySubject.php',
    type: 'POST',
    dataType: "json",
    async: true,
    success: function (response) {
      var scorePoint;
      var scoreRate;
      var exempted;
      var scoreTxt;
      var overdue;
      //console.log(response.length);
      if (response.length > 0) {
        $('.gradebook-currentterm').html(response['grade'][0].SemesterName);
      }

      if (response.result == 0) {
        console.log("IT")
      } else {
        table.clear();
        // ajaxtoAvgScore(response['courseId']);
        //console.log(response);
        var chk;
        var breakCheck1 = false;

        for (var i = 0; i < response['grade'].length; i++) {
          scorePoint = response['grade'][i].scorePoint;
          exempted = response['grade'][i].exempted;
          overdue = response['grade'][i].overdue;
          scoreRate = response['grade'][i].scoreRate * 100;
          scoreRate = scoreRate.toFixed(1) + '%';
          if (exempted == 1) {
            scoreTxt = 'Exempted';
          } else {
            if (scorePoint == null) {
              if (overdue == 1) {
                scoreTxt = 'Overdue';
              } else {
                scoreTxt = 'Pending';
              }
            } else {
              scorePoint = parseFloat(scorePoint).toFixed(1);
              scoreTxt = scorePoint + ' (' + scoreRate + ')';
            }
          }
          var ItemId = response['grade'][i].itemId;
          for (var s = 0; s < response['Avg'].length; s++) {
            if (response['Avg'][s].itemId == ItemId) {
              AvgScore = response['Avg'][s].averageScore;
              breakCheck1 = true;
              break;
            } else {
              AvgScore = 0;
            }
          }
          AvgScore = (Math.round(AvgScore * 10) / 10).toFixed(1);

          if (breakCheck1) {
            eData.push([response['grade'][i].assignDate,
              response['grade'][i].categoryTitle.trim(),
              response['grade'][i].itemTitle,
              scoreTxt,
              response['grade'][i].maxScore.slice(0, -1),
              // AvgScore,
              // response['grade'][i].comment,
              response['grade'][i].SubjectName,
              response['grade'][i].courseId,
              response['grade'][i].categoryLabel
            ]);


            tData.push([response['grade'][i].courseId,
              response['grade'][i].roomNo,
              response['grade'][i].teacherName
            ]);

          }
        }

        table = $('#datatable-gradebook').DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          // info: false,
          pagingType: "simple_numbers",
          oLanguage: {
            "sEmptyTable": "No data available"
          },
          language: {
            paginate: {
              next: '<i class="nc-icon nc-minimal-right">', // or '→'
              previous: '<i class="nc-icon nc-minimal-left">', // or '←'
              // emptyTable: "No data available"
            }
          },
          order: [
            [0, "desc"]
          ],
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          columnDefs: [{
              targets: 0,
              // width: "12%"
              width: "185px",
              className: "text-center"
            },
            {
              targets: 1,
              // width: "18%"
              width: "419px"

            },
            {
              targets: 2,
              // width: "18%"
              width: "418px"
            },
            {
              targets: 3,
              // width: "11%"
              width: "150px",
              className: "text-center"
            },
            {
              targets: 4,
              // width: "11%"
              width: "138px",
              className: "text-center"
            },
            // {
            //   targets: 5,
            //   // width: "12%"
            //   width: "153px"
            // },
            // {
            //   targets: 6,
            //   // width: "18%"
            //   width: "368px"
            // },
            {
              visible: false,
              targets: 5
            },
            {
              visible: false,
              targets: 6
            },
            {
              visible: false,
              targets: 7
            }
          ],
          responsive: true,
          // scrollX: true
        });
        var select = $(
            '<select class="select-category" id="gradebook-select-subject"></select>'
          )
          .prependTo($('#datatable-gradebook_filter'));
        createFilter(table, select);
        // $('#datatable-gradebook_filter').html('');
        var val2 = $('#gradebook-select-subject').val();
        table.column(6)
          .search(val2 ? '^' + val2 + '$' : '', true, false)
          .draw();
        var FullClassInfo2 = findClassInfo(tData, val2);
        $('.gradebook-classinfo').html(FullClassInfo2);
        prependToCategory('e');

        table.columns().every(function (index) {

          if (index == 6) {
            var that = this;

            select.on('change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );
              var FullClassInfo = findClassInfo(tData, val);
              $('.gradebook-classinfo').html(FullClassInfo);

              that
                .search(val ? '^' + val + '$' : '', true, false)
                .draw();

              if (val == '') {
                $('.gradebook-classinfo').html('');
                prependToCategory('e');
              } else {
                prependToCategory('f');
              }

            });

          }
        });

        $('#datatable-gradebook_length').parent().removeClass('col-md-6');
        $('#datatable-gradebook_length').parent().addClass('col-md-4');
        $('#datatable-gradebook_filter').parent().removeClass('col-md-6');
        $('#datatable-gradebook_filter').parent().addClass('col-md-8');
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function createFilter(table, select) {
  var sVal = [];
  var rVal = [];
  for (var i = 5; i < 7; i++) {
    table.column(i)
      .cache('search')
      .unique()
      .each(function (d) {
        if (i == 6) {
          sVal.push(d);
        } else {
          rVal.push(d);
        }
      });
  }
  for (var j = 0; j < sVal.length; j++) {
    select.append($('<option value="' + sVal[j] + '">' + rVal[j] + '</option>'));
  }
}

function createFilterV2(table, select, num1, num2, way) {
  var sVal = [];
  var rVal = [];
  var result = [];
  var s = 0;
  var t = 0;
  var final;
  for (var i = num1; i <= num2; i++) {
    table.column(i)
      .cache('search')
      .unique()
      .each(function (d) {
        if (i == num2) {
          sVal.push(d);
          sVal[s] = {
            id: d
          };
          s++;
        } else {
          rVal[t] = {
            text: d
          };
          t++;
        }
      });
  }

  for (var w = 0; w < sVal.length; w++) {
    result[w] = {
      id: sVal[w].id,
      text: rVal[w].text
    }
  }
  if (way == 'asc') {
    final = result.slice(0);
    final.sort(function (a, b) {
      return a.id - b.id;
    });

  } else {
    final = result;
  }

  console.log(final);
  for (var j = 0; j < final.length; j++) {
    select.append($('<option value="' + final[j].id + '">' + final[j].text + '</option>'));
  }
}

function prependToCategory(chk) {
  var select2;
  if ($("#gradebook-select-category").length) {
    select2 = $('#gradebook-select-category');
  } else {
    select2 = $(
        '<select class="select-category" id="gradebook-select-category"><option value="">All Category</option></select>'
      )
      .insertAfter($('#gradebook-select-subject'));
  }
  select2.append('<option value="' + chk + '">' + chk + '</option>');

  var table = $('#datatable-gradebook').DataTable();
  // var val = $('#gradebook-select-subject').val();

  table.column(7, {
    filter: 'applied'
  }).every(function () {
    var that = this;
    //empty filter again

    $('#gradebook-select-category')
      .empty()
      .append('<option value="">All Category</option>');
    var val2 = '';
    that
      .search(val2 ? '^' + val2 + '$' : '', true, false)
      .draw();

    // empty
    this
      .cache('search')
      .sort()
      .unique()
      .each(function (d) {
        select2.append($('<option value="' + d + '">' + d + '</option>'));
      });
    select2.on('change', function () {
      var val = $.fn.dataTable.util.escapeRegex(
        $(this).val()
      );
      that
        .search(val ? '^' + val + '$' : '', true, false)
        .draw();
    });
  });
}

function ajaxtoAvgScore(arr) {
  $.ajax({
    url: 'ajax_php/a.ItemAverage.php',
    type: 'POST',
    dataType: "json",
    data: {
      "courseIdArr": arr
    },
    success: function (response) {
      var test = response['Avg'];
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }

  });
}

function showMyParticipation() {
  var table = $('#participationHours').DataTable();
  var html = "";
  var eData = [];
  $.ajax({
    url: 'ajax_php/a.GetMyParticipation.php',
    type: 'POST',
    dataType: "json",
    async: true,
    success: function (response) {
      //console.log(response);
      if (response.result == 0) {
        console.log("IT")
      } else {
        myParticirationResponse = response;
        $('.participation-CurrentTerm').html(response[0].SemesterName);
        var hrSubmiitedBy;
        for (var i = 0; i < response.length; i++) {
          hrSubmiitedBy = response[i].CreateUserName;
          var SemesterName = response[i].SemesterName;
          var StatusIcon = GetStatusIcon(response[i].ActivityStatus);
          // var ActivitySourceIcon = GetActivitySourceIcon(response[i].ProgramSource);
          var ActivitySourceIcon = response[i].ProgramSource;
          var CategoryIcon = GetCategoryIcon(response[i].category);
          var VLWEIcon = GetVlweIcon(response[i].VLWE);
          var paticipationDate = '<div class="pDate">' + response[i].sDate + '</div>'
          var participationTitle = response[i].title;
          participationTitle = participationTitle.replace('YYY', '');
          participationTitle = participationTitle.replace('ZZZ', '');
          if (ActivitySourceIcon == 'SELF') {
            participationTitle = '<a data-toggle="modal" data-target="" data-id="' + [response[i].activityId, response[i].ActivityStatus] + '" class="modalLink" >' + participationTitle + '</a>';
          }
          var hours = '';
          if (response[i].hours == '.0') {
            hours = '0.0'
          } else if (response[i].hours == '.5') {
            hours = '0.5'
          } else {
            hours = response[i].hours
          }
          eData.push([
            paticipationDate,
            participationTitle,
            ActivitySourceIcon,
            CategoryIcon,
            response[i].category,
            VLWEIcon,
            hours,
            hrSubmiitedBy,
            response[i].FullStaffName,
            StatusIcon,
            SemesterName,
            response[i].termId
          ]);

          //   $('#participationHours thead').html(
          //     '<tr>' +
          //     '<th class="">Date</th>' +
          //     '<th>Activity</th>' +
          //     '<th class="participation-activitysource">Source</th>' +
          //     '<th class="participation-category">Category</th>' +
          //     '<th class="participation-category">Category</th>' +
          //     '<th>CREX</th>' +
          //     '<th>Hours</th>' +
          //     '<th>Submitted By</th>' +
          //     '<th>Approver</th>' +
          //     '<th class="not-mobile" rel="tooltip" data-html="true" data-original-title="' + tooltip + '">Status</th>' +
          //     '<th class="participation-termId">termId</th>' +
          //     '<th class="participation-termId">termId</th>' +
          //     '</tr>'
          //   )
          // }
        }
        table.clear();
        table = $('#participationHours').DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          ordering: true,
          // info: false,
          pagingType: "simple_numbers",
          dom: '<"row"<"col-md-4"l><"col-md-8 text-right"f>>t<"row"<"col-md-5"i><"col-md-7"p>>',
          oLanguage: {
            "sEmptyTable": "No data available"
          },
          language: {
            paginate: {
              next: '<i class="nc-icon nc-minimal-right">',
              previous: '<i class="nc-icon nc-minimal-left">'
            }
          },
          order: [
            [0, "desc"]
          ],
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          columnDefs: [{
              // width: '9%',
              width: '185px',
              targets: 0,
              className: "text-center"
            },
            {
              // width: '30.5%',
              responsivePriority: 1,
              width: '468px',
              targets: 1
            },
            {
              // width: '11%',
              width: '145px',
              targets: 2,
              className: "text-center"
            },
            {
              // width: '9%',
              width: '145px',
              targets: 3,
              className: "text-center"
            },
            {
              // width: '9%',
              visible: false,
              targets: 4
            },
            {
              // width: '8%',
              width: '120px',
              targets: 5,
              className: "text-center"
            },
            {
              // width: '8%',
              width: '120px',
              targets: 6,
              className: "text-right"
            },
            {
              // width: '15.5%',
              responsivePriority: 3,
              width: '237px',
              targets: 7
            },
            {
              // width: '15.5%',
              responsivePriority: 3,
              width: '237px',
              targets: 8
            },
            {
              // width: '9%',
              width: '120px',
              targets: 9,
              className: "text-center"
            },
            {
              targets: 10,
              visible: false,
            },
            {
              targets: 11,
              visible: false,
            },
          ],
          aoColumns: [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {
              "sType": "num-html"
            },
            null,
            null
          ],
          responsive: true
          // scrollX: true
        });


        var select = $(
            '<select id="participation-category-select" class="select-category"><option value="">All Categories</option></select>')
          .prependTo($('#participationHours_filter'))


        select.append($('<option value="10">PORE</option><option value="11">AISD</option><option value="12">CILE</option><option value="13">ACLE</option>'));



        var val = $('#participation-category-select').val();
        table.column(4)
          .search(val ? '^' + val + '$' : '', true, false)
          .draw();

        var select2 = $(
            '<select id="participation-term-select" class="select-category"><option value="">All Terms</option></select>')
          .prependTo($('#participationHours_filter'))

        createFilterV2(table, select2, 10, 11, 'none');

        var val1 = $('#participation-term-select').val();
        table.column(11)
          .search(val1 ? '^' + val1 + '$' : '', true, false)
          .draw();


        table.columns().every(function (index) {
          if (index == 11) {
            var that = this;

            select2.on('change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );

              that
                .search(val ? '^' + val + '$' : '', true, false)
                .draw();
            });

          }
        });

        table.columns().every(function (index) {
          if (index == 4) {
            var that = this;

            select.on('change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );

              that
                .search(val ? '^' + val + '$' : '', true, false)
                .draw();
            });

          }
        });

      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}


function pagerNumResize() {
  var width = $(window).width();
  if (width < 577) {
    $.fn.DataTable.ext.pager.numbers_length = 4;
  }
}




function getWeeklyMessage() {
  var url = 'ajax_php/a.connectCantoApi.php';
  $.ajax({
      url: url,
      type: 'POST',
      cache: false,
      dataType: 'json',
      data: {
        "format":"album",
        "folder": "NHMMS",
        "limit": 1
      }
    })
    .done(function (response) {
      if (response['results']) {
        //console.log(response);
        var vid = document.getElementById("dashboard-weeklyMessage-video");
        isSupp = vid.canPlayType("video/mp4");
        var recentVideo = response['results'][0].id;
        var videoSrc = "https://bodwell.canto.com/download/video/" + recentVideo + "/original";
        vid.src = videoSrc;
      }
    })
    .fail(function (response) {
      //console.log(response);
      // alert("error");
    })
}

function getHottopic(folder) {
  var url = 'ajax_php/a.connectCantoApi.php';
  $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: {
        "format":"album",
        "folder": folder,
        "limit": 10
      }
    })
    .done(function (response) {
      if (response['results']) {
        var results = response['results'];
        var html = '';
        for (var i = 0; i < results.length; i++) {
          var url = "";
          if (results[i].scheme == 'image') {
            url = 'https://bodwell.canto.com/preview/image/' + results[i].id + '/800';
            html += '<div class="carousel-item">' +
                      '<img src="'+url+'" class="d-block w-100" alt="...">'+
                    '</div>';
          } else {
            url = 'https://bodwell.canto.com/download/video/' + results[i].id + '/original'
            html = '<div class="carousel-item">' +
                    '<video class="video-fluid embed-responsive-item" controls width="100%">' +
                      '<source src="' + url + '" type="video/mp4"></source>' +
                    '</video>' +
                   '</div>'
          }


        }
        $('#carousel-hottopic .carousel-inner').html(html);
        $('#carousel-hottopic .carousel-inner .carousel-item').first().addClass('active');
      }
    })
    .fail(function (response) {
      //console.log(response);
      // alert("error");
    })
}

function getVideoPhotoGallery(folder) {
  var url = 'ajax_php/a.connectCantoApi.php';
  $.ajax({
      url: url,
      type: 'POST',
      cache: false,
      dataType: 'json',
      async:false,
      data: {
        "format":"album",
        "folder": folder,
        "limit" : 30
      }
    })
    .done(function (response) {
      if (response['results']) {
        //console.log(response['results']);
        mediaGallery = response['results'];
        var gallery_arr = [];
        var url = "";
        var result = response['results'];
        for (let i = 0; i < result.length; i++) {
          var playIcon = "";
          var duration = "";
          var duration_tag = "";
          var img_class = "";
          if (result[i].scheme == 'image') {
            url = 'https://bodwell.canto.com/preview/image/'+result[i].id+'/800';
          } else {
            url = result[i]['url'].directUrlPreview;
            // url = url.replace('video','image');
            playIcon = '<div class="playIcon-container"><i class="material-icons-outlined play-icon">play_circle_outline</i></div>'
            duration = convertToMin(result[i].default.Time);
            duration_tag = '<div class="duration-container">' + duration + '</div>';
          }

          if (parseInt(result[i].height) > parseInt(result[i].width)) {
            img_class = "gallery-img2";
          } else {
            img_class = "gallery-img";
          }

         var media_tags = "";
         if (result[i].tag.length > 0) {
           for (let j = 0; j < result[i].tag.length; j++) {
             media_tags += '#' + result[i].tag[j] + ' ';
           }
         }

          gallery_arr.push(
            '<div class="col-lg-3 col-md-4 col-6 justify-align-center">' +
              '<a href="#mediaModal" data-toggle="modal" data-target="#mediaModal" data-id="'+i+'" class="d-block mb-4 h-100 gallery media_modal">' +
              '<img class="' + img_class + '" src="' + url + '" alt="" id="pic' + i + '">' + playIcon + duration_tag +
              '<div class="folderName-container justify-align-center">' +
                '<div class="text-center width-80per">' +
                  // '<div class="font20">' + result[i].name + '</div>' +
                  '<div class="font20">' + result[i].description + '</div>' +
                '</div>' +
                // '<div class="row">' +
                //   '<div class="col-md-6 font12 text-center">' +
                //     '<div class="row"><div class="col-md-12">Upload Date</div><div class="col-md-12">' + result[i].default["Date Created"].substring(0, 10) + '</div></div>' +
                //   '</div>' +
                //   '<div class="col-md-6 font12 text-center">' +
                //     '<div class="row"><div class="col-md-12">File Size</div><div class="col-md-12">' + result[i].size + '</div></div>' +
                //   '</div>' +
                // '</div>' +
                '<div class="font12 width-80per text-center color-99c6fc">'+media_tags+'</div>'+
              '</div>' +

              '</a>' +
            '</div>'
          );
        }
        $('.gallery-container').html(gallery_arr);
      }
    })
    .fail(function (response) {
      //console.log(response);
      // alert("error");
    })
}

function getGalleryFolder(folder) {
  var url = 'ajax_php/a.connectCantoApiTree.php';
  $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      async:false,
      data: {
        "format":"folder",
        "folder": folder,
        "limit": 10
      }
    })
    .done(function (response) {
      var results = response['results'];
      console.log(results);
      var galleryFolder_arr = [];
      var res;
      for (let i = 0; i < results.length; i++) {
        var src = results[i]['url'].preview;

        if(src) {
          res = src.replace('/preview','').replace('api_binary/v1','preview');
        } else {
          res = 'https://bodwell.canto.com/preview/image/vsslt9jccp029fprlqhf7lou3f/800';
        }

        galleryFolder_arr.push(
          '<div class="col-lg-3 col-md-4 col-6 justify-align-center">' +
            '<a data-id="'+results[i].id+'" class="d-block mb-4 gallery-folder">' +
              '<img class="gallery-img" src="' + res + '/800" alt="" id="pic' + i + '">' +
              '<div class="folderName-container justify-align-start"><div class="border-white-4 font18 text-center width-80per">' + results[i].name + '</div></div>' +
            '</a>' +
          '</div>'
        );
      }
      $('.gallery-folder-container').html(galleryFolder_arr);
    })
    .fail(function (response) {
      //console.log(response);
    })
}

function getInvolvedStaff(SemesterID) {
  if (!SemesterID) {
    console.log('error');
    return;
  }
  $.ajax({
    url: 'ajax_php/a.GetInvolvedStaff.php',
    type: 'POST',
    dataType: "json",
    data: {
      "SemesterID": SemesterID
    },
    success: function (response) {
      console.log(response);
      if (response['status'] == 0) {
        console.log("IT")
      } else {
        var res = response.data[0];
        var teacherList = [];
        var nonCreTeacherList = [];
        var counselorList = [];
        var aclist = [];
        var advisorList = [];
        var principalList = [];

        var youthAdvisor2 = res.Hadvisor2.positionTitle;
        youthAdvisor2 = youthAdvisor2.replace('2', '');
        for (let i = 0; i < res.Teachers.length; i++) {
          var staffName = res.Teachers[i].teacherName;
          staffName = staffName.replace('YYY', '');
          staffName = staffName.replace('ZZZ', '');

          var courseName = res.Teachers[i].courseName;
          courseName = courseName.replace('YYY', '');
          courseName = courseName.replace('ZZZ', '');

          if (res.Teachers[i].courseType == 'N') {
            teacherList.push(
              '<div class="col-md-4 mg-t-10">' +
              '<img src="' + res.Teachers[i].imgsrc + '" class="img-xs staffImg" draggable="false"/>'+
              '<div><label>' + courseName + '</label></div>' +
              '<div><label>' + staffName + '</label></div>' +
              '</div>'
            )
          } else {
            nonCreTeacherList.push(
              '<div class="col-md-4 mg-t-10">' +
              '<img src="' + res.Teachers[i].imgsrc + '" class="img-xs staffImg" draggable="false"/>' +
              '<div><label>' + courseName + '</label></div>' +
              '<div><label>' + staffName + '</label></div>' +
              '</div>'
            )
          }
        }
        aclist.push(
          '<div class="col-md-4 mg-t-10">' +
          '<img src="' + res.Counselor.imgsrc + '" class="img-xs staffImg" draggable="false"/>' +
          '<div><label>' + res.Counselor.positionTitle + '</label></div>' +
          '<div><label>' + res.Counselor.fullName + '</label></div>' +
          '</div>'
        );
        aclist.push(
          '<div class="col-md-4 mg-t-10">' +
          '<img src="' + res.Hadvisor.imgsrc + '" class="img-xs staffImg" draggable="false"/>' +
          '<div><label>' + res.Hadvisor.positionTitle + '</label></div>' +
          '<div><label>' + res.Hadvisor.fullName + '</label></div>' +
          '</div>'
        );
        aclist.push(
          '<div class="col-md-4 mg-t-10">' +
          '<img src="' + res.Hadvisor2.imgsrc + '" class="img-xs staffImg" draggable="false"/>' +
          '<div><label>' + youthAdvisor2 + '</label></div>' +
          '<div><label>' + res.Hadvisor2.fullName + '</label></div>' +
          '</div>'
        );
        principalList.push(
          '<div class="col-md-6 mg-t-10">' +
          '<img src="' + res.Principal1.imgsrc + '" class="img-xs staffImg" draggable="false"/>' +
          '<div><label>' + res.Principal1.positionTitle + '</label></div>' +
          '<div><label>' + res.Principal1.fullName + '</label></div>' +
          '</div>'
        );
        principalList.push(
          '<div class="col-md-6 mg-t-10">' +
          '<img src="' + res.Principal2.imgsrc + '" class="img-xs staffImg" draggable="false"/>' +
          '<div><label>' + res.Principal2.positionTitle + '</label></div>' +
          '<div><label>' + res.Principal2.fullName + '</label></div>' +
          '</div>'
        );

        $('.credit-teacher').html(teacherList);
        $('.nonCredit-teacher').html(nonCreTeacherList);
        $('.counselorsnadvisors').html(aclist);
        $('.principal').html(principalList);

        $('.staffImg').on("error", function () {
          $(this).prop('src', 'img/user.png');
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function getTimeline(){
  $.ajax({
    url: 'ajax_php/a.GetTimeline.php',
    type: 'POST',
    dataType: "json",
    success: function (response) {
      if (response['status'] == 0) {
        console.log("IT")
      } else {
        var html = '';
        for (var i = 0; i < response.length; i++) {
          html += '<li class="custom-tl-item">'+
                  '<div class="custom-tl-badge primary"><i class="material-icons-outlined">assignment_ind</i></div>'+
                  '<div class="custom-tl-panel">'+
                    '<div class="custom-tl-heading">'+
                      '<h6 class="custom-tl-title">'+response[i].Title+'</h6>'+
                      '<p><small class="text-muted flex"><i class="material-icons-outlined font14 mg-r-5">'+
                            'calendar_today'+
                          '</i>'+
                          response[i].SDate+ ' ~ ' + response[i].EDate +
                        '</small></p>'+
                    '</div>'+
                    '<div class="custom-tl-body">'+
                      '<p>'+ response[i].Description +
                      '</p>'+
                    '</div>'+
                  '</div>'+
                '</li>';
        }
        $('.timeline-wrapper ul').html(html);

      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function getPastTermList() {
  $.ajax({
    url: 'ajax_php/a.GetPastTermList.php',
    type: 'POST',
    dataType: "json",
    async:false,
    success: function (response) {
      if (response['status'] == 0) {
        console.log("IT")
      } else {
        pastTermList = response;
        var option = '';
        for (var i = 0; i < response.length; i++) {
          option += '<option value="'+response[i].SemesterID+'">'+response[i].SemesterName+' - Term Ended</option>';
        }
        $('#pastterm-select').html(option);
      }
      $('.card-category').html(response[0].SemesterName + ' - Term Ended')
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function ajaxtoPastTermParticipation(SemesterID) {
  $.ajax({
    url: 'ajax_php/a.PastTermParticipationHours.php',
    type: 'POST',
    dataType: "json",
    data: {
      "SemesterID": SemesterID
    },
    success: function (response) {
      //console.log(response);
      var currentAISD = 0;
      var currentACLE = 0;
      var currentCILE = 0;
      var currentPORE = 0;
      var currentVLWE = 0;
      var currenthours = 0;

      $('.pastterm-PORE-C').html('');
      $('.pastterm-AISD-C').html('');
      $('.pastterm-CILE-C').html('');
      $('.pastterm-ACLE-C').html('');
      $('.pastterm-TOTAL-C').html('');
      $('.pastterm-VLWE-C').html('');

      for (var i = 0; i < response.length; i++) {
        var category = response[i].category;
        var termId = response[i].termId;
        var vlwe = response[i].VLWE;
        var hours = parseFloat(response[i].hours);
        var activityDate = response[i].activityDate;
          if (vlwe == 1) {
            currentVLWE += hours;
          }
          if (category == '10') {
            currentPORE += hours;
          } else if (category == '11') {
            currentAISD += hours;
          } else if (category == '12') {
            currentCILE += hours;
          } else if (category == '13') {
            currentACLE += hours;
          }
      }
      currenthours = currentPORE + currentAISD + currentCILE + currentACLE;
      $('.pastterm-PORE-C').html(currentPORE.toFixed(1));
      $('.pastterm-AISD-C').html(currentAISD.toFixed(1));
      $('.pastterm-CILE-C').html(currentCILE.toFixed(1));
      $('.pastterm-ACLE-C').html(currentACLE.toFixed(1));
      $('.pastterm-TOTAL-C').html(currenthours.toFixed(1));
      $('.pastterm-VLWE-C').html(currentVLWE.toFixed(1));
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function minimizeSidebar() {
  $('#minimizeSidebar').click(function () {
    if ($('body').hasClass('sidebar-mini')) {
      $('.logo').css('display', 'block');
      $('.user').css('display', 'none');
    } else {
      $('.logo').css('display', 'none');
      $('.user').css('display', 'block');
    }
  });
}

function ajaxtoAEPCourses(SemesterID) {
  $.ajax({
    url: 'ajax_php/a.MyAEPCourses.php',
    type: 'POST',
    dataType: "json",
    data: {
      "SemesterID": SemesterID
    },
    success: function (response) {
      console.log(response);
      var options = '';
      var careerChk;
      aepCoursesInfo = response['coursesInfo'];
      aepCourses = response['courses'];

      for (var i = 0; i < aepCoursesInfo.length; i++) {
        options += '<option value="' + aepCoursesInfo[i].SubjectID + '">'+aepCoursesInfo[i].SubjectName+'</option>';
      }
      $('#aep-subject').append(options);
      var val = $('#aep-subject').val();
      createAEPTable(aepCourses, val);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
  // only type p OR N = credit. except p Or N all non credit
}

function ajaxtoIAPRubric(SemesterID) {
  $.ajax({
    url: 'ajax_php/a.GetIAPRubric.php',
    type: 'POST',
    dataType: "json",
    data: {
      "SemesterID": SemesterID
    },
    success: function (response) {
      $('.iap-levelText').html(response[0].AEPLevel);
      $('.iap-stuName').html(getFullName(response[0].EnglishName, response[0].LastName, response[0].FirstName));
      $('#iap-tutoringInf').val(response[0].TInfo);
      $('#iap-comment').val(response[0].TComment);
      var EIOres = response[0].EIOClass.split(",");
      var ASres = response[0].ASupport.split(",");
      var res = EIOres.concat(ASres);
      for (var i = 0; i < res.length; i++) {
        $('input[value="'+res[i]+'"]:checkbox').attr('checked', 'checked');
      }

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
  // only type p OR N = credit. except p Or N all non credit
}

function createAEPTable(aepCourses, val) {
  var response = aepCourses[val];
  var aepObject = [
    {
      skill:"Reading",
      st1:convertNulltoNA(response.ST1Reading),
      pg1:convertNulltoNA(response.PG1Reading),
      pg2:convertNulltoNA(response.PG2Reading),
      mt:convertNulltoNA(response.MReading),
      pg3:convertNulltoNA(response.PG3Reading),
      pg4:convertNulltoNA(response.PG4Reading),
      st2:convertNulltoNA(response.ST2Reading),
      ft:convertNulltoNA(response.FReading),
    },
    {
      skill:"Writing",
      st1:convertNulltoNA(response.ST1Writing),
      pg1:convertNulltoNA(response.PG1Writing),
      pg2:convertNulltoNA(response.PG2Writing),
      mt:convertNulltoNA(response.MWriting),
      pg3:convertNulltoNA(response.PG3Writing),
      pg4:convertNulltoNA(response.PG4Writing),
      st2:convertNulltoNA(response.ST2Writing),
      ft:convertNulltoNA(response.FWriting),
    },
    {
      skill:"Speaking",
      st1:convertNulltoNA(response.ST1Speaking),
      pg1:convertNulltoNA(response.PG1Speaking),
      pg2:convertNulltoNA(response.PG2Speaking),
      mt:convertNulltoNA(response.MSpeaking),
      pg3:convertNulltoNA(response.PG3Speaking),
      pg4:convertNulltoNA(response.PG4Speaking),
      st2:convertNulltoNA(response.ST2Speaking),
      ft:convertNulltoNA(response.FSpeaking),
    },
    {
      skill:"Listening",
      st1:convertNulltoNA(response.ST1Listening),
      pg1:convertNulltoNA(response.PG1Listening),
      pg2:convertNulltoNA(response.PG2Listening),
      mt:convertNulltoNA(response.MListening),
      pg3:convertNulltoNA(response.PG3Listening),
      pg4:convertNulltoNA(response.PG4Listening),
      st2:convertNulltoNA(response.ST2Listening),
      ft:convertNulltoNA(response.FListening),
    },
    {
      skill:"Average All Skills",
      st1:calculateAEPAVG(response.ST1Reading, response.ST1Writing, response.ST1Speaking, response.ST1Listening),
      pg1:calculateAEPAVG(response.PG1Reading, response.PG1Writing, response.PG1Speaking, response.PG1Listening),
      pg2:calculateAEPAVG(response.PG2Reading, response.PG2Writing, response.PG2Speaking, response.PG2Listening),
      mt:calculateAEPAVG(response.MReading, response.MWriting, response.MSpeaking, response.MListening),
      pg3:calculateAEPAVG(response.PG3Reading, response.PG3Writing, response.PG3Speaking, response.PG3Listening),
      pg4:calculateAEPAVG(response.PG4Reading, response.PG4Writing, response.PG4Speaking, response.PG4Listening),
      st2:calculateAEPAVG(response.ST2Reading, response.ST2Writing, response.ST2Speaking, response.ST2Listening),
      ft:calculateAEPAVG(response.FReading, response.FWriting, response.FSpeaking, response.FListening),
    }
  ];
  var tr = '';
  for (var i = 0; i < aepObject.length; i++) {
    if (aepObject[i].skill=="Average All Skills") {
      tr += '<tr>' +
      '<td class="text-center font-weight-bold">'+aepObject[i].skill+'</td>'+
      ((aepObject[i].st1 == 'n/a')?'<td class="text-center naText">':'<td class="text-center font-weight-bold">')+aepObject[i].st1+'</td>' +
      ((aepObject[i].pg1 == 'n/a')?'<td class="text-center naText">':'<td class="text-center font-weight-bold">')+aepObject[i].pg1+'</td>' +
      ((aepObject[i].pg2 == 'n/a')?'<td class="text-center naText">':'<td class="text-center font-weight-bold">')+aepObject[i].pg2+'</td>' +
      ((aepObject[i].mt == 'n/a')?'<td class="text-center naText mt-td">':'<td class="text-center font-weight-bold mt-td">')+aepObject[i].mt+'</td>' +
      ((aepObject[i].pg3 == 'n/a')?'<td class="text-center naText">':'<td class="text-center font-weight-bold">')+aepObject[i].pg3+'</td>' +
      ((aepObject[i].pg4 == 'n/a')?'<td class="text-center naText">':'<td class="text-center font-weight-bold">')+aepObject[i].pg4+'</td>' +
      ((aepObject[i].st2 == 'n/a')?'<td class="text-center naText">':'<td class="text-center font-weight-bold">')+aepObject[i].st2+'</td>' +
      ((aepObject[i].ft == 'n/a')?'<td class="text-center naText ft-td">':'<td class="text-center font-weight-bold ft-td">')+aepObject[i].ft+'</td>' +
      '</tr>';
    } else {
      tr += '<tr>' +
    '<td class="text-center font-weight-bold">'+aepObject[i].skill+'</td>'+
    ((aepObject[i].st1 == 'n/a')?'<td class="text-center naText">':'<td class="text-center">')+aepObject[i].st1+'</td>' +
    ((aepObject[i].pg1 == 'n/a')?'<td class="text-center naText">':'<td class="text-center">')+aepObject[i].pg1+'</td>' +
    ((aepObject[i].pg2 == 'n/a')?'<td class="text-center naText">':'<td class="text-center">')+aepObject[i].pg2+'</td>' +
    ((aepObject[i].mt == 'n/a')?'<td class="text-center naText mt-td">':'<td class="text-center mt-td">')+aepObject[i].mt+'</td>' +
    ((aepObject[i].pg3 == 'n/a')?'<td class="text-center naText">':'<td class="text-center">')+aepObject[i].pg3+'</td>' +
    ((aepObject[i].pg4 == 'n/a')?'<td class="text-center naText">':'<td class="text-center">')+aepObject[i].pg4+'</td>' +
    ((aepObject[i].st2 == 'n/a')?'<td class="text-center naText">':'<td class="text-center">')+aepObject[i].st2+'</td>' +
    ((aepObject[i].ft == 'n/a')?'<td class="text-center naText ft-td">':'<td class="text-center ft-td">')+aepObject[i].ft+'</td>' +
    '</tr>';
    }

  }
  $('#datatable-aep tbody').html(tr);
}

function ajaxtoSemesterListForAssessments() {
  $.ajax({
    url: 'ajax_php/a.semesterListforAssessments.php',
    type: 'POST',
    async: false,
    dataType: "json",
    success: function (response) {
     console.log(response);
       $('.semester-assessments-list').append('<option value="all">All Terms</option></select>');
       for (var i = 0; i < response.length; i++) {
         let assessmentsID = response[i].AssessmentID;
         let title = response[i].Title;
         let semesterName = response[i].SemesterName;
         $('.semester-assessments-list').append(
           '<option value="' +
             assessmentsID +
             '">' +
             semesterName +
             "</option>"
         );
       }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function ajaxtoGetAssessmentsScore(){
  $.ajax({
    url: 'ajax_php/a.assessmentsScore.php',
    type: 'POST',
    async: false,
    dataType: "json",
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
      } else {
        globalAssessments = response;
        console.log(globalAssessments);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function generateAssessTable(globalAssessments, assessmentsID) {
  if(assessmentsID == 'all') {
    if(globalAssessments) {
      var tr = '';
      $('.assessments-info').html('');
      for (let i = 0; i < globalAssessments.length; i++) {
        tr += "<tr><td><span class='font-bold'>"+globalAssessments[i].SemesterName+"</span><br><span class='font12'>"+globalAssessments[i].DateFrom+"</span></td>" +
          "<td>"+chkNull(globalAssessments[i].ListeningScore)+"</td><td>"+chkNull(globalAssessments[i].ReadingScore)+"</td>"  +
          "<td>"+chkNull(globalAssessments[i].WritingScore)+"</td><td>"+chkNull(globalAssessments[i].WritingTask1)+"</td>"  +
          "<td>"+chkNull(globalAssessments[i].WritingTask2)+"</td><td class='font-bold'>"+chkNull(globalAssessments[i].OverallAverage)+"</td></tr>";
      }
      $('#datatable-assessments tbody').html(tr);
    } else {
      $('#datatable-assessments tbody').html('');
    }
  } else {
    var index;
    for (let i = 0; i < globalAssessments.length; i++) {
      if (globalAssessments[i].AssessmentID == assessmentsID) {
        index = i
      }
    }
    var tr = "<tr><td><span class='font-bold'>"+globalAssessments[index].SemesterName+"</span><br><span class='font12'>"+globalAssessments[index].DateFrom+"</span></td>" +
    "<td>"+chkNull(globalAssessments[index].ListeningScore)+"</td><td>"+chkNull(globalAssessments[index].ReadingScore)+"</td>"  +
    "<td>"+chkNull(globalAssessments[index].WritingScore)+"</td><td>"+chkNull(globalAssessments[index].WritingTask1)+"</td>"  +
    "<td>"+chkNull(globalAssessments[index].WritingTask2)+"</td><td class='font-bold'>"+chkNull(globalAssessments[index].OverallAverage)+"</td></tr>";
    $('#datatable-assessments tbody').html(tr);
    $('.assessments-info').html(globalAssessments[index].Title);
  }

}

function GetReportCard(type,colspan,sId){
  var studentOverallAvg = '';
  var midtermaepinfo =
  '<table width="720" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;">'+
  '<tr><td colspan="6">AEP achievement mid-term score explanatory notes:<br />'+
  '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;">'+
  '<tr><td valign="top">The student is:&nbsp;</td><td><table border="0" cellspacing="0" cellpadding="1" style="font-size:6pt;border: 1px solid;">'+
  '<tr><td>1</td><td>&nbsp;&nbsp;not meeting the expectations of the skill area</td></tr>'+
  '<tr><td>1.5</td><td>&nbsp;&nbsp;showing minimal progress in the skill area</td></tr>'+
  '<tr><td>2</td><td>&nbsp;&nbsp;progressing and demonstrating some improvements in the skill area</td></tr>'+
  '<tr><td>2.5</td><td>&nbsp;&nbsp;demonstrating steady improvement in the skill area</td></tr>'+
  '<tr><td>3</td><td>&nbsp;&nbsp;just meeting the expectations by demonstrating basic competence in the skill area</td></tr>'+
  '<tr><td>3.5</td><td>&nbsp;&nbsp;demonstrating stronger competence in the skill area</td></tr>'+
  '<tr><td>4</td><td>&nbsp;&nbsp;exceeding the expectations by demonstrating strong ability in the skill area</td></tr>'+
  '</table></td></tr></table></td></tr>'+
  '<tr><td colspan="6"><hr size="0.1" width="100%" color="Black"></td></tr></table>';

  var midtermsateinfo =
  '<table width="720" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;">'+
  '<tr><td colspan="6">'+
  'Sat E achievement mid-term score explanatory notes:<br>'+
  '<table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">'+
  '<tr><td>1 - Student is not meeting the expectations of the course.</td><td>3 - Student is almost meeting the expectations of the course.</td></tr>'+
  '<tr><td>2 - Student is progressing in the course.</td><td>4 - Student is meeting the expectations of the course.</td></tr>'+
  '</table></td></tr>'+
  '<tr><td colspan="6"><hr size="0.1" width="100%" color="Black"></td></tr>'+
  '</table>';

  var finaltermaepinfo =
  '<table width="720" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;">'+
  '<tr><td colspan="7"><hr size="0.1" width="100%" color="Black"></td></tr>'+
  '<tr><td colspan="7"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;"><tr><td colspan="2">AEP achievement mid-term score explanatory notes:</td><td width="34%">AEP achievement final average score:</td></tr>'+
  '<tr><td valign="top">The student is:&nbsp;</td><td><table border="0" cellspacing="0" cellpadding="1" style="font-size:6pt;border: 1px solid;">'+
  '<tr><td>1</td><td>&nbsp;&nbsp;not meeting the expectations of the skill area</td></tr>'+
  '<tr><td>1.5</td><td>&nbsp;&nbsp;showing minimal progress in the skill area</td></tr>'+
  '<tr><td>2</td><td>&nbsp;&nbsp;progressing and demonstrating some improvements in the skill area</td></tr>'+
  '<tr><td>2.5</td><td>&nbsp;&nbsp;demonstrating steady improvement in the skill area</td></tr>'+
  '<tr><td>3</td><td>&nbsp;&nbsp;just meeting the expectations by demonstrating basic competence in the skill area</td></tr>'+
  '<tr><td>3.5</td><td>&nbsp;&nbsp;demonstrating stronger competence in the skill area</td></tr>'+
  '<tr><td>4</td><td>&nbsp;&nbsp;exceeding the expectations by demonstrating strong ability in the skill area</td></tr>'+
  '</table></td><td valign="top"><table border="0" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">'+
  '<tr><td>1-2.88</td><td>: I</td><td width="15">&nbsp;</td><td>3-3.38</td><td>: C pass</td><td width="15">&nbsp;</td><td>3.5-3.75</td><td>: B</td><td width="15">&nbsp;</td><td>3.88-4</td><td>: A</td></tr>'+
  '</table></td></tr></table></td></tr>'+
  '<tr><td colspan="7"><hr size="0.1" width="100%" color="Black"></td></tr></table>';


  var finaltermsateinfo =
  '<table width="720" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;">'+
  '<tr><td colspan="7">'+
  'Sat E achievement final score explanatory notes:<br>'+
  '<table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">'+
  '<tr><td>1 - Student is not meeting the expectations of the course.</td><td>3 - Student is almost meeting the expectations of the course.</td></tr>'+
  '<tr><td>2 - Student is progressing in the course.</td><td>4 - Student is meeting the expectations of the course.</td></tr>'+
  '</table></td></tr>'+
  '<tr><td colspan="7"><hr size="0.1" width="100%" color="Black"></td></tr></table>';



  $.ajax({
    url: 'ajax_php/a.GetReportCard.php',
    type: 'POST',
    async: false,
    dataType: "json",
    data: {
      sId:sId
    },
    success: function (response) {
      console.log(response);
      if (response.result == 0) {
        console.log("IT");
      } else {
        var aepInfo;
        var sateInfo;
        var comment;
        var tAbsense = '';
        var tLate = '';
        var Mark = '';
        var LetterGrade = '';
        var tr='';
        var SReading = '';
        var SWriting = '';
        var SSpeaking = '';
        var SListening = '';
        var AReading = '';
        var AWriting = '';
        var ASpeaking = '';
        var AListening = '';
        var credit = '';
        var totalMark = 0;
        var totalReg = 0;
        var RMark = '';
        var RFMark = '';
        var gpaCredit = 0;
        var totalCredit = 0;
        var gpa = '';
        var ltrGradeNotinclude = ["E", "L", "N/A", "NC", "NM", "RM", "W"];
        var gradeNotinclude = ["",-1];
        var pAttended = "";

        for(var i in response){
          var s = response[i].StartDate;
          var m = response[i].MidCutOffDate;
          var e = response[i].EndDate;
          var n = response[i].SemesterName;
          if(type == 'Mid'){
            $('.termInfo').html('<b>'+n.slice(0,-4)+'Term: </b>'+s+' - '+m);

            aepInfo = midtermaepinfo;
            sateInfo = midtermsateinfo;

            tAbsense = response[i].MAbsence - response[i].MExcuse;
            tLate = response[i].MLate;
            Mark = response[i].GradeMidterm.replace(/\s+/g, '');
            LetterGrade = response[i].LtrGradeMidterm;
            comment = response[i].CommentMidterm;
            comment = comment.replace(/\n/g, "<br />");


            credit = ' ('+ response[i].Credit * 4 + ' credits)' ;
            pAttended = response[i].PAttended;
            if(Mark < 0) {
              RMark = '';
            } else {
              RMark = Mark + '%'
            }

            if(i.includes('AEP')){
              AReading = response[i].MReading;
              AWriting = response[i].MWriting;
              ASpeaking = response[i].MSpeaking;
              AListening = response[i].MListening;
              $('.aepBasicInfo_1').html(aepInfo);
              var aepGradeTable =
               `<table width="200" border="1" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
               <tr align="center"><td width="50">Reading</td><td width="50">Writing</td><td width="50">Speaking</td><td width="50">Listening</td></tr>
               <tr align="center" height="11"><td>`+AReading+`</td><td>`+AWriting+`</td><td>`+ASpeaking+`</td><td>`+AListening+`</td></tr>
               </table>`;
              RMark = 'N/A';
              LetterGrade = 'N/A';
              credit = '';
            } else {
              var aepGradeTable = '';
            }

            if(i.includes('Saturday')){
              $('.sateBasicInfo_1').html(sateInfo);
              RMark = '';
              LetterGrade = '';
              SReading = response[i].MReading;
              SWriting = response[i].MWriting;
              SSpeaking = response[i].MSpeaking;
              SListening = response[i].MListening;
              var sateGradeTable =
               `<table width="200" border="1" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
               <tr align="center"><td width="50">Mindset</td><td width="50">Progress</td><td width="50">Participation</td><td width="50">Work Habits</td></tr>
               <tr align="center" height="11"><td>`+SReading+`</td><td>`+SWriting+`</td><td>`+SSpeaking+`</td><td>`+SListening+`</td></tr>
               </table>`;
               credit = '';
            } else {
              var sateGradeTable = '';
            }

            if(i.includes('ZZZ')){
              tAbsense = '';
              tLate = '';
              RMark = '';
              LetterGrade = '';
              credit = '';
            }

            // totalMark += parseFloat(Mark);
            if(response[i].Credit > 0) {
              if(!ltrGradeNotinclude.includes(LetterGrade.replace(/\s+/g, '')) && Mark >= 0 && Mark !== ''){
                totalReg += 1;
                totalMark += parseFloat(Mark);
                totalCredit += parseFloat(response[i].Credit);
                gpaCredit += calculateGPA(response[i].Credit, LetterGrade);
              }
            }

            tr +=
            `<tr align="center"><td align="left" style="font-weight:bold;">`+response[i].SubjectName.replace("ZZZ", "Co-curricular: ")+`</td><td>`+aepGradeTable+sateGradeTable+`</td><td><span class="td_span">`+tAbsense+`</span></td><td><span class="td_span">`+tLate+`</span></td><td><span class="td_span">`+RMark+`</span></td><td><span class="td_span">`+LetterGrade+`</span></td></tr>`+
            `<tr><td valign="top" style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`+response[i].LastName+`, `+response[i].FirstName+credit+`</td></tr>`+
            `<tr><td colspan="`+colspan+`">`+comment+`</td></tr>`+
            `<tr><td colspan="`+colspan+`"><hr size="0.1" width="100%" color="Black"></td></tr>`;

          } else {
            $('.termInfo').html('<b>'+n.slice(0,-4)+'Term: </b>'+s+' - '+e);

            aepInfo = finaltermaepinfo;
            sateInfo = finaltermsateinfo;
            comment = response[i].CommentFinal;
            comment = comment.replace(/\n/g, "<br />");

            tAbsense = parseInt(response[i].MAbsence + response[i].FAbsence) - parseInt(response[i].MExcuse + response[i].FExcuse);
            tLate = parseInt(response[i].MLate + response[i].FLate);
            Mark = response[i].GradeFinal.replace(/\s+/g, '');
            FMark = response[i].GradeFinal.replace(/\s+/g, '');
            MMark = response[i].GradeMidterm.replace(/\s+/g, '');
            LetterGrade = response[i].LtrGradeFinal;
            credit = ' ('+ response[i].Credit * 4 + ' credits)' ;

            if(MMark < 0) {
              RMark = '';
            } else {
              RMark = MMark + '%'
            }
            if(FMark < 0) {
              RFMark = '';
            } else {
              RFMark = FMark + '%'
            }

            if(i.includes('AEP')){
              var MReading = response[i].MReading;
              var MWriting = response[i].MWriting;
              var MSpeaking = response[i].MSpeaking;
              var MListening = response[i].MListening;

              var FReading = response[i].FReading;
              var FWriting = response[i].FWriting;
              var FSpeaking = response[i].FSpeaking;
              var FListening = response[i].FListening;
              var FAvg = (FReading + FWriting + FSpeaking +FListening) / 4;
              $('.aepBasicInfo_1').html(aepInfo);
              var aepGradeTable =
               `<table width="260" border="1" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
                <tbody><tr><td colspan="2">&nbsp;</td><td colspan="2">Reading</td><td colspan="2">Writing</td><td colspan="2">Speaking</td><td colspan="2">Listening</td><td>Final Average Score</td></tr>
                <tr><td>Mid-term</td><td style="font-size:7pt;font-weight:bold;">Final</td><td>`+MReading+`</td><td style="font-size:7pt;font-weight:bold;">`+FReading+`</td><td>`+MWriting+`</td>
                <td style="font-size:7pt;font-weight:bold;">`+FWriting+`</td><td>`+MSpeaking+`</td><td style="font-size:7pt;font-weight:bold;">`+FSpeaking+`</td><td>`+MListening+`
                </td><td style="font-size:7pt;font-weight:bold;">`+FListening+`</td><td style="font-size:7pt;font-weight:bold;">`+FAvg+`</td></tr>
                </tbody></table>`;
              RMark = 'N/A';
              RFMark = FAvg;
              LetterGrade = 'N/A';
              credit = '';
            } else {
              var aepGradeTable = '';
            }

            if(i.includes('Saturday')){
              $('.sateBasicInfo_1').html(sateInfo);
              RMark = '';
              RFMark = '';
              LetterGrade = '';
              var MReading = response[i].MReading;
              var MWriting = response[i].MWriting;
              var MSpeaking = response[i].MSpeaking;
              var MListening = response[i].MListening;

              var FReading = response[i].FReading;
              var FWriting = response[i].FWriting;
              var FSpeaking = response[i].FSpeaking;
              var FListening = response[i].FListening;
              var sateGradeTable =
               `<table width="250" border="1" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
                <tbody><tr align="center"><td colspan="2">&nbsp;</td><td colspan="2">Mindset</td><td colspan="2">Progress</td><td colspan="2">Participation</td><td colspan="2">Work Habits</td></tr>
                <tr align="center"><td>Mid-term</td><td style="font-size:7pt;font-weight:bold;">Final</td>
                <td>`+MReading+`</td><td style="font-size:7pt;font-weight:bold;">`+FReading+`</td><td>`+MWriting+`</td><td style="font-size:7pt;font-weight:bold;">`+FWriting+`
                </td><td>`+MSpeaking+`</td><td style="font-size:7pt;font-weight:bold;">`+FSpeaking+`</td><td>`+MListening+`
                </td><td style="font-size:7pt;font-weight:bold;">`+FListening+`</td></tr>
                </tbody></table>`;
               credit = '';
            } else {
              var sateGradeTable = '';
            }

            if(i.includes('ZZZ')){
              tAbsense = '';
              tLate = '';
              RMark = '';
              LetterGrade = '';
              credit = '';
            }

            // totalMark += parseFloat(Mark);
            if(response[i].Credit > 0) {
              if(!ltrGradeNotinclude.includes(LetterGrade.replace(/\s+/g, '')) && Mark >= 0 && Mark !== ''){
                totalReg += 1;
                totalMark += parseFloat(Mark);
                totalCredit += parseFloat(response[i].Credit);
                gpaCredit += calculateGPA(response[i].Credit, LetterGrade);
              }
            }





            tr +=
            `<tr align="center"><td align="left" style="font-weight:bold;">`+response[i].SubjectName.replace("ZZZ", "Co-curricular: ")+`</td><td>`+aepGradeTable+sateGradeTable+`</td><td><span class="td_span">`+tAbsense+`</span></td><td><span class="td_span">`+tLate+`</span></td><td><span class="td_span">`+RMark+`</span></td><td><span class="td_span">`+RFMark+`</span></td><td><span class="td_span">`+LetterGrade+`</span></td></tr>`+
            `<tr><td valign="top" style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`+response[i].LastName+`, `+response[i].FirstName+credit+`</td></tr>`+
            `<tr><td colspan="`+colspan+`">`+comment+`</td></tr>`+
            `<tr><td colspan="`+colspan+`"><hr size="0.1" width="100%" color="Black"></td></tr>`;
          }

        }

        studentOverallAvg = totalMark / totalReg;
        if(studentOverallAvg){
          var studentOverallAvgLetter = getGradeLetter(Math.round(studentOverallAvg)/100);
          var studentOverallAvgTxt = Math.round(studentOverallAvg) + '%' + ' ('+studentOverallAvgLetter+')';
        }


        if(gpaCredit){
          gpa = roundToTwo(gpaCredit/totalCredit);
        }
        var bottom =
        `<table width="720" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;">`+
        `<tr><td>&nbsp;</td></tr>`+
        `<tr><td rowspan="6" valign="bottom"><img src="https://admin.bodwell.edu/BHS/staffimages/F0627sig.jpg" alt="" border="0"><br>_______________________________________<br>Principal's Signature:</td><td>&nbsp;</td></tr>`+
        `<tr><td>&nbsp;</td></tr>`+
        `<tr><td colspan="4" align="right">Student Overall Average:</td><td align="center" colspan="2">`+studentOverallAvgTxt+`</td></tr>`+
        `<tr class="tr_Gpa"><td colspan="3">&nbsp;</td><td align="right">GPA: </td><td colspan="2" align="center">`+gpa+`</td></tr>`+
        `<tr><td></td></tr>`+
        `<tr><td>&nbsp;</td></tr>`+
        `</table><br>`+
        `<table width="575" border="1" cellspacing="0" cellpadding="0">`+
        `<tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">`+
        `<tr><td colspan="8" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Grades are awarded on the following approved B.C. Ministry of Education Scale:</td></tr>`+
        `<tr><td>&nbsp;&nbsp;&nbsp;A</td><td>: 86 - 100%</td><td>C</td><td>: 60 - 66%</td><td>W</td><td>: Withdrew</td><td>RM</td><td>: Requirements Met</td></tr>`+
        `<tr><td>&nbsp;&nbsp;&nbsp;B</td><td>: 73 - 85%</td><td>C-</td><td>: 50 - 59%</td><td></td><td></td><td>NM</td><td>: Requirements Not Met</td></tr>`+
        `<tr><td>&nbsp;&nbsp;&nbsp;C+</td><td>: 67 - 72%</td><td>I</td><td>: In Progress</td><td>F</td><td>: 0 - 49%</td><td>L</td><td colspan="2">: Left School</td></tr>`+
        `<tr><td align="center" colspan="10" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Bodwell Honour Roll Standing is 86% (A) average or greater in 3 or more courses</td></tr>`+
        `</table></td></tr></table>`;
        $(tr).appendTo('.courseTbl tbody');
        $('.overallDiv').html(bottom);
        if(pAttended.includes('AEP')){
          $('.tr_Gpa').hide();
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}




function getSelfAssessments() {
  var eData = [];
  var term = $("#sAssessments-term-select").val();
  console.log(term);
  $.ajax({
    url: "ajax_php/a.getSelfAssessments.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      selfAssessmentsResponse = response;
      var tr;
      if (response.result == 0) {
        tr = '<tr><td class="text-center" colspan="6">No Record</td></tr>';
        $('#datatables-selfAssessments tbody').html(tr);
      } else {
        console.log(response);
        for (let i = 0; i < response.length; i++) {
          var LastName = response[i].LastName;
          var FirstName = response[i].FirstName;
          var EnglishName = response[i].EnglishName;
          var fullName;
          if (EnglishName) {
            fullName =
              FirstName + " (" + EnglishName + ") " + LastName;
          } else {
            fullName = FirstName + " " + LastName;
          }


          var title =
            '<a href="" data-id="' +
            response[i].AssessmentID +
            '"data-name="' +
            fullName +
            '"data-grade="' +
            response[i].CurrentGrade +
            '" data-toggle="modal" class="selfAssessmentsMdlLink">' +
            fullName +
            "</a>";
          eData.push([
            response[i].CreateDate,
            response[i].SemesterName,
            response[i].StudentID,
            title,
            response[i].CurrentGrade,
            response[i].ModifyDate,
            response[i].SemesterID,
          ]);
        }
        table = $("#datatables-selfAssessments").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          // responsive: true,
          scrollX: true,
          order: [
            [0, "desc"]
          ],
          pagingType: "simple_numbers",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="nc-icon nc-minimal-right">', // or '→'
              previous: '<i class="nc-icon nc-minimal-left">', // or '←'
            },
          },
          columnDefs: [{
              width: "10%",
              targets: 0,
            },{
              width: "10%",
              targets: 1,
            },{
              width: "10%",
              targets: 2,
            },{
              width: "10%",
              targets: 4,
            },{
              width: "10%",
              targets: 5,
            },{
              visible: false,
              targets: 6,
            }],
        });


        table.column(1).every(function () {
          var that = this;

          // Create the select list and search operation
          var select = $('<select id="sAssessments-term-select" class="form-control" />')
            .prependTo(".semester_filter")
            .on("change", function () {
              that.search($(this).val()).draw();
            });

          // Get the search data for the first column and add to the select list
          select.append($('<option value="">All Terms</option>'));

          this.cache("search")
            .sort()
            .unique()
            .each(function (d) {
              select.append($('<option value="' + d + '">' + d + "</option>"));
            });
        });

      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function chkReportCardEligible(feetype,amount){
  $.ajax({
    url: 'ajax_php/a.getOutstandingFee.php',
    type: 'POST',
    dataType: 'json',
    data: {
      FeeType: feetype,
      Amount : amount
    },
    success: function (response) {
      console.log(response['Eligible']);
      if(response['result'] == 0){
        console.log('No Data');
        location.href = "?page=reportcard";
      } else {
        if(response['Eligible'] == 'No') {
          swal({
            title: "Report card not available for viewing",
            text: "Please contact your child's counsellor or our Registration Officer",
            buttonsStyling: false,
            confirmButtonClass: "btn btn-success",
            type: "error"
          }).then(function () {
            location.href = "?page=reportcard";
          })
          .catch(swal.noop);

        } else {

        }
      }

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function GetReportCardSemester() {
  $('#reportcardTerm').html('');
  var select = '';
  $.ajax({
    url: 'ajax_php/a.GetReportCardSemester.php',
    type: 'POST',
    dataType: 'json',
    success: function (response) {
      console.log(response);
      if(response.result == 0){
        console.log('No DATA');
      } else {
        for (var i = 0; i < response.length; i++) {
          select += '<option value="'+response[i].SemesterID+'">'+response[i].SemesterName+'</option>';
        }
        $('#reportcardTerm').html('<option value=""></option>'+select);
      }

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}
