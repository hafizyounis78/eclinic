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
<table width="100%" border="0">
  <tr>
    <th>اسـم المـريـض</th>
    <td><?php if(isset($patient_row->name)) echo $patient_row->name;else if(isset($visit_row->name)) echo $visit_row->name;?></td>
    <th>رقم الملــف</th>
    <td><?php if(isset($patient_row->patient_file_id)) echo $patient_row->patient_file_id; else if(isset($visit_row->patient_file_id)) echo $visit_row->patient_file_id;?></td>
  </tr>
  <tr>
    <th>تاــرايخ الزيارة</th>
    <td><?php if(isset($currentDate)) echo $currentDate; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="0">
  <tr>
    <th colspan="2">الخــــطــة الغــــذائيـة</th>
  </tr>
  <tr>
    <th>الفطــــور</th>
    <td><?php if(isset($visit_row->breakfast)) echo $visit_row->breakfast;?></td>
  </tr>
  <tr>
    <th>الغـــداء</th>
    <td><?php if(isset($visit_row->lunch)) echo $visit_row->lunch;?></td>
  </tr>
  <tr>
    <th>العشـــاء</th>
    <td><?php if(isset($visit_row->dinner)) echo $visit_row->dinner;?></td>
  </tr>
</table>

