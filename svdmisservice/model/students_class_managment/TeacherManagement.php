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
	 * @param Date $tea_birth_day Teacher birthday for the system
	 * @param String $tea_city Teacher city for the system
	 * @param String $tec_nic Teacher nic for the system
	 * @param Int $lib_mem_id Library member id for the system
	 * @param String $tea_distance_to_home Teacher distance_to_home for the system
	 * @param String $tea_occupation Teacher occupation for the system
	 * @param String $tea_occupation_type Teacher occupation_type for the system
	 * @param String $tea_office_address Teacher office_address for the system
	 * @param String $tea_office_phone Teacher office_phone for the system
	 * @param Int $tea_gender gender of teacher  for the system 
	 * @param String $tea_email Teacher email for the system
	 * @param Int $tea_student_id Teacher student_id for the system
	 * @param Int $tea_ob_id Teacher ob_id for the system
	 *
     * @return database transaction status
     */
    public function createTeacher($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $recode_added_by ) {
		
        $response = array();
		
        // First check if teacher already existed in db
        if (!$this->isTeacherExists($tea_full_name)) {
  
            // insert query
			 $stmt = $this->conn->prepare("INSERT INTO teacher(tea_full_name, tea_name_with_initials, tea_land_phone_number, tea_mobile_phone_number, tea_address, tea_birth_day, tea_city, tec_nic, lib_mem_id, tea_distance_to_home, tea_occupation, tea_occupation_type, tea_office_address, tea_office_phone, tea_gender, tea_email, tea_student_id, tea_ob_id, recode_added_by) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			 $stmt->bind_param("sssssdssiisissssiii", $tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $recode_added_by );
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
	 * @param Date $tea_birth_day Teacher birthday for the system
	 * @param String $tea_city Teacher city for the system
	 * @param String $tec_nic Teacher nic for the system
	 * @param Int $lib_mem_id Library member id for the system
	 * @param String $tea_distance_to_home Teacher distance_to_home for the system
	 * @param String $tea_occupation Teacher occupation for the system
	 * @param String $tea_occupation_type Teacher occupation_type for the system
	 * @param String $tea_office_address Teacher office_address for the system
	 * @param String $tea_office_phone Teacher office_phone for the system
	 * @param Int $tea_gender gender of teacher  for the system 
	 * @param String $tea_email Teacher email for the system
	 * @param Int $tea_student_id Teacher student_id for the system
	 * @param Int $tea_ob_id Teacher ob_id for the system
	 * @param String $recode_added_by 
     *
     * @return database transaction status
     */
    public function updateTeacher($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $recode_added_by) {
		
        $response = array();
        // First check if teacher already existed in db
        if ($this->isTeacherExists($tea_full_name)) {
            
			//
			$stmt = $this->conn->prepare("UPDATE teacher SET tea_name_with_initials = ?, tea_land_phone_number = ?,  tea_mobile_phone_number= ?, tea_address = ?, tea_birth_day = ?, tea_city = ?, tec_nic = ?, lib_mem_id = ?, tea_distance_to_home = ?, tea_occupation = ?, tea_occupation_type = ?, tea_office_address = ?, tea_office_phone = ?, tea_gender = ?, tea_email = ?, tea_student_id = ?, tea_ob_id = ?,  status = 2,  recode_modified_at = now() , recode_modified_by = ? where tea_full_name = ? and (status = 1 or status = 2)");
			$stmt->bind_param("ssssissiisissssiiis", $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $recode_added_by, $tea_full_name);
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
     * Fetching teacher by tea_id
	 *
     * @param String $tea_id Teacher id
	 *
	 *@return Teacher object only needed data
     */
    public function getTeacherByTeacherTid($tea_id) {
        $stmt = $this->conn->prepare("SELECT tea_full_name, tea_name_with_initials, tea_land_phone_number, tea_mobile_phone_number, tea_address, tea_birth_day, tea_city, tec_nic, lib_mem_id, tea_distance_to_home, tea_occupation, tea_occupation_type, tea_office_address, tea_office_phone, tea_gender, tea_email, tea_student_id, tea_ob_id, status, recode_added_at, recode_added_by FROM teacher WHERE tea_id = ? and (status = 1 or status = 2)");
        $stmt->bind_param("i", $tea_id);
        if ($stmt->execute()) {
            $stmt->bind_result($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $status, $recode_added_at, $recode_added_by);
            $stmt->fetch();
            $teacher = array();
            $teacher["tea_full_name"] = $tea_full_name;
            $teacher["tea_name_with_initials"] = $tea_name_with_initials;
			$teacher["tea_land_phone_number"] = $tea_land_phone_number;
            $teacher["tea_mobile_phone_number"] = $tea_mobile_phone_number;
			$teacher["tea_address"] = $tea_address;
            $teacher["tea_birth_day"] = $tea_birth_day;
			$teacher["tea_city"] = $tea_city;
			$teacher["tec_nic"] = $tec_nic;
			$teacher["lib_mem_id"] = $lib_mem_id;
			$teacher["tea_distance_to_home"] = $tea_distance_to_home;
			$teacher["tea_occupation"] = $tea_occupation;
			$teacher["tea_occupation_type"] = $tea_occupation_type;
			$teacher["tea_office_address"] = $tea_office_address;
			$teacher["tea_office_phone"] = $tea_office_phone;
			$teacher["tea_gender"] = $tea_gender;
			$teacher["tea_email"] = $tea_email;
			$teacher["tea_student_id"] = $tea_student_id;
			$teacher["tea_ob_id"] = $tea_ob_id;
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
     * Fetching teacher by tea_full_name
	 *
     * @param String $tea_full_name Teacher name
	 *
	 *@return Teacher object only needed data
     */
    public function getTeacherByTeacherName($tea_full_name) {
        $stmt = $this->conn->prepare("SELECT tea_full_name, tea_name_with_initials, tea_land_phone_number, tea_mobile_phone_number, tea_address, tea_birth_day, tea_city, tec_nic, lib_mem_id, tea_distance_to_home, tea_occupation, tea_occupation_type, tea_office_address, tea_office_phone, tea_gender, tea_email, tea_student_id, tea_ob_id, status, recode_added_at, recode_added_by FROM teacher WHERE tea_full_name = ? and (status = 1 or status = 2)");
        $stmt->bind_param("s", $tea_full_name);
        if ($stmt->execute()) {
            $stmt->bind_result($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $status, $recode_added_at, $recode_added_by);
            $stmt->fetch();
            $teacher = array();
            $teacher["tea_full_name"] = $tea_full_name;
            $teacher["tea_name_with_initials"] = $tea_name_with_initials;
			$teacher["tea_land_phone_number"] = $tea_land_phone_number;
            $teacher["tea_mobile_phone_number"] = $tea_mobile_phone_number;
			$teacher["tea_address"] = $tea_address;
            $teacher["tea_birth_day"] = $tea_birth_day;
			$teacher["tea_city"] = $tea_city;
			$teacher["tec_nic"] = $tec_nic;
			$teacher["lib_mem_id"] = $lib_mem_id;
			$teacher["tea_distance_to_home"] = $tea_distance_to_home;
			$teacher["tea_occupation"] = $tea_occupation;
			$teacher["tea_occupation_type"] = $tea_occupation_type;
			$teacher["tea_office_address"] = $tea_office_address;
			$teacher["tea_office_phone"] = $tea_office_phone;
			$teacher["tea_gender"] = $tea_gender;
			$teacher["tea_email"] = $tea_email;
			$teacher["tea_student_id"] = $tea_student_id;
			$teacher["tea_ob_id"] = $tea_ob_id;
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
     * Fetching teacher by tec_nic
	 *
     * @param String $tec_nic Teacher nic
	 *
	 *@return Teacher object only needed data
     */
    public function getTeacherByTeacherNic($tec_nic) {
        $stmt = $this->conn->prepare("SELECT tea_full_name, tea_name_with_initials, tea_land_phone_number, tea_mobile_phone_number, tea_address, tea_birth_day, tea_city, tec_nic, lib_mem_id, tea_distance_to_home, tea_occupation, tea_occupation_type, tea_office_address, tea_office_phone, tea_gender, tea_email, tea_student_id, tea_ob_id, status, recode_added_at, recode_added_by FROM teacher WHERE tec_nic = ? and (status = 1 or status = 2)");
        $stmt->bind_param("s", $tec_nic);
        if ($stmt->execute()) {
            $stmt->bind_result($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $status, $recode_added_at, $recode_added_by);
            $stmt->fetch();
            $teacher = array();
            $teacher["tea_full_name"] = $tea_full_name;
            $teacher["tea_name_with_initials"] = $tea_name_with_initials;
			$teacher["tea_land_phone_number"] = $tea_land_phone_number;
            $teacher["tea_mobile_phone_number"] = $tea_mobile_phone_number;
			$teacher["tea_address"] = $tea_address;
            $teacher["tea_birth_day"] = $tea_birth_day;
			$teacher["tea_city"] = $tea_city;
			$teacher["tec_nic"] = $tec_nic;
			$teacher["lib_mem_id"] = $lib_mem_id;
			$teacher["tea_distance_to_home"] = $tea_distance_to_home;
			$teacher["tea_occupation"] = $tea_occupation;
			$teacher["tea_occupation_type"] = $tea_occupation_type;
			$teacher["tea_office_address"] = $tea_office_address;
			$teacher["tea_office_phone"] = $tea_office_phone;
			$teacher["tea_gender"] = $tea_gender;
			$teacher["tea_email"] = $tea_email;
			$teacher["tea_student_id"] = $tea_student_id;
			$teacher["tea_ob_id"] = $tea_ob_id;
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
     * Fetching teacher by lib_mem_id
	 *
     * @param String $lib_mem_id Teacher Library member id
	 *
	 *@return Teacher object only needed data
     */
    public function getTeacherByTeacherLid($lib_mem_id) {
        $stmt = $this->conn->prepare("SELECT tea_full_name, tea_name_with_initials, tea_land_phone_number, tea_mobile_phone_number, tea_address, tea_birth_day, tea_city, tec_nic, lib_mem_id, tea_distance_to_home, tea_occupation, tea_occupation_type, tea_office_address, tea_office_phone, tea_gender, tea_email, tea_student_id, tea_ob_id, status, recode_added_at, recode_added_by FROM teacher WHERE lib_mem_id = ? and (status = 1 or status = 2)");
        $stmt->bind_param("i", $lib_mem_id);
        if ($stmt->execute()) {
            $stmt->bind_result($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $status, $recode_added_at, $recode_added_by);
            $stmt->fetch();
            $teacher = array();
            $teacher["tea_full_name"] = $tea_full_name;
            $teacher["tea_name_with_initials"] = $tea_name_with_initials;
			$teacher["tea_land_phone_number"] = $tea_land_phone_number;
            $teacher["tea_mobile_phone_number"] = $tea_mobile_phone_number;
			$teacher["tea_address"] = $tea_address;
            $teacher["tea_birth_day"] = $tea_birth_day;
			$teacher["tea_city"] = $tea_city;
			$teacher["tec_nic"] = $tec_nic;
			$teacher["lib_mem_id"] = $lib_mem_id;
			$teacher["tea_distance_to_home"] = $tea_distance_to_home;
			$teacher["tea_occupation"] = $tea_occupation;
			$teacher["tea_occupation_type"] = $tea_occupation_type;
			$teacher["tea_office_address"] = $tea_office_address;
			$teacher["tea_office_phone"] = $tea_office_phone;
			$teacher["tea_gender"] = $tea_gender;
			$teacher["tea_email"] = $tea_email;
			$teacher["tea_student_id"] = $tea_student_id;
			$teacher["tea_ob_id"] = $tea_ob_id;
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
     * Fetching all teachers by tea_occupation_type
	 *
     * @return $teachersOtype object set of all teachersOccupationType
     */
    public function getAllTeacherOtype($tea_occupation_type) {
        $stmt = $this->conn->prepare("SELECT * FROM teacher WHERE (status = 1 or status = 2) and tea_occupation_type = ?");
		$stmt->bind_param("i", $tea_occupation_type);
        $stmt->execute();
        $teachersOtype = $stmt->get_result();
        $stmt->close();
        return $teachersOtype;
    }
	
	/**
     * Fetching all teachers by tea_gender
	 *
     * @return $teachersGender object set of all teachers' Gender
     */
    public function getAllTeacherGender($tea_gender) {
        $stmt = $this->conn->prepare("SELECT * FROM teacher WHERE (status = 1 or status = 2) and tea_gender = ?");
		$stmt->bind_param("s", $tea_gender);
        $stmt->execute();
        $teachersGender = $stmt->get_result();
        $stmt->close();
        return $teachersGender;
    }
	
	/**
     * Fetching teacher by tea_student_id
	 *
     * @param String $tea_student_id Teacher Library student id
	 *
	 *@return Teacher object only needed data
     */
    public function getTeacherByTeacherSid($tea_student_id) {
        $stmt = $this->conn->prepare("SELECT tea_full_name, tea_name_with_initials, tea_land_phone_number, tea_mobile_phone_number, tea_address, tea_birth_day, tea_city, tec_nic, lib_mem_id, tea_distance_to_home, tea_occupation, tea_occupation_type, tea_office_address, tea_office_phone, tea_gender, tea_email, tea_student_id, tea_ob_id, status, recode_added_at, recode_added_by FROM teacher WHERE tea_student_id = ? and (status = 1 or status = 2)");
        $stmt->bind_param("i", $tea_student_id);
        if ($stmt->execute()) {
            $stmt->bind_result($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $status, $recode_added_at, $recode_added_by);
            $stmt->fetch();
            $teacher = array();
            $teacher["tea_full_name"] = $tea_full_name;
            $teacher["tea_name_with_initials"] = $tea_name_with_initials;
			$teacher["tea_land_phone_number"] = $tea_land_phone_number;
            $teacher["tea_mobile_phone_number"] = $tea_mobile_phone_number;
			$teacher["tea_address"] = $tea_address;
            $teacher["tea_birth_day"] = $tea_birth_day;
			$teacher["tea_city"] = $tea_city;
			$teacher["tec_nic"] = $tec_nic;
			$teacher["lib_mem_id"] = $lib_mem_id;
			$teacher["tea_distance_to_home"] = $tea_distance_to_home;
			$teacher["tea_occupation"] = $tea_occupation;
			$teacher["tea_occupation_type"] = $tea_occupation_type;
			$teacher["tea_office_address"] = $tea_office_address;
			$teacher["tea_office_phone"] = $tea_office_phone;
			$teacher["tea_gender"] = $tea_gender;
			$teacher["tea_email"] = $tea_email;
			$teacher["tea_student_id"] = $tea_student_id;
			$teacher["tea_ob_id"] = $tea_ob_id;
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
     * Fetching teacher by tea_ob_id
	 *
     * @param String $tea_ob_id Teacher ob_id
	 *
	 *@return Teacher object only needed data
     */
    public function getTeacherByTeacherOid($tea_ob_id) {
        $stmt = $this->conn->prepare("SELECT tea_full_name, tea_name_with_initials, tea_land_phone_number, tea_mobile_phone_number, tea_address, tea_birth_day, tea_city, tec_nic, lib_mem_id, tea_distance_to_home, tea_occupation, tea_occupation_type, tea_office_address, tea_office_phone, tea_gender, tea_email, tea_student_id, tea_ob_id, status, recode_added_at, recode_added_by FROM teacher WHERE tea_ob_id = ? and (status = 1 or status = 2)");
        $stmt->bind_param("i", $tea_ob_id);
        if ($stmt->execute()) {
            $stmt->bind_result($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $status, $recode_added_at, $recode_added_by);
            $stmt->fetch();
            $teacher = array();
            $teacher["tea_full_name"] = $tea_full_name;
            $teacher["tea_name_with_initials"] = $tea_name_with_initials;
			$teacher["tea_land_phone_number"] = $tea_land_phone_number;
            $teacher["tea_mobile_phone_number"] = $tea_mobile_phone_number;
			$teacher["tea_address"] = $tea_address;
            $teacher["tea_birth_day"] = $tea_birth_day;
			$teacher["tea_city"] = $tea_city;
			$teacher["tec_nic"] = $tec_nic;
			$teacher["lib_mem_id"] = $lib_mem_id;
			$teacher["tea_distance_to_home"] = $tea_distance_to_home;
			$teacher["tea_occupation"] = $tea_occupation;
			$teacher["tea_occupation_type"] = $tea_occupation_type;
			$teacher["tea_office_address"] = $tea_office_address;
			$teacher["tea_office_phone"] = $tea_office_phone;
			$teacher["tea_gender"] = $tea_gender;
			$teacher["tea_email"] = $tea_email;
			$teacher["tea_student_id"] = $tea_student_id;
			$teacher["tea_ob_id"] = $tea_ob_id;
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
     * Fetching all teachers
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
    
  /**
     * Fetching all teachers by city
	 *
     * @return $teacherCity object set of all teacherCity
     */
    public function getAllTeacherCity($tea_city) {
        $stmt = $this->conn->prepare("SELECT * FROM teacher WHERE (status = 1 or status = 2) and tea_city = ?");
		$stmt->bind_param("s", $tea_city);
        $stmt->execute();
        $teacherCity = $stmt->get_result();
        $stmt->close();
        return $teacherCity;
    }
/*
 * ------------------------ SUPPORTIVE METHODS ------------------------
 */

	/**
     * Checking for duplicate teacher by tec_nic
     *
     * @param String $tec_nic teacher nic to check in db
     *
     * @return boolean
     */
    private function isTeacherExists($tec_nic) {
		//$tec_nic = "89275392375v";
		$stmt = $this->conn->prepare("SELECT tec_nic from teacher WHERE (status = 1 or status = 2) and tec_nic = ?");
        $stmt->bind_param("s", $tec_nic );
        $stmt->execute();
		$stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return ($num_rows > 0); //if it has more than zero number of rows; then  it sends true
    }
}
?>