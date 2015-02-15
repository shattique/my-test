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
    $_POST=$_GET;

    include_once 'config.php';

    $data=array();
    $success=0;
    $msg='';

    if(!empty($_POST['question']) && !empty($_POST['option1']) && !empty($_POST['option2']) && !empty($_POST['option3']) && !empty($_POST['option4']) && !empty($_POST['quiz_id']) && !empty($_POST['answer_number']) && !empty($_POST['ques_order'])){

        $sql="INSERT INTO questions VALUES(NULL,'".$_POST['question']."',".$_POST['ques_order'].",".$_POST['quiz_id'].")";
        if(mysql_query($sql)){
            $ques_id=mysql_insert_id();

            //$sql="INSERT INTO answers VALUES(NULL,".$ques_id.",".$_POST['active'].")";

            $is_correct=($_POST['answer_number'] == 1)? 1 :0 ;
            mysql_query("INSERT INTO answers VALUES(NULL,".$ques_id.",".$_POST['option1'].",".$is_correct.")");

            $is_correct=($_POST['answer_number'] == 2)? 1 :0 ;
            mysql_query("INSERT INTO answers VALUES(NULL,".$ques_id.",".$_POST['option2'].",".$is_correct.")");

            $is_correct=($_POST['answer_number'] == 3)? 1 :0 ;
            mysql_query("INSERT INTO answers VALUES(NULL,".$ques_id.",".$_POST['option3'].",".$is_correct.")");

            $is_correct=($_POST['answer_number'] == 4)? 1 :0 ;
            mysql_query("INSERT INTO answers VALUES(NULL,".$ques_id.",".$_POST['option4'].",".$is_correct.")");

            $success=1;
        }
        else{
            $msg='Error while saving data.';
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