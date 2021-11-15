<?php

date_default_timezone_set('America/Sao_Paulo');

include 'config.php';

$conn = new mysqli($host, $username, $password, $database);

$sql  ="update tbl_harvester                                          " ;
$sql .="   set timestamp  = now()                                     " ;
$sql .="      ,harvester  = @harvester := harvester                   " ;
$sql .=" where id = (select tab.id                                    " ;
$sql .="               from (select @rownum := @rownum + 1 as rownum  " ;
$sql .="                          , tbl_harvester.id                  " ;
$sql .="                       from (select @rownum := 0) r           " ;
$sql .="                          , tbl_harvester                     " ;
$sql .="                      where 1=1                               " ;
$sql .="              order by timestamp , id ) as tab                " ;
$sql .="              where tab.rownum =1 ) ;                         " ;

//echo $sql;
//echo "<BR><BR>" ;

$result = $conn->query($sql);

$sql="select @harvester harvester ;" ;

$result = $conn->query($sql);

$row = $result->fetch_assoc();

$harvester=$row["harvester"] ;

$myObj = new stdClass();
$myObj->harvester = $harvester;

$myJSON = json_encode($myObj);

echo $myJSON;

$conn->close();
?>
