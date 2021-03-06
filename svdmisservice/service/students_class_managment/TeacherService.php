<?php
require_once '../../model/user_management/OperationalUserManagement.php';
require_once '../../model/students_class_managment/TeacherManagement.php';
require '../.././config/libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// User id from db - Global Variable
$currunt_user_id = NULL;

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        $operationalUserManagement = new OperationalUserManagement();

        // get the api key
        $api_key = $headers['Authorization'];
        // validating api key
        if (!$operationalUserManagement->isValidApiKey($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $currunt_user_id;
            // get user primary key id
            $currunt_user_id = $operationalUserManagement->getUserId($api_key);
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}

/*
 * ------------------------ TEACHER TABLE METHODS ------------------------
 */
 
/**
 * teacher Registration
 * url - /teacher_register
 * method - POST
 * params - tea_full_name, tea_name_with_initials, tea_land_phone_number, tea_mobile_phone_number, tea_address, tea_birth_day, tea_city', 'tec_nic', 'lib_mem_id, tea_distance_to_home, tea_occupation', 'tea_occupation_type, tea_office_address, tea_office_phone, tea_gender, tea_email, tea_student_id, tea_ob_id
 */
$app->post('/teacher_register',  'authenticate', function() use ($app) {
	
            // check for required params
            verifyRequiredParams(array('tea_full_name', 'tea_name_with_initials', 'tea_land_phone_number', 'tea_mobile_phone_number', 'tea_address', 'tea_birth_day', 'tea_city', 'tec_nic', 'lib_mem_id', 'tea_distance_to_home', 'tea_occupation', 'tea_occupation_type', 'tea_office_address', 'tea_office_phone', 'tea_gender', 'tea_email', 'tea_student_id', 'tea_ob_id'));
			
			global $currunt_user_id;

            $response = array();

            // reading post params
            $tea_full_name = $app->request->post('tea_full_name');
			$tea_name_with_initials = $app->request->post('tea_name_with_initials');
			$tea_land_phone_number = $app->request->post('tea_land_phone_number');
			$tea_mobile_phone_number = $app->request->post('tea_mobile_phone_number');
			$tea_address = $app->request->post('tea_address');
			$tea_birth_day = $app->request->post('tea_birth_day');
			$tea_city = $app->request->post('tea_city');
			$tec_nic = $app->request->post('tec_nic');
			$lib_mem_id = $app->request->post('lib_mem_id');
			$tea_distance_to_home = $app->request->post('tea_distance_to_home');
			$tea_occupation = $app->request->post('tea_occupation');
			$tea_occupation_type = $app->request->post('tea_occupation_type');
			$tea_office_address = $app->request->post('tea_office_address');
			$tea_office_phone = $app->request->post('tea_office_phone');
			$tea_gender = $app->request->post('tea_gender');
			$tea_email = $app->request->post('tea_email');
			$tea_student_id = $app->request->post('tea_student_id');
			$tea_ob_id = $app->request->post('tea_ob_id');
			
            $teacherManagement = new TeacherManagement();
			$res = $teacherManagement->createTeacher($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $currunt_user_id);
			
            if ($res == CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "Teacher is successfully registered";
            } else if ($res == CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registering teacher";
            } else if ($res == ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this teacher already exist";
            }
            // echo json response
            echoRespnse(201, $response);
        });

/**
 * Teacher Update
 * url - /teacher_update
 * method - PUT
 * params - tea_full_name, tea_name_with_initials, tea_land_phone_number, tea_mobile_phone_number, tea_address, tea_birth_day, tea_city, tec_nic, lib_mem_id, tea_distance_to_home, tea_occupation, tea_occupation_type, tea_office_address, tea_office_phone, tea_gender, tea_email, tea_student_id, tea_ob_id
 */
$app->put('/teacher_update',  'authenticate', function() use ($app) {
	
            // check for required params
            verifyRequiredParams(array('tea_full_name', 'tea_name_with_initials', 'tea_land_phone_number', 'tea_mobile_phone_number', 'tea_address', 'tea_birth_day', 'tea_city', 'tec_nic', 'lib_mem_id', 'tea_distance_to_home', 'tea_occupation', 'tea_occupation_type', 'tea_office_address', 'tea_office_phone', 'tea_gender', 'tea_email', 'tea_student_id', 'tea_ob_id'));
			
			global $currunt_user_id;

            $response = array();

            // reading put params
            $tea_full_name = $app->request->put('tea_full_name');
			$tea_name_with_initials = $app->request->put('tea_name_with_initials');
			$tea_land_phone_number = $app->request->put('tea_land_phone_number');
			$tea_mobile_phone_number = $app->request->put('tea_mobile_phone_number');
			$tea_address = $app->request->put('tea_address');
			$tea_birth_day = $app->request->put('tea_birth_day');
			$tea_city = $app->request->put('tea_city');
			$tec_nic = $app->request->put('tec_nic');
			$lib_mem_id = $app->request->put('lib_mem_id');
			$tea_distance_to_home = $app->request->put('tea_distance_to_home');
			$tea_occupation = $app->request->put('tea_occupation');
			$tea_occupation_type = $app->request->put('tea_occupation_type');
			$tea_office_address = $app->request->put('tea_office_address');
			$tea_office_phone = $app->request->put('tea_office_phone');
			$tea_gender = $app->request->put('tea_gender');
			$tea_email = $app->request->put('tea_email');
			$tea_student_id = $app->request->put('tea_student_id');
			$tea_ob_id = $app->request->put('tea_ob_id');

            $teacherManagement = new TeacherManagement();
			$res = $teacherManagement->updateTeacher($tea_full_name, $tea_name_with_initials, $tea_land_phone_number, $tea_mobile_phone_number, $tea_address, $tea_birth_day, $tea_city, $tec_nic, $lib_mem_id, $tea_distance_to_home, $tea_occupation, $tea_occupation_type, $tea_office_address, $tea_office_phone, $tea_gender, $tea_email, $tea_student_id, $tea_ob_id, $currunt_user_id);
			
            if ($res == UPDATE_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "You are successfully updated teacher";
            } else if ($res == UPDATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while updating teacher";
            } else if ($res == NOT_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this teacher is not exist";
            }
            // echo json response
            echoRespnse(201, $response);
        });

/**
 * Teacher Delete
 * url - /teacher_delete
 * method - DELETE
 * params - tea_full_name
 */
$app->delete('/teacher_delete', 'authenticate', function() use ($app) {
			// check for required params
            verifyRequiredParams(array('tea_full_name',));
            
			global $currunt_user_id;

            $response = array();
			$tea_full_name = $app->request->delete('tea_full_name');
			
            $teacherManagement = new TeacherManagement();
			$res = $teacherManagement->deleteTeacher($tea_full_name, $currunt_user_id);
			
            if ($res == DELETE_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "Teacher is successfully deleted";
            } else if ($res == DELETE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while deleting teacher";
            } else if ($res == NOT_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this teacher is not exist"; 
            }
            // echo json response
            echoRespnse(201, $response);
        });
		
/**
 * get one teacher by tea_id
 * method GET
 * url /teacherNic/:tea_id          
 */
$app->get('/teacherTid/:tea_id', 'authenticate', function($tea_id) {
            global $currunt_user_id;
            $response = array();
            
			$teacherManagement = new TeacherManagement();
			$res = $teacherManagement->getTeacherByTeacherTid($tea_id);

            $response["error"] = false;
            $response["teacher"] = $res;
            
            echoRespnse(200, $response);
        });
		
/**
 * get one teacher by tea_full_name
 * method GET
 * url /teacherName/:tea_full_name          
 */
$app->get('/teacherName/:tea_full_name', 'authenticate', function($tea_full_name) {
            global $currunt_user_id;
            $response = array();
            
			$teacherManagement = new TeacherManagement();
			$res = $teacherManagement->getTeacherByTeacherName($tea_full_name);

            $response["error"] = false;
            $response["teacher"] = $res;
            
            echoRespnse(200, $response);
        });
		
/**
 * get one teacher by nic
 * method GET
 * url /teacherNic/:tecNic          
 */
$app->get('/teacherNic/:tecNic', 'authenticate', function($tec_nic) {
            global $currunt_user_id;
            $response = array();
            
			$teacherManagement = new TeacherManagement();
			$res = $teacherManagement->getTeacherByTeacherNic($tec_nic);

            $response["error"] = false;
            $response["teacher"] = $res;
            
            echoRespnse(200, $response);
        });
		
/**
 * get one teacher by lib_mem_id
 * method GET
 * url /teacherLid/:lib_mem_id          
 */
$app->get('/teacherLid/:lib_mem_id', 'authenticate', function($lib_mem_id) {
            global $currunt_user_id;
            $response = array();
            
			$teacherManagement = new TeacherManagement();
			$res = $teacherManagement->getTeacherByTeacherLid($lib_mem_id);

            $response["error"] = false;
            $response["teacher"] = $res;
            
            echoRespnse(200, $response);
        });
		
/**
 * Listing all teachers by occupation type
 * method GET
 * url //:teacherOtype        
 */
 
$app->get('/teacherOtype/:teacherOtype', 'authenticate', function($tea_occupation_type) {
            global $user_id;
			
            $response = array();
			
			$teacherManagement = new TeacherManagement();
			$res = $teacherManagement->getAllTeacherOtype($tea_occupation_type);

            $response["error"] = false;
            $response["teacher"] = array();

            // looping through result and preparing teachers array
            while ($teacher = $res->fetch_assoc()) {
                $tmp = array();
				
				$tmp["tea_full_name"] = $teacher["tea_full_name"];
                $tmp["tea_name_with_initials"] = $teacher["tea_name_with_initials"];
				$tmp["tea_land_phone_numbteacherCityer"] = $teacher["tea_land_phone_number"];
                $tmp["tea_mobile_phone_number"] = $teacher["tea_mobile_phone_number"];
				$tmp["tea_address"] = $teacher["tea_address"];
                $tmp["tea_birth_day"] = $teacher["tea_birth_day"];
				$tmp["tea_city"] = $teacher["tea_city"];
				$tmp["tec_nic"] = $teacher["tec_nic"];
				$tmp["lib_mem_id"] = $teacher["lib_mem_id"];
				$tmp["tea_distance_to_home"] = $teacher["tea_distance_to_home"];
				$tmp["tea_occupation"] = $teacher["tea_occupation"];
				$tmp["tea_occupation_type"] = $teacher["tea_occupation_type"];
				$tmp["tea_office_address"] = $teacher["tea_office_address"];
				$tmp["tea_office_phone"] = $teacher["tea_office_phone"];
				$tmp["tea_gender"] = $teacher["tea_gender"];
				$tmp["tea_email"] = $teacher["tea_email"];
				$tmp["tea_student_id"] = $teacher["tea_student_id"];
				$tmp["tea_ob_id"] = $teacher["tea_ob_id"];
                $tmp["status"] = $teacher["status"];
                $tmp["recode_added_at"] = $teacher["recode_added_at"];
				$tmp["recode_added_by"] = $teacher["recode_added_by"];
				
                array_push($response["teacher"], $tmp);
            }

            echoRespnse(200, $response);
        });

/**
 * Listing all teachers by gender
 * method GET
 * url //:teacherGender        
 */
 
$app->get('/teacherGender/:teacherGender', 'authenticate', function($tea_gender) {
            global $user_id;
			
            $response = array();
			
			$teacherManagement = new TeacherManagement();
			$res = $teacherManagement->getAllTeacherGender($tea_gender);

            $response["error"] = false;
            $response["teacher"] = array();

            // looping through result and preparing teachers array
            while ($teacher = $res->fetch_assoc()) {
                $tmp = array();
				
				$tmp["tea_full_name"] = $teacher["tea_full_name"];
                $tmp["tea_name_with_initials"] = $teacher["tea_name_with_initials"];
				$tmp["tea_land_phone_numbteacherCityer"] = $teacher["tea_land_phone_number"];
                $tmp["tea_mobile_phone_number"] = $teacher["tea_mobile_phone_number"];
				$tmp["tea_address"] = $teacher["tea_address"];
                $tmp["tea_birth_day"] = $teacher["tea_birth_day"];
				$tmp["tea_city"] = $teacher["tea_city"];
				$tmp["tec_nic"] = $teacher["tec_nic"];
				$tmp["lib_mem_id"] = $teacher["lib_mem_id"];
				$tmp["tea_distance_to_home"] = $teacher["tea_distance_to_home"];
				$tmp["tea_occupation"] = $teacher["tea_occupation"];
				$tmp["tea_occupation_type"] = $teacher["tea_occupation_type"];
				$tmp["tea_office_address"] = $teacher["tea_office_address"];
				$tmp["tea_office_phone"] = $teacher["tea_office_phone"];
				$tmp["tea_gender"] = $teacher["tea_gender"];
				$tmp["tea_email"] = $teacher["tea_email"];
				$tmp["tea_student_id"] = $teacher["tea_student_id"];
				$tmp["tea_ob_id"] = $teacher["tea_ob_id"];
                $tmp["status"] = $teacher["status"];
                $tmp["recode_added_at"] = $teacher["recode_added_at"];
				$tmp["recode_added_by"] = $teacher["recode_added_by"];
				
                array_push($response["teacher"], $tmp);
            }

            echoRespnse(200, $response);
        });		
		
/**
 * get one teacher by tea_student_id
 * method GET
 * url /teacherSid/:tea_student_id          
 */
$app->get('/teacherSid/:tea_student_id', 'authenticate', function($tea_student_id) {
            global $currunt_user_id;
            $response = array();
            
			$teacherManagement = new TeacherManagement();
			$res = $teacherManagement->getTeacherByTeacherSid($tea_student_id);

            $response["error"] = false;
            $response["teacher"] = $res;
            
            echoRespnse(200, $response);
        });						
		
/**
 * get one teacher by tea_ob_id
 * method GET
 * url /teacherOid/:tea_ob_id          
 */
$app->get('/teacherOid/:tea_ob_id', 'authenticate', function($tea_ob_id) {
            global $currunt_user_id;
            $response = array();
            
			$teacherManagement = new TeacherManagement();
			$res = $teacherManagement->getTeacherByTeacherOid($tea_ob_id);

            $response["error"] = false;
            $response["teacher"] = $res;
            
            echoRespnse(200, $response);
        });						

/**
 * Listing all teachers
 * method GET
 * url /teachers        
 */
$app->get('/teachers', 'authenticate', function() {
            global $user_id;
			
            $response = array();
			
			$teacherManagement = new TeacherManagement();
			$res = $teacherManagement->getAllTeachers();

            $response["error"] = false;
            $response["teacher"] = array();

            // looping through result and preparing teachers array
            while ($teacher = $res->fetch_assoc()) {
                $tmp = array();
				
                $tmp["tea_full_name"] = $teacher["tea_full_name"];
                $tmp["tea_name_with_initials"] = $teacher["tea_name_with_initials"];
				$tmp["tea_land_phone_number"] = $teacher["tea_land_phone_number"];
                $tmp["tea_mobile_phone_number"] = $teacher["tea_mobile_phone_number"];
				$tmp["tea_address"] = $teacher["tea_address"];
                $tmp["tea_birth_day"] = $teacher["tea_birth_day"];
				$tmp["tea_city"] = $teacher["tea_city"];
				$tmp["tec_nic"] = $teacher["tec_nic"];
				$tmp["lib_mem_id"] = $teacher["lib_mem_id"];
				$tmp["tea_distance_to_home"] = $teacher["tea_distance_to_home"];
				$tmp["tea_occupation"] = $teacher["tea_occupation"];
				$tmp["tea_occupation_type"] = $teacher["tea_occupation_type"];
				$tmp["tea_office_address"] = $teacher["tea_office_address"];
				$tmp["tea_office_phone"] = $teacher["tea_office_phone"];
				$tmp["tea_gender"] = $teacher["tea_gender"];
				$tmp["tea_email"] = $teacher["tea_email"];
				$tmp["tea_student_id"] = $teacher["tea_student_id"];
				$tmp["tea_ob_id"] = $teacher["tea_ob_id"];
                $tmp["status"] = $teacher["status"];
                $tmp["recode_added_at"] = $teacher["recode_added_at"];
				$tmp["recode_added_by"] = $teacher["recode_added_by"];
				
                array_push($response["teacher"], $tmp);
            }

            echoRespnse(200, $response);
        });		

/**
 * Listing all teachers by city
 * method GET
 * url //:teacherCity        
 */
 
$app->get('/teacherCity/:teacherCity', 'authenticate', function($tea_city) {
            global $user_id;
			
            $response = array();
			
			$teacherManagement = new TeacherManagement();
			$res = $teacherManagement->getAllTeacherCity($tea_city);

            $response["error"] = false;
            $response["teacher"] = array();

            // looping through result and preparing teachers array
            while ($teacher = $res->fetch_assoc()) {
                $tmp = array();
				
				$tmp["tea_full_name"] = $teacher["tea_full_name"];
                $tmp["tea_name_with_initials"] = $teacher["tea_name_with_initials"];
				$tmp["tea_land_phone_numbteacherCityer"] = $teacher["tea_land_phone_number"];
                $tmp["tea_mobile_phone_number"] = $teacher["tea_mobile_phone_number"];
				$tmp["tea_address"] = $teacher["tea_address"];
                $tmp["tea_birth_day"] = $teacher["tea_birth_day"];
				$tmp["tea_city"] = $teacher["tea_city"];
				$tmp["tec_nic"] = $teacher["tec_nic"];
				$tmp["lib_mem_id"] = $teacher["lib_mem_id"];
				$tmp["tea_distance_to_home"] = $teacher["tea_distance_to_home"];
				$tmp["tea_occupation"] = $teacher["tea_occupation"];
				$tmp["tea_occupation_type"] = $teacher["tea_occupation_type"];
				$tmp["tea_office_address"] = $teacher["tea_office_address"];
				$tmp["tea_office_phone"] = $teacher["tea_office_phone"];
				$tmp["tea_gender"] = $teacher["tea_gender"];
				$tmp["tea_email"] = $teacher["tea_email"];
				$tmp["tea_student_id"] = $teacher["tea_student_id"];
				$tmp["tea_ob_id"] = $teacher["tea_ob_id"];
                $tmp["status"] = $teacher["status"];
                $tmp["recode_added_at"] = $teacher["recode_added_at"];
				$tmp["recode_added_by"] = $teacher["recode_added_by"];
				
                array_push($response["teacher"], $tmp);
            }

            echoRespnse(200, $response);
        });		
								
/*
 * ------------------------ SUPPORTIVE METHODS ------------------------
 */				
				
/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
	// Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();
?>