<!-- SELECT C.SemesterName,
C.StartDate,
C.MidCutOffDate,
C.EndDate,
B.*,
A.*,
D.FirstName,
D.LastName
FROM tblbhsstudentsubject A
LEFT JOIN tblBHSSubject B ON B.SubjectID = A.SubjectID
LEFT JOIN tblBHSSemester C ON C.SemesterID = B.SemesterID
LEFT JOIN tblStaff D ON D.StaffID = B.TeacherID
WHERE A.StudNum = 201900143
AND C.SemesterID = 79
AND NOT B.SubjectName LIKE 'YYY%' ORDER BY B.SubjectName -->
<html>
<head>
	<title>Bodwell High School Administration</title>
</head>
<body style="margin:0px; font-size:12pt;font-family: Arial, Helvetica, sans-serif;">
<table width="720" border="0" cellspacing="0" cellpadding="0" style="font-size:10pt;font-family: Arial, Helvetica, sans-serif;">
<cfoutput query="getstudent">
<tr><td width="180"><img src="https://admin.bodwell.edu/bhs/studentimages/<cfif photo is "">bhs.gif<cfelse>#photo#</cfif>" width=100 height=150 alt="" border="0"></td><td align="center" valign="top" width="340"><b><div style="font-size:11pt;">Bodwell High School and Bodwell Academy</div><br>
<i>Strength In Diversity</i></b><br><br>
955 Harbourside Drive<br>
North Vancouver, BC V7P 3S4<br>
Tel: (604)998-1000  Fax: (604)924-5058<br>
http://www.bodwell.edu<br>
email: office@bodwell.edu<br>
</td><td align="center" width="180"><img src="https://admin.bodwell.edu/bhs/images/bhslogo2.jpg" width=110 height=116 alt="" border="0"></td></tr>
<tr><td colspan="2"><b>#ucase(lastname)#, #firstname#</b><br><table border="0" cellspacing="0" cellpadding="0" style="font-size:10pt;font-family: Arial, Helvetica, sans-serif;"><tr><td>Student ##:</td><td>#url.studentid#</td></tr>
<tr><td align="right">PEN ##:</td><td>#pen#</td></tr></table></td><td align="center" valign="top">Principal: Mr. Stephen Goobie</td></tr>
<tr><td colspan="3"><hr size="0.1" width="100%" color="Black"></td></tr>
</table>
<table width="720" border="0" cellspacing="0" cellpadding="0" style="font-size:10pt;font-family: Arial, Helvetica, sans-serif;">
<cfif left(attended, 3) is "AEP"><cfset attended = replace(attended, "AEP", "Academic & English Preparation (AEP)")></cfif>
<tr><td>Program Attended: #attended#</td><td align="right"><b><cfif getrpt.semestername contains "Summer">Summer<cfelseif getrpt.semestername contains "Fall">Fall<cfelseif getrpt.semestername contains "Spring">Spring<cfelseif getrpt.semestername contains "Winter">Winter</cfif> Term: </b>#dateformat(getrpt.startdate, "mmmm yyyy")# - <cfif url.term is "commentmidterm">#dateformat(getrpt.midcutoffdate, "mmmm, yyyy")#<cfelseif url.term is "commentfinal">#dateformat(getrpt.enddate, "mmmm, yyyy")#</cfif></td></tr>
<tr><td>Mentor Teacher: #mentor#</td><td align="right"><b><cfif url.term is "commentmidterm">Mid-term<cfelse>Final</cfif> Report Card</b></td></tr>
</table></cfoutput>

<cfif url.term is "commentmidterm">
<table width="720" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;">
<tr><td colspan="6"><hr size="0.1" width="100%" color="Black"></td></tr>
<cfset gpa = 0><cfset tcredit = 0><cfset soa = 0><cfset ttlsoa = 0><cfset aepcount = 0><cfset satecount = 0>
	<cfloop query="getrpt">
		<cfif left(subjectname, 3) is "AEP" and aepcount is 0><cfset aepcount = 1></cfif>
		<cfif left(subjectname, 8) is "Saturday" and satecount is 0><cfset satecount = 1></cfif>
	</cfloop>
<cfoutput query="getrpt">
<cfset lperiod = mlate><cfset aperiod = mabsence><cfset eperiod = mexcuse><cfset totalperiods = mtotalperiods>
<cfif aepcount is 1><cfset aepcount = 2>
<tr><td colspan="6">AEP achievement mid-term score explanatory notes:<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;">
<tr><td valign="top">The student is:&nbsp;</td><td><table border="0" cellspacing="0" cellpadding="1" style="font-size:6pt;border: 1px solid;">
<tr><td>1</td><td>&nbsp;&nbsp;not meeting the expectations of the skill area</td></tr>
<tr><td>1.5</td><td>&nbsp;&nbsp;showing minimal progress in the skill area</td></tr>
<tr><td>2</td><td>&nbsp;&nbsp;progressing and demonstrating some improvements in the skill area</td></tr>
<tr><td>2.5</td><td>&nbsp;&nbsp;demonstrating steady improvement in the skill area</td></tr>
<tr><td>3</td><td>&nbsp;&nbsp;just meeting the expectations by demonstrating basic competence in the skill area</td></tr>
<tr><td>3.5</td><td>&nbsp;&nbsp;demonstrating stronger competence in the skill area</td></tr>
<tr><td>4</td><td>&nbsp;&nbsp;exceeding the expectations by demonstrating strong ability in the skill area</td></tr>
</table></td></tr></table></td></tr>
<tr><td colspan="6"><hr size="0.1" width="100%" color="Black"></td></tr>
</cfif>
<cfif satecount is 1><cfset satecount = 2>
<tr><td colspan="6">
Sat E achievement mid-term score explanatory notes:<br>
<table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
<tr><td>1 - Student is not meeting the expectations of the course.</td><td>3 - Student is almost meeting the expectations of the course.</td></tr>
<tr><td>2 - Student is progressing in the course.</td><td>4 - Student is meeting the expectations of the course.</td></tr>
</table></td></tr>
<tr><td colspan="6"><hr size="0.1" width="100%" color="Black"></td></tr>
</cfif>
<cfif aepcount lte 2><cfset aepcount = 3>
<tr align="center" style="font-weight:bold;"><td align="left" width="250">Course Name</td><td width="220">&nbsp;</td><td>Total</td><td>Total</td><td>Mid-term</td><td>Letter</td></tr>
<tr align="center" style="font-weight:bold;"><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher's Name</td><td>&nbsp;</td><td>Absences</td><td>Lates</td><td>Mark</td><td>Grade</td></tr>
<tr><td colspan="6"><hr size="0.1" width="100%" color="Black"></td></tr>
</cfif>
<cfif subjectname contains "Daily Physical Activity">
<!--- no show for Daily Physical Activity --->
<cfelseif subjectname contains "ZZZ">
<tr align="center"><td align="left" colspan="5" style="font-weight:bold;">#replace(subjectname, "ZZZ", "Extra-curricular:")#</td></tr>
<tr><td style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#lastname#, #firstname#</td></tr>
<tr><td colspan="6">#replace(commentmidterm, "#chr(10)#", "<br>", "all")#</td></tr>
<tr><td colspan="6"><hr size="0.1" width="100%" color="Black"></td></tr>
<cfelse>
<tr align="center"><td align="left" style="font-weight:bold;">#replace(subjectname, "ZZZ", "Extra-curricular:")#<cfif credit neq 0> (#evaluate(credit * 4)# credits)</cfif></td>
<td><cfif left(subjectname, 3) is "AEP">
<table width="200" border="1" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
<tr align="center"><td width="50">Reading</td><td width="50">Writing</td><td width="50">Speaking</td><td width="50">Listening</td></tr>
<tr align="center"><td>#mreading#</td><td>#mwriting#</td><td>#mspeaking#</td><td>#mlistening#</td></tr>
</table>
<cfelseif left(subjectname, 8) is "Saturday">
<table width="200" border="1" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
<tr align="center"><td width="50">Mindset</td><td width="50">Progress</td><td width="50">Participation</td><td width="50">Work Habits</td></tr>
<tr align="center" height="11"><td><cfif mreading neq "">#numberformat(mreading, "0.0")#</cfif></td><td><cfif mwriting neq "">#numberformat(mwriting, "0.0")#</cfif></td><td><cfif mspeaking neq "">#numberformat(mspeaking, "0.0")#</cfif></td><td><cfif mlistening neq "">#numberformat(mlistening, "0.0")#</cfif></td></tr>
</table>
<cfelse>&nbsp;</cfif></td><td>#evaluate(aperiod - eperiod)#</td><td>#lperiod#</td><td><cfif trim(ltrgrademidterm) neq "E" and trim(ltrgrademidterm) neq "L" and trim(ltrgrademidterm) neq "N/A" and trim(ltrgrademidterm) neq "NC" and trim(ltrgrademidterm) neq "NM" and trim(ltrgrademidterm) neq "RM" and trim(ltrgrademidterm) neq "W" and grademidterm neq "" and grademidterm neq -1 and left(subjectname, 3) neq "AEP" and left(subjectname, 8) neq "Saturday" and subjectname does not contain "Numeracy Assessment" and subjectname does not contain "Literacy Assessment"><cfset soa = soa + grademidterm><cfset ttlsoa = ttlsoa +1><cfset tcredit = tcredit + credit><cfif trim(ltrgrademidterm) is "A"><cfset gpa = gpa + (credit * 4)><cfelseif trim(ltrgrademidterm) is "B"><cfset gpa = gpa + (credit * 3)><cfelseif trim(ltrgrademidterm) is "C+"><cfset gpa = gpa + (credit * 2.5)><cfelseif trim(ltrgrademidterm) is "C"><cfset gpa = gpa + (credit * 2)><cfelseif trim(ltrgrademidterm) is "C-"><cfset gpa = gpa + (credit * 1)></cfif></cfif><cfif left(subjectname, 3) is "AEP">N/A<cfelseif left(subjectname, 8) is "Saturday">&nbsp;<cfelseif grademidterm gte 0>#grademidterm#%</cfif></td><td><cfif trim(ltrgrademidterm) is "IP" or trim(ltrgrademidterm) is "F">I<cfelseif left(subjectname, 3) is "AEP">N/A<cfelseif left(subjectname, 8) is "Saturday">&nbsp;<cfelse>#ltrgrademidterm#</cfif></td></tr>
<tr><td valign="top" style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#lastname#, #firstname#</td></tr>
<tr><td colspan="6">#replace(commentmidterm, "#chr(10)#", "<br>", "all")#</td></tr>
<tr><td colspan="6"><hr size="0.1" width="100%" color="Black"></td></tr>
</cfif>
</cfoutput>
<tr><td>&nbsp;</td></tr>
<tr><td rowspan="6" valign="bottom"><img src="staffimages/F0627sig.jpg" alt="" border="0"><br>_______________________________________<br>Principal's Signature:</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<cfoutput><tr><td>&nbsp;</td><td colspan="3">Student Overall Average:</td><td align="center"><cfif soa is 0 and ttlsoa is 0><cfelse>#round(evaluate(soa / ttlsoa))#% (<cfif round(evaluate(soa / ttlsoa)) gte 86>A<cfelseif round(evaluate(soa / ttlsoa)) gte 73>B<cfelseif round(evaluate(soa / ttlsoa)) gte 67>C+<cfelseif round(evaluate(soa / ttlsoa)) gte 60>C<cfelseif round(evaluate(soa / ttlsoa)) gte 50>C-<cfelseif round(evaluate(soa / ttlsoa)) gte 0>F</cfif>)</cfif></td></tr>
<tr><td>&nbsp;</td><td colspan="3"><cfif url.attended does not contain "AEP">GPA: </td><td align="center"><cfif tcredit neq 0>#decimalformat(evaluate(gpa / tcredit))#<cfelse>N/A</cfif> </cfif></td></tr>
<tr><td><cfif soa neq 0 and ttlsoa neq 0><cfif int(evaluate(soa / ttlsoa)) gte 86>Honour Roll Standing</cfif></cfif>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr></cfoutput>
</table><br>

<cfelseif url.term is "commentfinal">
<table width="720" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;">
<tr><td colspan="7"><hr size="0.1" width="100%" color="Black"></td></tr>
<cfset numrow = 0><cfset gpa = 0><cfset tcredit = 0><cfset soa = 0><cfset ttlsoa = 0><cfset aepcount = 0><cfset satecount = 0>
<cfloop query="getrpt">
<cfif left(subjectname, 3) is "AEP" and aepcount is 0><cfset aepcount = 1></cfif>
<cfif left(subjectname, 8) is "Saturday" and satecount is 0><cfset satecount = 1></cfif>
</cfloop>
<cfoutput query="getrpt">
<cfset numrow = numrow + 2><cfset lperiod = mlate + flate><cfset aperiod = mabsence + fabsence><cfset eperiod = mexcuse + fexcuse><cfset totalperiods = ftotalperiods>
<cfif aepcount is 1><cfset aepcount = 2>
<tr><td colspan="7"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;"><tr><td colspan="2">AEP achievement mid-term score explanatory notes:</td><td width="34%">AEP achievement final average score:</td></tr>
<tr><td valign="top">The student is:&nbsp;</td><td><table border="0" cellspacing="0" cellpadding="1" style="font-size:6pt;border: 1px solid;">
<tr><td>1</td><td>&nbsp;&nbsp;not meeting the expectations of the skill area</td></tr>
<tr><td>1.5</td><td>&nbsp;&nbsp;showing minimal progress in the skill area</td></tr>
<tr><td>2</td><td>&nbsp;&nbsp;progressing and demonstrating some improvements in the skill area</td></tr>
<tr><td>2.5</td><td>&nbsp;&nbsp;demonstrating steady improvement in the skill area</td></tr>
<tr><td>3</td><td>&nbsp;&nbsp;just meeting the expectations by demonstrating basic competence in the skill area</td></tr>
<tr><td>3.5</td><td>&nbsp;&nbsp;demonstrating stronger competence in the skill area</td></tr>
<tr><td>4</td><td>&nbsp;&nbsp;exceeding the expectations by demonstrating strong ability in the skill area</td></tr>
</table></td><td valign="top"><table border="0" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
<tr><td>1-2.88</td><td>: I</td><td width="15">&nbsp;</td><td>3-3.38</td><td>: C pass</td><td width="15">&nbsp;</td><td>3.5-3.75</td><td>: B</td><td width="15">&nbsp;</td><td>3.88-4</td><td>: A</td></tr>
</table></td></tr>
</table></td></tr>
<tr><td colspan="7"><hr size="0.1" width="100%" color="Black"></td></tr>
</cfif>
<cfif satecount is 1><cfset satecount = 2>
<tr><td colspan="7">
Sat E achievement final score explanatory notes:<br>
<table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
<tr><td>1 - Student is not meeting the expectations of the course.</td><td>3 - Student is almost meeting the expectations of the course.</td></tr>
<tr><td>2 - Student is progressing in the course.</td><td>4 - Student is meeting the expectations of the course.</td></tr>
</table></td></tr>
<tr><td colspan="7"><hr size="0.1" width="100%" color="Black"></td></tr>
</cfif>
<cfif aepcount lte 2><cfset aepcount = 3>
<tr align="center" style="font-weight:bold;"><td align="left" width="260">Course Name</td><td width="260">&nbsp;</td><td width="48">Total</td><td width="48">Total</td><td width="48">Mid-term</td><td width="48">Final</td><td width="48">Final Letter</td></tr>
<tr align="center" style="font-weight:bold;"><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher's Name</td><td>&nbsp;</td><td>Absences</td><td>Lates</td><td>Mark</td><td>Mark</td><td>Grade</td></tr>
<tr><td colspan="7"><hr size="0.1" width="100%" color="Black"></td></tr>
</cfif>
<cfif subjectname contains "Daily Physical Activity">
<tr align="center"><td align="left" colspan="6" style="font-weight:bold;">#replace(subjectname, "ZZZ", "Extra-curricular:")#</td><td>#ltrgradefinal#</td></tr>
<tr><td style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#lastname#, #firstname#</td><td colspan="6">#replace(commentfinal, "#chr(10)#", "<br>", "all")#</td></tr>
<tr><td colspan="7"><hr size="0.1" width="100%" color="Black"></td></tr>
<cfelseif subjectname contains "ZZZ">
<tr align="center"><td align="left" colspan="7" style="font-weight:bold;">#replace(subjectname, "ZZZ", "Extra-curricular:")#</td></tr>
<tr><td style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#lastname#, #firstname#</td></tr>
<tr><td colspan="7">#replace(commentfinal, "#chr(10)#", "<br>", "all")#</td></tr>
<tr><td colspan="7"><hr size="0.1" width="100%" color="Black"></td></tr>
<cfset numrow = numrow - 1>
<cfelse>
<tr align="center"><td align="left" style="font-weight:bold;">#replace(subjectname, "ZZZ", "Extra-curricular:")#<cfif credit neq 0> (#evaluate(credit * 4)# credits)</cfif></td><td><cfif left(subjectname, 3) is "AEP">
<table width="260" border="1" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
<tr><td colspan="2">&nbsp;</td><td colspan="2">Reading</td><td colspan="2">Writing</td><td colspan="2">Speaking</td><td colspan="2">Listening</td><td>Final Average Score</td></tr>
<tr><td>Mid-term</td><td style="font-size:7pt;font-weight:bold;">Final</td><td>#mreading#</td><td style="font-size:7pt;font-weight:bold;">#freading#</td><td>#mwriting#</td><td style="font-size:7pt;font-weight:bold;">#fwriting#</td><td>#mspeaking#</td><td style="font-size:7pt;font-weight:bold;">#fspeaking#</td><td>#mlistening#</td><td style="font-size:7pt;font-weight:bold;">#flistening#</td><td style="font-size:7pt;font-weight:bold;"><cfif freading neq "" and fwriting neq "" and fspeaking neq "" and flistening neq "">#evaluate((freading + fwriting + fspeaking + flistening) / 4)#</cfif></td></tr>
</table>
<cfelseif left(subjectname, 8) is "Saturday">
<table width="250" border="1" cellspacing="0" cellpadding="0" style="font-size:6pt;font-family: Arial, Helvetica, sans-serif;">
<tr align="center"><td colspan="2">&nbsp;</td><td colspan="2">Mindset</td><td colspan="2">Progress</td><td colspan="2">Participation</td><td colspan="2">Work Habits</td></tr>
<tr align="center"><td>Mid-term</td><td style="font-size:7pt;font-weight:bold;">Final</td><td><cfif mreading neq "">#numberformat(mreading, "0.0")#</cfif></td><td style="font-size:7pt;font-weight:bold;"><cfif freading neq "">#numberformat(freading, "0.0")#</cfif></td><td><cfif mwriting neq "">#numberformat(mwriting, "0.0")#</cfif></td><td style="font-size:7pt;font-weight:bold;"><cfif fwriting neq "">#numberformat(fwriting, "0.0")#</cfif></td><td><cfif mspeaking neq "">#numberformat(mspeaking, "0.0")#</cfif></td><td style="font-size:7pt;font-weight:bold;"><cfif fspeaking neq "">#numberformat(fspeaking, "0.0")#</cfif></td><td><cfif mlistening neq "">#numberformat(mlistening, "0.0")#</cfif></td><td style="font-size:7pt;font-weight:bold;"><cfif flistening neq "">#numberformat(flistening, "0.0")#</cfif></td></tr>
</table>
<cfelse>&nbsp;</cfif></td><td>#evaluate(aperiod - eperiod)#</td><td>#lperiod#</td><td><cfif left(subjectname, 3) is "AEP">N/A<cfelseif left(subjectname, 8) is "Saturday">&nbsp;<cfelseif grademidterm gte 0>#grademidterm#%<cfelse>#ltrgrademidterm#</cfif></td><td><cfif trim(ltrgradefinal) neq "E" and trim(ltrgradefinal) neq "L" and trim(ltrgradefinal) neq "N/A" and trim(ltrgradefinal) neq "NC" and trim(ltrgradefinal) neq "NM" and trim(ltrgradefinal) neq "RM" and trim(ltrgradefinal) neq "W" and gradefinal neq "" and gradefinal neq -1 and left(subjectname, 3) neq "AEP" and left(subjectname, 8) neq "Saturday" and subjectname does not contain "Numeracy Assessment" and subjectname does not contain "Literacy Assessment"><cfset tcredit = tcredit + credit><cfif left(subjectname, 3) is "AEP" and aepgradefinal neq ""><cfif aepgradefinal is 4><cfset soa = soa + 95><cfelseif aepgradefinal gte 3.75><cfset soa = soa + 85><cfelseif aepgradefinal gte 3.5><cfset soa = soa + 75><cfelseif aepgradefinal gte 3.25><cfset soa = soa + 65><cfelseif aepgradefinal gte 3><cfset soa = soa + 55><cfelseif aepgradefinal gte 2.75><cfset soa = soa + 45><cfelseif aepgradefinal gte 2.25><cfset soa = soa + 42.5><cfelseif aepgradefinal gte 2><cfset soa = soa + 40><cfelseif aepgradefinal gte 1.75><cfset soa = soa + 35><cfelseif aepgradefinal gte 1.25><cfset soa = soa + 32.5><cfelse><cfset soa = soa + 30></cfif><cfset ttlsoa = ttlsoa + 1><cfelseif gradefinal gte 0><cfset soa = soa + gradefinal><cfset ttlsoa = ttlsoa + 1></cfif><cfif trim(ltrgradefinal) is "A"><cfset gpa = gpa + (credit * 4)><cfelseif trim(ltrgradefinal) is "B"><cfset gpa = gpa + (credit * 3)><cfelseif trim(ltrgradefinal) is "C+"><cfset gpa = gpa + (credit * 2.5)><cfelseif trim(ltrgradefinal) is "C"><cfset gpa = gpa + (credit * 2)><cfelseif trim(ltrgradefinal) is "C-"><cfset gpa = gpa + (credit * 1)></cfif></cfif><cfif left(subjectname, 3) is "AEP">#aepgradefinal#<cfelseif left(subjectname, 8) is "Saturday">&nbsp;<cfelseif gradefinal gte 0>#gradefinal#%</cfif></td><td><cfif left(subjectname, 8) is "Saturday">&nbsp;<cfelse>#ltrgradefinal#</cfif></td></tr>
<tr><td valign="top" style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#lastname#, #firstname#</td></tr>
<tr><td colspan="7">#replace(commentfinal, "#chr(10)#", "<br>", "all")#</td></tr>
<tr><td colspan="7"><hr size="0.1" width="100%" color="Black"></td></tr>
</cfif>
</cfoutput>

<tr><td>&nbsp;</td></tr>
<tr><td rowspan="6" valign="bottom"><img src="staffimages/F0627sig.jpg" alt="" border="0"><br>_______________________________________<br>Principal's Signature:</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<cfoutput><tr><td colspan="4" align="right">Student Overall Average:</td><td align="center" colspan="2"><cfif soa is 0 and ttlsoa is 0><cfelse>#round(evaluate(soa / ttlsoa))#% (<cfif round(evaluate(soa / ttlsoa)) gte 86>A<cfelseif round(evaluate(soa / ttlsoa)) gte 73>B<cfelseif round(evaluate(soa / ttlsoa)) gte 67>C+<cfelseif round(evaluate(soa / ttlsoa)) gte 60>C<cfelseif round(evaluate(soa / ttlsoa)) gte 50>C-<cfelseif round(evaluate(soa / ttlsoa)) gte 0>F</cfif>)</cfif></td></tr>
<tr><td colspan="3">&nbsp;</td><td align="right"><cfif url.attended does not contain "AEP">GPA: </td><td colspan="2" align="center"><cfif tcredit neq 0>#decimalformat(evaluate(gpa / tcredit))#<cfelse>N/A</cfif> </cfif></td></tr>
<tr><td><cfif soa neq 0 and ttlsoa neq 0><cfif int(evaluate(soa / ttlsoa)) gte 86>Honour Roll Standing</cfif></cfif>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr></cfoutput>
</table><br>

</cfif>
<table width="575" border="1" cellspacing="0" cellpadding="0">
<tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">
<tr><td colspan="8" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Grades are awarded on the following approved B.C. Ministry of Education Scale:</td></tr>
<tr><td>&nbsp;&nbsp;&nbsp;A</td><td>: 86 - 100%</td><td>C</td><td>: 60 - 66%</td><td>W</td><td>: Withdrew</td><td>RM</td><td>: Requirements Met</td></tr>
<tr><td>&nbsp;&nbsp;&nbsp;B</td><td>: 73 - 85%</td><td>C-</td><td>: 50 - 59%</td><td></td><td></td><td>NM</td><td>: Requirements Not Met</td></tr>
<tr><td>&nbsp;&nbsp;&nbsp;C+</td><td>: 67 - 72%</td><cfif url.term is "commentmidterm"><td>I</td><td>: In Progress</td><cfelse><td>F</td><td>: 0 - 49%</td></cfif><td></td><td></td><td>L</td><td>: Left School</td></tr>
<tr><td align="center" colspan="10" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Bodwell Honour Roll Standing is 86% (A) average or greater in 3 or more courses</td></tr>
</table></td></tr></table>
<cfif url.term is "commentfinal"><br>
<cfquery name="getnextselection" datasource="#session.dsname#" username="#session.dsnusername#" password="#session.dsnpassword#">
select tblbhsstudentsubject.studnum, tblbhssubject.subjectname, tblbhssubject.block, tblbhsstudent.lastname, tblbhsstudent.firstname, tblbhssemester.semestername, tblbhssemester.startdate from tblbhsstudentsubject, tblbhssubject, tblbhsstudent, tblbhssemester where tblbhsstudentsubject.subjectid = tblbhssubject.subjectid and tblbhsstudentsubject.studnum = tblbhsstudent.studentid and tblbhssubject.semesterid = tblbhssemester.semesterid and tblbhssubject.semesterid = #evaluate(semesterid + 1)# and tblbhsstudentsubject.studnum = #url.studentid# group by tblbhsstudentsubject.studnum, tblbhsstudent.lastname, tblbhsstudent.firstname, tblbhssubject.subjectname, tblbhssubject.block, tblbhssemester.semestername, tblbhssemester.startdate
</cfquery>
<cfif getnextselection.recordcount neq 0 and getcurrentsemester.semesterid is semesterid>
<table width="720" border="0" cellspacing="0" cellpadding="0" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">
<tr><td>&nbsp;</td></tr>
<cfoutput query="getnextselection" group="studnum">
<tr><td><b>#semestername# Course Selection - #lastname#, #firstname# #studnum#</b></td></tr>
<cfoutput><tr><td>#replace(subjectname, "ZZZ", "Extra-curricular:")#</td></tr>
</cfoutput>
</cfoutput>
</table>
</cfif>
</cfif>
</body>
</html>
