<?php
/**
 * Class to handle all the StudentClass details
 * This class will have CRUD methods for StudentClass
 *
 * @author Randi Kodikara
 *
 */

class StudentClassManagement {

    private $conn;

    function __construct() {
        require_once '../../model/commen/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
		
/*
 * ------------------------ STUDENT CLASS TABLE METHODS ------------------------
 */

    /**
     * Creating new student_class
     *
     * @param Int $year year for the system
	 * @param Int $stu_id student id for the system
	 * @param Int $clz_id class id for the system
	 * @param Int $clz_report_id class report id for the system
	 * @param Int $prefect_report_id prefect report id for the system
	 *
     * @return database transaction status
     */
    public function createStudentClass($year, $stu_id, $clz_id, $clz_report_id, $prefect_report_id, $recode_added_by ) {
		
        $response = array();
		
        // First check if student_class already existed in db
        if (!$this->isStudentClassExists($year,$stu_id)) {
  
            // insert query
			 $stmt = $this->conn->prepare("INSERT INTO student_class(year, stu_id, clz_id, clz_report_id, prefect_report_id, recode_added_by) values(?,?,?,?,?,?)");
			 $stmt->bind_param("iiiiii", $year, $stu_id, $clz_id, $clz_report_id, $prefect_report_id, $recode_added_by );
			 $result = $stmt->execute();

			 $stmt->close();

        } else {
            // student_class is not already existed in the db
            return ALREADY_EXISTED;
        }
		         
        // Check for successful insertion
        if ($result) {
			// student_class successfully inserted
            return CREATED_SUCCESSFULLY;
        } else {
            // Failed to create student_class
            return CREATE_FAILED;
        }
        
		return $response;

    }
	
	/**
     * Update student_class
     *
     * @param Int $year year for the system
	 * @param Int $stu_id student id for the system
	 * @param Int $clz_id class id for the system
	 * @param Int $clz_report_id class report id for the system
	 * @param Int $prefect_report_id prefect report id for the system
	 * @param String $recode_added_by 
     *
     * @return database transaction status
     */
    public function updateStudentClass($year, $stu_id, $clz_id, $clz_report_id, $prefect_report_id) {
		
        $response = array();
        // First check if student_class already existed in db
        if ($this->isStudentClassExists($year, $stu_id)) {
            
			//
			$stmt = $this->conn->prepare("UPDATE student_class SET clz_id = ?, clz_report_id = ?,  prefect_report_id= ?,  status = 2,  recode_modified_at = now() , recode_modified_by = ? where year = ? and stu_id = ? and (status = 1 or status = 2)");
			$stmt->bind_param("iiiiii", $clz_id, $clz_report_id, $prefect_report_id, $recode_added_by, $year, $stu_id);
			$result = $stmt->execute();

			$stmt->close();

        } else {
            // student_class is not already existed in the db
            return NOT_EXISTED;
        }
		         
        // Check for successful update
        if ($result) {
			// student_class successfully update
            return UPDATE_SUCCESSFULLY;
        } else {
            // Failed to update student_class
            return UPDATE_FAILED;
        }
        
		return $response;

    }
	
/**
     * Delete student_class
     *
     * @param Int $year year for the system
	 * @param Int $stu_id student id for the system
	 * @param String $recode_added_by
     *
     * @return database transaction status
     */
    public function deleteStudentClass($year, $stu_id, $recode_added_by ) {
		
        $response = array();
        // First check if student_class already existed in db
        if ($this->isStudentClassExists($year, $stu_id)) {
           			
			//
			$stmt = $this->conn->prepare("UPDATE student_class set status = 3, recode_modified_at = now() , recode_modified_by = ? where year = ? and stu_id = ? and (status = 1 or status = 2)");
			$stmt->bind_param("iii",$recode_added_by, $year, $stu_id);
			$result = $stmt->execute();
			
            $stmt->close();

        } else {
            // student_class is not already existed in the db
            return NOT_EXISTED;
        }
		         
        // Check for successful insertion
        if ($result) {
			// student_class successfully deleted
            return DELETE_SUCCESSFULLY;
        } else {
            // Failed to delete student_class
            return DELETE_FAILED;
        }
        
		return $response;

    }
	  
	/**
     * Fetching student_class by year, stu_id
	 *
     * @param Int $year year for the system
	 * @param Int $stu_id student id for the system
	 *
	 *@return student_class object only needed data
     */
    public function getStudentClass($year, $stu_id) {
        
			$stmt = $this->conn->prepare("SELECT year, stu_id, clz_id, clz_report_id, prefect_report_id, status, recode_added_at, recode_added_by FROM student_class where year = ? and stu_id = ? and (status = 1 or status = 2)");
			$stmt->bind_param("ii",$year, $stu_id);
			if ($stmt->execute()) {
            $stmt->bind_result($year, $stu_id, $clz_id, $clz_report_id, $prefect_report_id, $status, $recode_added_at, $recode_added_by);
            $stmt->fetch();
            $student_class = array();
            $student_class["year"] = $year;
			$student_class["stu_id"] = $stu_id;
			$student_class["clz_id"] = $clz_id;
			$student_class["clz_report_id"] = $clz_report_id;
			$student_class["prefect_report_id"] = $prefect_report_id;
			$student_class["status"] = $status;
            $student_class["recode_added_at"] = $recode_added_at;
			$student_class["recode_added_by"] = $recode_added_by;

            $stmt->close();
            return $student_class;
        } else {
            return NULL;
        }
	}
/*
 * ------------------------ SUPPORTIVE METHODS ------------------------
 */

	/**
     * Checking for duplicate student_class by year, stu_id
     *
     * @param Int $year, $stu_id student_class to check in db
     *
     * @return boolean
     */
    private function isStudentClassExists($year, $stu_id) {
		//$year = "2010", $stu_id = "1";
		$stmt = $this->conn->prepare("SELECT year, stu_id from student_class WHERE (status = 1 or status = 2) and year = ? and stu_id = ?");
        $stmt->bind_param("ii", $year, $stu_id);
        $stmt->execute();
		$stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return ($num_rows > 0); //if it has more than zero number of rows; then  it sends true
    }
}
?>