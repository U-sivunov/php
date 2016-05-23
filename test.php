<?
require_once "log_class.php";

LogToFile::setDir("test_logs/"); 
$log1= new LogToFile("log1.txt");
$log2= new LogToFile();

LogToSQL::setBaseName("Test base");
$log3= new LogToSQL("log3");
$log4= new LogToSQL();

$log5= new LogToStdout;

for ($i=0;$i<5;$i++){
	$arr[]=$i*10;
	$log1->write("число ".$i);
	$log2->write("число ".$i);
	$log3->write("число ".$i);
	$log4->write("число ".$i);
	$log5->write("число ".$i);
	sleep(2);
}
    $log1->write($arr);
	$log2->write($arr);
	$log3->write($arr);
	$log4->write($arr);
	$log5->write($arr);
	
	sleep(2);
	
	$log1->write($log3,"сообщение",$arr,$i);
	$log2->write($log3,"сообщение",$arr,$i);
	$log3->write($log3,"сообщение",$arr,$i);
	$log4->write($log3,"сообщение",$arr,$i);
	$log5->write($log3,"сообщение",$arr,$i);
?>