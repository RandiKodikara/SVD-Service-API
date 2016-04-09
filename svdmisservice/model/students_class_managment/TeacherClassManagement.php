<?php
/**
 * Class to handle all the teacherClass details
 * This class will have CRUD methods for teacherClass
 *
 * @author Randi Kodikara
 *
 */

class TeacherClassManagement {

    private $conn;

    function __construct() {
        require_once '../../model/commen/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
		
/*
 * ------------------------ TEACHER CLASS TABLE METHODS ------------------------
 */

    /**
     * Creating new teacher_class
     *
     * @param Int $year Year for the system
	 * @param Int $tec_id Teacher id for the system
	 * @param Int $clz_id class id for the system
     *
     * @return database transaction status
     */
    public function createTeacherClass($year,$tec_id,$clz_id,$recode_added_by ) {
		
        $response = array();
		
        // First check if teacher_class already existed in db
        if (!$this->isTeacherClassExists($year,$tec_id)) {
  
            // insert query
			 $stmt = $this->conn->prepare("INSERT INTO teacher_class(year,tec_id,clz_id, recode_added_by) values(?,?,?,?)");
			 $stmt->bind_param("iiii", $year,$tec_id,$clz_id,$recode_added_by );
			 $result = $stmt->execute();

			 $stmt->close();

        } else {
            // teacher_class is not already existed in the db
            return ALREADY_EXISTED;
        }
		         
        // Check for successful insertion
        if ($result) {
			// teacher_class successfully inserted
            return CREATED_SUCCESSFULLY;
        } else {
            // Failed to create teacher_class
            return CREATE_FAILED;
        }
        
		return $response;

    }
	
	/**
     * Update teacher_class
     *
     * @param Int $year Year for the system
	 * @param Int $tec_id Teacher id for the system
	 * @param Int $clz_id class id for the system
	 * @param String $recode_added_by 
     *
     * @return database transaction status
     */
    public function updateTeacherClass($year, $tec_id, $clz_id, $recode_added_by) {
		
        $response = array();
        // First check if teacher_class already existed in db
        if ($this->isTeacherClassExists($year, $tec_id)) {
            
			//
			$stmt = $this->conn->prepare("UPDATE teacher_class SET clz_id = ?, status = 2, recode_modified_at = now() , recode_modified_by = ? where year = ? and tec_id = ? and (status = 1 or status = 2)");
			$stmt->bind_param("iiii", $clz_id, $recode_added_by, $year, $tec_id);
			$result = $stmt->execute();

			$stmt->close();

        } else {
            // teacher_class is not already existed in the db
            return NOT_EXISTED;
        }
		         
        // Check for successful update
        if ($result) {
			// teacher_class successfully update
            return UPDATE_SUCCESSFULLY;
        } else {
            // Failed to update teacher_class
            return UPDATE_FAILED;
        }
        
		return $response;

    }
	
/**
     * Delete teacher_class
     *
     * @param Int $year Year for the system
	 * @param Int $tec_id Teacher id for the system
	 * @param String $recode_added_by
     *
     * @return database transaction status
     */
    public function deleteTeacherClass($year, $tec_id, $recode_added_by ) {
		
        $response = array();
        // First check if teacher_class already existed in db
        if ($this->isTeacherClassExists($year, $tec_id)) {
           			
			//
			$stmt = $this->conn->prepare("UPDATE teacher_class set status = 3, recode_modified_at = now() , recode_modified_by = ? where year = ? and tec_id = ? and (status = 1 or status = 2)");
			$stmt->bind_param("iii",$recode_added_by, $year, $tec_id);
			$result = $stmt->execute();
			
            $stmt->close();

        } else {
            // teacher_class is not already existed in the db
            return NOT_EXISTED;
        }
		         
        // Check for successful insertion
        if ($result) {
			// teacher_class successfully deleted
            return DELETE_SUCCESSFULLY;
        } else {
            // Failed to delete teacher_class
            return DELETE_FAILED;
        }
        
		return $response;

    }
	  
	/**
     * Fetching teacher by tea_full_name
	 *
     * @param String $tea_full_name Teacher name
	 *
	 *@return Teacher object only needed data
     */
    public function getTeacherByTeacherClassId($tec_id) {
        $stmt = $this->conn->prepare("SELECT year, tec_id, clz_id , status, recode_added_at, recode_added_by FROM teacher_class WHERE tec_id = ? and (status = 1 or status = 2)");
        $stmt->bind_param("i",$tec_id);
        if ($stmt->execute()) {
            $stmt->bind_result($year, $tec_id, $clz_id, $status, $recode_added_at, $recode_added_by);
            $stmt->fetch();
            $teacher_class = array();
            $teacher_class["year"] = $year;
            $teacher_class["tec_id"] = $tec_id;
			$teacher_class["clz_id"] = $clz_id;
            $teacher_class["status"] = $status;
            $teacher_class["recode_added_at"] = $recode_added_at;
			$teacher_class["recode_added_by"] = $recode_added_by;

            $stmt->close();
            return $teacher_class;
        } else {
            return NULL;
        }
    }
    
	/**
     * Fetching all teacher_class
	 *
     * @return $teacherClasses boject set of all teachers
     */
    public function getAllTeachers() {
        $stmt = $this->conn->prepare("SELECT * FROM teacher_class WHERE (status = 1 or status = 2)");
        $stmt->execute();
        $teachers = $stmt->get_result();
        $stmt->close();
        return $teachers;
    }
	
	/**
     * Fetching only year and tec_id teacher_class
	 *
     * @return $getAllYearTeaID boject set of all year and tec_id
     */
    public function getAllYearTeaID() {
        $stmt = $this->conn->prepare("SELECT year, tec_id FROM teacher_class WHERE (status = 1 or status = 2)");
        $stmt->execute();
        $getAllYearTeaID = $stmt->get_result();
        $stmt->close();
        return $getAllYearTeaID;
    }
	
  /**
     * Fetching all teacherClass by year
	 *
     * @return $year object set of all teacherClass
     */
    public function getAllTeacherYear($year) {
        $stmt = $this->conn->prepare("SELECT * FROM teacher_class WHERE (status = 1 or status = 2) and year = ?");
		$stmt->bind_param("i", $year);
        $stmt->execute();
        $teacherYear = $stmt->get_result();
        $stmt->close();
        return $teacherYear;
    }
  
 /**
     * Fetching all teacherClass by class
	 *
     * @return $clz_id object set of all teacherClass
     */
    public function getAllTeacherClasses($clz_id) {
        $stmt = $this->conn->prepare("SELECT * FROM teacher_class WHERE (status = 1 or status = 2) and clz_id = ?");
		$stmt->bind_param("i", $clz_id);
        $stmt->execute();
        $classes = $stmt->get_result();
        $stmt->close();
        return $classes;
    }
	
/*
 * ------------------------ SUPPORTIVE METHODS ------------------------
 */

	/**
     * Checking for duplicate teacher by tea_full_name
     *
     * @param String $tea_full_name teacher name to check in db
     *
     * @return boolean
     */
    private function isTeacherClassExists($year,$tec_id) {
		//$tea_full_name = "a1";
		$stmt = $this->conn->prepare("SELECT year and tec_id from teacher_class WHERE (status = 1 or status = 2) and year = ? and tec_id = ?");
        $stmt->bind_param("ii",$year,$tec_id );
        $stmt->execute();
		$stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return ($num_rows > 0); //if it has more than zero number of rows; then  it sends true
    }
}
?>