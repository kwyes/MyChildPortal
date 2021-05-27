<?php
$_SQL = array(

    'find-currentsemester' => "SELECT *
    ,CONVERT(char(10), StartDate, 126) as StartDate
    ,CONVERT(char(10), EndDate, 126) as EndDate
    ,CONVERT(char(10), MidCutOffDate, 126) as MidCutOffDate
    FROM tblBHSSemester WHERE CurrentSemester = 'Y' ",

    'find-Enrollmentsemester' => "SELECT SemesterID, SemesterName
    FROM tblBHSSemester WHERE ? BETWEEN StartDate AND EndDate ",

    'student-info' => "SELECT
    COUNT(DISTINCT c.SemesterID) numTerms,
    COUNT(DISTINCT (Case when c.SubjectName LIKE 'AEP%' then c.SemesterID end)) numOfAepTerm,
	  student.StudentID studentId,
    student.PEN pen,
    student.FirstName firstName,
    student.LastName lastName,
    student.EnglishName englishName,
    student.SchoolEmail schoolEmail,
    student.CurrentGrade currentGrade,
	  student.Counselor counsellor,
    student.Mentor mentor,
    student.Houses houses,
    homestay.Homestay homestay,
    homestay.Residence residence,
    homestay.Halls halls,
    homestay.RoomNo roomNo,
    homestay.Hadvisor youthAdvisor,
    homestay.Hadvisor2 youthAdvisor2,
    homestay.Tutor tutor,
    student.EnrolmentDate EnrollmentDate
	  FROM tblBHSStudent student
    LEFT JOIN tblBHSHomestay homestay ON student.StudentID = homestay.StudentID
	  LEFT JOIN tblBHSStudentSubject b ON student.StudentID = b.StudNum
    LEFT JOIN tblBHSSubject c ON b.SubjectID = c.SubjectID
    LEFT JOIN tblBHSSemester d ON c.SemesterID = d.SemesterID
    WHERE student.StudentID=? AND student.CurrentStudent='Y' AND d.SemesterID<=?
	GROUP BY
	student.StudentID,
	student.PEN,
  student.FirstName,
  student.LastName,
  student.EnglishName,
  student.SchoolEmail,
  student.CurrentGrade,
	student.Counselor,
  student.Mentor,
  student.Houses,
  homestay.Homestay,
  homestay.Residence,
  homestay.Halls,
  homestay.RoomNo,
  homestay.Hadvisor,
  homestay.Hadvisor2,
  homestay.Tutor,
  student.EnrolmentDate",

  'get-user-auth' => "SELECT a.LoginIDParent, a.LoginID schoolEmail, a.UserID studentId, a.PW2 password, b.FirstName, b.LastName, b.EnglishName, b.CurrentGrade, b.PEN, b.Mentor
  FROM tblBHSUserAuth a
  JOIN tblBHSStudent b ON a.UserID = b.StudentID
  WHERE a.LoginIDParent ='{LoginID}' AND a.Category='20' AND b.CurrentStudent='Y'",

  'grade-list-by-student' => "SELECT
      course.SemesterID termId,
      semester.SemesterName,
      studentCourse.StudSubjID studentCourseId,
      course.SubjectName SubjectName,
      studentCourse.StudNum studentId,
      studentCourse.SubjectID courseId,
      item.CategoryID categoryId,
      item.CategoryItemID itemId,
      grade.GradeID gradeId,
      item.Title itemTitle,
      item.ItemWeight itemWeight,
      grade.ScorePoint scorePoint,
      grade.ScorePoint / item.MaxValue scoreRate,
      item.ScoreType scoreType,
      grade.Comment comment,
      grade.Exempted exempted,
      item.MaxValue maxScore,
      course.RoomNo roomNo,
      CONCAT(staff.FirstName, ' ', staff.LastName) teacherName,
      CONVERT(CHAR(10), item.AssignDate, 126) assignDate,
      CONVERT(CHAR(10), item.DueDate, 126) dueDate,
      CASE WHEN item.AssignDate <= GETDATE() AND ABS(DATEDIFF(DAY, item.AssignDate, GETDATE())) > 3 AND grade.ScorePoint IS NULL THEN 1 ELSE 0 END overdue,
      CASE
        WHEN grade.Exempted = 1 THEN 'exempted'
        WHEN grade.ScorePoint IS NOT NULL THEN 'normal'
        WHEN item.AssignDate <= GETDATE() AND ABS(DATEDIFF(DAY, item.AssignDate, GETDATE())) > 3 THEN 'overdue'
        ELSE 'pending'
      END gradeStatus,
      category.CategoryCode categoryCode,
      category.Text categoryTitle,
      CONCAT(category.Text, ' (', FORMAT(ROUND(category.CategoryWeight * 100, 2),'g15'), '%)') categoryLabel,
      category.CategoryWeight categoryWeight,
      CONCAT(ROUND(category.CategoryWeight * 100, 2), '%') categoryWeightLabel
  FROM tblBHSStudentSubject studentCourse
  JOIN tblBHSSubject course ON studentCourse.SubjectID = course.SubjectID
  JOIN tblBHSOGSCategoryItems item ON item.SemesterID = course.SemesterID AND item.SubjectID = course.SubjectID
  JOIN tblStaff staff ON course.TeacherID = staff.StaffID
  LEFT JOIN tblBHSSemester semester ON semester.SemesterID = course.SemesterID
  LEFT JOIN tblBHSOGSCourseCategory category ON category.SemesterID = course.SemesterID AND category.CategoryID = item.CategoryID and category.SubjectID = item.SubjectID
  LEFT JOIN tblBHSOGSGrades grade ON studentCourse.StudSubjID = grade.StudSubjID AND item.CategoryItemID = grade.CategoryItemID
  WHERE course.SemesterID=? AND studentCourse.StudNum=? AND item.AssignDate > '1900-01-01'
  ORDER BY item.SubjectID ASC, item.Title ASC",


  'item-average-list' => "SELECT
      grade.CategoryItemID itemId,
      COUNT(grade.CategoryItemID) itemCount,
      AVG(grade.ScorePoint) averageScore,
      AVG(grade.ScorePoint) / AVG(item.MaxValue) averageRate
  FROM tblBHSOGSGrades grade
  JOIN tblBHSOGSCategoryItems item ON grade.CategoryItemID = item.CategoryItemID
  JOIN tblBHSOGSCourseCategory category ON item.CategoryID = category.CategoryID
  JOIN tblBHSSubject course ON category.SubjectID = course.SubjectID
  WHERE course.SubjectID IN ({subjectid}) AND grade.ScorePoint IS NOT NULL AND grade.Exempted <> 1
  GROUP BY grade.CategoryItemID",


  'student-activity-list-v4' => "SELECT
           A.StudentActivityID activityId
          ,A.Title title
          ,A.ActivityCategory category
          ,CONVERT(CHAR(10), A.SDate, 126) sDate
          ,CONVERT(CHAR(10), A.EDate, 126) eDate
          ,A.Body description
          ,A.ApproverStaffID staffId
          ,CONCAT(D.FirstName, ' ', D.LastName) as FullStaffName
          ,A.ActivityStatus
          ,A.ProgramSource
          ,A.Hours hours
          ,A.VLWE qvwh
          ,A.StudentID studentId
          ,CONCAT(S.FirstName, ' ', S.LastName) as FullName
          ,A.StudentID studentId
          ,A.SemesterID termId
          ,M.SemesterName SemesterName
          ,A.VLWE VLWE
          ,A.Location location
          ,A.SELFComment1 stuComment1
          ,A.SELFComment2 stuComment2
          ,A.SELFComment3 stuComment3
          ,A.ApproverComment1 approverComment1
          ,CreateUserID
          ,CASE
          WHEN
            ISNUMERIC(LEFT(A.CreateUserID,1)) = 0
          THEN
            CONCAT(E.FirstName, ' ', E.LastName)
          ELSE
            CONCAT(S.FirstName, ' ', S.LastName)
          END AS CreateUserName
          ,CONVERT(varchar, A.CreateDate, 120) CreateDate
          ,CONVERT(varchar, A.ModifyDate, 120) ModifyDate
          ,CASE
          WHEN
            ISNUMERIC(LEFT(A.ModifyUserID,1)) = 0
          THEN
            CONCAT(F.FirstName, ' ', F.LastName)
          ELSE
            CONCAT(S.FirstName, ' ', S.LastName)
          END AS ModifyUserName
      FROM tblBHSSPStudentActivities A
      LEFT JOIN tblStaff D ON A.ApproverStaffID = D.StaffID
      LEFT JOIN tblStaff E ON A.CreateUserID = E.StaffID
      LEFT JOIN tblStaff F ON A.ModifyUserID = F.StaffID
      LEFT JOIN tblBHSStudent S ON S.StudentID = A.StudentID
      LEFT JOIN tblBHSSemester M ON A.SemesterID = M.SemesterID
      WHERE A.StudentID=? AND CONVERT(CHAR(10), A.SDate, 126) >= ?
      ORDER BY A.SDate DESC",

      'course-grade-list' => "SELECT
        studentId,
        courseId,
        COUNT(categoryId) categoryCount,
        SUM(categoryWeight) categoryWeightTotal,
        SUM(categoryRateScaled * categoryWeight) courseRateOrigin,
        SUM(categoryRateScaled * categoryWeight) * (1 / SUM(categoryWeight)) courseRateScaled
      FROM (
        SELECT
          student.StudentID studentId,
          course.SubjectID courseId,
          category.CategoryID categoryId,
          category.CategoryWeight categoryWeight,
          SUM((grade.ScorePoint / item.MaxValue) * item.ItemWeight) * (1 / SUM(item.ItemWeight)) categoryRateScaled
        FROM tblBHSOGSGrades grade
          JOIN tblBHSOGSCategoryItems item ON grade.CategoryItemID = item.CategoryItemID
          JOIN tblBHSOGSCourseCategory category ON item.CategoryID = category.CategoryID
          JOIN tblBHSSubject course ON category.SubjectID = course.SubjectID
          JOIN tblBHSStudentSubject studentSubject ON grade.StudSubjID = studentSubject.StudSubjID
          JOIN tblBHSStudent student ON studentSubject.StudNum = StudentID
        WHERE student.StudentID='{studentId}' AND grade.SemesterID='{termId}' AND grade.ScorePoint IS NOT NULL AND grade.Exempted <> 1
        GROUP BY student.StudentID, course.SubjectID, category.CategoryID, category.CategoryWeight
      ) categoryGrade
      GROUP BY studentId, courseId",


      'course-list' => "SELECT
          course.SemesterID termId,
          studentCourse.StudSubjID studentCourseId,
          studentCourse.StudNum studentId,
          studentCourse.SubjectID courseId,
          course.SubjectName courseName,
          staff.StaffID teacherId,
          CONCAT(staff.FirstName, ' ', staff.LastName) teacherName,
          staff.FirstName teacherFirstName,
          staff.LastName teacherLastName,
          course.PName provincialName,
          course.CourseCd courseCode,
          course.RoomNo roomNo,
          course.Cap cap,
          course.Spa spa,
          course.Credit credit,
          course.Type courseType,
          course.CourseCd
      FROM tblBHSStudentSubject studentCourse
      JOIN tblBHSSubject course ON studentCourse.SubjectID = course.SubjectID
      JOIN tblStaff staff ON course.TeacherID = staff.StaffID
      WHERE course.SemesterID=? AND studentCourse.StudNum=? AND course.SubjectName NOT LIKE 'YYY%'
      ORDER BY
          course.Credit DESC,
          course.SubjectName ASC",

      'course-aep-list' => "SELECT B.SubjectName, A.*
      FROM tblBHSStudentSubject A
      LEFT JOIN tblBHSSubject B ON B.SubjectID = A.SubjectID
      WHERE A.StudNum = ? AND B.SemesterID = ?
      AND B.SubjectName LIKE '%AEP%' ORDER BY B.SubjectName ASC",

      'absent-list-by-courselist'  => "SELECT StudSubjID studentCourseId, SUM(AbsencePeriod) absenceCount, SUM(LatePeriod) lateCount
      FROM tblBHSAttendance
      WHERE StudSubjID IN ({studentCourseList}) AND Excuse = '0'
      GROUP BY StudSubjID",

      'student-activity-list-v2' => "
          SELECT
               A.StudentActivityID activityId
              ,A.Title title
              ,A.ActivityCategory category
              ,CONVERT(CHAR(10), A.SDate, 126) activityDate
              ,A.Body description
              ,A.ApproverStaffID staffId
              ,D.FirstName firstName
              ,D.LastName lastName
              ,A.Hours hours
              ,A.VLWE qvwh
              ,A.StudentID studentId
              ,A.SemesterID termId
              ,A.VLWE VLWE
          FROM tblBHSSPStudentActivities A
          LEFT JOIN tblStaff D ON A.ApproverStaffID = D.StaffID
          WHERE A.StudentID=? AND A.ActivityStatus = '80' AND A.SDate >= '2018-01-01'
          ORDER BY A.SDate DESC
      ",

      'get-career-path' => "SELECT P.*,
                                   CONVERT(char(10), ApprovalDate, 126) ApprovalDate,
                                   CONVERT(char(10), P.CreateDate, 126) CreateDateV,
                                   S.FirstName,
                                   S.LastName,
                                   CASE
                                    WHEN
                                      ISNUMERIC(LEFT(P.CreateUserID,1)) = 0
                                    THEN
                                      CONCAT(S.FirstName, ' ', S.LastName)
                                    ELSE
                                      CONCAT(B.FirstName, ' ', B.LastName)
                                    END AS CreateUserName,
                                   CASE
                                    WHEN
                                      ISNUMERIC(LEFT(P.ModifyUserID,1)) = 0
                                    THEN
                                      CONCAT(S.FirstName, ' ', S.LastName)
                                    ELSE
                                      CONCAT(B.FirstName, ' ', B.LastName)
                                    END AS ModifyUserName
                              FROM tblBHSStudentCareerLifePathway P
                         LEFT JOIN tblStaff S ON P.TeacherID = S.StaffID
                         LEFT JOIN tblBHSStudent B ON P.StudentID = B.StudentID
                             WHERE P.StudentID = ? AND P.SemesterID = ?",

             'involve-staff-list' => "SELECT s.Counselor
           	,CASE
           			WHEN s.Counselor != ''
           				THEN
           				(SELECT TOP 1 StaffID FROM tblStaff WHERE CONCAT(FirstName, ' ' , LastName) = s.Counselor)
           			ELSE ''
           		END AS CounselorID
               ,h.Hadvisor
           	,CASE
           		WHEN h.Hadvisor != ''
           			THEN
           			(SELECT TOP 1 StaffID FROM tblStaff WHERE CONCAT(FirstName, ' ' , LastName) = h.Hadvisor)
           		ELSE ''
           	END AS HadvisorID
               ,h.Hadvisor2
           	,CASE
           		WHEN h.Hadvisor2 != ''
           			THEN
           			(SELECT TOP 1 StaffID FROM tblStaff WHERE CONCAT(FirstName, ' ' , LastName) = h.Hadvisor2)
           		ELSE ''
           	END AS HadvisorID2
               FROM tblBHSStudent s
               LEFT JOIN tblBHSHomestay h on h.StudentID = s.StudentID
               where s.StudentID = :studentId",

           'teacher-involved-list' => "SELECT
                 course.SubjectName courseName,
                 staff.StaffID teacherId,
                 CONCAT(staff.FirstName, ' ', staff.LastName) teacherName,
                 staff.FirstName teacherFirstName,
                 staff.LastName teacherLastName,
                 course.Credit credit,
                 course.Type courseType
             FROM tblBHSStudentSubject studentCourse
             JOIN tblBHSSubject course ON studentCourse.SubjectID = course.SubjectID
             JOIN tblStaff staff ON course.TeacherID = staff.StaffID
             WHERE course.SemesterID=:SemesterID AND studentCourse.StudNum=:studentId AND course.SubjectName NOT LIKE 'YYY%'
             ORDER BY
                 course.Credit DESC,
                 course.SubjectName ASC",

          'get-time-line' => "SELECT EventID
              ,EventCategory
              ,Title
              ,Description
              ,CONVERT(char(10), SDate, 126) SDate
              ,CONVERT(char(10), EDate, 126) EDate
              ,Remarks
              ,ModifyDate
              ,ModifyUserID
              ,CreateDate
              ,CreateUserID
          FROM tblBHSEventCalendar
          ORDER BY SDate ASC",

          'past-term-list' => "SELECT d.SemesterID, d.SemesterName
          FROM tblBHSStudentSubject b
          LEFT JOIN tblBHSSubject c ON b.SubjectID = c.SubjectID
          LEFT JOIN tblBHSSemester d ON c.SemesterID = d.SemesterID
          where StudNum = :studentId AND d.SemesterID<=:SemesterID
          group by d.SemesterID, d.SemesterName
          order by d.SemesterID desc",

          'past-term-participation' => "SELECT
               A.StudentActivityID activityId
              ,A.Title title
              ,A.ActivityCategory category
              ,CONVERT(CHAR(10), A.SDate, 126) activityDate
              ,A.Body description
              ,A.ApproverStaffID staffId
              ,A.Hours hours
              ,A.VLWE qvwh
              ,A.StudentID studentId
              ,A.SemesterID termId
              ,A.VLWE VLWE
          FROM tblBHSSPStudentActivities A
          WHERE A.StudentID=:studentId AND A.ActivityStatus = '80' AND A.SemesterID = :SemesterID
          ORDER BY A.SDate DESC",

          'insert-user-auth-log' => "INSERT INTO tblBHSUserAuthLog(Username, UserCategory, StudentID, AppSystem, UserIPAddress, InternalStaff, StaffID, CreateDate)
          VALUES('{Username}', '{UserCategory}', '{StudentID}', '{AppSystem}', '{UserIPAddress}', '{InternalStaff}', '{StaffID}', '{CreateDate}')",

          'iap-rubric' => "SELECT B.FirstName, B.LastName, B.EnglishName, A.* FROM tblBHSAPLPRubric A
          LEFT JOIN tblBHSStudent B ON A.StudentID = B.StudentID WHERE A.StudentID = ? AND A.SemesterID = ?",

          'semester-list-assessments' => "SELECT a.AssessmentID, a.SemesterID, a.Title, s.SemesterName
          FROM tblBHSAssessmentMain a
          LEFT JOIN tblBHSSemester s ON s.SemesterID = a.SemesterID
          ORDER BY a.SemesterID DESC",

          'assessments-score' => "SELECT r.*, a.Title, a.SemesterID, s.SemesterName, CONVERT(CHAR(10), a.DateFrom, 126) DateFrom
          FROM tblBHSAssessmentEPAResult r
          LEFT JOIN tblBHSAssessmentMain a on a.AssessmentID = r.AssessmentID
          LEFT JOIN tblBHSSemester s ON s.SemesterID = a.SemesterID
          WHERE r.StudentID = ?
          ORDER BY r.AssessmentID DESC",

          'get-report-card' => "SELECT C.SemesterName,
          FORMAT(C.StartDate, 'MMMM yyyy') StartDate,
    	    FORMAT(C.MidCutOffDate, 'MMMM yyyy') MidCutOffDate,
    	    FORMAT(C.EndDate, 'MMMM yyyy') EndDate,
          B.*,
          A.*,
          D.FirstName,
          D.LastName
          FROM tblbhsstudentsubject A
          LEFT JOIN tblBHSSubject B ON B.SubjectID = A.SubjectID
          LEFT JOIN tblBHSSemester C ON C.SemesterID = B.SemesterID
          LEFT JOIN tblStaff D ON D.StaffID = B.TeacherID
          WHERE A.StudNum = :StudentID
          AND C.SemesterID = :SemesterID
          AND NOT B.SubjectName LIKE 'YYY%' ORDER BY B.SubjectName",

          'self-assessments' => "SELECT s.AssessmentID,
        	   s.AssessmentFormID,
        	   s.StudentID,
        	   t.FirstName,
        	   t.LastName,
        	   t.EnglishName,
        	   a.SemesterID,
        	   m.SemesterName,
        	   a.FormHtml,
        	   s.CurrentGrade,
        	   s.CommunicationRate,
        	   s.PersonalRate,
        	   s.ThinkingRate,
        	   s.CommunicationText,
        	   s.PersonalText,
        	   s.ThinkingText,
             a.Grade,
            CONVERT(char(10), s.CreateDate, 126) as CreateDate,
            CONVERT(char(10), s.ModifyDate, 126) as ModifyDate
          FROM tblBHSStudentAssessment s
          LEFT JOIN tblBHSAssessmentForm a on a.AssessmentFormID = s.AssessmentFormID
          LEFT JOIN tblBHSStudent t on t.StudentID = s.StudentID
          LEFT JOIN tblBHSSemester m on m.SemesterID = a.SemesterID
          WHERE s.StudentID = :StudentID",

          'get-outstanding-fee' => "SELECT *
          FROM tblBHSOutstanding
          WHERE StudentID = :StudentID AND FeeType = :FeeType AND Amount > :Amount AND (StartDate IS NULL OR StartDate <= CONVERT(DATETIME, GETDATE(), 102))",

          'get-report-card-semester' => "SELECT C.SemesterID,C.SemesterName FROM tblbhsstudentsubject A
          LEFT JOIN tblBHSSubject B ON B.SubjectID = A.SubjectID
          LEFT JOIN tblBHSSemester C ON C.SemesterID = B.SemesterID
          LEFT JOIN tblStaff D ON D.StaffID = B.TeacherID
          WHERE A.StudNum = :StudentID AND C.SemesterID > 78 AND C.MidCutOffDate <= GETDATE() AND GradeMidterm != 0 group by C.SemesterID, C.SemesterName ORDER BY C.SemesterID ASC",


  );



?>
