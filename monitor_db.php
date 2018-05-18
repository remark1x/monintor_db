<?php
class mon_sql extends mysqli{
	private $db;
	//private $cuser;
	//for test
	private $cuser="test6";

	function __construct(){
		//$db_json=file_get_contents("mon.json") or die("Fail to get json");
		$db_json=file_get_contents("/home/wwwfile/mon.json") or die("Fail to get json");
		$obj=json_decode($db_json,true);
		// var_dump(json_decode($db_json, true));
		$user= $obj['mondb']['user'];
		$password= $obj['mondb']['password'];
		$dbname=$obj['mondb']['dbname'];
		echo $user;echo $password;echo $dbname;echo '<br \>';
		if(!$con)echo mysqli_error();else echo "Inited!<br \>";
		$db = mysqli_connect("localhost",$user,$password,$dbname);  
      		 if(!$db){  
          	 echo  mysqli_connect_error();  
   		 }  
		else echo("Connect to ".$dbname);
		$this->db = $db;
	}

	public function insert_user($user_name,$user_code,$user_email=NULL){
		$sql="INSERT INTO user VALUES(?,?,?)";
		$db=$this->db;
		$short = $db->prepare($sql);
		$short->bind_param("sss",$user_name,$user_code,$user_email);
		if($short->execute()){
		echo "Inserted<br \>";
		$this->cuser=$user_name;
		return true;
		}
		else{
		echo "Error".mysqli_error();
		return false;
		}
	}	

	private function change_base($table,$name,$value,$primary_key,$user=NULL){
		if(!$user) $user=$this->cuser;
		$sql='update '.$table.
					 ' set '.$name.' =? where '.$primary_key.' =?';
		$db=$this->db;
		$short = $db->prepare($sql);
		$short->bind_param("ss",$value,$user);
		
		if($short->execute())
		return true;
		else
		return false;
	}	

	public function change($change_name,$change_val){
		switch ($change_name){
		case "user_code":
			echo "user_code:\n";
			if ($this->change_base("user","user_code",$change_val,"user_name")) echo "changed! new val:".$change_val."\n";
			break;
		}
	
	}
	
	

}
//echo phpinfo();
echo "php inited\n";
$mon_db = new mon_sql();
//$mon_db->insert_user("test12","test_code","test_email");
$mon_db->change("user_code","Mypasswprd$#@%");

?>

