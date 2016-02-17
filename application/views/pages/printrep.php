<?php 

if (isset($patient_info))				
{
	foreach($patient_info as $patient_row);
}
if(isset($visit_info))
{
	foreach($visit_info as $visit_row);
}
?>
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
    <td><?php if(isset($visit_info->visit_date)) echo $visit_info->visit_date; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="1" style="border-style:solid;border-color:#666;border-width:.1;border-collapse: collapse">
  <tr>
    <th colspan="2">الخــــطــة الغــــذائيـة</th>
  </tr>
  <tr>
    <th width="10%">الفطــــور</th>
    <td><?php if(isset($visit_row->breakfast)) echo $visit_row->breakfast;?></td>
  </tr>
  <tr>
    <th width="10%">الغـــداء</th>
    <td><?php if(isset($visit_row->lunch)) echo $visit_row->lunch;?></td>
  </tr>
  <tr>
    <th width="10%">العشـــاء</th>
    <td><?php if(isset($visit_row->dinner)) echo $visit_row->dinner;?></td>
  </tr>
</table>
<br />
<br />
<br />
</div>
<div align="left">
	<b>الدكتور/</b>  
	 <?php $sdata = $this->session->userdata('logged_in');
                       echo $sdata['name'];?>
</div>