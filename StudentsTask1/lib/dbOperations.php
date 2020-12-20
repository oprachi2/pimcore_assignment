<?php
    require_once('./config/db1.php');

    function fetchRecordAll($entity,$start=0,$end=10)
    {
        // fetch records for entity(category, article, comment) where status is true
        // start and end will control the behaviour for pagination  
        $sql = "select * from $entity where status = 'A' limit $start, $end";
        global $con;
        $res = mysqli_query($con,$sql);
        $data=array();
        if(mysqli_num_rows($res)>0)
        {
            while($record = mysqli_fetch_assoc($res))
            {
                $data[]=$record;
            }
            return $data;
        }
        else
        {
            return false;
        }
       
    }

    function fetchRecordSpecific($entity,$primary)
    {
        // fetch single record for entity(category, article, comment)
        $sql = "select * from $entity where id=$primary";
        global $con;
        $res = mysqli_query($con,$sql);
        $data=array();
        if(mysqli_num_rows($res)>0)
        {
            while($record = mysqli_fetch_assoc($res))
            {
                $data=$record;
            }
            return $data;    
        }
        else
        {
            return false;
        }
    
    }

    function insertRecord($entity,$data)
    {
        // insert single record for entity(category, article, comment) with data passed
        //echo 'Insert Called';
        $sql='';
        global $con;
        //using if else structure
        // all id's are primary keys
        if($entity =='user')
        {
        
//            $sql = "INSERT INTO `user`(`name`, `email`, `pwd`, `status`) VALUES ("; 
$sql="INSERT INTO `user` (`id`, `name`, `email`, `pwd`, `status`) VALUES (NULL,'$data[user]','$data[email]','$data[pwd]','A')";
		$res = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con)>0){
			echo 'Record Inserted';
		}else{
			echo 'Record Not Inserted';
		}
        }
        else if($entity =='category')
        {
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `category`(`id`,`name`, `desc`, `status`, `created`, `updated`) VALUES (NULL,'$data[addname]','$data[desc]','$data[status]','$date', '$date')";
        $res = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con)>0){
			echo 'Record Inserted';
		}else{
			echo 'Record Not Inserted';
		}
        }
        
        else if($entity =='article')
        {
            $sql = "INSERT INTO `article`(`author`, `category`, `title`, `content`, `created`, `updated`, `status`) VALUES ('$data[author]','$data[category]','$data[title]','$data[content]','$data[created]','$data[updated]','$data[status]'  WHERE id= $primary";
        }
        
        else
        {
            $sql = "INSERT INTO `comment`(`person`, `content`, `created`, `status`, `article`) VALUES ('$data[person]','$data[content]','$data[created]','$data[status]','$data[article]' WHERE id= $primary";
        }
       
    }

    function updateRecord($entity,$primary,$data)
    {
        // update single record for entity(category, article, comment) using its primary key with data passed
        $sql='';
        global $con;
        //using if else structure
        // all id's are primary keys
        if($entity =='user')
        {
            $sql = "UPDATE user SET `name`= '$data[user]', `email` = '$data[email]', `pwd` = '$data[pwd]' `status` = '$data[status]' WHERE id = $primary";
        }
        
        else if($entity =='category')
        {
            $sql = "UPDATE category SET `name`= '$data[name]', `desc` = '$data[desc]', `status` = '$data[status]' ,`created` = NOW(),`updated` = NOW() WHERE id = $primary";
            if(mysqli_query($con, $sql) )
            {
                echo("Record Updated");
            } else{echo("Record Not Updated");}
            
        }
        
        else if($entity =='article')
        {
            $sql = "UPDATE article SET `author`= '$data[author]', `category` = '$data[category]', `title` = '$data[title]', `content` = '$data[content]', `created` = NOW(),`updated` = NOW(), `status` = '$data[status]' WHERE id = $primary";
        }
        
        else
        {
            $sql = "UPDATE comment SET `person`= '$data[person]',`content` = '$data[content]', `created` = NOW(),`article` = $data[article], `status` = '$data[status]' WHERE id = $primary";
        }
       
    }

    function deleteRecord($entity,$primary)
    {
        // delete single record for entity(category, article, comment) using its primary key
        global $con;
        $sql="DELETE FROM `$entity` WHERE `id`= '$primary'";
        echo "tested";
        $res=mysqli_query($con,$sql);
        if(mysqli_affected_rows($GLOBALS['con'])>0)
        {
            return ture;
        }
        else
        {
            return false;
        }
    }

    function authenticate($username, $pwd)
    {
        // if successful, redirect to dashboard
        // else stay on logi
$msg= '';        
$sql="select * from user where name='$username'";
        global $con;
        $res = mysqli_query($con,$sql);
        if(mysqli_num_rows($res)>0)
{

            while($record=mysqli_fetch_assoc($res))
            {

              if($record['pwd']==$pwd)
							{
							return $record;
							}
            else
            {
$a="";
return $a;             
          }
}
    }
}
?>