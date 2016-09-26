<?php defined('SYSPATH') or die('No direct access allowed.');

Class Model_Home extends Model {


	//Add new records
	public function add_profile($title, $filename, $img_url)
	{
		$sql = 	" 	INSERT INTO 
						profile (title, filename, img_url) 
		 			VALUES 
		 				(:a, :b, :c) 
				";

		$result = DB::query(Database::INSERT, $sql);
		$result->parameters(array(
		    ':a' => $title,
		    ':b' => $filename,
		    ':c' => $img_url
		));

		return $result->execute();
	}

	//Update records
	public function update_profile($id, $title, $filename, $img_url)
	{
		$result = '';
		if ($filename!==''){
			$sql = 	" 	UPDATE 
							profile 
						SET 
							title = :a, filename = :b, img_url = :c 
			 			WHERE 
			 				id = :d 
					";

			$result = DB::query(Database::UPDATE, $sql);
			$result->parameters(array(
			    ':a' => $title,
			    ':b' => $filename,
			    ':c' => $img_url,
			    ':d' => $id
			));
		} else {			
			$sql = 	" 	UPDATE 
							profile 
						SET 
							title = :a 
			 			WHERE 
			 				id = :b 
					";

			$result = DB::query(Database::UPDATE, $sql);
			$result->parameters(array(
			    ':a' => $title,
			    ':b' => $id
			));
		}
		
		return $result->execute();
	}

	//Delete records
	public function delete_profile($id)
	{
		$sql = 	" 	DELETE 
					FROM 
						profile
		 			WHERE 
		 				id = :a 
				";

		$result = DB::query(Database::DELETE, $sql);
		$result->parameters(array(
		    ':a' => $id
		));

		return $result->execute();
	}

	//Search records
	public function search_profile_list($offset,$search)
	{
		$sql = 	" 	SELECT 
						*
				  	FROM 
						profile 
					WHERE
						title LIKE '%".$search."%' 
					ORDER BY
						id DESC
					LIMIT ".$offset.", 10 
				";

		$result = DB::query(Database::SELECT, $sql);

		return $result->execute()->as_array();
	}


	//Get all records
	public function get_all_profile_list($offset = 0)
	{
		$sql = 	" 	SELECT 
						* 
				  	FROM 
						profile 
					ORDER BY
						id DESC
					LIMIT ".$offset.", 10 
				";

		$result = DB::query(Database::SELECT, $sql);

		return $result->execute()->as_array();
	}

} // End Home Model