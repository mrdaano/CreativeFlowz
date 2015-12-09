<?php
	
class Media {
	
	private static $dir = "/media";
	private $errors = array();
	
	public function __construct() {
		
	}
	
	public function getMedia() {
		return DB::start()->get('*', 'media')->results();
	}
	
	public function deleteFile($id) {
		
	}
	
	public function addFile($inputName = 'file') {
		$file = $_FILES[$inputName];
		
		if ($file['size'] == 0 && $file['error'] == 4) {
			$this->addError("Er is geen bestand geselecteerd, probeer het opnieuw.");
			return false;
		}
		
		echo "werkt";
		
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