<?php
	
class Media {
	
	private static $dir = "media";
	private $errors = array(), $acceptedTypes = array("png","jpg","jpeg","gif","svg","pdf","mp4","mov");
	
	public function __construct() {
		
	}
	
	public function getMedia() {
		return DB::start()->get('*', 'media')->results();
	}
	
	public function deleteFile($id) {
		
	}
	
	public function addFile($inputName = 'file') {
		$this->errors = array();
		$dir = $this->dir . "/" . date("Y-m");
		$error = false;
		$file = $_FILES[$inputName];
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		$dest = $dir . "/" . $file['name'] . $ext;
		
		if ($file['size'] == 0 && $file['error'] == 4) {
			$this->addError("Er is geen bestand geselecteerd, probeer het opnieuw.");
			return false;
		}
		
		if (!in_array($ext, $this->$acceptedTypes)) {
			$this->addError("Dit bestandstype is niet geaccepteerd.");
			$error = true;
		}
		
		if (!file_exists($dir)) {
			mkdir($dir);
		}
		
		if (move_uploaded_file($file["tmp_name"], $dest)) {
			return true;
		}
		
		$this->addError("Sorry, we kunnen uw bestand niet uploaden. Probeer het a.u.b. opnieuw.");
		return false;
		
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