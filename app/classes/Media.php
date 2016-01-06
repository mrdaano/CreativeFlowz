<?php
	
class Media {
	
	private $dir = "media";
	private $errors = array(), $acceptedTypes = array("png","jpg","jpeg","gif","svg","pdf","mp4","mov");
	
	public function __construct() {
		
	}
	
	public function getMedia() {
		return Database::start()->get('*', 'media')->results();
	}
	
	public function deleteFile($id) {
		$item = Database::start()->get('*', 'media', array(array('id','=',$id)));
		
		if ($item->count() > 0) {
			$item = $item->first();
			unlink($item->path."/".$item->name);
			Database::start()->delete('media', array(array('id', '=', $id)));
			return true;
		}
		return false;
		
	}
	
	public function addFile($inputName = 'file') {
		$this->errors = array();
		$dir = $this->dir . "/" . date("Y-m");
		$error = false;
		$file = $_FILES[$inputName];
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		$name = $file['name'];
		$dest = $dir . "/" . $name;
		
		if ($file['size'] == 0 && $file['error'] == 4) {
			$this->addError("Er is geen bestand geselecteerd, probeer het opnieuw.");
			return false;
		}
		
		if (!in_array($ext, $this->acceptedTypes)) {
			$this->addError("Dit bestandstype is niet geaccepteerd.");
			$error = true;
		}
		
		if (!file_exists($dir)) {
			mkdir($dir, 0777);
		}
		
		if (file_exists($dest)) {
			$num = substr(hexdec(uniqid()), 11);
			$dest = $dir . "/" . $num . "." . $ext;
			$name = $num . "." . $ext;
		}
		
		if (move_uploaded_file($file["tmp_name"], $dest)) {
			$db = Database::start()->insert('media', array(
					'name' => $name,
					'path' => $dir
				))->error();
			
			if (!$db) {
				return true;
			}
			
		}
		
		$this->addError("Sorry, we kunnen uw bestand niet uploaden. Probeer het a.u.b. opnieuw.");
		return false;
		
	}
	
	public function getType($string) {
		$imageExt = array("png","jpg","jpeg","gif","svg");
		$movExt = array("mp4", "mov");
		if (in_array(pathinfo($string, PATHINFO_EXTENSION), $imageExt)) {
			return "Afbeelding";
		} else if (in_array(pathinfo($string, PATHINFO_EXTENSION), $movExt)) {
			return "Film";
		}
		return "Bestand";
	}
	
	public function getErrors() {
		return $this->errors;
	}
	
	private function addError($error) {
		if (is_string($error)) {
			array_push($this->errors, $error);
		}
	}
}