<?php

/**
 * @author Sazzad Hossain
 * @copyright 2015
 */

ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);  

$hostname = "localhost";
$database = "erp_ocms";
$username = "root";
$password = "";
$dbConnection = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database, $dbConnection);

include 'simplexlsx.class.php';

$local_file = 'line.xlsx';
$xlsx = new SimpleXLSX($local_file);
$all_employee = $xlsx->rows();


echo '<pre>';
print_r($all_employee);
exit;
/**/
    
    foreach($all_employee as $employee):
        $_sql_insert = 'INSERT INTO lib_line_info SET ';  
        $_sql_insert .= '`name` = "' . mysql_real_escape_string(trim($employee['0'])) . '", ';      
        $_sql_insert .= '`user_id` = "1", ';     
        $_sql_insert .= "`created_at`='".date("Y-m-d H:m:s")."', ";
        $_sql_insert .= "`updated_at`='".date("Y-m-d H:m:s")."'";
        //echo $_sql_insert; exit;
        mysql_query($_sql_insert);
    endforeach;
?>