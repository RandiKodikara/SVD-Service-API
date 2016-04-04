<?php
/**
 * Class to handle all the exam details
 * This class will have CRUD methods for exam
 *
 * @author Randi Kodikara
 *
 */

class ClassManagement {

    private $conn;

    function __construct() {
        require_once '../../model/commen/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
	
	
/*
 * ------------------------ CLASS TABLE METHODS ------------------------
 */

    /**
     * Creating new class
     *
     * @param Int $clz_grade Class grade for the system
     * @param String $clz_class Discription of the Class
	 * @param String $recode_added_by 
     *
     * @return database transaction status
     */
    public function createClass($clz_grade, $clz_class,$recode_added_by ) {

		
        $response = array();
		
        // First check if class already existed in db
        if (!$this->isClassExists($clz_grade,$clz_class)) {
  
            // insert query
			 $stmt = $this->conn->prepare("INSERT INTO class(clz_grade, clz_class, recode_added_by) values(?, ?, ?)");
			 $stmt->bind_param("isi", $clz_grade, $clz_class, $recode_added_by );
			 $result = $stmt->execute();

			 $stmt->close();

        } else {
            // Class is already existed in the db
            return ALREADY_EXISTED;
        }
		
         

        // Check for successful insertion
        if ($result) {
			// class successfully inserted
            return CREATED_SUCCESSFULLY;
        } else {
            // Failed to create class
            return CREATE_FAILED;
        }
        
		return $response;

    }
	
/**
     * Delete class
     *
     * @param Int $clz_grade Class grade for the system
	 * @param String $clz_class class of the Class
	 * @param Int $recode_added_by
     *
     * @return database transaction status
     */
    public function deleteClass($clz_grade,$clz_class, $recode_added_by) {

		
        $response = array();
        // First check if class already existed in db
        if ($this->isClassExists($clz_grade,$clz_class)) {
           			
			//
			$stmt = $this->conn->prepare("UPDATE class set status = 3, recode_modified_at = now() , recode_modified_by = ? where clz_grade = ? and clz_class = ? and status=1");
			$stmt->bind_param("iis",$recode_added_by, $clz_grade,$clz_class);
			$result = $stmt->execute();
			
            $stmt->close();

        } else {
            // Class is not already existed in the db
            return NOT_EXISTED;
        }
		
         

        // Check for successful insertion
        if ($result) {
			// class successfully deleted
            return DELETE_SUCCESSFULLY;
        } else {
            // Failed to delete class
            return DELETE_FAILED;
        }
        
		return $response;

    }
	  
	/**
     * Fetching class by clz_grade and clz_class
	 *
     * @param Int $clz_grade Class grade
	 * @param String $clz_class Class class
	 *@return Class object only needed data
     */
    public function getClassByClassName($clz_grade,$clz_class) {
        $stmt = $this->conn->prepare("SELECT clz_grade, clz_class, status, recode_added_at, recode_added_by FROM class WHERE clz_grade = ? and clz_class = ? and status=1");
        $stmt->bind_param("is", $clz_grade,$clz_class);
        if ($stmt->execute()) {
            $stmt->bind_result($clz_grade,  $clz_class, $status, $recode_added_at, $recode_added_by);
            $stmt->fetch();
            $class = array();
            $class["clz_grade"] = $clz_grade;
            $class["clz_class"] = $clz_class;
            $class["status"] = $status;
            $class["recode_added_at"] = $recode_added_at;
			$class["recode_added_by"] = $recode_added_by;

            $stmt->close();
            return $class;
        } else {
            return NULL;
        }
    }
  
  
	/**
     * Fetching all class
	 *
     * @return $class boject set of all class
     */
    public function getAllClass() {
        $stmt = $this->conn->prepare("SELECT * FROM class WHERE status = 1");
        $stmt->execute();
        $class = $stmt->get_result();
        $stmt->close();
        return $class;
    }
	
  
  
  
  
  
/*
 * ------------------------ SUPPORTIVE METHODS ------------------------
 */

	/**
     * Checking for duplicate class by clz_grade and clz_class
     *
     * @param Int $clz_grade class grade to check in db
     * @param String $clz_class class class to check in db
     * @return boolean
     */
    private function isClassExists($clz_grade, $clz_class) {
		//$clz_grade, $clz_class = 5, "a";
		$stmt = $this->conn->prepare("SELECT clz_grade,clz_class from class WHERE status = 1 and clz_grade = ? and clz_class = ?  ");
        $stmt->bind_param("is",$clz_grade, $clz_class);
        $stmt->execute();
		$stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return ($num_rows > 0); //if it has more than zero number of rows; then  it sends true
    }

}

?>
