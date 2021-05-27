<?php

session_start();

require_once 'sql.php';
require_once 'sendEmailClass.php';
require_once 'image.php';

class mychildPortalClass extends DBController {
    function getSql($name) {
        global $_SQL;
        return $_SQL[$name];
    }
    public function login($userID, $userPW, $chk, $staffId){
      $sql = $this->getSql('get-user-auth');
      $sql = str_replace('{LoginID}', $userID, $sql);
      // print_r($sql);
      $stmt = $this->db->prepare($sql);
      // $stmt->bindParam(1, $userID);
      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $tmp = array();
            if($userPW == $row["password"]){
              $tmp["status"] = "0";
              $tmp["studentId"] = $row["studentId"];
              $_SESSION['LoginIDParent'] = $row["LoginIDParent"];
              $_SESSION['studentId'] = $row["studentId"];
              $_SESSION['PEN'] = $row["PEN"];
              $_SESSION['studentLastName'] = $row["LastName"];
              $_SESSION['studentFirstName'] = $row["FirstName"];
              $_SESSION['studentEngName'] = $row["EnglishName"];
              $_SESSION['CurrentGrade'] = $row['CurrentGrade'];
              $_SESSION['Mentor'] = $row['Mentor'];
              $str = strstr($row['CurrentGrade'], "AEP");
              if($str == false){
                $_SESSION['AEP'] = 'N';
              } else {
                $_SESSION['AEP'] = 'Y';
              }
              $c = new mychildPortalClass();
              $authlog = $c->insertUserAuthLog($userID, $row["studentId"], 'current_student_parent', 'parent_web', $chk, $staffId );
              $tmp["query"] = $authlog;
            } else {
              $tmp["status"] = "1";
            }
            array_push($response, $tmp);
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

  public function insertUserAuthLog($username, $studentid, $usercategory, $appsystem, $chk, $staffId){
      $ip = $this->getUserIpAddr();
      $date = date("Y-m-d H:i:s");
      $query = $this->getSql('insert-user-auth-log');
      $query = str_replace('{Username}', $username, $query);
      $query = str_replace('{StudentID}', $studentid, $query);
      $query = str_replace('{UserCategory}', $usercategory, $query);
      $query = str_replace('{AppSystem}', $appsystem, $query);
      $query = str_replace('{UserIPAddress}', $ip, $query);
      $query = str_replace('{InternalStaff}', $chk, $query);
      $query = str_replace('{StaffID}', $staffId, $query);
      $query = str_replace('{CreateDate}', $date, $query);
      $stmt = $this->db->prepare($query);

      if ($stmt->execute()) {
          $response = array();
          $tmp = array();
          $tmp['query'] = $query;
          array_push($response, $tmp);
         return $response;
      } else {
          return NULL;
      }
  }

    public function studentInfo(){
      $query = $this->getSql('student-info');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $_SESSION['studentId']);
      $stmt->bindParam(2, $_SESSION['SemesterID']);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $response[] = $row;
            $src = "https://asset.bodwell.edu/OB4mpVpg/student/bhs".$_SESSION['studentId'].".jpg";
            $response[0]['imgsrc'] = $src;
            $_SESSION['numTerms'] = $row['numTerms'];
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function currentTerm(){
       $query = $this->getSql('find-currentsemester');
       $stmt = $this->db->prepare($query);
       if ($stmt->execute()) {
           while ($row = $stmt->fetch()) {
             $tmp = array();
             $response[] = $row;
             $_SESSION['SemesterID'] = $row['SemesterID'];
             $startDate = $row['StartDate'];
             $_SESSION['StartDate'] = $startDate;
             $_SESSION['NextStartDate'] = $row['NextStartDate'];
             $midCutoffDate = $row['MidCutOffDate'];
             $endDate = $row['EndDate'];
             $_SESSION['MidCutOffDate'] = $midCutoffDate;
             $_SESSION['EndDate'] = $endDate;
             $today = date('Y-m-d');
             $t = '';
             if ($today < $startDate){
               $txt = "Term Not Started";
               $t = 'mid';
             } elseif ($today >= $startDate && $today < $midCutoffDate) {
               $txt = "First half of term in progress";
               $t = 'mid';
             } elseif ($today >= $midCutoffDate && $today <= $endDate) {
               $txt = "Second half of term in progress";
               $t = 'fin';
             } else {
               $txt = "End of Term";
               $t = 'fin';
             }
             $response['text'] = $txt;
             $_SESSION['SemesterName'] = $row['SemesterName'];
             $_SESSION['termStatus'] = $txt;
             $_SESSION['reportTerm'] = $t;
           }
          return $response;
       } else {
           return NULL;
       }
       $stmt->close();
     }

    public function EnrollTerm($EnrollmentDate){
      $query = $this->getSql('find-Enrollmentsemester');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $EnrollmentDate);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function NumberOfTerm(){
      $query = $this->getSql('num-terms-by-id');
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $response[] = $row;
            $_SESSION['SemesterID'] = $row['SemesterID'];
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function GetMyGrades($SemesterID){
        // $query = $this->getSql('course-grade-list');
        $studentid = $_SESSION['studentId'];
        $sql = $this->getSql('course-grade-list');
        $sql = str_replace('{termId}', $SemesterID, $sql);
        $sql = str_replace('{studentId}', $studentid, $sql);

        $stmt = $this->db->prepare($sql);

        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
              $tmp = array();
              $response[] = $row;
            }
           return $response;
        } else {
            return NULL;
        }
        $stmt->close();
    }


    public function GetMyCourses($SemesterID){
      $query = $this->getSql('course-list');
      $stmt = $this->db->prepare($query);
      $studentid = $_SESSION['studentId'];
      $stmt->bindParam(1, $SemesterID);
      $stmt->bindParam(2, $studentid);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['courses'][] = $row;
            $studentCourseId[] = $row['studentCourseId'];
          }
          $c = new mychildPortalClass();
          $absenselateResponse = $c->GetMyAbsenseLate($studentCourseId);
          if($absenselateResponse){
            $response_final = array_merge($response,$absenselateResponse);
          } else {
            $response_final = $response;
          }

         return $response_final;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function GetMyAEPCourses($SemesterID){
      $query = $this->getSql('course-aep-list');
      $stmt = $this->db->prepare($query);
      $studentid = $_SESSION['studentId'];
      $stmt->bindParam(1, $studentid);
      $stmt->bindParam(2, $SemesterID);
      if ($stmt->execute()) {
        $i = 0;
          while ($row = $stmt->fetch()) {
            $response['courses'][$row['SubjectID']] = array_map('utf8_encode', $row);
            $response['coursesInfo'][$i]['SubjectID'] = $row['SubjectID'];
            $response['coursesInfo'][$i]['SubjectName'] = $row['SubjectName'];
            $i++;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function GetMyAbsenseLate($studentCourseId){
      if($studentCourseId) {
          $courseList = array();
          foreach($studentCourseId as $courseId) {
              $courseList[] = "'{$courseId}'";
          }
          $query = $this->getSql('absent-list-by-courselist');
          $query = str_replace('{studentCourseList}', implode(',', $courseList), $query);
          $stmt = $this->db->prepare($query);
          if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
              $response['Absense'][] = $row;
            }
             return $response;
          } else {
              return NULL;
          }

          if(!empty($this->db->errorInfo())){
            return array();
          }

          $stmt->close();

      } else {
          return array();
      }
    }

    public function GetPaticipationHours(){
      $query = $this->getSql('student-activity-list-v2');
      $stmt = $this->db->prepare($query);
      $studentid = $_SESSION['studentId'];
      $stmt->bindParam(1, $studentid);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = array_map('utf8_encode', $row);
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetGradeBySubject(){
      $query = $this->getSql('grade-list-by-student');
      $stmt = $this->db->prepare($query);
      $studentid = $_SESSION['studentId'];
      $SemesterID = $_SESSION['SemesterID'];
      $stmt->bindParam(1, $SemesterID);
      $stmt->bindParam(2, $studentid);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['grade'][] = $row;
            $courseIdArr[] = $row['courseId'];
          }
          $c = new mychildPortalClass();
          $courseAvg = $c->GetItemAverage($courseIdArr);
          $response_final = array_merge($response,$courseAvg);
         return $response_final;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetItemAverage($courses){
      if($courses) {
          $courseList = array();
          foreach($courses as $courseId) {
              $courseList[] = "'{$courseId}'";
          }
          $query = $this->getSql('item-average-list');
          $query = str_replace('{subjectid}', implode(',', $courseList), $query);
          $stmt = $this->db->prepare($query);

          if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
              $response['Avg'][] = $row;
            }
             return $response;
          } else {
              return NULL;
          }
          $stmt->close();

      } else {
          return array();
      }
    }

    public function GetMyParticipation(){

      $query = $this->getSql('student-activity-list-v4');
      $stmt = $this->db->prepare($query);
      $studentid = $_SESSION['studentId'];
      $SemesterID = $_SESSION['SemesterID'];
      // $StartDate = $_SESSION['StartDate'];
      $StartDate = '2018-01-02';
      $stmt->bindValue(1, $studentid);
      $stmt->bindValue(2, $StartDate);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = array_map('utf8_encode', $row);
          }
          // $response = array_map('utf8_encode', $response);

         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }


    public function GetCategoryName($category) {
      $categoryName;
      if ($category == '10') {
        $categoryName = 'Physical, Outdoor & Recreation Education';
      } else if ($category == '11') {
        $categoryName = 'Academic, Interest & Skill Development';
      } else if ($category == '12') {
        $categoryName = 'Citizenship, Interaction & Leadership Experience';
      } else if ($category == '13') {
        $categoryName = 'Arts, Culture & Local Exploration';
      }  else {
        $categoryName = 'err';
      }
      return $categoryName;
    }

    public function GetApprovalList(){
      $query = $this->getSql('approval-list');
      $stmt = $this->db->prepare($query);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetAllSchoolActivity(){
      $query = $this->getSql('school-activity-list');
      $SemesterID = $_SESSION['SemesterID'];
      $query=str_replace('{termId}', $SemesterID,$query);
      $stmt = $this->db->prepare($query);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

      public function GetDetailOfActivity($ActivityID){
      $query = $this->getSql('activity-detail');
      $SemesterID = $_SESSION['SemesterID'];
      $query=str_replace('{termId}', $SemesterID,$query);
      $query=str_replace('{activityId}', $ActivityID,$query);
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetNumOfActivityJoined($ActivityID){
      $query = $this->getSql('chk-activity-join');
      $stmt = $this->db->prepare($query);
      $SemesterID = $_SESSION['SemesterID'];
      $studentid = $_SESSION['studentId'];

      $stmt->bindParam(1, $studentid);
      $stmt->bindParam(2, $SemesterID);
      $stmt->bindParam(3, $ActivityID);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getStaffEmailbyId($staffId){
      $query = $this->getSql('get-staff-email-by-id');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $staffId);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function getSemesterIDFromSDate($sDate) {
      $query = $this->getSql('find-semesterid-date');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(1, $sDate);
      $stmt->bindValue(2, $sDate);
      if ($stmt->execute()) {
        $row = $stmt->fetch();
        return $row['SemesterID'];
      } else {
        return '999';
      }
      $stmt->close();
    }

    function getListCareerSubject($SemesterID) {
      $query = $this->getSql('get-list-career-subject');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $SemesterID);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['data'][] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function getListCareer($SemesterID) {
      $query = $this->getSql('get-career-path');
      $stmt = $this->db->prepare($query);
      $studentid = $_SESSION['studentId'];
      $stmt->bindParam(1, $studentid);
      $stmt->bindParam(2, $SemesterID);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['data'][] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }


    public function GetSubjectInfo($course, $SemesterID, $studentid) {
      $query = $this->getSql('get-subject-info');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $SemesterID);
      $stmt->bindParam(2, $studentid);
      $stmt->bindParam(3, $course);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getInvolvedStaff($SemesterID){
      $studentId = $_SESSION['studentId'];
      $query = $this->getSql('involve-staff-list');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam("studentId", $studentId);
      /*** status 0 => no record , status 1 => successful ***/
      if ($stmt->execute()) {
        $count = $stmt->rowCount();
        if($count == 0) {
          $data['status'] = '0';
          $data['message'] = 'no record';
        } else {
            $data['status'] = '1';
            $data['message'] = 'Success';
            $data['readme'] = '';
            $data['today'] = date('Y-m-d');
            $row = $stmt->fetch();

            $teacherQuery = $this->getSql('teacher-involved-list');
            $tstmt = $this->db->prepare($teacherQuery);
            $tstmt->bindParam("SemesterID", $SemesterID);
            $tstmt->bindParam("studentId", $studentId);
            if ($tstmt->execute()) {
              while ($tRow = $tstmt->fetch()) {
                if($tRow['teacherId']){
                  $teacherimgsrc = "https://asset.bodwell.edu/OB4mpVPg/staff/".$tRow['teacherId'].".jpg";
                } else {
                  $teacherimgsrc = '';
                }

                $data['data'][0]['Teachers'][] = array(
                    'teacherName' => $tRow['teacherName'],
                    'courseName' => $tRow['courseName'],
                    'teacherId' => $tRow['teacherId'],
                    'courseType' => $tRow['courseType'],
                    'imgsrc' => $teacherimgsrc
                );
              }
            }


            if($row['CounselorID']){
              $counselorimgsrc = "https://asset.bodwell.edu/OB4mpVPg/staff/".$row['CounselorID'].".jpg";
            } else {
              $counselorimgsrc = '';
            }
            $data['data'][0]['Counselor'] = array(
                'staffId' => $row['CounselorID'],
                'fullName' => $row['Counselor'],
                'positionTitle' => 'Counselor',
                'imgsrc' => $counselorimgsrc
            );


            if($row['HadvisorID']){
              $advisor1imgsrc = "https://asset.bodwell.edu/OB4mpVPg/staff/".$row['HadvisorID'].".jpg";
            } else {
              $advisor1imgsrc = '';
            }
            $data['data'][0]['Hadvisor'] = array(
                'staffId' => $row['HadvisorID'],
                'fullName' => $row['Hadvisor'],
                'positionTitle' => 'Youth Advisor',
                'imgsrc' => $advisor1imgsrc
            );

            if($row['HadvisorID2']){
              $advisor2imgsrc = "https://asset.bodwell.edu/OB4mpVPg/staff/".$row['HadvisorID2'].".jpg";
            } else {
              $advisor2imgsrc = '';
            }
            $data['data'][0]['Hadvisor2'] = array(
                'staffId' => $row['HadvisorID2'],
                'fullName' => $row['Hadvisor2'],
                'positionTitle' => 'Youth Advisor2',
                'imgsrc' => $advisor2imgsrc
            );

            $data['data'][0]['Principal1'] = array(
                'staffId' => 'F0083',
                'fullName' => 'Cathy Lee',
                'positionTitle' => 'Principal - Academics',
                'imgsrc' => "https://asset.bodwell.edu/OB4mpVPg/staff/F0083.jpg"
            );
            $data['data'][0]['Principal2'] = array(
                'staffId' => 'F0627',
                'fullName' => 'Stephen Goobie',
                'positionTitle' => 'Principal - Student Life',
                'imgsrc' => "https://asset.bodwell.edu/OB4mpVPg/staff/F0627.jpg"
            );

        }
        return $data;
      } else {
        return NULL;
      }

      $stmt->close();
      $tstmt->close();

    }

    public function getTimeline() {
      $query = $this->getSql('get-time-line');
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getPastTermList(){
      $query = $this->getSql('past-term-list');
      $stmt = $this->db->prepare($query);
      $studentId = $_SESSION['studentId'];
      $SemesterID = $_SESSION['SemesterID'] - 1;
      $stmt->bindParam("SemesterID", $SemesterID);
      $stmt->bindParam("studentId", $studentId);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function GetPastTermPaticipationHours($SemesterID){
      $query = $this->getSql('past-term-participation');
      $stmt = $this->db->prepare($query);
      $studentId = $_SESSION['studentId'];
      $stmt->bindParam("SemesterID", $SemesterID);
      $stmt->bindParam("studentId", $studentId);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }


    public function GetIAPRubric($SemesterID){
      $query = $this->getSql('iap-rubric');
      $stmt = $this->db->prepare($query);
      $studentid = $_SESSION['studentId'];
      $stmt->bindParam(1, $studentid);
      $stmt->bindParam(2, $SemesterID);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function semesterListForAssessments()  {
      $query = $this->getSql('semester-list-assessments');
      $stmt = $this->db->prepare($query);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getAssessmentsScore() {
      $query = $this->getSql('assessments-score');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $_SESSION['studentId']);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            // $response[$row['AssessmentID']][] = $row;
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetReportCard($sId) {
      $query = $this->getSql('get-report-card');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':StudentID', $_SESSION['studentId']);
      $stmt->bindValue(':SemesterID', $sId);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[$row['SubjectName']] = array_map('utf8_encode', $row);
            // $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getSelfAssessments() {
      $query = $this->getSql('self-assessments');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':StudentID', $_SESSION['studentId']);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetReportCardSemester() {
      $query = $this->getSql('get-report-card-semester');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':StudentID', $_SESSION['studentId']);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetOutstandingFee($FeeType, $Amount) {
      $query = $this->getSql('get-outstanding-fee');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':FeeType', $FeeType, PDO::PARAM_STR);
      $stmt->bindValue(':Amount', $Amount);
      $stmt->bindValue(':StudentID', $_SESSION['studentId']);
      if ($stmt->execute()) {
          $data = $stmt->fetchAll();
          if($data) {
            $response['Eligible'] = 'No';
          } else {
            $response['Eligible'] = 'Yes';
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }


}
?>
