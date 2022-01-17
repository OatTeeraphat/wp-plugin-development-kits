<?php         
		global $wpdb;
		$param = isset( $_GET['id'] ) ? $_GET['id'] : 0;
		$project_id = isset( $_GET['id'] ) ? substr($_GET['id'], 0, 6) : 0;

		$table_name = $wpdb->prefix . "project_flow";
		$rows = $wpdb->get_results( "SELECT * FROM `wp_project_flow` WHERE `project_id` LIKE '".$project_id."'");
		$rowcount = $wpdb->num_rows;

		if (!empty($rowcount)) :

			$pin = substr($_GET['id'], -4);
			if ( $rows[0]->_hash != $pin ){
				$rowcount = 0;
				$pin_error = 1;
			}

		endif;

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>ติดตามงาน</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
</head>

<body>

	<?php include 'header.php'; ?>

	<div class="page-title-3 d-none" style="height: 200px;background-image: url('<?php echo  get_template_directory_uri().'/assets/pic/Mask Group 12.JPG' ?>');">
		<div class="container">
			<div class="warpper-text text-white">
				<h1>ติดตามโครงการ</h1>
			</div>
		</div>
	</div>

	<div class="p-5 py-3 mb-4 bg-darkblue">
			<div class="container warpper-text pt-3 pb-2 mt-0 text-center text-white">
				<h3 class="mt-2 mb-2" style="font-size:2em;">สถานะโครงการ</h3>
            	<span>ระบบตรวจสอบสถานะการดำเนินการ</span>
			</div>
		</div>

	<?php if (!empty($rowcount)) : $row = $rows[0] ?>
		<div class="container mb-md-5 mb-4">
			<div class="row justify-content-center">
				<div class="col col-md-12 col-lg-8 mt-3 mt-md-4">
					
					<div class="card border rounded-0">
						<div class="card-body">
							<div class="row justify-content-center align-items-center">
								<div class="col-10 col-md-8 my-2 mt-1">
									<div class="d-flex justify-content-center align-items-center">
										<div class="d-block text-center">
											<h3 class="mb-1">อาคาร <?php echo $row->project_name; ?></h3>
											<h6 class="card-title mb-1">เลขที่งาน <?php echo substr($row->project_id, 0, 3); ?> <?php echo substr($row->project_id, 3, 3); ?> <span class="badge badge-primary"></span></h6>
											<p class="card-subtitle mb-1 text-muted d-none">14 ธ.ค. 2019</p>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row justify-content-center align-items-start">
								<div class="col-11 col-md-8 mt-3">
									<div class="d-flex justify-content-center align-items-center">
										<div class="d-block text-center">
											<?php if($row->project_desc != "-" || empty($row->project_desc)) : ?>
												<h5 class="card-title mb-2"><strong>ข้อมูลอาคาร</strong></h5>
												<p class="mb-0 "><?php echo $row->project_desc; ?></p>
											<?php endif;?>
											<?php if($row->project_customer != "-" || empty($row->project_customer)) : ?>
												<p class="mb-0">ผู้ดูแลอาคาร : <?php echo $row->project_customer; ?></p>
											<?php endif;?>
										</div>
									</div>
								</div>
							</div>
							<div class="row justify-content-center">
								<div class="col-md-9 mt-5">
									<div class="row justify-content-center align-items-start">
										<div class="col-10 col-md-3 text-center rounded-circle-container">
											<div class="rounded-circle rounded-circle-custom <?php echo !empty($row->step_1) ? "active" : "" ?>"><i class="feather-1" data-feather="users"></i></div>
											<p class="mb-0">
												<small>วิศวกรเข้าตรวจสอบอาคาร</small>
												<small><br><?php echo !empty($row->step_1) ? "<span class='badge badge-success d-md-none' > เรียบร้อย ". date('d/m/yy', strtotime( $row->step_1 )). "</span>" : ""  ?></small>
											</p>
										</div>
										<div class="col-10 col-md-3 text-center rounded-circle-container">
											<div class="rounded-circle rounded-circle-custom <?php echo !empty($row->step_2) ? "active" : "" ?>"><i class="feather-1" data-feather="clipboard"></i></div>
											<p class="mb-0">
												<small>จัดทำรายงานตรวจสอบ รายการแก้ไข ข้อเสนอแนะ</small>
												<small><br><?php echo !empty($row->step_2) ? "<span class='badge badge-success d-md-none' > เรียบร้อย ". date('d/m/yy', strtotime( $row->step_2 )). "</span>" : ""  ?></small>
											</p>
										</div>
										<div class="col-10 col-md-3 text-center rounded-circle-container">
											<div class="rounded-circle rounded-circle-custom <?php echo !empty($row->step_3) ? "active" : "" ?>"><i class="feather-1" data-feather="send"></i></div>
											<p class="mb-0">
												<small>ส่งเอกสารให้หน่วยงานราชการ</small>
												<small><br><?php echo !empty($row->step_3) ? "<span class='badge badge-success d-md-none' > เรียบร้อย ". date('d/m/yy', strtotime( $row->step_3 )). "</span>" : ""  ?></small>

											</p>
										</div>
										<div class="col-10 col-md-3 text-center rounded-circle-container">
											<div class="rounded-circle rounded-circle-custom <?php echo !empty($row->step_4) ? "active" : "" ?>"><i class="feather-1" data-feather="check-circle"></i></div>
											<p class="mb-0">
												<small>เสร็จสิ้น <br>ได้รับใบ ร.1</small>
												<small><br><?php echo !empty($row->step_4) ? "<span class='badge badge-success d-md-none' > เรียบร้อย ". date('d/m/yy', strtotime( $row->step_4 )). "</span>" : ""  ?></small>
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="row justify-content-center p-3">
								<div class="col col-lg-10 mt-0 p-3 mb-0 mt-md-4 mb-md-4">
									<h5 class="text-center mb-3 d-none d-md-block"><strong>รายละเอียด</strong></h5>
									<div class="card bg-light p-3 pt-4 mb-4 rounded-0 d-none d-md-block">
										<ul class="card-custom">
											<?php if (empty($row->step_1)) : ?>
												<li>
													<div class="row">
														<div class="col-3 mb-2"><?php echo date('d/m/yy'); ?></div>
														<div class="col-9 mb-2">ลงทะเบียน ระบบติดตามโครงการ <br><a href="#" class='badge badge-primary text-white'>ไฟล์เอกสาร</a></div>
													</div>
												</li>
											<?php endif;?>
											<?php if (!empty($row->step_1)) : ?>
											<li>
												<div class="row">
													<div class="col-3 mb-1"><?php echo date('d/m/yy', strtotime( $row->step_1 ) ); ?></div>
													<div class="col-9 mb-1">วิศวกรเข้าตรวจสอบอาคาร <br><a href="<?php echo !empty($row->_file1) ? $row->_file1 : 'javascript:;' ?>" class='badge badge-primary text-white px-1 <?php echo empty($row->_file1) ? 'd-none' : '' ?>'>ไฟล์เอกสาร</a></div>
												</div>
											</li>
											<?php endif;?>
											<?php if (!empty($row->step_2)) : ?>
											<li>
												<div class="row">
													<div class="col-3 mb-1"><?php echo date('d/m/yy', strtotime( $row->step_2 ) ); ?></div>
													<div class="col-9 mb-1">จัดทำรายงานตรวจสอบ รายการแก้ไข ข้อเสนอแนะ <br><a href="<?php echo !empty($row->_file2) ? $row->_file2 : 'javascript:;' ?>" class='badge badge-primary text-white px-1 <?php echo empty($row->_file2) ? 'd-none' : '' ?>'>ไฟล์เอกสาร</a></div>
												</div>
											</li>
											<?php endif;?>
											<?php if (!empty($row->step_3)) : ?>
											<li>
												<div class="row">
													<div class="col-3 mb-1"><?php echo date('d/m/yy', strtotime( $row->step_3 ) ); ?></div>
													<div class="col-9 mb-1">ส่งเอกสารให้หน่วยงานราชการ <br><a href="<?php echo !empty($row->_file3) ? $row->_file3 : 'javascript:;' ?>" class='badge badge-primary text-white px-1 <?php echo empty($row->_file3) ? 'd-none' : '' ?>'>ไฟล์เอกสาร</a></div>
												</div>
											</li>
											<?php endif;?>
											<?php if (!empty($row->step_4)) : ?>
											<li>
												<div class="row">
													<div class="col-3 mb-1"><?php echo date('d/m/yy', strtotime( $row->step_4 ) ); ?></div>
													<div class="col-9 mb-1">เสร็จสิ้น ได้รับใบ ร.1 <br><a href="<?php echo !empty($row->_file4) ? $row->_file4 : 'javascript:;' ?>" class='badge badge-primary text-white <?php echo empty($row->_file4) ? 'd-none' : '' ?>'>ไฟล์เอกสาร</a></div>
												</div>
											</li>
											<?php endif;?>
										</ul>
									</div>
									<a href="<?php echo !empty($row->_file4) ? $row->_file4 : 'javascript:;' ?>" <?php echo empty($row->_file4) ? 'download' : '' ?> class="btn btn-block text-white cursor-pointer <?php echo !empty($row->step_4) && !empty($row->_file4) ? "btn-primary" : "btn-secondary rounded-0" ?>"><span><i data-feather="file-text"></i> ดาวน์โหลด ใบ ร.1</span></a>
									<p class="card-subtitle mb-1 text-muted mt-3 text-center" style="line-height : 1;"><small>ท่านจะสามารถดาวน์โหลด ใบ ร.1 ได้เมื่อกระบวนการเสร็จสิ้น <br>และกระบวนการทางราชการ เรียบร้อยแล้ว</small></p>
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

		.badge-primary{
			background : #2f5397!important;
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

</html>