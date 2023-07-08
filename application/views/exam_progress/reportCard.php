<style type="text/css">
	@media print {
		.pagebreak {
			page-break-before: always;
		}
		.table-bordered > thead > tr > th,
		.table-bordered > tbody > tr > th,
		.table-bordered > tfoot > tr > th,
		.table-bordered > thead > tr > td,
		.table-bordered > tbody > tr > td,
		.table-bordered > tfoot > tr > td {
		    border-color: #000 !important;
		}
	}
	.mark-container {
	    background: #fff;
	    width: 1000px;
	    position: relative;
	    z-index: 2;
	    margin: 0 auto;
	    padding: 20px 30px;
	}
	table {
	    border-collapse: collapse;
	    width: 100%;
	    margin: 0 auto;
	}
</style>

<?php
$extINTL = extension_loaded('intl');
if (count($student_array)) {
	foreach ($student_array as $sc => $studentID) {
		$result = $this->exam_progress_model->getStudentReportCard($studentID, $sessionID);
		$student = $result['student'];
		$branchID = $student['branch_id'];
		$getSchool = $this->db->where(array('id' => $branchID))->get('branch')->row_array();
		$schoolYear = get_type_name_by_id('schoolyear', $sessionID, 'school_year');
		?>
	<div class="mark-container">
		<table border="0" style="margin-top: 20px; height: 100px;">
			<tbody>
				<tr>
				<td style="width:40%;vertical-align: top;"><img style="max-width:225px;" src="<?=$this->application_model->getBranchImage($branchID, 'report-card-logo')?>"></td>
				<td style="width:60%;vertical-align: top;">
					<table align="right" class="table-head text-right">
						<tbody>
							<tr><th style="font-size: 26px;" class="text-right"><?=$getSchool['school_name']?></th></tr>
							<tr><th style="font-size: 14px; padding-top: 4px;" class="text-right">Academic Session : <?=$schoolYear?></th></tr>
							<tr><td><?=$getSchool['address']?></td></tr>
							<tr><td><?=$getSchool['mobileno']?></td></tr>
							<tr><td><?=$getSchool['email']?></td></tr>
						</tbody>
					</table>
				</td>
				</tr>
			</tbody>
		</table>
		<div style="width: 100%;">
			<div style="width: 80%; float: left;">
				<table class="table table-bordered" style="margin-top: 20px;">
					<tbody>
						<tr>
							<th>Name</td>
							<td><?=$student['first_name'] . " " . $student['last_name']?></td>
							<th>Register No</td>
							<td><?=$student['register_no']?></td>
							<th>Roll Number</td>
							<td><?=$student['roll']?></td>
						</tr>
						<tr>
							<th>Father Name</td>
							<td><?=$student['father_name']?></td>
							<th>Admission Date</td>
							<td><?=_d($student['admission_date'])?></td>
							<th>Date of Birth</td>
							<td><?=_d($student['birthday'])?></td>
						</tr>
						<tr>
							<th>Mother Name</td>
							<td><?=$student['mother_name']?></td>
							<th>Class</td>
							<td><?=$student['class_name'] . " (" . $student['section_name'] . ")"?></td>
							<th>Gender</td>
							<td><?=ucfirst($student['gender'])?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="width: 20%; float: left; text-align: right;">
				<img src="<?php echo get_image_url('student', $student['photo']); ?>" style="margin-top: 20px; border-radius: 10px;" height="120">
			</div>
		</div>
		<table class="table table-condensed table-bordered mt-lg">
			<thead>
				<tr>
					<th>Subject</th>
				<?php foreach ($examArray as $id) { ?>
					<th><?php echo get_type_name_by_id('exam',$id)  ?></th>
				<?php } ?>
					<th>Cumulative Average</th>
					<th>Grade</th>
					<th>Remark</th>
					<th>Class Average</th>
					<th>Subject Position</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$colspan = count($examArray) + 5;
			$total_grade_point = 0;
			$grand_obtain_marks = 0;
			$grand_full_marks = 0;
			$result_status = 1;
			$getSubjectsList = $this->subject_model->getSubjectByClassSection($student['class_id'], $student['section_id']);
			$getSubjectsList = $getSubjectsList->result_array();
			foreach ($getSubjectsList as $row) {
				$subTotalObtain = 0;
				$subTotalFull = 0;
				?>
				<tr>
					<td valign="middle" width="20%"><?=$row['subjectname']?></td>
					<?php foreach ($examArray as $id) { ?>
					<td valign="middle"><?php 
					$getExamTotalMark = $this->exam_progress_model->getExamTotalMark($studentID, $sessionID, $row['subject_id'], $id);
					$subTotalObtain += $getExamTotalMark['grand_obtain_marks'];
					$subTotalFull += $getExamTotalMark['grand_full_marks'];
					echo $getExamTotalMark['grand_obtain_marks'] ." / ". $getExamTotalMark['grand_full_marks'];
					?></td>
					<?php } ?>
					<td valign="middle"><?php 
					if (empty($subTotalObtain)) {
						$cumulative_Average = 0;
					} else {
						$grand_obtain_marks += $subTotalObtain;
						$grand_full_marks += $subTotalFull;
						$cumulative_Average = (($subTotalObtain * 100) / $subTotalFull);
					}
					echo number_format($cumulative_Average, 1, '.', '') . "%";
				?></td>
					<td valign="middle"><?php $grade = $this->exam_progress_model->get_grade($cumulative_Average, 1); $total_grade_point += $grade['grade_point']; echo $grade['name'];  ?></td>
					<td valign="middle"><?php echo $grade['remark']; ?></td>
					<td valign="middle"><?php echo $this->exam_progress_model->getClassAverage($examArray, $sessionID, $row['subject_id']); ?></td>
					<td valign="middle"><?php echo $this->exam_progress_model->getSubjectPosition($student['class_id'], $student['section_id'],  $examArray, $sessionID, $row['subject_id'], $subTotalObtain); ?></td>
				</tr>
			<?php } ?>
				<tr class="text-weight-semibold">
					<td valign="top">GRAND TOTAL :</td>
					<td valign="top" colspan="<?=$colspan?>"><?=$grand_obtain_marks . '/' . $grand_full_marks; ?>, Average : <?php $percentage = ($grand_obtain_marks * 100) / $grand_full_marks; echo number_format($percentage, 2, '.', '')?>%</td>
				</tr>
			<?php if ($extINTL == true) { ?>
				<tr class="text-weight-semibold">
					<td valign="top">GRAND TOTAL IN WORDS :</td>
					<td valign="top" colspan="<?=$colspan?>">
						<?php
						$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
						echo ucwords($f->format($grand_obtain_marks));
						?>
					</td>
				</tr>
			<?php } ?>
				<tr class="text-weight-semibold">
					<td valign="top">GPA :</td>
					<td valign="top" colspan="<?=$colspan?>"><?=number_format(($total_grade_point / count($getSubjectsList)), 2, '.', '')?>%</td>
				</tr>
			</tbody>
		</table>
		<div style="width: 100%; display: flex;">
			<div style="width: 50%; padding-right: 15px;">
				<?php
				if ($attendance == true) {
					$year = explode('-', $schoolYear);
					$getTotalWorking = $this->db->where(array('enroll_id' => $student['enrollID'], 'year(date)' => $year[0]))->get('student_attendance')->num_rows();
					$getTotalAttendance = $this->db->where(array('enroll_id' => $student['enrollID'], 'status' => 'P', 'year(date)' => $year[0]))->get('student_attendance')->num_rows();
					$attenPercentage = empty($getTotalWorking) ? '0.00' : ($getTotalAttendance * 100) / $getTotalWorking;
					?>
				<table class="table table-bordered table-condensed">
					<tbody>
						<tr>
							<th colspan="2" class="text-center">Attendance</th>
						</tr>
						<tr>
							<th style="width: 65%;">No. of working days</th>
							<td><?=$getTotalWorking?></td>
						</tr>
						<tr>
							<th style="width: 65%;">No. of days attended</th>
							<td><?=$getTotalAttendance?></td>
						</tr>
						<tr>
							<th style="width: 65%;">Attendance Percentage</th>
							<td><?=number_format($attenPercentage, 2, '.', '') ?>%</td>
						</tr>
					</tbody>
				</table>
				<?php } ?>
			</div>
	<?php if ($grade_scale == true) { ?>
			<div style="width: 50%; padding-left: 15px;">
				<table class="table table-condensed table-bordered">
					<tbody>
						<tr>
							<th colspan="3" class="text-center">Grading Scale</th>
						</tr>
						<tr>
							<th>Grade</th>
							<th>Min Percentage</th>
							<th>Max Percentage</th>
						</tr>
					<?php 
					$grade = $this->db->where('branch_id', $branchID)->get('grade')->result_array();
					foreach ($grade as $key => $row) {
					?>
						<tr>
							<td style="width: 30%;"><?=$row['name']?></td>
							<td style="width: 30%;"><?=$row['lower_mark']?>%</td>
							<td style="width: 30%;"><?=$row['upper_mark']?>%</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
	<?php } ?>
		</div>
	<?php if (!empty($remarks_array[$studentID])) { ?>
		<div style="width: 100%;">
			<table class="table table-condensed table-bordered">
				<tbody>
					<tr>
						<th style="width: 250px;">Remarks</th>
						<td><?=$remarks_array[$studentID]?></td>
					</tr>
				</tbody>
			</table>
		</div>
	<?php } ?>
		<table style="width:100%; outline:none; margin-top: 35px;">
			<tbody>
				<tr>
					<td style="font-size: 15px; text-align:left;">Print Date : <?=_d($print_date)?></td>
					<td style="border-top: 1px solid #ddd; font-size:15px;text-align:left">Principal Signature</td>
					<td style="border-top: 1px solid #ddd; font-size:15px;text-align:center;">Class Teacher Signature</td>
					<td style="border-top: 1px solid #ddd; font-size:15px;text-align:right;">Parent Signature</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="pagebreak"> </div> 
<?php } } ?>
