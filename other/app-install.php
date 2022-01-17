<?php

// function install()
// {
//     global $wpdb;
//     $installed_ver = get_option( "jal_db_version" );

//     if ( $installed_ver != $jal_db_version ) {
    
//         $table = $wpdb->prefix."project_flow";
//         $structure = "CREATE TABLE $table (
//             id INT(9) NOT NULL AUTO_INCREMENT,
//             project_name VARCHAR(255) NOT NULL,
//             project_desc VARCHAR(255) NOT NULL,
//             project_status INT(1) DEFAULT 0,
//             _hash VARCHAR(20) DEFAULT 0,
//             UNIQUE KEY id (id)
//         );";
//         $wpdb->query($structure);
    
//         // Populate table
//         $wpdb->query("INSERT INTO $table(project_name, project_status)
//             VALUES('Hello Building', 0)");
//     }
    
// }

// <th class="no-sort">ชื่ออาคาร</th>
// <th class="no-sort">ข้อมูลทั่วไป</th>
// <th class="no-sort">ตรวจสอบ</th>
// <th class="no-sort">ทำรายงาน</th>
// <th class="no-sort">ส่งเอกสาร</th>
// <th class="no-sort">เสร็จสิ้น</th>
// <th class="no-sort">ออกใบ ร1</th>

?>