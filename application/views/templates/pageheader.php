<!-- END STYLE CUSTOMIZER -->
			<!-- BEGIN PAGE HEADER-->
			<!--<h3 class="page-title">
			<?php // echo $title;?> <small>blank page</small>
			</h3>-->
            <?php
			$res_menue = $this->session->userdata('menue');
			$menuName ='';
			$pageName = '';
			$pageURL= '';
			foreach($res_menue as $row)
			{
				$url = explode("/", $row->page_url);
				
				if ($url[1] == $title)
				{
					$menuName =$row->menu_name;
					$pageName = $row->page_title;
					$pageURL= $row->page_url;
				}
					
			}
			?>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="<?php echo base_url();?>home">الصفحة الرئيسية</a>
						<i class="fa fa-angle-left"></i>
					</li>
                    <?php
					if ($menuName !='')
					{
						echo '<li>
								  <a href="#">'.$menuName.'</a>
								  <i class="fa fa-angle-left"></i>
							  </li>';
					}
					?>
					<li>
						<a href="<?php echo base_url().$pageURL;?>"><?php echo $pageName;?></a>
					</li>
				</ul>
				<div class="page-toolbar">
					<!--<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						Actions <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li>
								<a href="#">Action</a>
							</li>
							<li>
								<a href="#">Another action</a>
							</li>
							<li>
								<a href="#">Something else here</a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="#">Separated link</a>
							</li>
						</ul>
					</div>-->
				</div>
			</div>
			<!-- END PAGE HEADER-->