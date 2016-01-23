<?php

class Elderfilemodel extends CI_Model
{
	
	// Get Elder File
	function get_elder_file($elderid)
	{
		$myquery = "SELECT fl.file_id, fl.file_doc_id, fl.elder_id, fl.file_status_id, filestatus.sub_constant_name file_status,
							fl.close_date, fl.close_reason_id, closeres.sub_constant_name closeres, fl.created_on, fl.created_by
					  FROM file_tb fl 
						LEFT OUTER JOIN sub_constant_tb filestatus ON fl.file_status_id = filestatus.sub_constant_id
							LEFT OUTER JOIN sub_constant_tb closeres ON fl.close_reason_id = closeres.sub_constant_id
					 WHERE fl.elder_id = ".$elderid;
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
	
	// Get Elder Docs
	function get_elder_doc($fileid)
	{
		$myquery = "SELECT doc.elder_doc_id, doc.file_id, doc.doc_type_id, doctype.sub_constant_name doc_type , doc.doc_path,
							doc.created_on, doc.created_by
					  FROM elder_doc_tb doc, sub_constant_tb doctype
					 WHERE doc.doc_type_id = doctype.sub_constant_id
					   AND doc.file_id = ".$fileid;
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
	
	function file_update()
	{
		extract($_POST);
		
		$data['file_status_id']  = $drpFilestatus;
		$data['file_doc_id']  = $txtFiledocId;
		if($dpClose == '')
			$data['close_date'] 	 = NULL;
		else
			$data['close_date'] 	 = $dpClose;
		if($drpClosereasone == '')
			$data['close_reason_id'] = NULL;
		else
			$data['close_reason_id'] = $drpClosereasone;
		
		
		
		$this->db->where ('file_id',$hdnFileid);
		$this->db->update('file_tb',$data);
		
	}
	
	//***************** ELDER DOC ***************//
	function elder_doc_insert()
	{
		extract($_POST);
		
		$newfilename = $fileid . mt_rand() . '.' .pathinfo($filename,PATHINFO_EXTENSION);
		
		$data['file_id']     = $fileid;
		$data['doc_type_id'] = $doctype;
		$data['doc_path']    = $newfilename;
		//$data['created_by'] = $_SESSION['username'];
		
		$this->db->insert('elder_doc_tb',$data);
		
		
		// Upload File
		if ($_SERVER['SERVER_NAME'] == "localhost") $dir = "elder";
		else $dir = "app"; 
		
		$target_dir = $_SERVER["DOCUMENT_ROOT"]."/".$dir."/docuploads/";
		$target_file = $target_dir . $newfilename;
		
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
		
	}
	
	// Delete Doc
	function elder_doc_delete()
	{
		extract($_POST);
		
		$this->db->where('elder_doc_id', $elderdocid);
		$this->db->delete('elder_doc_tb');
		
		// Delete File
		if ($_SERVER['SERVER_NAME'] == "localhost") $dir = "elder";
		else $dir = "app"; 
		unlink($_SERVER["DOCUMENT_ROOT"]."/".$dir."/docuploads/".$filename);
	}
	
}
?>