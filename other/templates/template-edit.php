<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>แก้ไขโครงการ - Performax Building Service</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
</head>

<?php         
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		global $wp_session;
		$is_admin = is_user_logged_in();

		global $wpdb;

		$param = isset( $_GET['edit'] ) ? $_GET['edit'] : 0;
		$project_id = isset( $_GET['edit'] ) ? substr($_GET['edit'], 0, 6) : 0;

		$table_name = $wpdb->prefix . "project_flow";
		$rows = $wpdb->get_results( "SELECT * FROM `wp_project_flow` WHERE `project_id` LIKE '".$project_id."'");
		$rowcount = $wpdb->num_rows;

		if (!empty($rowcount)) :

			$pin = substr($param , -4);
			if ( $rows[0]->_hash != $pin ){
				$rowcount = 0;
				$pin_error = 1;
			}

		endif;


		if (isset($_POST['project_name'])&& !empty($_POST['project_name']) && !empty($rowcount)) :
			
			$POST = array_map('stripslashes_deep', $_POST );
			$info = $rows[0];
			
			for ($x = 1; $x <= 4; $x++) :

				if(!empty($_FILES[ 'file'.$x ]['name'])) :

					${ 'ext'.$x } = array_pop(explode('.', $_FILES[ 'file'.$x ]['name']));
					
					if ( in_array(${ 'ext'.$x }, array('pdf', 'PDF'))) : ${ 'filename'.$x } = uploadFile($_FILES[ 'file'.$x ], $info, 'file'.$x );
					else : ${ 'file_error'.$x } = 1; $_FILES[ 'file'.$x ] = NULL ;
					endif;

				endif;

			endfor;

			$wpdb->update( 
				$table_name , 
				array( 
					'project_id' => $project_id,
					'project_name' => $POST['project_name'],
					'project_desc' => $POST['project_desc'],
					'project_customer' => $POST['project_customer'],
					'step_1' => stepCondition($POST['step_1'], "step_1", $rows[0]),
					'step_2' => stepCondition($POST['step_2'], "step_2", $rows[0]),
					'step_3' => stepCondition($POST['step_3'], "step_3", $rows[0]),
					'step_4' => stepCondition($POST['step_4'], "step_4", $rows[0]),
					'_file1' => isset($filename1) ? strval($filename1) : stripslashes_deep($POST['urlfile1']),
					'_file2' => isset($filename2) ? strval($filename2) : stripslashes_deep($POST['urlfile2']),
					'_file3' => isset($filename3) ? strval($filename3) : stripslashes_deep($POST['urlfile3']),
					'_file4' => isset($filename4) ? strval($filename4) : stripslashes_deep($POST['urlfile4']),
					'_create' => stripslashes_deep($rows[0]->_create)
				), 
				array( 
					'project_id' => stripslashes_deep(substr($_GET['edit'], 0, 6))
				)
			);

			$after_post = true;
		
		endif;


		function uploadFile ($file, $info, $name) {
			
			$file['name'] = $name . "-" . $info->project_id . "-" .$info->project_name . "-เอกสารใบรับรองการตรวจสอบอาคาร-ร1-" . date("d-m-y", strtotime( $info->_update ) ) . ".pdf";

			$uploadedfile =  $file;
			$uploadopt = array('test_form' => FALSE );
			add_filter( 'upload_dir', 'wpse_141088_upload_dir' );
			
			$movefile = wp_handle_upload( $uploadedfile, $uploadopt );
			$imageurl = "";

			remove_filter( 'upload_dir', 'wpse_141088_upload_dir' );

			if ( $movefile && ! isset( $movefile['error'] ) ) {
				$imageurl = $movefile['url'];
				return $imageurl;
			} 

			return false;

		}

		function wpse_141088_upload_dir( $dir ) {
			return array(
				'path'   => $dir['basedir'] . $dir['subdir'] . '/project',
				'url'    => $dir['baseurl'] . $dir['subdir'] .'/project',
				'subdir' => $dir['subdir'] .'/project',
			) + $dir;
		}


		function stepCondition($status, $column, $row) {
			if(!empty($status)) {
				return $row->$column == NULL ? date("Y-m-d H:i:s") : $row->$column;
			}
			return NULL;
		}

?>



<body>

	<?php include 'header.php'; ?>

	<div class="page-title-3" style="height: 5px; border-width: 15px;">
		<div class="container">
		</div>
	</div>

	<?php if (isset($after_post) && !empty($after_post) && !isset($file_error1) && !isset($file_error2)) : $row = $rows[0] ?>
		
		<div class="container mb-0 pb-3">
			<div class="row justify-content-center">
				<div class="col col-md-8 col-lg-6 mt-3 mb-0">
					<div class="card border rounded-0 p-3 py-4 py-md-3">
						<div class="card-body text-center">
							<div class="row justify-content-center">
								<div class="col text-center">
									<h3 class="mb-0 p-0 mt-0">อัพเดทเรียบร้อย</h3>
									<p>เมื่อเวลา <?php echo date("Y-m-d H:i:s");?></p>
									<div class="rounded-circle rounded-circle-custom mb-3"><i class="feather-1" data-feather="save"></i></div>
									<p class="mb-1">หมายเลขติดตามโครงการ</p>
									<div class="input-group mb-3"  style="width: 300px; margin: 0 auto;" >
										<input type="text" id="project_id" class="form-control"  readonly value="<?php echo substr($row->project_id, 0, 6); ?><?php echo $row->_hash ?>" required>
										<div class="input-group-append">
											<button onclick="copyToClipboard('#project_id')" class="btn btn-outline-secondary" type="button" id="button-addon2">copy</button>
										</div>
									</div>

									<p class="mb-1">URL สำหรับเข้าสู่ระบบ</p>
									<div class="input-group mb-1"  style="width: 300px; margin: 0 auto;" >
										<input type="text" id="project_url" class="form-control"  readonly value="<?php echo home_url( '/tracking/' ); ?>?id=<?php echo substr($row->project_id, 0, 6); ?><?php echo $row->_hash ?>" required>
										<div class="input-group-append">
											<button onclick="copyToClipboard('#project_url')" class="btn btn-outline-secondary" type="button" id="button-addon2">copy</button>
										</div>
										
									</div>
									<a href="<?php echo home_url( '/tracking/' ) . "?id=" . substr($row->project_id, 0, 6) . $row->_hash ; ?>">ไปยัง URL สถานะโครงการ</a>
									<a class="btn btn-primary btn-block mt-4" href="<?php echo home_url( '/tracking/' ); ?>"><i class="feather-1" data-feather="arrow-left"></i> ย้อนกลับ</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php elseif (!empty($rowcount)) : $row = $rows[0] ?>

		<div class="container mb-5 pb-5">
			<div class="row justify-content-center">
				<div class="col col-md-10 mt-5">
					<div class="row">
						<div class="col text-center">
							<h2 class="mb-0">อัพเดทโครงการ</h2>
							<p>แก้ไขรายละเอียด <?php echo $is_admin ? '<span class="badge badge-success">โดย ADMIN</span>' : '' ?></p>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col col-md-10 col-lg-8">
					
							<div class="card border p-3 p-md-0 rounded-0">
								<div class="card-body">
									<form class="needs-validation" enctype='multipart/form-data' action="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" method="post" novalidate>
										<div class="row">
											<div class="col">
												<div class="form-group">
													<label for="project_name"><h5 class="mb-0 mt-1">ชื่อโครงการ</h5></label>
													<input type="text" class="form-control <?php echo $is_admin ? 'border-warning alert-warning' : '' ?>" id="project_name" name="project_name" <?php echo !$is_admin ? 'readonly' : '' ?> value="<?php echo $row->project_name; ?>" required>
													<div class="invalid-feedback">
														โปรดป้อนชื่อโครงการ
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-6 col-md-3 ">
												<div class="form-group">
													<label for="project_name"><h5 class="mb-0 mt-3">เล่มที่</h5></label>
													<input type="text" class="form-control" name="project_id_book_id" pattern=".{3,3}" readonly value="<?php echo substr($row->project_id, 0, 3); ?>" required>
													<div class="invalid-feedback">
														โปรดป้อนหมายเลขเล่ม
													</div>
												</div>
											</div>
											<div class="col-6 col-md-3">
												<div class="form-group">
													<label for="project_name"><h5 class="mb-0 mt-3">เลขที่</h5></label>
													<input type="text" class="form-control" name="project_id_num_id" pattern=".{3,3}" readonly value="<?php echo substr($row->project_id, 3, 3); ?>" required>
													<div class="invalid-feedback">
														โปรดป้อนหมายเลขที่
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div class="form-group">
													<label for="project_name"><h5 class="mb-0 mt-3">ผู้ดูแลอาคาร</h5></label>
													<input type="text" class="form-control  <?php echo $is_admin ? 'border-warning alert-warning' : '' ?> " id="project_name" name="project_customer" value="<?php echo $row->project_customer; ?>" <?php echo !$is_admin ? 'readonly' : '' ?> required>
													<div class="invalid-feedback">
														โปรดป้อนชื่อผู้ดูแลอาคาร
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div class="form-group">
													<label for="project_desc"><h5 class="mb-0 mt-3">ข้อมูลโครงการ</h5></label>
													<textarea class="form-control alert-warning border-warning" id="project_desc" placeholder="เช่น อาคารสำนักงาน สูง 14 ชั้น (บนดิน) 2ชั้น (ใต้ดิน)" name="project_desc" required><?php echo $row->project_desc; ?></textarea>
													<div class="invalid-feedback">
														โปรดป้อนข้อมูลโครงการ
													</div>
												</div>
											</div>
										</div>
										
										<div class="row mt-3 mb-1" style="padding : 3px;">
										<div class="col">
										
										
										<?php for ($x = 1; $x <= 4; $x++) : ?>

											<?php

												$step_txt = [
													"วิศวกรเข้าตรวจสอบอาคาร",
													"จัดทำรายงานตรวจสอบ รายการแก้ไข ข้อเสนอแนะ",
													"ส่งเอกสารให้หน่วยงานราชการ",
													"เสร็จสิ้น ได้รับใบ ร.1",
												]
											
											?>

											<div class="custom-control mb-0 d-flex">
												<input type="checkbox" class="form-check-input" name="<?= 'step_'.$x ?>" id="<?= 'step_'.$x ?>" <?php echo !empty($row->{ 'step_'.$x }) ? "checked" : ""; ?> style=" zoom: 1.75; position: relative; left: 5px; top: -3px;">
												<label for="<?= 'step_'.$x ?>"><h5 class="ml-3 mr-3 mb-0"><?= $x.')' ?> <?= $step_txt[$x - 1]; ?> <?php echo !empty($row->{ 'step_'.$x }) ? "<span class='badge badge-success' > บันทึกเมื่อ ". date('d/m/yy', strtotime( $row->{ 'step_'.$x } )) : "" . "</span>" ?></label></h5>
												<div class="invalid-feedback">คุณระบุสถานะไปแล้ว จำเป็นต้องเลือก</div>
											</div>
												
											<?php if (!empty($row->step_1)) : ?>

												<label for="project_desc">ไฟลล์เอกสาร - <small class="text-muted">รองรับไฟลล์ pdf เท่านั้น</small></label>

												<div class="alert alert-primary mb-5 <?php echo empty($row->{ '_file'.$x }) || isset(${ 'file_error'.$x }) ? "d-none" : ""; ?>" id="<?='block-download'.$x ?>" role="alert">
													<div class="d-flex">
														<i class="mr-2" data-feather="download"></i>
														<input type="hidden" name="<?= 'urlfile'.$x ?>" id="<?= 'urlfile'.$x ?>" value="<?php echo $row->{ '_file'.$x }; ?>" novalidate >
														<a href="<?php echo $row->{ '_file'.$x }; ?>" download style="font-size: 1.0em; line-height: 1em;">ดาวน์โหลด <br><small>(<?=basename($row->{ '_file'.$x })?>)</small></a>
													</div>
													<button type="button" class="close <?php echo (!$is_admin) ? 'd-none' : '' ?>" onclick="toggleDownload(<?=$x?>)" aria-label="Close" style="top: 5px; position: absolute; right: 15px;">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>

											<?php endif; ?>

											<?php if ($is_admin) : ?>

												<div class="alert alert-secondary mb-5 <?php echo !empty($row->{ '_file'.$x }) && !isset(${ 'file_error'.$x }) ? "d-none" : ""; ?>" id="<?='block-isdownload'.$x ?>" role="alert">
													<input type="file" name="<?= 'file'.$x ?>" style="width:90%"; novalidate >
													<div class="invalid-feedback <?php echo !empty(${"file_error".$x}) && $_FILES ? "d-block" : "" ?>">รองรับไฟลล์ pdf เท่านั้น</div>
												</div>

											<?php else : ?>
												
												<div class="alert alert-secondary mb-5 <?php echo !empty($row->{ '_file'.$x }) && !isset(${ 'file_error'.$x }) ? "d-none" : ""; ?>" id="<?= 'block-isdownload'.$x ?>" role="alert">
													ยังไม่ได้อัพโหลดเอกสาร
												</div>

											<?php endif; ?>

										<?php endfor; ?>

										</div>
										</div>

										<button type="submit" class="btn btn-primary btn-block"><span><i class="mr-2" data-feather="file-text"></i>บันทึกการแก้ไข</span></button>
									</form>
								</div>
							</div>
					
						</div>
					</div>	

				</div>
			</div>
		</div>

	<?php else : ?>
		
		<div class="container mb-0 pb-3">
			<div class="row justify-content-center">
				<div class="col col-md-8 col-lg-6 mt-3 mb-0">
					<div class="card border rounded-0 p-3 py-4 py-md-3">
						<div class="card-body text-center">
							<div class="row justify-content-center">
								<div class="col text-center">
									<h3 class="mb-0 p-0 mt-0">ไม่พบข้อมูล</h3>
									<p>โปรดติดต่อผู้ดูแลระบบ (Admin)</p>
									<div class="rounded-circle rounded-circle-custom mb-3"><i class="feather-1" data-feather="frown"></i></div>
									<p><?php echo isset($pin_error) ? '401 - Unauthorized' : 'ไม่พบข้อมูลในระบบ' ?></p>
									<a class="btn btn-primary btn-block mt-4" href="<?php echo home_url( '/tracking/' ); ?>"><i class="feather-1" data-feather="arrow-left"></i> ย้อนกลับ</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php endif; ?>

	<?php include 'footer.php'; ?>

	<style>
		.rounded-circle-custom {
			font-size: 2.5em;
			height: 12vw;
			width: 12vw;
			max-width: 100px;
			max-height: 100px;
			text-align: center;
			line-height: 1em;
			display: flex;
			justify-content: center;
			align-items: center;
			color: #2f5397;
			border: 3px solid #2f5397;
			background: #fff;
			margin: 0 auto;
		}

		.rounded-circle-custom.active {
			color: #fff;
			background: #2f5397;
			border-color: #2f5397;
		}

		.rounded-circle-custom.success {
			color: #4CAF50;
			background: #fff;
			border-color: #4CAF50;
		}

		.rounded-circle-container p {
			font-size: 1em;
			line-height: 1;
			margin-top: 15px;
		}

		.feather-1 {
			width: 1em;
			height: 1em;
		}

		.card-custom {
			padding-left: 30px;
			margin-top: 5px;
			min-height: 150px;
		}

		.card-custom li {
			margin-bottom: 10px;
		}
	</style>




</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
 crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
 crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
 crossorigin="anonymous"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script>
	feather.replace()
</script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).val()).select();
	console.log($(element).val())
    document.execCommand("copy");
    $temp.remove();
}

function toggleDownload(id) {
	var txt;
	var r = confirm("คุณต้องการลบไฟลล์นี้หรือไม่");
	if (r == true) {
		$("#urlfile" + id).val("");
		$("#block-isdownload" + id).toggleClass("d-none");
		$("#block-download" + id).toggleClass("d-none");
	}
}

</script>

</html>