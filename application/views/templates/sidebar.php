
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
				<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
					<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
					<form class="sidebar-search " action="extra_search.html" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
                
                <li <?php if($title == 'home') echo 'class="start active open"'; else echo 'class="start "';?>>
					<a href="<?php echo base_url();?>home">
					<i class="icon-home"></i>
					<span class="title">الصفحة الرئيسية</span>
					<?php if($title == 'home')
					echo '<span class="selected"></span>
						  <span class="arrow"></span>'; 
					else
						echo '<span class="arrow "></span>';
					?>
					</a>
					
				</li>
                <?php
				$res_menue = $this->session->userdata('menue');

					$menueid ='';
					$headmenue ='';
					$menuetitle = '';
					$submenue = '';
					$endmenue = '';
					
					$open_menue = '<li>';
					$menue_link = '<a href="javascript:;">';
					$menue_icon = '<i class="icon-home"></i>';
					$menue_name = '';
					$menue_arrow = '<span class="arrow"></span></a>';
					$open_sub_menue = '<ul class="sub-menu">';
					$sub_menue_item = '';
					$end_sub_menue = '</ul>';
					$end_menue = '</li>';
					
					foreach($res_menue as $row)
					{
						$url = explode("/", $row->page_url);
						$page = $url[1];
						
						if ($menueid == '')
						{
							$menueid = $row->menu_id;
							
							$menue_icon = '<i class="'.$row->menu_icon.'"></i>';
							$menue_name = '<span class="title">'.$row->menu_name.'</span>';
						}
						else if($row->menu_id != $menueid)
						{
							echo $open_menue;
							echo $menue_link;
							echo $menue_icon;
							echo $menue_name;
							echo $menue_arrow;
							echo $open_sub_menue;
							echo $sub_menue_item;
							echo $end_sub_menue;
							echo $end_menue;
							
							$menueid = $row->menu_id;
							$sub_menue_item = '';
							
							$open_menue = '<li>';
							$menue_arrow = '<span class="arrow"></span></a>';
							
							$menue_icon = '<i class="'.$row->menu_icon.'"></i>';
							$menue_name = '<span class="title">'.$row->menu_name.'</span>';
							
							/*$headmenue = ' <li>
											  <a href="javascript:;">
											  <i class="icon-home"></i>
											  <span class="title">'.$row->menu_name.'</span>
											  <span class="arrow "></span>
											  </a>
											  <ul class="sub-menu">';*/
						}
						
						if($title == $page)
						{
							$open_menue = '<li class="active open">';
							$menue_arrow = '<span class="selected"></span>
						  					<span class="arrow open"></span></a>';
											
							if ($row->show_in_menue == 1)
							{
							  $sub_menue_item = $sub_menue_item.
											   '<li class="active">
													<a href="'.base_url().$row->page_url.'">
													<i class="'.$row->page_icon.'"></i>
													'.$row->page_title.'</a>
												</li>';
							}
						}
						else
						{
							if ($row->show_in_menue == 1)
							{
							  $sub_menue_item = $sub_menue_item.
											   '<li>
													<a href="'.base_url().$row->page_url.'">
													<i class="'.$row->page_icon.'"></i>
													'.$row->page_title.'</a>
												</li>';
							}
						}
						
					}
					// Print Last Menu Item
					echo $open_menue;
					echo $menue_link;
					echo $menue_icon;
					echo $menue_name;
					echo $menue_arrow;
					echo $open_sub_menue;
					echo $sub_menue_item;
					echo $end_sub_menue;
					echo $end_menue;		
				?>
                
				
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->