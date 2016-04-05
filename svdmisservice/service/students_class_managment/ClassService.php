<?php
require_once '../../model/user_management/OperationalUserManagement.php';
require_once '../../model/students_class_managment/ClassManagement.php';
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
 * ------------------------ CLASS TABLE METHODS ------------------------
 */
 
/**
 * Class Registration
 * url - /class_register
 * method - POST
 * params - clz_grade, clz_class
 */
$app->post('/class_register',  'authenticate', function() use ($app) {
	
            // check for required params
            verifyRequiredParams(array('clz_grade', 'clz_class'));
			
			global $currunt_user_id;

            $response = array();

            // reading post params
            $clz_grade = $app->request->post('clz_grade');
            $clz_class = $app->request->post('clz_class');
           
            $classManagement = new ClassManagement();
			$res = $classManagement->createClass($clz_grade, $clz_class,$currunt_user_id);
			
            if ($res == CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "Class is successfully registered";
            } else if ($res == CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registereing class";
            } else if ($res == ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this class already exist";
            }
            // echo json response
            echoRespnse(201, $response);
        });

/**
 * Class Delete
 * url - /class_delete
 * method - DELETE
 * params - clz_grade,clz_class
 */
$app->delete('/class_delete', 'authenticate', function() use ($app) {
			// check for required params
            verifyRequiredParams(array('clz_grade', 'clz_class'));
            
			global $currunt_user_id;

            $response = array();
			
			// reading delete params
            $clz_grade = $app->request->delete('clz_grade');
            $clz_class = $app->request->delete('clz_class');

			
            $classManagement = new ClassManagement();
			$res = $classManagement->deleteClass($clz_grade,$clz_class, $currunt_user_id);
			
            if ($res == DELETE_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "Class is successfully deleted";
            } else if ($res == DELETE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while deleting class";
            } else if ($res == NOT_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this class is not exist";
            }
            // echo json response
            echoRespnse(201, $response);
        });
		
/**
 * get one class
 * method GET
 * url /class/:clz_grade/:clz_class          
 */
$app->get('/class/:clz_grade/:clz_class', 'authenticate', function($clz_grade,$clz_class) {
            global $currunt_user_id;
            $response = array();
            
			$classManagement = new ClassManagement();
			$res = $classManagement->getClassByClassName($clz_grade,$clz_class);

            $response["error"] = false;
            $response["class"] = $res;
           
            echoRespnse(200, $response);
        });

/**
 * Listing all class
 * method GET
 * url /class        
 */
$app->get('/class', 'authenticate', function() {
            global $user_id;
			
            $response = array();
			
            $classManagement = new ClassManagement();
			$res = $classManagement->getAllClass();

            $response["error"] = false;
            $response["class"] = array();

            // looping through result and preparing class array
            while ($class = $res->fetch_assoc()) {
                $tmp = array();
				
                $tmp["clz_grade"] = $class["clz_grade"];
                $tmp["clz_class"] = $class["clz_class"];
                $tmp["status"] = $class["status"];
                $tmp["recode_added_at"] = $class["recode_added_at"];
				$tmp["recode_added_by"] = $class["recode_added_by"];
				
                array_push($response["class"], $tmp);
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
	// Handling DELETE request params
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