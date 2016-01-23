<?php
class Usertypepermmodel extends CI_Model
{
	function get_not_allowed_menue()
	{
		extract($_POST);
		
		$myquery = "SELECT mp.menu_page_id, mp.menu_id, m.menu_name, mp.page_id, p.page_title,
							(SELECT user_menu_page_id 
							   FROM user_menu_page_tb ump
							  WHERE ump.user_type_id = ".$user_type_id.
							  " AND ump.menu_page_id = mp.menu_page_id) allowed
					FROM menu_tb m, page_tb p, menu_page_tb mp
					WHERE m.menu_id = mp.menu_id
					  AND p.page_id = mp.page_id
					ORDER BY m.menu_order, p.page_order";
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
	
	function user_menu_page_insert()
	{
		extract($_POST);
		
		$myquery = "INSERT INTO user_menu_page_tb
					(menu_page_id, user_type_id)
					(SELECT menu_page_id,".$user_type_id."
					   FROM menu_page_tb
					  WHERE menu_page_id IN (".implode(",",$values)."))";
		
		$res = $this->db->query($myquery);
		
		
	}
	
	function user_menu_page_delete()
	{
		extract($_POST);
		
		$myquery = "DELETE FROM user_menu_page_tb
					WHERE user_type_id = ".$user_type_id."
					  AND menu_page_id IN (".implode(",",$values).")";
		
		$res = $this->db->query($myquery);
		
		
	}
}
?>