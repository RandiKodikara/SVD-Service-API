<?php
/**
 * Class to handle all the classReport details
 * This class will have CRUD methods for classReport
 *
 * @author Randi Kodikara
 *
 */

class ClassReportManagement {

    private $conn;

    function __construct() {
        require_once '../../model/commen/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
		
/*
 * ------------------------ CLASS REPORT TABLE METHODS ------------------------
 */

    /**
     * Creating new class_report
     *
     * @param Int $clz_evaluation_cri_1 to $clz_evaluation_cri_40 class evaluation_cri for the system
	 * @param String $clz_evaluation_cri_41 to $clz_evaluation_cri_80 class evaluation_cri for the system
     *
     * @return database transaction status
     */
    public function createClassReport($clz_evaluation_cri_1, $clz_evaluation_cri_2, $clz_evaluation_cri_3, $clz_evaluation_cri_4, $clz_evaluation_cri_5, $clz_evaluation_cri_6, $clz_evaluation_cri_7, $clz_evaluation_cri_8, $clz_evaluation_cri_9, $clz_evaluation_cri_10, $clz_evaluation_cri_11, $clz_evaluation_cri_12, $clz_evaluation_cri_13, $clz_evaluation_cri_14, $clz_evaluation_cri_15, $clz_evaluation_cri_16, $clz_evaluation_cri_17, $clz_evaluation_cri_18, $clz_evaluation_cri_19, $clz_evaluation_cri_20, $clz_evaluation_cri_21, $clz_evaluation_cri_22, $clz_evaluation_cri_23, $clz_evaluation_cri_24, $clz_evaluation_cri_25, $clz_evaluation_cri_26, $clz_evaluation_cri_27, $clz_evaluation_cri_28, $clz_evaluation_cri_29, $clz_evaluation_cri_30, $clz_evaluation_cri_31, $clz_evaluation_cri_32, $clz_evaluation_cri_33, $clz_evaluation_cri_34, $clz_evaluation_cri_35, $clz_evaluation_cri_36, $clz_evaluation_cri_37, $clz_evaluation_cri_38, $clz_evaluation_cri_39, $clz_evaluation_cri_40, $clz_evaluation_cri_41, $clz_evaluation_cri_42, $clz_evaluation_cri_43, $clz_evaluation_cri_44, $clz_evaluation_cri_45, $clz_evaluation_cri_46, $clz_evaluation_cri_47, $clz_evaluation_cri_48, $clz_evaluation_cri_49, $clz_evaluation_cri_50, $clz_evaluation_cri_51, $clz_evaluation_cri_52, $clz_evaluation_cri_53, $clz_evaluation_cri_54, $clz_evaluation_cri_55, $clz_evaluation_cri_56, $clz_evaluation_cri_57, $clz_evaluation_cri_58, $clz_evaluation_cri_59, $clz_evaluation_cri_60, $clz_evaluation_cri_61, $clz_evaluation_cri_62, $clz_evaluation_cri_63, $clz_evaluation_cri_64, $clz_evaluation_cri_65, $clz_evaluation_cri_66, $clz_evaluation_cri_67, $clz_evaluation_cri_68, $clz_evaluation_cri_69, $clz_evaluation_cri_70, $clz_evaluation_cri_71, $clz_evaluation_cri_72, $clz_evaluation_cri_73, $clz_evaluation_cri_74, $clz_evaluation_cri_75, $clz_evaluation_cri_76, $clz_evaluation_cri_77, $clz_evaluation_cri_78, $clz_evaluation_cri_79, $clz_evaluation_cri_80, $recode_added_by ) {
		
        $response = array();
		
        // First check if class_report already existed in db
        if (!$this->isClassReportExists($clz_repo_id)) {
  
            // insert query
			 $stmt = $this->conn->prepare("INSERT INTO class_report(clz_evaluation_cri_1, clz_evaluation_cri_2, clz_evaluation_cri_3, clz_evaluation_cri_4, clz_evaluation_cri_5, clz_evaluation_cri_6, clz_evaluation_cri_7, clz_evaluation_cri_8, clz_evaluation_cri_9, clz_evaluation_cri_10, clz_evaluation_cri_11, clz_evaluation_cri_12, clz_evaluation_cri_13, clz_evaluation_cri_14, clz_evaluation_cri_15, clz_evaluation_cri_16, clz_evaluation_cri_17, clz_evaluation_cri_18, clz_evaluation_cri_19, clz_evaluation_cri_20, clz_evaluation_cri_21, clz_evaluation_cri_22, clz_evaluation_cri_23, clz_evaluation_cri_24, clz_evaluation_cri_25, clz_evaluation_cri_26, clz_evaluation_cri_27, clz_evaluation_cri_28, clz_evaluation_cri_29, clz_evaluation_cri_30, clz_evaluation_cri_31, clz_evaluation_cri_32, clz_evaluation_cri_33, clz_evaluation_cri_34, clz_evaluation_cri_35, clz_evaluation_cri_36, clz_evaluation_cri_37, clz_evaluation_cri_38, clz_evaluation_cri_39, clz_evaluation_cri_40, clz_evaluation_cri_41, clz_evaluation_cri_42, clz_evaluation_cri_43, clz_evaluation_cri_44, clz_evaluation_cri_45, clz_evaluation_cri_46, clz_evaluation_cri_47, clz_evaluation_cri_48, clz_evaluation_cri_49, clz_evaluation_cri_50, clz_evaluation_cri_51, clz_evaluation_cri_52, clz_evaluation_cri_53, clz_evaluation_cri_54, clz_evaluation_cri_55, clz_evaluation_cri_56, clz_evaluation_cri_57, clz_evaluation_cri_58, clz_evaluation_cri_59, clz_evaluation_cri_60, clz_evaluation_cri_61, clz_evaluation_cri_62, clz_evaluation_cri_63, clz_evaluation_cri_64, clz_evaluation_cri_65, clz_evaluation_cri_66, clz_evaluation_cri_67, clz_evaluation_cri_68, clz_evaluation_cri_69, clz_evaluation_cri_70, clz_evaluation_cri_71, clz_evaluation_cri_72, clz_evaluation_cri_73, clz_evaluation_cri_74, clz_evaluation_cri_75, clz_evaluation_cri_76, clz_evaluation_cri_77, clz_evaluation_cri_78, clz_evaluation_cri_79, clz_evaluation_cri_80, recode_added_by) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			 $stmt->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiissssssssssssssssssssssssssssssssssssssssi", $clz_evaluation_cri_1, $clz_evaluation_cri_2, $clz_evaluation_cri_3, $clz_evaluation_cri_4, $clz_evaluation_cri_5, $clz_evaluation_cri_6, $clz_evaluation_cri_7, $clz_evaluation_cri_8, $clz_evaluation_cri_9, $clz_evaluation_cri_10, $clz_evaluation_cri_11, $clz_evaluation_cri_12, $clz_evaluation_cri_13, $clz_evaluation_cri_14, $clz_evaluation_cri_15, $clz_evaluation_cri_16, $clz_evaluation_cri_17, $clz_evaluation_cri_18, $clz_evaluation_cri_19, $clz_evaluation_cri_20, $clz_evaluation_cri_21, $clz_evaluation_cri_22, $clz_evaluation_cri_23, $clz_evaluation_cri_24, $clz_evaluation_cri_25, $clz_evaluation_cri_26, $clz_evaluation_cri_27, $clz_evaluation_cri_28, $clz_evaluation_cri_29, $clz_evaluation_cri_30, $clz_evaluation_cri_31, $clz_evaluation_cri_32, $clz_evaluation_cri_33, $clz_evaluation_cri_34, $clz_evaluation_cri_35, $clz_evaluation_cri_36, $clz_evaluation_cri_37, $clz_evaluation_cri_38, $clz_evaluation_cri_39, $clz_evaluation_cri_40, $clz_evaluation_cri_41, $clz_evaluation_cri_42, $clz_evaluation_cri_43, $clz_evaluation_cri_44, $clz_evaluation_cri_45, $clz_evaluation_cri_46, $clz_evaluation_cri_47, $clz_evaluation_cri_48, $clz_evaluation_cri_49, $clz_evaluation_cri_50, $clz_evaluation_cri_51, $clz_evaluation_cri_52, $clz_evaluation_cri_53, $clz_evaluation_cri_54, $clz_evaluation_cri_55, $clz_evaluation_cri_56, $clz_evaluation_cri_57, $clz_evaluation_cri_58, $clz_evaluation_cri_59, $clz_evaluation_cri_60, $clz_evaluation_cri_61, $clz_evaluation_cri_62, $clz_evaluation_cri_63, $clz_evaluation_cri_64, $clz_evaluation_cri_65, $clz_evaluation_cri_66, $clz_evaluation_cri_67, $clz_evaluation_cri_68, $clz_evaluation_cri_69, $clz_evaluation_cri_70, $clz_evaluation_cri_71, $clz_evaluation_cri_72, $clz_evaluation_cri_73, $clz_evaluation_cri_74, $clz_evaluation_cri_75, $clz_evaluation_cri_76, $clz_evaluation_cri_77, $clz_evaluation_cri_78, $clz_evaluation_cri_79, $clz_evaluation_cri_80,$recode_added_by );
			 $result = $stmt->execute();

			 $stmt->close();

        } else {
            // class_report is not already existed in the db
            return ALREADY_EXISTED;
        }
		         
        // Check for successful insertion
        if ($result) {
			// class_report successfully inserted
            return CREATED_SUCCESSFULLY;
        } else {
            // Failed to create class_report
            return CREATE_FAILED;
        }
        
		return $response;

    }
	
	/**
     * Update class_report
     *
     * @param Int $clz_evaluation_cri_1 to $clz_evaluation_cri_40 class evaluation_cri for the system
	 * @param String $clz_evaluation_cri_41 to $clz_evaluation_cri_80 class evaluation_cri for the system
	 * @param String $recode_added_by 
     *
     * @return database transaction status
     */
    public function updateClassReport($clz_evaluation_cri_1, $clz_evaluation_cri_2, $clz_evaluation_cri_3, $clz_evaluation_cri_4, $clz_evaluation_cri_5, $clz_evaluation_cri_6, $clz_evaluation_cri_7, $clz_evaluation_cri_8, $clz_evaluation_cri_9, $clz_evaluation_cri_10, $clz_evaluation_cri_11, $clz_evaluation_cri_12, $clz_evaluation_cri_13, $clz_evaluation_cri_14, $clz_evaluation_cri_15, $clz_evaluation_cri_16, $clz_evaluation_cri_17, $clz_evaluation_cri_18, $clz_evaluation_cri_19, $clz_evaluation_cri_20, $clz_evaluation_cri_21, $clz_evaluation_cri_22, $clz_evaluation_cri_23, $clz_evaluation_cri_24, $clz_evaluation_cri_25, $clz_evaluation_cri_26, $clz_evaluation_cri_27, $clz_evaluation_cri_28, $clz_evaluation_cri_29, $clz_evaluation_cri_30, $clz_evaluation_cri_31, $clz_evaluation_cri_32, $clz_evaluation_cri_33, $clz_evaluation_cri_34, $clz_evaluation_cri_35, $clz_evaluation_cri_36, $clz_evaluation_cri_37, $clz_evaluation_cri_38, $clz_evaluation_cri_39, $clz_evaluation_cri_40, $clz_evaluation_cri_41, $clz_evaluation_cri_42, $clz_evaluation_cri_43, $clz_evaluation_cri_44, $clz_evaluation_cri_45, $clz_evaluation_cri_46, $clz_evaluation_cri_47, $clz_evaluation_cri_48, $clz_evaluation_cri_49, $clz_evaluation_cri_50, $clz_evaluation_cri_51, $clz_evaluation_cri_52, $clz_evaluation_cri_53, $clz_evaluation_cri_54, $clz_evaluation_cri_55, $clz_evaluation_cri_56, $clz_evaluation_cri_57, $clz_evaluation_cri_58, $clz_evaluation_cri_59, $clz_evaluation_cri_60, $clz_evaluation_cri_61, $clz_evaluation_cri_62, $clz_evaluation_cri_63, $clz_evaluation_cri_64, $clz_evaluation_cri_65, $clz_evaluation_cri_66, $clz_evaluation_cri_67, $clz_evaluation_cri_68, $clz_evaluation_cri_69, $clz_evaluation_cri_70, $clz_evaluation_cri_71, $clz_evaluation_cri_72, $clz_evaluation_cri_73, $clz_evaluation_cri_74, $clz_evaluation_cri_75, $clz_evaluation_cri_76, $clz_evaluation_cri_77, $clz_evaluation_cri_78, $clz_evaluation_cri_79, $clz_evaluation_cri_80, $recode_added_by) {
		
        $response = array();
        // First check if class_report already existed in db
        if ($this->isClassReportExists($clz_repo_id)) {
            
			//
			$stmt = $this->conn->prepare("UPDATE class_report SET clz_evaluation_cri_1 = ?, clz_evaluation_cri_2 = ?, clz_evaluation_cri_3 = ?, clz_evaluation_cri_4 = ?, clz_evaluation_cri_5 = ?, clz_evaluation_cri_6 = ?, clz_evaluation_cri_7 = ?, clz_evaluation_cri_8 = ?, clz_evaluation_cri_9 = ?, clz_evaluation_cri_10 = ?, clz_evaluation_cri_11 = ?, clz_evaluation_cri_12 = ?, clz_evaluation_cri_13 = ?, clz_evaluation_cri_14 = ?, clz_evaluation_cri_15 = ?, clz_evaluation_cri_16 = ?, clz_evaluation_cri_17 = ?, clz_evaluation_cri_18 = ?, clz_evaluation_cri_19 = ?, clz_evaluation_cri_20 = ?, clz_evaluation_cri_21 = ?, clz_evaluation_cri_22 = ?, clz_evaluation_cri_23 = ?, clz_evaluation_cri_24 = ?, clz_evaluation_cri_25 = ?, clz_evaluation_cri_26 = ?, clz_evaluation_cri_27 = ?, clz_evaluation_cri_28 = ?, clz_evaluation_cri_29 = ?, clz_evaluation_cri_30 = ?, clz_evaluation_cri_31 = ?, clz_evaluation_cri_32 = ?, clz_evaluation_cri_33 = ?, clz_evaluation_cri_34 = ?, clz_evaluation_cri_35 = ?, clz_evaluation_cri_36 = ?, clz_evaluation_cri_37 = ?, clz_evaluation_cri_38 = ?, clz_evaluation_cri_39 = ?, clz_evaluation_cri_40 = ?, clz_evaluation_cri_41 = ?, clz_evaluation_cri_42 = ?, clz_evaluation_cri_43 = ?, clz_evaluation_cri_44 = ?, clz_evaluation_cri_45 = ?, clz_evaluation_cri_46 = ?, clz_evaluation_cri_47 = ?, clz_evaluation_cri_48 = ?, clz_evaluation_cri_49 = ?, clz_evaluation_cri_50 = ?, clz_evaluation_cri_51 = ?, clz_evaluation_cri_52 = ?, clz_evaluation_cri_53 = ?, clz_evaluation_cri_54 = ?, clz_evaluation_cri_55 = ?, clz_evaluation_cri_56 = ?, clz_evaluation_cri_57 = ?, clz_evaluation_cri_58 = ?, clz_evaluation_cri_59 = ?, clz_evaluation_cri_60 = ?, clz_evaluation_cri_61 = ?, clz_evaluation_cri_62 = ?, clz_evaluation_cri_63 = ?, clz_evaluation_cri_64 = ?, clz_evaluation_cri_65 = ?, clz_evaluation_cri_66 = ?, clz_evaluation_cri_67 = ?, clz_evaluation_cri_68 = ?, clz_evaluation_cri_69 = ?, clz_evaluation_cri_70 = ?, clz_evaluation_cri_71 = ?, clz_evaluation_cri_72 = ?, clz_evaluation_cri_73 = ?, clz_evaluation_cri_74 = ?, clz_evaluation_cri_75 = ?, clz_evaluation_cri_76 = ?, clz_evaluation_cri_77 = ?, clz_evaluation_cri_78 = ?, clz_evaluation_cri_79 = ?, clz_evaluation_cri_80 = ?, status = 2, recode_modified_at = now() , recode_modified_by = ? where clz_repo_id = ? and (status = 1 or status = 2)");
			$stmt->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiissssssssssssssssssssssssssssssssssssssssii", $clz_evaluation_cri_1, $clz_evaluation_cri_2, $clz_evaluation_cri_3, $clz_evaluation_cri_4, $clz_evaluation_cri_5, $clz_evaluation_cri_6, $clz_evaluation_cri_7, $clz_evaluation_cri_8, $clz_evaluation_cri_9, $clz_evaluation_cri_10, $clz_evaluation_cri_11, $clz_evaluation_cri_12, $clz_evaluation_cri_13, $clz_evaluation_cri_14, $clz_evaluation_cri_15, $clz_evaluation_cri_16, $clz_evaluation_cri_17, $clz_evaluation_cri_18, $clz_evaluation_cri_19, $clz_evaluation_cri_20, $clz_evaluation_cri_21, $clz_evaluation_cri_22, $clz_evaluation_cri_23, $clz_evaluation_cri_24, $clz_evaluation_cri_25, $clz_evaluation_cri_26, $clz_evaluation_cri_27, $clz_evaluation_cri_28, $clz_evaluation_cri_29, $clz_evaluation_cri_30, $clz_evaluation_cri_31, $clz_evaluation_cri_32, $clz_evaluation_cri_33, $clz_evaluation_cri_34, $clz_evaluation_cri_35, $clz_evaluation_cri_36, $clz_evaluation_cri_37, $clz_evaluation_cri_38, $clz_evaluation_cri_39, $clz_evaluation_cri_40, $clz_evaluation_cri_41, $clz_evaluation_cri_42, $clz_evaluation_cri_43, $clz_evaluation_cri_44, $clz_evaluation_cri_45, $clz_evaluation_cri_46, $clz_evaluation_cri_47, $clz_evaluation_cri_48, $clz_evaluation_cri_49, $clz_evaluation_cri_50, $clz_evaluation_cri_51, $clz_evaluation_cri_52, $clz_evaluation_cri_53, $clz_evaluation_cri_54, $clz_evaluation_cri_55, $clz_evaluation_cri_56, $clz_evaluation_cri_57, $clz_evaluation_cri_58, $clz_evaluation_cri_59, $clz_evaluation_cri_60, $clz_evaluation_cri_61, $clz_evaluation_cri_62, $clz_evaluation_cri_63, $clz_evaluation_cri_64, $clz_evaluation_cri_65, $clz_evaluation_cri_66, $clz_evaluation_cri_67, $clz_evaluation_cri_68, $clz_evaluation_cri_69, $clz_evaluation_cri_70, $clz_evaluation_cri_71, $clz_evaluation_cri_72, $clz_evaluation_cri_73, $clz_evaluation_cri_74, $clz_evaluation_cri_75, $clz_evaluation_cri_76, $clz_evaluation_cri_77, $clz_evaluation_cri_78, $clz_evaluation_cri_79, $clz_evaluation_cri_80, $recode_added_by, $clz_repo_id);
			$result = $stmt->execute();

			$stmt->close();

        } else {
            // class_report is not already existed in the db
            return NOT_EXISTED;
        }
		         
        // Check for successful update
        if ($result) {
			// class_report successfully update
            return UPDATE_SUCCESSFULLY;
        } else {
            // Failed to update class_report
            return UPDATE_FAILED;
        }
        
		return $response;

    }
	
/**
     * Delete class_report
     *
     * @param Int $clz_repo_id Class Report id for the system
	 * @param String $recode_added_by
     *
     * @return database transaction status
     */
    public function deleteClassReport($clz_repo_id, $recode_added_by ) {
		
        $response = array();
        // First check if class_report already existed in db
        if ($this->isClassReportExists($clz_repo_id)) {
           			
			//
			$stmt = $this->conn->prepare("UPDATE class_report set status = 3, recode_modified_at = now() , recode_modified_by = ? where clz_repo_id = ? and (status = 1 or status = 2)");
			$stmt->bind_param("ii",$recode_added_by, $clz_repo_id);
			$result = $stmt->execute();
			
            $stmt->close();

        } else {
            // class_report is not already existed in the db
            return NOT_EXISTED;
        }
		         
        // Check for successful insertion
        if ($result) {
			// class_report successfully deleted
            return DELETE_SUCCESSFULLY;
        } else {
            // Failed to delete class_report
            return DELETE_FAILED;
        }
        
		return $response;

    }
	  
	/**
     * Fetching class_report by clz_repo_id
	 *
     * @param Int $clz_repo_id Class Report id
	 *
	 *@return Teacher object only needed data
     */
    public function getReportByClassReportId($clz_repo_id) {
        $stmt = $this->conn->prepare("SELECT * FROM class_report WHERE clz_repo_id = ? and (status = 1 or status = 2)");
        $stmt->bind_param("i",$clz_repo_id);
        $stmt->execute();
		$classReport = $stmt->get_result();
        $stmt->close();
        return $classReport;
           
    }
   
/*
 * ------------------------ SUPPORTIVE METHODS ------------------------
 */

	/**
     * Checking for duplicate report by clz_repo_id
     *
     * @param String $clz_repo_id report id to check in db
     *
     * @return boolean
     */
    private function isClassReportExists($clz_repo_id) {
		//$clz_repo_id = "1";
		$stmt = $this->conn->prepare("SELECT clz_repo_id from class_report WHERE (status = 1 or status = 2) and clz_repo_id = ?");
        $stmt->bind_param("i",$clz_repo_id);
        $stmt->execute();
		$stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return ($num_rows > 0); //if it has more than zero number of rows; then  it sends true
    }
}
?>