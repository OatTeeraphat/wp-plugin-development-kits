<?php

    function wp_project_list($rows_result) {

        global $wpdb;

        $table_name = $wpdb->prefix . "project_flow";

        $pagenum = $rows_result['pagenum'];
        $limit = $rows_result['limit'];

        $offset = ( $pagenum - 1 ) * $limit;
        $total = $rows_result['total'];
        $num_of_pages = ceil( $total / $limit );

        $rows = $rows_result['rows'];
        $rowcount =  $rows_result['rowcount'];

        $http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $current_url = $http . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    ?>	

		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
		<style>
		.mb-15{ margin-bottom : 15px; }
		#example > thead td {}
		table{ width: 100%; background: #fff; border: 1px solid #000; position: relative; }
		.dataTables_length{ margin-bottom : 15px; }
		</style>
        <div class="wrap abs">
            <!-- <div class="tablenav top mb-15">
                <div class="alignleft actions">
                    <a href="<?php echo admin_url('admin.php?page=mywp_schools_create'); ?>" class="button action">Add New</a>
                </div>
                <br class="clear">
            </div> -->
            <?php
            $path_array = wp_upload_dir()['baseurl']; // wp_upload_dir has diffrent types of array I am used 'baseurl' for path

            ?>

            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="no-sort" style="width: 30px;padding: 10px;">เลือก</th>
                        <th>เลขที่</th>
                        <th class="no-sort">อาคาร</th>
                        <th>รหัสติดตาม</th>
                        <th>อัพเดท</th>
                        <th class="no-sort" >ตรวจสอบ</th>
                        <th class="no-sort" >ออกรายงาน</th>
                        <th class="no-sort" >ส่งเรื่อง</th>
                        <th class="no-sort" >เสร็จสิ้น</th>
                        <th class="no-sort" >ใบ ร1</th>
                        <th class="no-sort" >วันที่</th>
                    </tr>
                </thead>
                <tbody>
        
                    <?php foreach ($rows as $key => $value) { ?>
        
                    <tr>
                        <td class="check"><input type="checkbox" name="_check[]" value="<?php echo $value->project_id ?>" /></td>
                        <td><?php echo $value->project_id ?></td>
                        <td>
                            <strong style="font-size: 15px; position: relative; top: -2px;">
                                <?php echo $value->project_name ?>
                            </strong><br>
                            <p style="line-height: 1.2; margin: 5px 0 3px; color: #4b4b4b; font-style: italic;">
                                <?php echo $value->project_desc ?> - <?php echo $value->project_customer ?><br>
                            </p>
                            <div class="row-actions">
                                <span class="untrash"><a href="<?php echo home_url( '/tracking/' ); ?>?edit=<?php echo substr($value->project_id, 0, 6); ?><?php echo $value->_hash ?>" target="_blank" aria-label="กู้คืน “หน้าตัวอย่าง” จากถังขยะ">แก้ไข</a> | 
                                </span><span class="delete"><a href="<?php echo $current_url . '&delete=true&id=' . $value->project_id ?>" class="submitdelete" aria-label="ลบ “หน้าตัวอย่าง” อย่างถาวร">ลบรายการ</a></span></div>
                        </td>
                        <td><a href="<?php echo home_url( '/tracking/' )  . '?id=' . $value->project_id . $value->_hash; ?>" target="_blank"><?php echo $value->project_id . $value->_hash ?></a></td>
                        <td><?php echo $value->_update ?></td>
                        <td><?php echo $value->step_1 ? '<div alt="f12a" class="dashicons dashicons-yes-alt">' : '<div alt="f460" class="dashicons dashicons-minus">' ?></div></td>
                        <td><?php echo $value->step_2 ? '<div alt="f12a" class="dashicons dashicons-yes-alt">' : '<div alt="f460" class="dashicons dashicons-minus">' ?></div></td>
                        <td><?php echo $value->step_3 ? '<div alt="f12a" class="dashicons dashicons-yes-alt">' : '<div alt="f460" class="dashicons dashicons-minus">' ?></div></td>
                        <td><?php echo $value->step_4 ? '<div alt="f12a" class="dashicons dashicons-yes-alt">' : '<div alt="f460" class="dashicons dashicons-minus">' ?></div></td>
                        <td>
                            
                            <?php if(empty($value->_file)): ?>
                                <div alt="f460" class="dashicons dashicons-minus">
                            <?php else: ?>
                                <a download style="text-decoration : none;" href="<?php echo $value->_file;?>">
                                    <span class="dashicons dashicons-media-text" style="font-size: 25px; line-height: 0.7em;"></span> .pdf
                                </a>
                            <?php endif; ?>

                        </td>
                        <td class="column-date">
                            แก้ไขล่าสุด <span title=""><?php echo date('d/m/yy', strtotime( $value->_update ) ); ?></span>
                        </td>
                    </tr>
        
                    <?php } ?>
        
                </tbody>
            </table>

        </div>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function($) {
				$('#example').DataTable({
                    order: [ 4, 'desc' ],
                    paging: false,
                    searching: false,
                    columnDefs: [
                        { targets: 'no-sort', orderable: false },
                        { targets: [4], className: "hidden" },
                        { targets: [0], width : "0px" },  
                        { targets: [1], width : "30px" },
                        { targets: [0,1,3,5,6], className: "dt-center" },
                        { targets: [2], width : "550px", padding : "30px" },
                        { targets: [3,10], width : "90px" },
                        { targets: [7,8,9], width : "30px", className: "dt-center"}
                    ],
                    language: {
                        info: "แสดงหน้า <?php echo $pagenum; ?> จาก <?php echo $num_of_pages; ?> หน้า (ทั้งหมด <?= $total; ?> รายการ)",
                        zeroRecords: "<div style='font-size: 1.2em; padding: 30px;'>ไม่พบรายการที่คุณค้นหา</div>",

                    }
                });
			} );
			})(jQuery);
		</script>
        <style>
            th.dt-center, td.dt-center { text-align: center; }
            .dashicons-yes-alt{color: green; font-size: 1.75em;}
            .submitdelete{color:red;}
            .dataTables_paginate.paging_simple_numbers{ margin-top : 5px; }
            input[type="checkbox"]{margin-right: 0;}
            .check{width: 10px; padding: 7.5px;}
            .row-actions{left:0;}
        </style>

        <?php

        $page_links = paginate_links( array(
            'base' => add_query_arg( 'pagenum', '%#%' ),
            'format' => '',
            'prev_text' => __( '&laquo;', 'text-domain' ),
            'next_text' => __( '&raquo;', 'text-domain' ),
            'total' => $num_of_pages,
            'current' => $pagenum
        ) );

        if ( $page_links ) {
            echo '<div class="tablenav" style="width: 99%;"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
        }
}
?>