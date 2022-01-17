<?php         
		global $wpdb;
		
		$param = isset( $_GET['create'] ) ? $_GET['create'] : 0;
		$project_id = isset( $_GET['create'] ) ? substr($_GET['create'], 0, 6) : 0;

		$condition = strlen($_GET['create']) == 6;

		$table_name = $wpdb->prefix . "project_flow";
		$rows = $wpdb->get_results( "SELECT * FROM `wp_project_flow` WHERE `project_id` LIKE '".$project_id."'");
		$rowcount = $wpdb->num_rows;

		if (isset($_POST['project_name']) && !empty($_POST['project_name'])) :
			
			$POST = array_map( 'stripslashes_deep', $_POST);

			$random = substr((mt_rand(1111, 9999)), 0, 4);

			if (empty($rowcount)) :
		
				$wpdb->insert( 
					$table_name , 
					array( 
						'project_id' => $project_id,
						'project_name' => $POST['project_name'],
						'project_desc' => $POST['project_desc'],
						'project_customer' => $POST['project_customer'],
						'step_1' => !empty($POST['step_1']) ? date("Y-m-d H:i:s") : NULL,
						'_hash' => $random,
						'_hashc' => $project_id . $random,
					),
					array( 
						'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'
					) 
				);

			endif;

			$after_post = true;
			$rows = $wpdb->get_results( "SELECT * FROM `wp_project_flow` WHERE `project_id` LIKE '".$project_id."'");
			$rowcount = $wpdb->num_rows;
			
		
		endif;

		//echo $rowcount;

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>เพิ่มโครงการ - Performax Building Service</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
</head>

<body>

	<?php include 'header.php'; ?>

	<div class="page-title-3" style="height: 5px; border-width: 15px;">
		<div class="container">
		</div>
	</div>

	<?php if (isset($after_post) && !empty($rowcount)) : $row = $rows[0] ?>
		
		<div class="container mb-0 pb-3">
			<div class="row justify-content-center">
				<div class="col col-md-8 col-lg-6 mt-3 mb-0">
					<div class="card border rounded-0 p-3 py-4 py-md-3">
						<div class="card-body text-center">
							<div class="row justify-content-center">
								<div class="col text-center">
									<h3 class="mb-3 p-0 mt-0">บันทึกเรียบร้อย</h3>
									<p>เมื่อเวลา <?php echo date("Y-m-d H:i:s");?></p>
									<div class="rounded-circle rounded-circle-custom mb-3"><i class="feather-1" data-feather="file-plus"></i></div>
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

	<?php elseif (empty($rowcount) && $condition) : ?>

		<div class="container mb-5 pb-5">
			<div class="row justify-content-center">
				<div class="col col-md-10 mt-5">
					<div class="row">
						<div class="col text-center">
							<h2 class="mb-0">เพิ่มโครงการใหม่</h2>
							<p>กรอกรายละเอียด</p>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col col-md-10 col-lg-8">
							<div class="card border p-3 p-md-0 rounded-0">
								<div class="card-body">
									<form class="needs-validation" action="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" method="post" novalidate>
										<div class="row">
											<div class="col">
												<div class="form-group">
													<label for="project_name"><h5 class="mb-0 mt-3">ชื่อโครงการ<span class="text-danger">*</span></h5></label>
													<input type="text" class="form-control" id="project_name" name="project_name" value="" required>
													<div class="invalid-feedback">
														โปรดป้อนชื่อโครงการ
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-6 col-md-3">
												<div class="form-group">
													<label for="project_name"><h5 class="mb-0 mt-3">เล่มที่<span class="text-danger">*</span></h5></label>
													<input type="text" class="form-control" name="project_id_book_id" pattern=".{3,3}" maxlength="3" readonly value="<?php echo substr($_GET['create'], 0, 3)?>" required>
													<div class="invalid-feedback">
														โปรดป้อนหมายเลขเล่ม
													</div>
												</div>
											</div>
											<div class="col-6 col-md-3">
												<div class="form-group">
													<label for="project_name"><h5 class="mb-0 mt-3">เลขที่<span class="text-danger">*</span></h5></label>
													<input type="text" class="form-control" name="project_id_num_id" pattern=".{3,3}" maxlength="3" readonly value="<?php echo substr($_GET['create'], 3, 3)?>" required>
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
													<input type="text" class="form-control" id="project_name" name="project_customer" value="" required>
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
													<textarea class="form-control" id="project_desc" placeholder="เช่น อาคารสำนักงาน สูง 14 ชั้น (บนดิน) 2ชั้น (ใต้ดิน)" name="project_desc" required></textarea>
													<div class="invalid-feedback">
														โปรดป้อนข้อมูลโครงการ
													</div>
												</div>
											</div>
										</div>
										<div class="d-block mt-2 mb-4">
											<div class="custom-control mb-3 d-flex">
												<input type="checkbox" class="form-check-input" name="step_1" id="step_1" <?php echo !empty($row->step_1) ? "checked required" : ""; ?> style=" zoom: 1.75; position: relative; left: 5px; top: -3px;">
												<label for="step_1"><h5 class="ml-3 mr-3 mb-0">1) วิศวกรเข้าตรวจสอบอาคาร </h5><?php echo !empty($row->step_1) ? "<span class='badge badge-success' > บันทึกเมื่อ ". date('d/m/yy', strtotime( $row->step_1 )) : "" . "</span>" ?></label>
												<div class="invalid-feedback">คุณระบุสถานะไปแล้ว จำเป็นต้องเลือก</div>
											</div>
										</div>
										<button type="submit" class="btn btn-primary btn-block"><span><i class="mr-2" data-feather="file-plus"></i>เพิ่มโครงการใหม่</span></button>
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
									<h3 class="mb-0 p-0 mt-0">เกิดปัญหา !</h3>
									<p>โปรดติดต่อผู้ดูแลระบบ (Admin)</p>
									<div class="rounded-circle rounded-circle-custom mb-3"><i class="feather-1" data-feather="frown"></i></div>
									<p><?php echo !empty($rowcount) ? 'มีโครงการนี้แล้วในระบบ' : 'Format ไม่ถูกต้อง' ?></p>
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
			font-size: 2.75em;
			height: 120px;
			width: 120px;
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

</script>

</html>