<?php
/**
 * Class to handle all the teacher details
 * This class will have CRUD methods for teacher
 *
 * @author Randi Kodikara
 *
 */

class TeacherManagement {

    private $conn;

    function __construct() {
        require_once '../../model/commen/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
		
/*
 * ------------------------ TEACHER TABLE METHODS ------------------------
 */

    /**
     * Creating new teacher
     *
     * @param String $tea_full_name Teacher full name for the system
	 * @param String $tea_name_with_initials Teacher name with initials for the system
	 * @param String $tea_land_phone_number Teacher land phone number for the system
	 * @param String $tea_mobile_phone_number Teacher mobile phone number for the system
	 * @param String $tea_address Teacher address for the system
	 * @param String $tea_city Teacher city for the system
	 * @param Int $lib_mem_id Library member id for the system 
     *
     * @return database transaction status
     */
    public function createTeacher($tea_full_name,$tea_name_with_initials,$tea_land_phone_number,$tea_mobile_phone_number,$tea_address,$tea_city,$lib_mem_id,$recode_added_by ) {
		
        $response = array();
		
        // First check if teacher already existed in db
        if (!$this->isTeacherExists($tea_full_name)) {
  
            // insert query
			 $stmt = $this->conn->prepare("INSERT INTO teacher(tea_full_name,tea_name_with_initials,tea_land_phone_number,tea_mobile_phone_number,tea_address,tea_city,lib_mem_id, recode_added_by) values( ?, ?,?,?,?,?,?,?)");
			 $stmt->bind_param("ssssssii", $tea_full_name,$tea_name_with_initials,$tea_land_phone_number,$tea_mobile_phone_number,$tea_address,$tea_city,$lib_mem_id, $recode_added_by );
			 $result = $stmt->execute();

			 $stmt->close();

        } else {
            // teacher is not already existed in the db
            return ALREADY_EXISTED;
        }
		         
        // Check for successful insertion
        if ($result) {
			// teacher successfully inserted
            return CREATED_SUCCESSFULLY;
        } else {
            // Failed to create teacher
            return CREATE_FAILED;
        }
        
		return $response;

    }
	
	/**
     * Update teacher
     *
     * @param String $tea_full_name Teacher full name for the system
	 * @param String $tea_name_with_initials Teacher name with initials for the system
	 * @param String $tea_land_phone_number Teacher land phone number for the system
	 * @param String $tea_mobile_phone_number Teacher mobile phone number for the system
	 * @param String $tea_address Teacher address for the system
	 * @param String $tea_city Teacher city for the system
	 * @param Int $lib_mem_id Library member id for the system 
	 * @param String $recode_added_by 
     *
     * @return database transaction status
     */
    public function updateTeacher($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_city, $lib_mem_id, $recode_added_by) {
		
        $response = array();
        // First check if teacher already existed in db
        if ($this->isTeacherExists($tea_full_name)) {
            
			//
			$stmt = $this->conn->prepare("UPDATE teacher SET tea_name_with_initials = ? and tea_land_phone_number = ? and  tea_mobile_phone_number= ? and  tea_address = ? and tea_city = ? and lib_mem_id = ? and  status = 2,  recode_modified_at = now() , recode_modified_by = ? where tea_full_name = ? and (status = 1 or status = 2)");
			$stmt->bind_param("sssssiis", $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_city, $lib_mem_id, $recode_added_by, $tea_full_name);
			$result = $stmt->execute();

			$stmt->close();

        } else {
            // teacher is not already existed in the db
            return NOT_EXISTED;
        }
		         
        // Check for successful update
        if ($result) {
			// teacher successfully update
            return UPDATE_SUCCESSFULLY;
        } else {
            // Failed to update teacher
            return UPDATE_FAILED;
        }
        
		return $response;

    }
	
/**
     * Delete teacher
     *
     * @param String $tea_full_name Teacher full name for the system
	 * @param String $tea_name_with_initials Teacher name with initials for the system
	 * @param String $tea_land_phone_number Teacher land phone number for the system
	 * @param String $tea_mobile_phone_number Teacher mobile phone number for the system
	 * @param String $tea_address Teacher address for the system
	 * @param String $tea_city Teacher city for the system
	 * @param Int $lib_mem_id Library member id for the system 
	 * @param String $recode_added_by
     *
     * @return database transaction status
     */
    public function deleteTeacher($tea_full_name, $recode_added_by ) {
		
        $response = array();
        // First check if teacher already existed in db
        if ($this->isTeacherExists($tea_full_name)) {
           			
			//
			$stmt = $this->conn->prepare("UPDATE teacher set status = 3, recode_modified_at = now() , recode_modified_by = ? where tea_full_name = ? and (status = 1 or status = 2)");
			$stmt->bind_param("is",$recode_added_by, $tea_full_name);
			$result = $stmt->execute();
			
            $stmt->close();

        } else {
            // Teacher is not already existed in the db
            return NOT_EXISTED;
        }
		         
        // Check for successful insertion
        if ($result) {
			// teacher successfully deleted
            return DELETE_SUCCESSFULLY;
        } else {
            // Failed to delete teacher
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
    public function getTeacherByTeacherName($tea_full_name) {
        $stmt = $this->conn->prepare("SELECT tea_full_name,tea_name_with_initials,tea_land_phone_number,tea_mobile_phone_number,tea_address,tea_city, lib_mem_id, status, recode_added_at, recode_added_by FROM teacher WHERE tea_full_name = ? and (status = 1 or status = 2)");
        $stmt->bind_param("s", $tea_full_name);
        if ($stmt->execute()) {
            $stmt->bind_result($tea_full_name,  $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number,  $tea_address, $tea_city,  $lib_mem_id, $status, $recode_added_at, $recode_added_by);
            $stmt->fetch();
            $teacher = array();
            $teacher["tea_full_name"] = $tea_full_name;
            $teacher["tea_name_with_initials"] = $tea_name_with_initials;
			$teacher["tea_land_phone_number"] = $tea_land_phone_number;
            $teacher["tea_mobile_phone_number"] = $tea_mobile_phone_number;
			$teacher["tea_address"] = $tea_address;
            $teacher["tea_city"] = $tea_city;
			$teacher["lib_mem_id"] = $lib_mem_id;
            $teacher["status"] = $status;
            $teacher["recode_added_at"] = $recode_added_at;
			$teacher["recode_added_by"] = $recode_added_by;

            $stmt->close();
            return $teacher;
        } else {
            return NULL;
        }
    }
    
	/**
     * Fetching all techers
	 *
     * @return $teachers boject set of all teachers
     */
    public function getAllTeachers() {
        $stmt = $this->conn->prepare("SELECT * FROM teacher WHERE (status = 1 or status = 2)");
        $stmt->execute();
        $teachers = $stmt->get_result();
        $stmt->close();
        return $teachers;
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
    private function isTeacherExists($tea_full_name) {
		//$tea_full_name = "a1";
		$stmt = $this->conn->prepare("SELECT tea_full_name from teacher WHERE (status = 1 or status = 2) and tea_full_name = ?");
        $stmt->bind_param("s", $tea_full_name );
        $stmt->execute();
		$stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return ($num_rows > 0); //if it has more than zero number of rows; then  it sends true
    }
}
?>