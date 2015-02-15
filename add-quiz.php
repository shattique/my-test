<?php
set_time_limit(0);
ini_set("memory_limit","-1");
ini_set("max_execution_time","86400");

    /*if(!isset($_POST['api_key']) || $_POST['api_key'] != 'imran1234'){
        die ('Restricted Access!');
    }*/
    
    /*$data['varname']=$_POST['var'];
    $content = json_encode($data);
    header('Content-Type: application/json');
	echo $content;
    
    die;*/
    //$_POST=$_GET;

    include_once 'config.php';

    $data=array();
    $success=0;
    $msg='';

    if(!empty($_POST['quiz_name']) && !empty($_POST['active'])){
        $exists_res=mysql_query("SELECT COUNT(*) as cnt FROM quiz WHERE quiz_name='".$_POST['quiz_name']."'");
        $exists_row=mysql_fetch_array($exists_res);

        if($exists_row['cnt'] > 0){
            $msg='Quiz already exists.';
        }
        else{
            $sql="INSERT INTO quiz VALUES(NULL,'".$_POST['quiz_name']."',".$_POST['active'].")";
            if(mysql_query($sql)){
                $user_result=mysql_query("SELECT * FROM quiz ORDER BY quiz_name ASC");

                while($row=mysql_fetch_array($user_result)){
                    $data[]=array("quiz_id" => $row['quiz_id'], "quiz_name" => $row['quiz_name'], "active" => $row['active']);
                }
                $success=1;
            }
            else{
                $msg='Error while saving data.';
            }
        }

    }
    else{
        $msg='Please complete all fields.';
    }

$results=array();
$results['data']=$data;
$results['success']=$success;
$results['msg']=$msg;

//$content = $_GET['callback']. '(' . json_encode($results). ')';
$content = json_encode($results);

header('Content-Type: application/json');
echo $content;


?>