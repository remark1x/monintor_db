<?php
class mon_sql extends mysqli{
	private $db;
	private $cuser;
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
		return true;
		$this->cuser=$user_name;
		}
		else{
		echo "Error".mysqli_error();
		return false;
		}
	}	

	private function change_base($table,$name,$value,$user=NULL){
		if(!$user) $user=$this->cuser;
		$sql="update".$type."set".$name."=? where user_name =?";
		$db=$this->db;
		$short = $db->prepare($sql);
		$short->bind_param("ss",$value,$user);
		if($short->execute())
		return true;
		else
		return false;
	}	
	private function hello(){echo "hello\n";}
	public function change($change_name,$change_val){
		$this->hello();
		switch ($change_name){
		case "user_code":
			if ($this->change_base("user","user_code",$change_val)) echo "changed! new val:".$change_val."\n";
			break;
		}
	
	}	

}
echo "php inited\n";
$mon_db = new mon_sql();
$mon_db->insert_user("test6","test_code","test_email");
$mon_db->change("user_code","change_value2018...");

?>

