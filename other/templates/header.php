

    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white">
        <div class="container">
            
            <a href="<? echo get_home_url();?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/images/performax-logo.png" style="width: 110px;" alt="performax image logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-nav ml-auto">



                        <li class="nav-item mr-5">
                            <a class="nav-link " href="<?php echo get_permalink(get_page_by_path( 'project' ));?>">ผลงาน <span class="sr-only">(current)</span></a>
                        </li>
						<li class="nav-item mr-5">
                            <a class="nav-link" href="<?php echo get_permalink(get_page_by_path( 'about' ));?>">เกี่ยวกับ <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item mr-5">
                            <a class="nav-link" href="<?php echo get_permalink(get_page_by_path( 'service' ));?>">บริการ <span class="sr-only">(current)</span></a>
                        </li>
						<li class="nav-item mr-5">
                            <a class="nav-link" href="<?php echo get_permalink(get_page_by_path( 'knowledge' ));?>">ความรู้ <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item mr-5">
                            <a class="nav-link" href="<?php echo get_permalink(get_page_by_path( 'contact' ));?>">ติดต่อ <span class="sr-only">(current)</span></a>
                        </li>
						<li class="nav-item active mr-5">
                            <a class="nav-link" href="<?php echo get_permalink(get_page_by_path( 'tracking' ));?>">ติดตามงาน <span class="sr-only">(current)</span></a>
                        </li>
                        
                        
                        <li class="nav-item active">
                            <a class="nav-link" href="<?=$th_permalink?>">TH<span class="sr-only">(current)</span></a>
                        </li>
						<li class="nav-item <?=($permalink->th['active']) ? "active" : "" ?>">
                            <a class="nav-link disabled" href="">|<span class="sr-only">(current)</span></a>
                        </li>
						<li class="nav-item disabled <?=($permalink->en['active']) ? "" : "" ?>">
                            <a class="nav-link disabled" href="<?=$en_permalink?>">EN<span class="sr-only">(current)</span></a>
                        </li>

                </ul>
            </div>
        </div>
    </nav>

	<style>
		.disabled{
			cursor: disabled;
		}
	</style>