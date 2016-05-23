<?
abstract class SupLog {
  
  protected function getTime(){
    return date("Y-m-d H:i:s");
  }
}




class LogToFile extends SupLog{
  private static $dir="";
  private $f;

  public static function setDir($dir){
    self::$dir=$dir;
  }

  public function __construct($fname=""){
    if (self::$dir!="")
		if (!is_dir(self::$dir)) 
			mkdir(self::$dir);
			
	if ($fname==""){
      $fname="log ".date("Y-m-d h-i-s").".txt";
    }
    $this->f=fopen(self::$dir.$fname,"a");
  }

  public function __destruct(){
    fclose($this->f);
  }
  
  public function write(){

	$note=$this->getTime()." ";
	$args=func_num_args();
	for ($i=0;$i<$args;$i++){
		$arg=func_get_arg($i);
		$note.=print_r($arg,true).PHP_EOL;
	}  
	$note.=PHP_EOL;
	fwrite($this->f,$note);
  }
}




class LogToSQL extends SupLog{
  private static $host='localhost';
  private static $charSet='cp1251';
  private static $baseName='newtes';
  private static $user='root';
  private static $pass='';

  public static function setHost($host){
    self::$host=$host;
  }

  public static function setCharSet($cha){
    self::$charSet=$cha;
  }

  public static function setBaseName($name){
    self::$baseName=$name;
  }

  public static function setUser($us){
    self::$User=$us;
  }

  public static function setPassword($pass){
    self::$pass=$pass;
  }

  private $connect;
  private $table;

  public function __construct($table_name=""){
    $this->connect= mysqli_connect(self::$host,self::$user,self::$pass,self::$baseName);
    
	if ($table_name=="") $table_name="Log ".$this->getTime();
	
    $this->table=$table_name;
    mysqli_query($this->connect,"SET NAMES '".self::$charSet."'");
    mysqli_query($this->connect,"CREATE TABLE IF NOT EXISTS `$this->table`
                ( `id` INT NOT NULL AUTO_INCREMENT , `time` VARCHAR(19) NOT NULL , `message` VARCHAR(1000) NOT NULL ,
                PRIMARY KEY (`id`)) ENGINE = MyISAM");

  }

  public function __destruct(){
    $this->connect->close();
  }
  

  public function write(){
	$note="";
	$args=func_num_args();
	for ($i=0;$i<$args;$i++){
		$arg=func_get_arg($i);
		$note.=print_r($arg,true).PHP_EOL;
	}  
	  
    mysqli_query($this->connect,"INSERT INTO `$this->table` (`time`,`message`)
      VALUES ('".$this->getTime()."', '".$note."')");

  }
}
 

 
 
class LogToStdout extends SupLog{

	public function write(){
	
	$note=$this->getTime()." ";
	$args=func_num_args();
	for ($i=0;$i<$args;$i++){
		$arg=func_get_arg($i);
		$note.=print_r($arg,true)."<br />";
	}  
	
	
		echo $note."<br /><br />";
	}	
}
?>
