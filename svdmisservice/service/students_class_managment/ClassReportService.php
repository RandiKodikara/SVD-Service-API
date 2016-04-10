<?php
require_once '../../model/user_management/OperationalUserManagement.php';
require_once '../../model/students_class_managment/ClassReportManagement.php';
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
 * class_report Registration
 * url - /class_report_register
 * method - POST
 * params - clz_evaluation_cri_1, clz_evaluation_cri_2, clz_evaluation_cri_3, clz_evaluation_cri_4, clz_evaluation_cri_5, clz_evaluation_cri_6, clz_evaluation_cri_7, clz_evaluation_cri_8, clz_evaluation_cri_9, clz_evaluation_cri_10, clz_evaluation_cri_11, clz_evaluation_cri_12, clz_evaluation_cri_13, clz_evaluation_cri_14, clz_evaluation_cri_15, clz_evaluation_cri_16, clz_evaluation_cri_17, clz_evaluation_cri_18, clz_evaluation_cri_19, clz_evaluation_cri_20, clz_evaluation_cri_21, clz_evaluation_cri_22, clz_evaluation_cri_23, clz_evaluation_cri_24, clz_evaluation_cri_25, clz_evaluation_cri_26, clz_evaluation_cri_27, clz_evaluation_cri_28, clz_evaluation_cri_29, clz_evaluation_cri_30, clz_evaluation_cri_31, clz_evaluation_cri_32, clz_evaluation_cri_33, clz_evaluation_cri_34, clz_evaluation_cri_35, clz_evaluation_cri_36, clz_evaluation_cri_37, clz_evaluation_cri_38, clz_evaluation_cri_39, clz_evaluation_cri_40, clz_evaluation_cri_41, clz_evaluation_cri_42, clz_evaluation_cri_43, clz_evaluation_cri_44, clz_evaluation_cri_45, clz_evaluation_cri_46, clz_evaluation_cri_47, clz_evaluation_cri_48, clz_evaluation_cri_49, clz_evaluation_cri_50, clz_evaluation_cri_51, clz_evaluation_cri_52, clz_evaluation_cri_53, clz_evaluation_cri_54, clz_evaluation_cri_55, clz_evaluation_cri_56, clz_evaluation_cri_57, clz_evaluation_cri_58, clz_evaluation_cri_59, clz_evaluation_cri_60, clz_evaluation_cri_61, clz_evaluation_cri_62, clz_evaluation_cri_63, clz_evaluation_cri_64, clz_evaluation_cri_65, clz_evaluation_cri_66, clz_evaluation_cri_67, clz_evaluation_cri_68, clz_evaluation_cri_69, clz_evaluation_cri_70, clz_evaluation_cri_71, clz_evaluation_cri_72, clz_evaluation_cri_73, clz_evaluation_cri_74, clz_evaluation_cri_75, clz_evaluation_cri_76, clz_evaluation_cri_77, clz_evaluation_cri_78, clz_evaluation_cri_79, clz_evaluation_cri_80
 */
$app->post('/class_report_register',  'authenticate', function() use ($app) {
	
            // check for required params
            verifyRequiredParams(array('clz_evaluation_cri_1', 'clz_evaluation_cri_2', 'clz_evaluation_cri_3', 'clz_evaluation_cri_4', 'clz_evaluation_cri_5', 'clz_evaluation_cri_6', 'clz_evaluation_cri_7', 'clz_evaluation_cri_8', 'clz_evaluation_cri_9', 'clz_evaluation_cri_10', 'clz_evaluation_cri_11', 'clz_evaluation_cri_12', 'clz_evaluation_cri_13', 'clz_evaluation_cri_14', 'clz_evaluation_cri_15', 'clz_evaluation_cri_16', 'clz_evaluation_cri_17', 'clz_evaluation_cri_18', 'clz_evaluation_cri_19', 'clz_evaluation_cri_20', 'clz_evaluation_cri_21', 'clz_evaluation_cri_22', 'clz_evaluation_cri_23', 'clz_evaluation_cri_24', 'clz_evaluation_cri_25', 'clz_evaluation_cri_26', 'clz_evaluation_cri_27', 'clz_evaluation_cri_28', 'clz_evaluation_cri_29', 'clz_evaluation_cri_30', 'clz_evaluation_cri_31', 'clz_evaluation_cri_32', 'clz_evaluation_cri_33', 'clz_evaluation_cri_34', 'clz_evaluation_cri_35', 'clz_evaluation_cri_36', 'clz_evaluation_cri_37', 'clz_evaluation_cri_38', 'clz_evaluation_cri_39', 'clz_evaluation_cri_40', 'clz_evaluation_cri_41', 'clz_evaluation_cri_42', 'clz_evaluation_cri_43', 'clz_evaluation_cri_44', 'clz_evaluation_cri_45', 'clz_evaluation_cri_46', 'clz_evaluation_cri_47', 'clz_evaluation_cri_48', 'clz_evaluation_cri_49', 'clz_evaluation_cri_50', 'clz_evaluation_cri_51', 'clz_evaluation_cri_52', 'clz_evaluation_cri_53', 'clz_evaluation_cri_54', 'clz_evaluation_cri_55', 'clz_evaluation_cri_56', 'clz_evaluation_cri_57', 'clz_evaluation_cri_58', 'clz_evaluation_cri_59', 'clz_evaluation_cri_60', 'clz_evaluation_cri_61', 'clz_evaluation_cri_62', 'clz_evaluation_cri_63', 'clz_evaluation_cri_64', 'clz_evaluation_cri_65', 'clz_evaluation_cri_66', 'clz_evaluation_cri_67', 'clz_evaluation_cri_68', 'clz_evaluation_cri_69', 'clz_evaluation_cri_70', 'clz_evaluation_cri_71', 'clz_evaluation_cri_72', 'clz_evaluation_cri_73', 'clz_evaluation_cri_74', 'clz_evaluation_cri_75', 'clz_evaluation_cri_76', 'clz_evaluation_cri_77', 'clz_evaluation_cri_78', 'clz_evaluation_cri_79', 'clz_evaluation_cri_80'));
			
			global $currunt_user_id;

            $response = array();

            // reading post params
            $clz_evaluation_cri_1 = $app->request->post('clz_evaluation_cri_1');
			$clz_evaluation_cri_2 = $app->request->post('clz_evaluation_cri_2');
			$clz_evaluation_cri_3 = $app->request->post('clz_evaluation_cri_3');
			$clz_evaluation_cri_4 = $app->request->post('clz_evaluation_cri_4');
			$clz_evaluation_cri_5 = $app->request->post('clz_evaluation_cri_5');
			$clz_evaluation_cri_6 = $app->request->post('clz_evaluation_cri_6');
			$clz_evaluation_cri_7 = $app->request->post('clz_evaluation_cri_7');
			$clz_evaluation_cri_8 = $app->request->post('clz_evaluation_cri_8');
			$clz_evaluation_cri_9 = $app->request->post('clz_evaluation_cri_9');
			$clz_evaluation_cri_10 = $app->request->post('clz_evaluation_cri_10');
			$clz_evaluation_cri_11 = $app->request->post('clz_evaluation_cri_11');
			$clz_evaluation_cri_12 = $app->request->post('clz_evaluation_cri_12');
			$clz_evaluation_cri_13 = $app->request->post('clz_evaluation_cri_13');
			$clz_evaluation_cri_14 = $app->request->post('clz_evaluation_cri_14');
			$clz_evaluation_cri_15 = $app->request->post('clz_evaluation_cri_15');
			$clz_evaluation_cri_16 = $app->request->post('clz_evaluation_cri_16');
			$clz_evaluation_cri_17 = $app->request->post('clz_evaluation_cri_17');
			$clz_evaluation_cri_18 = $app->request->post('clz_evaluation_cri_18');
			$clz_evaluation_cri_19 = $app->request->post('clz_evaluation_cri_19');
			$clz_evaluation_cri_20 = $app->request->post('clz_evaluation_cri_20');
			$clz_evaluation_cri_21 = $app->request->post('clz_evaluation_cri_21');
			$clz_evaluation_cri_22 = $app->request->post('clz_evaluation_cri_22');
			$clz_evaluation_cri_23 = $app->request->post('clz_evaluation_cri_23');
			$clz_evaluation_cri_24 = $app->request->post('clz_evaluation_cri_24');
			$clz_evaluation_cri_25 = $app->request->post('clz_evaluation_cri_25');
			$clz_evaluation_cri_26 = $app->request->post('clz_evaluation_cri_26');
			$clz_evaluation_cri_27 = $app->request->post('clz_evaluation_cri_27');
			$clz_evaluation_cri_28 = $app->request->post('clz_evaluation_cri_28');
			$clz_evaluation_cri_29 = $app->request->post('clz_evaluation_cri_29');
			$clz_evaluation_cri_30 = $app->request->post('clz_evaluation_cri_30');
			$clz_evaluation_cri_31 = $app->request->post('clz_evaluation_cri_31');
			$clz_evaluation_cri_32 = $app->request->post('clz_evaluation_cri_32');
			$clz_evaluation_cri_33 = $app->request->post('clz_evaluation_cri_33');
			$clz_evaluation_cri_34 = $app->request->post('clz_evaluation_cri_34');
			$clz_evaluation_cri_35 = $app->request->post('clz_evaluation_cri_35');
			$clz_evaluation_cri_36 = $app->request->post('clz_evaluation_cri_36');
			$clz_evaluation_cri_37 = $app->request->post('clz_evaluation_cri_37');
			$clz_evaluation_cri_38 = $app->request->post('clz_evaluation_cri_38');
			$clz_evaluation_cri_39 = $app->request->post('clz_evaluation_cri_39');
			$clz_evaluation_cri_40 = $app->request->post('clz_evaluation_cri_40');
			$clz_evaluation_cri_41 = $app->request->post('clz_evaluation_cri_41');
			$clz_evaluation_cri_42 = $app->request->post('clz_evaluation_cri_42');
			$clz_evaluation_cri_43 = $app->request->post('clz_evaluation_cri_43');
			$clz_evaluation_cri_44 = $app->request->post('clz_evaluation_cri_44');
			$clz_evaluation_cri_45 = $app->request->post('clz_evaluation_cri_45');
			$clz_evaluation_cri_46 = $app->request->post('clz_evaluation_cri_46');
			$clz_evaluation_cri_47 = $app->request->post('clz_evaluation_cri_47');
			$clz_evaluation_cri_48 = $app->request->post('clz_evaluation_cri_48');
			$clz_evaluation_cri_49 = $app->request->post('clz_evaluation_cri_49');
			$clz_evaluation_cri_50 = $app->request->post('clz_evaluation_cri_50');
			$clz_evaluation_cri_51 = $app->request->post('clz_evaluation_cri_51');
			$clz_evaluation_cri_52 = $app->request->post('clz_evaluation_cri_52');
			$clz_evaluation_cri_53 = $app->request->post('clz_evaluation_cri_53');
			$clz_evaluation_cri_54 = $app->request->post('clz_evaluation_cri_54');
			$clz_evaluation_cri_55 = $app->request->post('clz_evaluation_cri_55');
			$clz_evaluation_cri_56 = $app->request->post('clz_evaluation_cri_56');
			$clz_evaluation_cri_57 = $app->request->post('clz_evaluation_cri_57');
			$clz_evaluation_cri_58 = $app->request->post('clz_evaluation_cri_58');
			$clz_evaluation_cri_59 = $app->request->post('clz_evaluation_cri_59');
			$clz_evaluation_cri_60 = $app->request->post('clz_evaluation_cri_60');
			$clz_evaluation_cri_61 = $app->request->post('clz_evaluation_cri_61');
			$clz_evaluation_cri_62 = $app->request->post('clz_evaluation_cri_62');
			$clz_evaluation_cri_63 = $app->request->post('clz_evaluation_cri_63');
			$clz_evaluation_cri_64 = $app->request->post('clz_evaluation_cri_64');
			$clz_evaluation_cri_65 = $app->request->post('clz_evaluation_cri_65');
			$clz_evaluation_cri_66 = $app->request->post('clz_evaluation_cri_66');
			$clz_evaluation_cri_67 = $app->request->post('clz_evaluation_cri_67');
			$clz_evaluation_cri_68 = $app->request->post('clz_evaluation_cri_68');
			$clz_evaluation_cri_69 = $app->request->post('clz_evaluation_cri_69');
			$clz_evaluation_cri_70 = $app->request->post('clz_evaluation_cri_70');
			$clz_evaluation_cri_71 = $app->request->post('clz_evaluation_cri_71');
			$clz_evaluation_cri_72 = $app->request->post('clz_evaluation_cri_72');
			$clz_evaluation_cri_73 = $app->request->post('clz_evaluation_cri_73');
			$clz_evaluation_cri_74 = $app->request->post('clz_evaluation_cri_74');
			$clz_evaluation_cri_75 = $app->request->post('clz_evaluation_cri_75');
			$clz_evaluation_cri_76 = $app->request->post('clz_evaluation_cri_76');
			$clz_evaluation_cri_77 = $app->request->post('clz_evaluation_cri_77');
			$clz_evaluation_cri_78 = $app->request->post('clz_evaluation_cri_78');
			$clz_evaluation_cri_79 = $app->request->post('clz_evaluation_cri_79');
			$clz_evaluation_cri_80 = $app->request->post('clz_evaluation_cri_80');
           
            $classReportManagement = new ClassReportManagement();
			$res = $classReportManagement->createClassReport($clz_evaluation_cri_1, $clz_evaluation_cri_2, $clz_evaluation_cri_3, $clz_evaluation_cri_4, $clz_evaluation_cri_5, $clz_evaluation_cri_6, $clz_evaluation_cri_7, $clz_evaluation_cri_8, $clz_evaluation_cri_9, $clz_evaluation_cri_10, $clz_evaluation_cri_11, $clz_evaluation_cri_12, $clz_evaluation_cri_13, $clz_evaluation_cri_14, $clz_evaluation_cri_15, $clz_evaluation_cri_16, $clz_evaluation_cri_17, $clz_evaluation_cri_18, $clz_evaluation_cri_19, $clz_evaluation_cri_20, $clz_evaluation_cri_21, $clz_evaluation_cri_22, $clz_evaluation_cri_23, $clz_evaluation_cri_24, $clz_evaluation_cri_25, $clz_evaluation_cri_26, $clz_evaluation_cri_27, $clz_evaluation_cri_28, $clz_evaluation_cri_29, $clz_evaluation_cri_30, $clz_evaluation_cri_31, $clz_evaluation_cri_32, $clz_evaluation_cri_33, $clz_evaluation_cri_34, $clz_evaluation_cri_35, $clz_evaluation_cri_36, $clz_evaluation_cri_37, $clz_evaluation_cri_38, $clz_evaluation_cri_39, $clz_evaluation_cri_40, $clz_evaluation_cri_41, $clz_evaluation_cri_42, $clz_evaluation_cri_43, $clz_evaluation_cri_44, $clz_evaluation_cri_45, $clz_evaluation_cri_46, $clz_evaluation_cri_47, $clz_evaluation_cri_48, $clz_evaluation_cri_49, $clz_evaluation_cri_50, $clz_evaluation_cri_51, $clz_evaluation_cri_52, $clz_evaluation_cri_53, $clz_evaluation_cri_54, $clz_evaluation_cri_55, $clz_evaluation_cri_56, $clz_evaluation_cri_57, $clz_evaluation_cri_58, $clz_evaluation_cri_59, $clz_evaluation_cri_60, $clz_evaluation_cri_61, $clz_evaluation_cri_62, $clz_evaluation_cri_63, $clz_evaluation_cri_64, $clz_evaluation_cri_65, $clz_evaluation_cri_66, $clz_evaluation_cri_67, $clz_evaluation_cri_68, $clz_evaluation_cri_69, $clz_evaluation_cri_70, $clz_evaluation_cri_71, $clz_evaluation_cri_72, $clz_evaluation_cri_73, $clz_evaluation_cri_74, $clz_evaluation_cri_75, $clz_evaluation_cri_76, $clz_evaluation_cri_77, $clz_evaluation_cri_78, $clz_evaluation_cri_79, $clz_evaluation_cri_80);
			
            if ($res == CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "class_report is successfully registered";
            } else if ($res == CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registering class_report";
            } else if ($res == ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this class_report already exist";
            }
            // echo json response
            echoRespnse(201, $response);
        });

/**
 * class_report Update
 * url - /class_report_update
 * method - PUT
 * params - clz_evaluation_cri_1, clz_evaluation_cri_2, clz_evaluation_cri_3, clz_evaluation_cri_4, clz_evaluation_cri_5, clz_evaluation_cri_6, clz_evaluation_cri_7, clz_evaluation_cri_8, clz_evaluation_cri_9, clz_evaluation_cri_10, clz_evaluation_cri_11, clz_evaluation_cri_12, clz_evaluation_cri_13, clz_evaluation_cri_14, clz_evaluation_cri_15, clz_evaluation_cri_16, clz_evaluation_cri_17, clz_evaluation_cri_18, clz_evaluation_cri_19, clz_evaluation_cri_20, clz_evaluation_cri_21, clz_evaluation_cri_22, clz_evaluation_cri_23, clz_evaluation_cri_24, clz_evaluation_cri_25, clz_evaluation_cri_26, clz_evaluation_cri_27, clz_evaluation_cri_28, clz_evaluation_cri_29, clz_evaluation_cri_30, clz_evaluation_cri_31, clz_evaluation_cri_32, clz_evaluation_cri_33, clz_evaluation_cri_34, clz_evaluation_cri_35, clz_evaluation_cri_36, clz_evaluation_cri_37, clz_evaluation_cri_38, clz_evaluation_cri_39, clz_evaluation_cri_40, clz_evaluation_cri_41, clz_evaluation_cri_42, clz_evaluation_cri_43, clz_evaluation_cri_44, clz_evaluation_cri_45, clz_evaluation_cri_46, clz_evaluation_cri_47, clz_evaluation_cri_48, clz_evaluation_cri_49, clz_evaluation_cri_50, clz_evaluation_cri_51, clz_evaluation_cri_52, clz_evaluation_cri_53, clz_evaluation_cri_54, clz_evaluation_cri_55, clz_evaluation_cri_56, clz_evaluation_cri_57, clz_evaluation_cri_58, clz_evaluation_cri_59, clz_evaluation_cri_60, clz_evaluation_cri_61, clz_evaluation_cri_62, clz_evaluation_cri_63, clz_evaluation_cri_64, clz_evaluation_cri_65, clz_evaluation_cri_66, clz_evaluation_cri_67, clz_evaluation_cri_68, clz_evaluation_cri_69, clz_evaluation_cri_70, clz_evaluation_cri_71, clz_evaluation_cri_72, clz_evaluation_cri_73, clz_evaluation_cri_74, clz_evaluation_cri_75, clz_evaluation_cri_76, clz_evaluation_cri_77, clz_evaluation_cri_78, clz_evaluation_cri_79, clz_evaluation_cri_80
 */
$app->put('/class_report_update',  'authenticate', function() use ($app) {
	
            // check for required params
            verifyRequiredParams(array( 'clz_evaluation_cri_1', 'clz_evaluation_cri_2', 'clz_evaluation_cri_3', 'clz_evaluation_cri_4', 'clz_evaluation_cri_5', 'clz_evaluation_cri_6', 'clz_evaluation_cri_7', 'clz_evaluation_cri_8', 'clz_evaluation_cri_9', 'clz_evaluation_cri_10', 'clz_evaluation_cri_11', 'clz_evaluation_cri_12', 'clz_evaluation_cri_13', 'clz_evaluation_cri_14', 'clz_evaluation_cri_15', 'clz_evaluation_cri_16', 'clz_evaluation_cri_17', 'clz_evaluation_cri_18', 'clz_evaluation_cri_19', 'clz_evaluation_cri_20', 'clz_evaluation_cri_21', 'clz_evaluation_cri_22', 'clz_evaluation_cri_23', 'clz_evaluation_cri_24', 'clz_evaluation_cri_25', 'clz_evaluation_cri_26', 'clz_evaluation_cri_27', 'clz_evaluation_cri_28', 'clz_evaluation_cri_29', 'clz_evaluation_cri_30', 'clz_evaluation_cri_31', 'clz_evaluation_cri_32', 'clz_evaluation_cri_33', 'clz_evaluation_cri_34', 'clz_evaluation_cri_35', 'clz_evaluation_cri_36', 'clz_evaluation_cri_37', 'clz_evaluation_cri_38', 'clz_evaluation_cri_39', 'clz_evaluation_cri_40', 'clz_evaluation_cri_41', 'clz_evaluation_cri_42', 'clz_evaluation_cri_43', 'clz_evaluation_cri_44', 'clz_evaluation_cri_45', 'clz_evaluation_cri_46', 'clz_evaluation_cri_47', 'clz_evaluation_cri_48', 'clz_evaluation_cri_49', 'clz_evaluation_cri_50', 'clz_evaluation_cri_51', 'clz_evaluation_cri_52', 'clz_evaluation_cri_53', 'clz_evaluation_cri_54', 'clz_evaluation_cri_55', 'clz_evaluation_cri_56', 'clz_evaluation_cri_57', 'clz_evaluation_cri_58', 'clz_evaluation_cri_59', 'clz_evaluation_cri_60', 'clz_evaluation_cri_61', 'clz_evaluation_cri_62', 'clz_evaluation_cri_63', 'clz_evaluation_cri_64', 'clz_evaluation_cri_65', 'clz_evaluation_cri_66', 'clz_evaluation_cri_67', 'clz_evaluation_cri_68', 'clz_evaluation_cri_69', 'clz_evaluation_cri_70', 'clz_evaluation_cri_71', 'clz_evaluation_cri_72', 'clz_evaluation_cri_73', 'clz_evaluation_cri_74', 'clz_evaluation_cri_75', 'clz_evaluation_cri_76', 'clz_evaluation_cri_77', 'clz_evaluation_cri_78', 'clz_evaluation_cri_79', 'clz_evaluation_cri_80'));
			
			global $currunt_user_id;

            $response = array();

            // reading put params
			$clz_evaluation_cri_1 = $app->request->put('clz_evaluation_cri_1');
			$clz_evaluation_cri_2 = $app->request->put('clz_evaluation_cri_2');
			$clz_evaluation_cri_3 = $app->request->put('clz_evaluation_cri_3');
			$clz_evaluation_cri_4 = $app->request->put('clz_evaluation_cri_4');
			$clz_evaluation_cri_5 = $app->request->put('clz_evaluation_cri_5');
			$clz_evaluation_cri_6 = $app->request->put('clz_evaluation_cri_6');
			$clz_evaluation_cri_7 = $app->request->put('clz_evaluation_cri_7');
			$clz_evaluation_cri_8 = $app->request->put('clz_evaluation_cri_8');
			$clz_evaluation_cri_9 = $app->request->put('clz_evaluation_cri_9');
			$clz_evaluation_cri_10 = $app->request->put('clz_evaluation_cri_10');
			$clz_evaluation_cri_11 = $app->request->put('clz_evaluation_cri_11');
			$clz_evaluation_cri_12 = $app->request->put('clz_evaluation_cri_12');
			$clz_evaluation_cri_13 = $app->request->put('clz_evaluation_cri_13');
			$clz_evaluation_cri_14 = $app->request->put('clz_evaluation_cri_14');
			$clz_evaluation_cri_15 = $app->request->put('clz_evaluation_cri_15');
			$clz_evaluation_cri_16 = $app->request->put('clz_evaluation_cri_16');
			$clz_evaluation_cri_17 = $app->request->put('clz_evaluation_cri_17');
			$clz_evaluation_cri_18 = $app->request->put('clz_evaluation_cri_18');
			$clz_evaluation_cri_19 = $app->request->put('clz_evaluation_cri_19');
			$clz_evaluation_cri_20 = $app->request->put('clz_evaluation_cri_20');
			$clz_evaluation_cri_21 = $app->request->put('clz_evaluation_cri_21');
			$clz_evaluation_cri_22 = $app->request->put('clz_evaluation_cri_22');
			$clz_evaluation_cri_23 = $app->request->put('clz_evaluation_cri_23');
			$clz_evaluation_cri_24 = $app->request->put('clz_evaluation_cri_24');
			$clz_evaluation_cri_25 = $app->request->put('clz_evaluation_cri_25');
			$clz_evaluation_cri_26 = $app->request->put('clz_evaluation_cri_26');
			$clz_evaluation_cri_27 = $app->request->put('clz_evaluation_cri_27');
			$clz_evaluation_cri_28 = $app->request->put('clz_evaluation_cri_28');
			$clz_evaluation_cri_29 = $app->request->put('clz_evaluation_cri_29');
			$clz_evaluation_cri_30 = $app->request->put('clz_evaluation_cri_30');
			$clz_evaluation_cri_31 = $app->request->put('clz_evaluation_cri_31');
			$clz_evaluation_cri_32 = $app->request->put('clz_evaluation_cri_32');
			$clz_evaluation_cri_33 = $app->request->put('clz_evaluation_cri_33');
			$clz_evaluation_cri_34 = $app->request->put('clz_evaluation_cri_34');
			$clz_evaluation_cri_35 = $app->request->put('clz_evaluation_cri_35');
			$clz_evaluation_cri_36 = $app->request->put('clz_evaluation_cri_36');
			$clz_evaluation_cri_37 = $app->request->put('clz_evaluation_cri_37');
			$clz_evaluation_cri_38 = $app->request->put('clz_evaluation_cri_38');
			$clz_evaluation_cri_39 = $app->request->put('clz_evaluation_cri_39');
			$clz_evaluation_cri_40 = $app->request->put('clz_evaluation_cri_40');
			$clz_evaluation_cri_41 = $app->request->put('clz_evaluation_cri_41');
			$clz_evaluation_cri_42 = $app->request->put('clz_evaluation_cri_42');
			$clz_evaluation_cri_43 = $app->request->put('clz_evaluation_cri_43');
			$clz_evaluation_cri_44 = $app->request->put('clz_evaluation_cri_44');
			$clz_evaluation_cri_45 = $app->request->put('clz_evaluation_cri_45');
			$clz_evaluation_cri_46 = $app->request->put('clz_evaluation_cri_46');
			$clz_evaluation_cri_47 = $app->request->put('clz_evaluation_cri_47');
			$clz_evaluation_cri_48 = $app->request->put('clz_evaluation_cri_48');
			$clz_evaluation_cri_49 = $app->request->put('clz_evaluation_cri_49');
			$clz_evaluation_cri_50 = $app->request->put('clz_evaluation_cri_50');
			$clz_evaluation_cri_51 = $app->request->put('clz_evaluation_cri_51');
			$clz_evaluation_cri_52 = $app->request->put('clz_evaluation_cri_52');
			$clz_evaluation_cri_53 = $app->request->put('clz_evaluation_cri_53');
			$clz_evaluation_cri_54 = $app->request->put('clz_evaluation_cri_54');
			$clz_evaluation_cri_55 = $app->request->put('clz_evaluation_cri_55');
			$clz_evaluation_cri_56 = $app->request->put('clz_evaluation_cri_56');
			$clz_evaluation_cri_57 = $app->request->put('clz_evaluation_cri_57');
			$clz_evaluation_cri_58 = $app->request->put('clz_evaluation_cri_58');
			$clz_evaluation_cri_59 = $app->request->put('clz_evaluation_cri_59');
			$clz_evaluation_cri_60 = $app->request->put('clz_evaluation_cri_60');
			$clz_evaluation_cri_61 = $app->request->put('clz_evaluation_cri_61');
			$clz_evaluation_cri_62 = $app->request->put('clz_evaluation_cri_62');
			$clz_evaluation_cri_63 = $app->request->put('clz_evaluation_cri_63');
			$clz_evaluation_cri_64 = $app->request->put('clz_evaluation_cri_64');
			$clz_evaluation_cri_65 = $app->request->put('clz_evaluation_cri_65');
			$clz_evaluation_cri_66 = $app->request->put('clz_evaluation_cri_66');
			$clz_evaluation_cri_67 = $app->request->put('clz_evaluation_cri_67');
			$clz_evaluation_cri_68 = $app->request->put('clz_evaluation_cri_68');
			$clz_evaluation_cri_69 = $app->request->put('clz_evaluation_cri_69');
			$clz_evaluation_cri_70 = $app->request->put('clz_evaluation_cri_70');
			$clz_evaluation_cri_71 = $app->request->put('clz_evaluation_cri_71');
			$clz_evaluation_cri_72 = $app->request->put('clz_evaluation_cri_72');
			$clz_evaluation_cri_73 = $app->request->put('clz_evaluation_cri_73');
			$clz_evaluation_cri_74 = $app->request->put('clz_evaluation_cri_74');
			$clz_evaluation_cri_75 = $app->request->put('clz_evaluation_cri_75');
			$clz_evaluation_cri_76 = $app->request->put('clz_evaluation_cri_76');
			$clz_evaluation_cri_77 = $app->request->put('clz_evaluation_cri_77');
			$clz_evaluation_cri_78 = $app->request->put('clz_evaluation_cri_78');
			$clz_evaluation_cri_79 = $app->request->put('clz_evaluation_cri_79');
			$clz_evaluation_cri_80 = $app->request->put('clz_evaluation_cri_80');
			
            $classReportRManagement = new ClassReportRManagement();
			$res = $classReportRManagement->updateClassReport($clz_evaluation_cri_1, $clz_evaluation_cri_2, $clz_evaluation_cri_3, $clz_evaluation_cri_4, $clz_evaluation_cri_5, $clz_evaluation_cri_6, $clz_evaluation_cri_7, $clz_evaluation_cri_8, $clz_evaluation_cri_9, $clz_evaluation_cri_10, $clz_evaluation_cri_11, $clz_evaluation_cri_12, $clz_evaluation_cri_13, $clz_evaluation_cri_14, $clz_evaluation_cri_15, $clz_evaluation_cri_16, $clz_evaluation_cri_17, $clz_evaluation_cri_18, $clz_evaluation_cri_19, $clz_evaluation_cri_20, $clz_evaluation_cri_21, $clz_evaluation_cri_22, $clz_evaluation_cri_23, $clz_evaluation_cri_24, $clz_evaluation_cri_25, $clz_evaluation_cri_26, $clz_evaluation_cri_27, $clz_evaluation_cri_28, $clz_evaluation_cri_29, $clz_evaluation_cri_30, $clz_evaluation_cri_31, $clz_evaluation_cri_32, $clz_evaluation_cri_33, $clz_evaluation_cri_34, $clz_evaluation_cri_35, $clz_evaluation_cri_36, $clz_evaluation_cri_37, $clz_evaluation_cri_38, $clz_evaluation_cri_39, $clz_evaluation_cri_40, $clz_evaluation_cri_41, $clz_evaluation_cri_42, $clz_evaluation_cri_43, $clz_evaluation_cri_44, $clz_evaluation_cri_45, $clz_evaluation_cri_46, $clz_evaluation_cri_47, $clz_evaluation_cri_48, $clz_evaluation_cri_49, $clz_evaluation_cri_50, $clz_evaluation_cri_51, $clz_evaluation_cri_52, $clz_evaluation_cri_53, $clz_evaluation_cri_54, $clz_evaluation_cri_55, $clz_evaluation_cri_56, $clz_evaluation_cri_57, $clz_evaluation_cri_58, $clz_evaluation_cri_59, $clz_evaluation_cri_60, $clz_evaluation_cri_61, $clz_evaluation_cri_62, $clz_evaluation_cri_63, $clz_evaluation_cri_64, $clz_evaluation_cri_65, $clz_evaluation_cri_66, $clz_evaluation_cri_67, $clz_evaluation_cri_68, $clz_evaluation_cri_69, $clz_evaluation_cri_70, $clz_evaluation_cri_71, $clz_evaluation_cri_72, $clz_evaluation_cri_73, $clz_evaluation_cri_74, $clz_evaluation_cri_75, $clz_evaluation_cri_76, $clz_evaluation_cri_77, $clz_evaluation_cri_78, $clz_evaluation_cri_79, $clz_evaluation_cri_80, $currunt_user_id);
			
            if ($res == UPDATE_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "You are successfully updated class_report";
            } else if ($res == UPDATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while updating class_report";
            } else if ($res == NOT_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this class_report is not exist";
            }
            // echo json response
            echoRespnse(201, $response);
        });

/**
 * class_report Delete
 * url - /class_report_delete
 * method - DELETE
 * params - clz_repo_id
 */
$app->delete('/class_report_delete', 'authenticate', function() use ($app) {
			// check for required params
            verifyRequiredParams(array('clz_repo_id'));
            
			global $currunt_user_id;

            $response = array();
			$clz_repo_id = $app->request->delete('clz_repo_id');
			
            $classReportManagement = new ClassReportManagement();
			$res = $classReportManagement->deleteClassReport($clz_repo_id, $currunt_user_id);
			
            if ($res == DELETE_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "ClassReport is successfully deleted";
            } else if ($res == DELETE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while deleting ClassReport";
            } else if ($res == NOT_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this ClassReport is not exist"; 
            }
            // echo json response
            echoRespnse(201, $response);
        });
		
/**
 * Listing all reports by clz_repo_id
 * method GET
 * url //:report        
 */
 
$app->get('/classReport/:report', 'authenticate', function($clz_repo_id) {
            global $user_id;
			
            $response = array();
			
			$classReportManagement = new ClassReportManagement();
			$res = $classReportManagement->getReportByClassReportId($clz_repo_id);

            $response["error"] = false;
            $response["class_report"] = array();

            // looping through result and preparing class_report array
            while ($class_report = $res->fetch_assoc()) {
                $tmp = array();
				
				$tmp["clz_evaluation_cri_1"] = $class_report["clz_evaluation_cri_1"];
				$tmp["clz_evaluation_cri_2"] = $class_report["clz_evaluation_cri_2"];
                $tmp["clz_evaluation_cri_3"] = $class_report["clz_evaluation_cri_3"];
				$tmp["clz_evaluation_cri_4"] = $class_report["clz_evaluation_cri_4"];
				$tmp["clz_evaluation_cri_5"] = $class_report["clz_evaluation_cri_5"];
				$tmp["clz_evaluation_cri_6"] = $class_report["clz_evaluation_cri_6"];
				$tmp["clz_evaluation_cri_7"] = $class_report["clz_evaluation_cri_7"];
				$tmp["clz_evaluation_cri_8"] = $class_report["clz_evaluation_cri_8"];
				$tmp["clz_evaluation_cri_9"] = $class_report["clz_evaluation_cri_9"];
				$tmp["clz_evaluation_cri_10"] = $class_report["clz_evaluation_cri_10"];
				$tmp["clz_evaluation_cri_11"] = $class_report["clz_evaluation_cri_11"];
				$tmp["clz_evaluation_cri_12"] = $class_report["clz_evaluation_cri_12"];
                $tmp["clz_evaluation_cri_13"] = $class_report["clz_evaluation_cri_13"];
				$tmp["clz_evaluation_cri_14"] = $class_report["clz_evaluation_cri_14"];
				$tmp["clz_evaluation_cri_15"] = $class_report["clz_evaluation_cri_15"];
				$tmp["clz_evaluation_cri_16"] = $class_report["clz_evaluation_cri_16"];
				$tmp["clz_evaluation_cri_17"] = $class_report["clz_evaluation_cri_17"];
				$tmp["clz_evaluation_cri_18"] = $class_report["clz_evaluation_cri_18"];
				$tmp["clz_evaluation_cri_19"] = $class_report["clz_evaluation_cri_19"];
				$tmp["clz_evaluation_cri_20"] = $class_report["clz_evaluation_cri_20"];
				$tmp["clz_evaluation_cri_21"] = $class_report["clz_evaluation_cri_21"];
				$tmp["clz_evaluation_cri_22"] = $class_report["clz_evaluation_cri_22"];
                $tmp["clz_evaluation_cri_23"] = $class_report["clz_evaluation_cri_23"];
				$tmp["clz_evaluation_cri_24"] = $class_report["clz_evaluation_cri_24"];
				$tmp["clz_evaluation_cri_25"] = $class_report["clz_evaluation_cri_25"];
				$tmp["clz_evaluation_cri_26"] = $class_report["clz_evaluation_cri_26"];
				$tmp["clz_evaluation_cri_27"] = $class_report["clz_evaluation_cri_27"];
				$tmp["clz_evaluation_cri_28"] = $class_report["clz_evaluation_cri_28"];
				$tmp["clz_evaluation_cri_29"] = $class_report["clz_evaluation_cri_29"];
				$tmp["clz_evaluation_cri_30"] = $class_report["clz_evaluation_cri_30"];
				$tmp["clz_evaluation_cri_31"] = $class_report["clz_evaluation_cri_31"];
				$tmp["clz_evaluation_cri_32"] = $class_report["clz_evaluation_cri_32"];
                $tmp["clz_evaluation_cri_33"] = $class_report["clz_evaluation_cri_33"];
				$tmp["clz_evaluation_cri_34"] = $class_report["clz_evaluation_cri_34"];
				$tmp["clz_evaluation_cri_35"] = $class_report["clz_evaluation_cri_35"];
				$tmp["clz_evaluation_cri_36"] = $class_report["clz_evaluation_cri_36"];
				$tmp["clz_evaluation_cri_37"] = $class_report["clz_evaluation_cri_37"];
				$tmp["clz_evaluation_cri_38"] = $class_report["clz_evaluation_cri_38"];
				$tmp["clz_evaluation_cri_39"] = $class_report["clz_evaluation_cri_39"];
				$tmp["clz_evaluation_cri_40"] = $class_report["clz_evaluation_cri_40"];
				$tmp["clz_evaluation_cri_41"] = $class_report["clz_evaluation_cri_41"];
				$tmp["clz_evaluation_cri_42"] = $class_report["clz_evaluation_cri_42"];
                $tmp["clz_evaluation_cri_43"] = $class_report["clz_evaluation_cri_43"];
				$tmp["clz_evaluation_cri_44"] = $class_report["clz_evaluation_cri_44"];
				$tmp["clz_evaluation_cri_45"] = $class_report["clz_evaluation_cri_45"];
				$tmp["clz_evaluation_cri_46"] = $class_report["clz_evaluation_cri_46"];
				$tmp["clz_evaluation_cri_47"] = $class_report["clz_evaluation_cri_47"];
				$tmp["clz_evaluation_cri_48"] = $class_report["clz_evaluation_cri_48"];
				$tmp["clz_evaluation_cri_49"] = $class_report["clz_evaluation_cri_49"];
				$tmp["clz_evaluation_cri_50"] = $class_report["clz_evaluation_cri_50"];
				$tmp["clz_evaluation_cri_51"] = $class_report["clz_evaluation_cri_51"];
				$tmp["clz_evaluation_cri_52"] = $class_report["clz_evaluation_cri_52"];
                $tmp["clz_evaluation_cri_53"] = $class_report["clz_evaluation_cri_53"];
				$tmp["clz_evaluation_cri_54"] = $class_report["clz_evaluation_cri_54"];
				$tmp["clz_evaluation_cri_55"] = $class_report["clz_evaluation_cri_55"];
				$tmp["clz_evaluation_cri_56"] = $class_report["clz_evaluation_cri_56"];
				$tmp["clz_evaluation_cri_57"] = $class_report["clz_evaluation_cri_57"];
				$tmp["clz_evaluation_cri_58"] = $class_report["clz_evaluation_cri_58"];
				$tmp["clz_evaluation_cri_59"] = $class_report["clz_evaluation_cri_59"];
				$tmp["clz_evaluation_cri_60"] = $class_report["clz_evaluation_cri_60"];
				$tmp["clz_evaluation_cri_61"] = $class_report["clz_evaluation_cri_61"];
				$tmp["clz_evaluation_cri_62"] = $class_report["clz_evaluation_cri_62"];
                $tmp["clz_evaluation_cri_63"] = $class_report["clz_evaluation_cri_63"];
				$tmp["clz_evaluation_cri_64"] = $class_report["clz_evaluation_cri_64"];
				$tmp["clz_evaluation_cri_65"] = $class_report["clz_evaluation_cri_65"];
				$tmp["clz_evaluation_cri_66"] = $class_report["clz_evaluation_cri_66"];
				$tmp["clz_evaluation_cri_67"] = $class_report["clz_evaluation_cri_67"];
				$tmp["clz_evaluation_cri_68"] = $class_report["clz_evaluation_cri_68"];
				$tmp["clz_evaluation_cri_69"] = $class_report["clz_evaluation_cri_69"];
				$tmp["clz_evaluation_cri_70"] = $class_report["clz_evaluation_cri_70"];
				$tmp["clz_evaluation_cri_71"] = $class_report["clz_evaluation_cri_71"];
				$tmp["clz_evaluation_cri_72"] = $class_report["clz_evaluation_cri_72"];
                $tmp["clz_evaluation_cri_73"] = $class_report["clz_evaluation_cri_73"];
				$tmp["clz_evaluation_cri_74"] = $class_report["clz_evaluation_cri_74"];
				$tmp["clz_evaluation_cri_75"] = $class_report["clz_evaluation_cri_75"];
				$tmp["clz_evaluation_cri_76"] = $class_report["clz_evaluation_cri_76"];
				$tmp["clz_evaluation_cri_77"] = $class_report["clz_evaluation_cri_77"];
				$tmp["clz_evaluation_cri_78"] = $class_report["clz_evaluation_cri_78"];
				$tmp["clz_evaluation_cri_79"] = $class_report["clz_evaluation_cri_79"];
				$tmp["clz_evaluation_cri_80"] = $class_report["clz_evaluation_cri_80"];
                $tmp["status"] = $class_report["status"];
                $tmp["recode_added_at"] = $class_report["recode_added_at"];
				$tmp["recode_added_by"] = $class_report["recode_added_by"];
				
                array_push($response["class_report"], $tmp);
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