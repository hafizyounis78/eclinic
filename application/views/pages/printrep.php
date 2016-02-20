<?php 

if (isset($patient_info))				
{
	foreach($patient_info as $patient_row);
}
if(isset($visit_info))
{
	foreach($visit_info as $visit_row);
}
$plan_table = "";
if (isset($plan_info))				
{
	$days = array( 
			1 => 'اليوم الأول',
			2 => 'اليوم الثاني',
			3 => 'اليوم الثالث', 
			4 => 'اليوم الرابع',
			5 => 'اليوم الخامس',
			6 => 'اليوم السادس',
			7 => 'اليوم السابع');
		
	$plan_table = '<table width="100%" border="1" style="border-style:solid;border-color:#666;border-width:.1;border-collapse: collapse">
			<thead>
			  <tr class="bg-grey-steel">
				  <th scope="col">
					   &nbsp;
				  </th>
				  <th scope="col">
					الفـطــــور
				  </th>
				  <th scope="col">
					الغـــــداء
				  </th>
				  <th scope="col">
					العشـــــاء
				  </th>
			  </tr>
			</thead>
			<tbody>';
		foreach($plan_info as $row)
		{
			
			$plan_table = $plan_table.
					'<tr>
					  <td><b>'.$days[$row->plan_day_id].'</b></td>
					  <td>'.$row->breakfast.'</td>
					  <td>'.$row->lunch.'</td>
					  <td>'.$row->dinner.'</td>
				 </tr>';
	
		}
		$plan_table = $plan_table.
					'<tr>
					  <td><b>ملاحظــات</b></td>
					  <td colspan="3">'.$row->notes.'</td>
					</tr>';
		$plan_table = $plan_table.' </tbody>
        </table>';
	
}

?>
<div style="background-image:url(<?php echo base_url();?>assets/admin/layout/img/prescription.jpg);background-repeat:no-repeat;height:1280px">
<div style="height:220px"></div>
<div align="right" dir="rtl">
<table width="100%" border="1" style="border-style:solid;border-color:#333;border-width:.1;border-collapse: collapse">
  <tr>
    <th>اسـم المـريـض</th>
    <td><?php if(isset($patient_row->name)) echo $patient_row->name;else if(isset($visit_row->name)) echo $visit_row->name;?></td>
    <th>رقم الملــف</th>
    <td width="10%" align="center"><?php if(isset($patient_row->patient_file_id)) echo $patient_row->patient_file_id; else if(isset($visit_row->patient_file_id)) echo $visit_row->patient_file_id;?></td>
  </tr>
  <tr>
    <th>تاريــخ الزيارة</th>
    <td><?php if(isset($visit_row->visit_date)) echo $visit_row->visit_date; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<?php if(isset($plan_table)) echo $plan_table;?>
<br />
<br />
<br />
</div>
<div align="left">
	<b>الدكتور/</b>  
	 <?php $sdata = $this->session->userdata('logged_in');
                       echo $sdata['name'];?>
</div>
</div>