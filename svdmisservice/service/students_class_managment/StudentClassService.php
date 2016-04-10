<?php
require_once '../../model/user_management/OperationalUserManagement.php';
require_once '../../model/students_class_managment/StudentClassManagement.php';
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
 * ------------------------ STUDENT CLASS TABLE METHODS ------------------------
 */
 
/**
 * student_class Registration
 * url - /student_class_register
 * method - POST
 * params - year, stu_id, clz_id, clz_report_id, prefect_report_id
 */
$app->post('/student_class_register',  'authenticate', function() use ($app) {
	
            // check for required params
            verifyRequiredParams(array('year', 'stu_id', 'clz_id', 'clz_report_id', 'prefect_report_id'));
			
			global $currunt_user_id;

            $response = array();

            // reading post params
            $year = $app->request->post('year');
			$stu_id = $app->request->post('stu_id');
			$clz_id = $app->request->post('clz_id');
			$clz_report_id = $app->request->post('clz_report_id');
			$prefect_report_id = $app->request->post('prefect_report_id');
			
            $studentClassManagement = new StudentClassManagement();
			$res = $studentClassManagement->createStudentClass($year, $stu_id, $clz_id, $clz_report_id, $prefect_report_id, $currunt_user_id);
			
            if ($res == CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "student_class is successfully registered";
            } else if ($res == CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registering student_class";
            } else if ($res == ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this student_class already exist";
            }
            // echo json response
            echoRespnse(201, $response);
        });

/**
 * student_class Update
 * url - /student_class_update
 * method - PUT
 * params - year, stu_id, clz_id, clz_report_id, prefect_report_id
 */
$app->put('/student_class_update',  'authenticate', function() use ($app) {
	
            // check for required params
            verifyRequiredParams(array('year', 'stu_id', 'clz_id', 'clz_report_id', 'prefect_report_id'));
			
			global $currunt_user_id;

            $response = array();

            // reading put params
            $year = $app->request->put('year');
			$stu_id = $app->request->put('stu_id');
			$clz_id = $app->request->put('clz_id');
			$clz_report_id = $app->request->put('clz_report_id');
			$prefect_report_id = $app->request->put('prefect_report_id');

            $studentClassManagement = new StudentClassManagement();
			$res = $studentClassManagement->updateStudentClass($year, $stu_id, $clz_id, $clz_report_id, $prefect_report_id);
			
            if ($res == UPDATE_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "You are successfully updated student_class";
            } else if ($res == UPDATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while updating student_class";
            } else if ($res == NOT_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this student_class is not exist";
            }
            // echo json response
            echoRespnse(201, $response);
        });

/**
 * student_class Delete
 * url - /student_class_delete
 * method - DELETE
 * params - year, stu_id
 */
$app->delete('/student_class_delete', 'authenticate', function() use ($app) {
			// check for required params
            verifyRequiredParams(array('year','stu_id'));
            
			global $currunt_user_id;

            $response = array();
			$year = $app->request->delete('year');
			$stu_id = $app->request->delete('stu_id');
			
            $studentClassManagement = new StudentClassManagement();
			$res = $studentClassManagement->deleteStudentClass($year, $stu_id, $currunt_user_id);
			
            if ($res == DELETE_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "student_class is successfully deleted";
            } else if ($res == DELETE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while deleting student_class";
            } else if ($res == NOT_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this student_class is not exist"; 
            }
            // echo json response
            echoRespnse(201, $response);
        });
		
/**
 * get one student_class by year, stu_id
 * method GET
 * url /student_class/:year/:stu_id        
 */
$app->get('/student_class/:year/:stu_id', 'authenticate', function($year, $stu_id) {
			
            global $currunt_user_id;
            $response = array();
            
			$studentClassManagement = new StudentClassManagement();
			$res = $studentClassManagement->getStudentClass($year, $stu_id);

            $response["error"] = false;
            $response["student_class"] = $res;
			
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