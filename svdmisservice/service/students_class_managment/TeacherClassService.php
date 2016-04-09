<?php
require_once '../../model/user_management/OperationalUserManagement.php';
require_once '../../model/students_class_managment/TeacherClassManagement.php';
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
 * ------------------------ TEACHER CLASS TABLE METHODS ------------------------
 */
 
/**
 * teacher_class Registration
 * url - /teacher_class_register
 * method - POST
 * params - year,tec_id,clz_id
 */
$app->post('/teacher_class_register',  'authenticate', function() use ($app) {
	
            // check for required params
            verifyRequiredParams(array('year','tec_id','clz_id'));
			
			global $currunt_user_id;

            $response = array();

            // reading post params
            $year = $app->request->post('year');
			$tec_id = $app->request->post('tec_id');
			$clz_id = $app->request->post('clz_id');
           
            $teacherClassManagement = new TeacherClassManagement();
			$res = $teacherClassManagement->createTeacherClass($year,$tec_id,$clz_id,$currunt_user_id);
			
            if ($res == CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "Teacher_Class is successfully registered";
            } else if ($res == CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registering teacher_class";
            } else if ($res == ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this teacher_class already exist";
            }
            // echo json response
            echoRespnse(201, $response);
        });

/**
 * teacher_class Update
 * url - /teacher_class_update
 * method - PUT
 * params - year,tec_id,clz_id
 */
$app->put('/teacher_class_update',  'authenticate', function() use ($app) {
	
            // check for required params
            verifyRequiredParams(array( 'year','tec_id','clz_id'));
			
			global $currunt_user_id;

            $response = array();

            // reading put params
			$year = $app->request->put('year');
            $tec_id = $app->request->put('tec_id');
			$clz_id = $app->request->put('clz_id');
			
            $teacherClassManagement = new TeacherClassManagement();
			$res = $teacherClassManagement->updateTeacherClass($year, $tec_id, $clz_id, $currunt_user_id);
			
            if ($res == UPDATE_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "You are successfully updated teacher_class";
            } else if ($res == UPDATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while updating teacher_class";
            } else if ($res == NOT_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this teacher_class is not exist";
            }
            // echo json response
            echoRespnse(201, $response);
        });

/**
 * teacher_class Delete
 * url - /teacher_class_delete
 * method - DELETE
 * params - year,tec_id
 */
$app->delete('/teacher_class_delete', 'authenticate', function() use ($app) {
			// check for required params
            verifyRequiredParams(array('year','tec_id'));
            
			global $currunt_user_id;

            $response = array();
			$year = $app->request->delete('year');
			$tec_id = $app->request->delete('tec_id');
			
            $teacherClassManagement = new TeacherClassManagement();
			$res = $teacherClassManagement->deleteTeacherClass($year, $tec_id, $currunt_user_id);
			
            if ($res == DELETE_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "TeacherClass is successfully deleted";
            } else if ($res == DELETE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while deleting TeacherClass";
            } else if ($res == NOT_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this TeacherClass is not exist"; 
            }
            // echo json response
            echoRespnse(201, $response);
        });
		
/**
 * get one teacher
 * method GET
 * url /teacherClass/:tec_id          
 */
$app->get('/teacherClass/:tec_id', 'authenticate', function($tec_id) {
            global $currunt_user_id;
            $response = array();
            
			$teacherClassManagement = new TeacherClassManagement();
			$res = $teacherClassManagement->getTeacherByTeacherClassId($tec_id);

            $response["error"] = false;
            $response["teacher_class"] = $res;
            
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
			
			$teacherClassManagement = new TeacherClassManagement();
			$res = $teacherClassManagement->getAllTeachers();

            $response["error"] = false;
            $response["teacher_class"] = array();

            // looping through result and preparing teachers array
            while ($teacher_class = $res->fetch_assoc()) {
                $tmp = array();
				
                $tmp["year"] = $teacher_class["year"];
                $tmp["tec_id"] = $teacher_class["tec_id"];
				$tmp["clz_id"] = $teacher_class["clz_id"];
                $tmp["status"] = $teacher_class["status"];
                $tmp["recode_added_at"] = $teacher_class["recode_added_at"];
				$tmp["recode_added_by"] = $teacher_class["recode_added_by"];
				
                array_push($response["teacher_class"], $tmp);
            }

            echoRespnse(200, $response);
        });		

/**
 * Listing all teachers
 * method GET
 * url /teachers        
 */
$app->get('/YearTeaID', 'authenticate', function() {
            global $user_id;
			
            $response = array();
			
			$teacherClassManagement = new TeacherClassManagement();
			$res = $teacherClassManagement->getAllYearTeaID();

            $response["error"] = false;
            $response["teacher_class"] = array();

            // looping through result and preparing teachers array
            while ($teacher_class = $res->fetch_assoc()) {
                $tmp = array();
				
                $tmp["year"] = $teacher_class["year"];
                $tmp["tec_id"] = $teacher_class["tec_id"];
				
                array_push($response["teacher_class"], $tmp);
            }

            echoRespnse(200, $response);
        });		
		
		
/**
 * Listing all teachers by year
 * method GET
 * url /teacherClasses/:teacherYear        
 */
 
$app->get('/teacherClasses/:teacherYear', 'authenticate', function($year) {
            global $user_id;
			
            $response = array();
			
			$teacherClassManagement = new TeacherClassManagement();
			$res = $teacherClassManagement->getAllTeacherYear($year);

            $response["error"] = false;
            $response["teacher_class"] = array();

            // looping through result and preparing teacherClass array
            while ($teacher_class = $res->fetch_assoc()) {
                $tmp = array();
				
                $tmp["year"] = $teacher_class["year"];
                $tmp["tec_id"] = $teacher_class["tec_id"];
				$tmp["clz_id"] = $teacher_class["clz_id"];
                $tmp["status"] = $teacher_class["status"];
                $tmp["recode_added_at"] = $teacher_class["recode_added_at"];
				$tmp["recode_added_by"] = $teacher_class["recode_added_by"];
				
                array_push($response["teacher_class"], $tmp);
            }

            echoRespnse(200, $response);
        });		
		
/**
 * Listing all teachers by class_id
 * method GET
 * url /classes/:classes        
 */
 
$app->get('/Classes/:classes', 'authenticate', function($clz_id) {
            global $user_id;
			
            $response = array();
			
			$teacherClassManagement = new TeacherClassManagement();
			$res = $teacherClassManagement->getAllTeacherClasses($clz_id);

            $response["error"] = false;
            $response["teacher_class"] = array();

            // looping through result and preparing teacherClass array
            while ($teacher_class = $res->fetch_assoc()) {
                $tmp = array();
				
                $tmp["year"] = $teacher_class["year"];
                $tmp["tec_id"] = $teacher_class["tec_id"];
				$tmp["clz_id"] = $teacher_class["clz_id"];
                $tmp["status"] = $teacher_class["status"];
                $tmp["recode_added_at"] = $teacher_class["recode_added_at"];
				$tmp["recode_added_by"] = $teacher_class["recode_added_by"];
				
                array_push($response["teacher_class"], $tmp);
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