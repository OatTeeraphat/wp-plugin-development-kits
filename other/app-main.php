<?php 	

		global $wpdb;

        $table_name = $wpdb->prefix . "project_flow";

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;      

        $limit = 10; // number of rows in page
		$offset = ( $pagenum - 1 ) * $limit;
		
		if(!empty($_POST['search'])){

			$search = $_POST['search'];
			$where_cause = "`project_id` LIKE '$search%' OR 
							`project_name` LIKE '%$search%' OR
							`_hashc` LIKE '$search'";

			$total = $wpdb->get_var( "select count(*) as total from $table_name where $where_cause ");

			$num_of_pages = ceil( $total / $limit );

			$rows_search = $wpdb->get_results( "SELECT * from $table_name WHERE $where_cause ORDER BY `_update` DESC LIMIT $offset, $limit ");
			$rowcount_search = $wpdb->num_rows;
			
		} else {

			$total = $wpdb->get_var( "select count(*) as total from $table_name" );
			$num_of_pages = ceil( $total / $limit );

			$rows = $wpdb->get_results( "SELECT * from $table_name ORDER BY `_update` DESC LIMIT $offset, $limit ");
			$rowcount = $wpdb->num_rows;

		}

		$rows = isset($rows) ? $rows : $rows_search;
		$rowcount = isset($rowcount) ? $rowcount : $rowcount_search;

		$rows_result = array(
			"rows" =>  $rows,
			"rowcount" => $rowcount ,
			"num_of_pages" => $num_of_pages,
			"total" => $total,
			"limit" => $limit,
			"pagenum" => $pagenum
		);

		if($_POST['action'] == 'remove'){

			$items = $_POST['_check'];
			$ids = implode("','", $items);
			$wpdb->get_results("DELETE FROM $table_name WHERE `project_id` IN ('".$ids."')");

			$count = count($items);
			
		};

		if($_GET['delete'] == 'true'){

			$item = $_GET['id'];
			$wpdb->get_results("DELETE FROM $table_name WHERE `project_id` = $item");
			$count = 1;
			
		}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<div class="wrap">

	<div class="row">
		<h1>
			โครงการทั้งหมด 
			<a data-fancybox data-src="#create-content" href="javascript:;" class="page-title-action">
				เขียนหน้าใหม่
			</a>
		</h1>
	</div>

	<div class="row">
		<?php if (isset($count)) : ?>
		<div id="message" class="updated notice is-dismissible">
			<p>ลบ <?=$count;?> รายการอย่างถาวรแล้ว</p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text">ยกเลิกคำเตือนนี้</span>
			</button>
		</div>
		<?php endif; ?>
	</div>



	<ul class="subsubsub">
		<li class="all"><a href="javascript:;" class="current" aria-current="page">ทั้งหมด <span class="count">(<?=$total;?>)</span></a></li>|
		<li class="all"><a href="" aria-current="page">โหลดใหม่</a></li>
	</ul>
	

	<form method="post" id="table" action="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>">
		
		<p class="search-box" style="position: relative; left: -20px;" >
			<label class="screen-reader-text" for="post-search-input">ค้นหา:</label>
			<input type="search" id="post-search-input" name="search" placeholder="เลขที่, ชื่ออาคาร" value="<?=isset($search)? $search : ""?>">
			<input type="submit" id="search-submit" class="button" value="ค้นหา">
		</p>

		<div class="tablenav top">
			<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-top" class="screen-reader-text">เลือกการกระทำแบบกลุ่ม</label>
				<select name="action" id="bulk-action-selector-top">
					<option value="-1">คำสั่งจำนวนมาก</option>
					<option value="remove">ลบที่เลือก</option>
				</select>
				<input type="submit" id="doaction" class="button action" value="นำไปใช้">
			</div>
			<div class="alignright" style="position: relative; top: 10px; left: -10px;">
				<?php if(!isset($search)) :?>
				แสดงหน้า <?php echo $pagenum; ?> จาก <?php echo $num_of_pages; ?> หน้า (ทั้งหมด <?= $total; ?> รายการ)
				<?php else :?>
				ค้นหา "<?=$search?>" พบ <?= $total; ?> รายการ
				<?php endif;?>
			</div>
		</div>
		

		<?php include 'app-page-listproject.php'; wp_project_list($rows_result); ?>

		<br class="clear">

		<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">เลือกการกระทำแบบกลุ่ม</label>
			<select name="action" id="bulk-action-selector-top">
				<option value="-1">คำสั่งจำนวนมาก</option>
				<option value="edit" class="hide-if-no-js">แก้ไข</option>
				<option value="trash">ย้ายไปถังขยะ</option>
			</select>
			<input type="submit" id="doaction" class="button action" value="นำไปใช้">
		</div>

	</form>

	

</div>

	<div style="display: none;" id="create-content" >

		<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document" style="text-align: center;" >
				<div class="modal-content">
				<div class="modal-header justify-content-center border-0">
					<div class="text-center">
						<h3 class="mb-0" style="margin: 0; font-size: 1.5em; text-align: center;">เพิ่มโครงการ</h3>
						<p class="mb-0" style=" margin: 5px 0 15px; ">กรุณากรอกข้อมูล</p>
					</div>
				</div>
				<div class="modal-body py-0">

					<div class="row justify-content-center">
						<div class="col-12 col-md-6" >
							<div class="form-group">
								<input type="number" class="form-control" id="book_id" onKeyPress="if(this.value.length==3) return false;" maxlength="3" placeholder="เล่มที่" required style="width: 100%; margin-bottom: 10px; font-size: 15px; border: 1px solid #494949;">
								<input type="number" class="form-control" id="project_id" onKeyPress="if(this.value.length==3) return false;" maxlength="3" placeholder="เลขที่" required style="width: 100%; margin-bottom: 10px; font-size: 15px; border: 1px solid #494949;">
								<input type="button" onclick="submit(this)" id="doaction" class="button action" value="เพิ่มใหม่">
								<script>
									function submit(a) {
										var book_id = $(a).parent().find("#book_id").val();
										var project_id = $(a).parent().find('#project_id').val();
										$('#error_id').hide();

										if(book_id!="" && project_id!=="" && book_id.length==3 && project_id.length==3){
											$(a).parent().find("#book_id").val("")
											$(a).parent().find('#project_id').val("")
											$(".fancybox-close-small").click()
											return window.open(
												"<?php echo home_url( '/tracking/' )  . '?create=' ;?>" + `${book_id}${project_id}`,
												"_blank"
											);
										}

										setTimeout(() => {
											$('#error_id').show();
										},200);

									}				
								</script>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-center border-0">
					<div class="row" style=" width: 100%; ">
						<div class="col p-0">
							
							<div class="row justify-content-center">
								<small id="error_id" class="text-danger mt-2" style="display : none; position: relative;top: 5px;color: #F44336;">โปรดใส่ข้อมูลให้ถูกต้อง</small>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>

<style>
	.tablenav{
		width: 99%;
		position: relative;
	}
	.tablenav-pages{
		position: relative;
		float: none !important;
		top: -12px;
	}
	.tablenav-pages a, .tablenav-pages span{
		margin: 0 5px 0 0;
		font-size: 15px;
		text-align: center;
	}
	.tablenav-pages span{
		padding: 3px 7.5px;
		background: #f4f5f6;
		border: 1px solid #0171a1;
		border-radius: 3px;
	}
	.mb-0{
		margin-bottom : 0;
	}
	.fancybox-content{
		display: inline-block;
		padding: 30px;
		width: 300px;
	}
	table.dataTable td{
		vertical-align: top;
    	font-size: 14px;
	}
	table.dataTable.no-footer {
		border-color: #ccd0d4;
	}
	table.dataTable thead th, table.dataTable thead td {
		border-color: #ccd0d4;
	}
	table.dataTable thead th, table.dataTable tfoot th {
		font-weight: normal;
		font-size: 14px;
		color: #000;
	}
</style>

<script>

	(function() {
	'use strict';
	window.addEventListener('load', function() {

		var btn = document.getElementsByClassName('register');
		var forms = document.getElementsByClassName('needs-validation');
		
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

	

</script>

