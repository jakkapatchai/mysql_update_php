<?php 
session_start();
# เผยแพร่ใน http://www.thaiall.com/perlphpasp/source.pl?9137
# ===
# ส่วนกำหนดค่าเริ่มต้นของระบบ
$host     = "localhost";
$db       = "northwind";  
$tb       = "categories"; 
$user     = "root"; // รหัสผู้ใช้ ให้สอบถามจากผู้ดูแลระบบ
$password = "";    // รหัสผ่าน ให้สอบถามจากผู้ดูแลระบบ
$create_table_sql = "create table categories (CategoryID varchar(20),  CategoryName varchar(20), Description varchar(20))";
if (isset($_REQUEST{'action'})) $act = $_REQUEST{'action'}; else $act = "";
# ===
# ส่วนแสดงผลหลัก ทั้งปกติ และหลังกดปุ่ม del หรือ edit
if (strlen($act) == 0 || $act == "del" || $act == "edit") {
  $conn = mysql_connect("$host","$user","$password");
  $r = mysql_db_query($db,"select * from categories") or die ("phpmyadmin - " . $create_table_sql . "<br/>" . mysql_error());
  echo "<table>";
  while ($o = mysql_fetch_object($r)) {
    if (isset($_REQUEST{'CategoryID'}) && $_REQUEST{'CategoryID'}  == $o->CategoryID) $chg = " style='background-color:#f9f9f9"; else $chg = " readonly style='background-color:#ffffdd";
    echo "<tr><form action='' method=post>
      <td><input name=CategoryID size=5 value='". $o->CategoryID . "' style='background-color:#dddddd' readonly></td>
      <td><input name=CategoryName size=40 value='". $o->CategoryName . "' $chg'></td>
      <td><input name=Description size=20 value='". $o->Description . "' $chg;text-align:right'></td>
      <td>";
    if (isset($_REQUEST{'CategoryID'}) && $_REQUEST{'CategoryID'} == $o->CategoryID) {
      if ($act == "del") echo "<input type=submit name=action value='del : confirm' style='height:40;background-color:yellow'>";
      if ($act == "edit") echo "<input type=submit name=action value='edit : confirm' style='height:40;background-color:#aaffaa'>";
    } else {
      echo "<input type=submit name=action value='del' style='height:26'> <input type=submit name=action value='edit' style='height:26'>";
    }
    echo "</td></form></tr>";
  }	
  echo "<tr><form action='' method=post><td><input name=CategoryID size=5></td><td><input name=CategoryName size=40></td><td><input name=Description size=20></td><td><input type=submit name=action value='add' style='height:26'></td></tr>
  </form></table>";
  if (isset($_SESSION["msg"])) echo "<br>".$_SESSION["msg"];
  $_SESSION["msg"] = ""; 
  exit;
} 
# ===
# ส่วนเพิ่มข้อมูล
if ($act == "add") {
  $q  = "iCategoryNameert into categories values('". $_REQUEST{'CategoryID'} . "','". $_REQUEST{'CategoryName'} . "','". $_REQUEST{'Description'} . "')";
  $conn = mysql_connect("$host","$user","$password");
  $r = mysql_db_query($db,$q);   
  if ($r) $_SESSION["msg"] = "iCategoryNameert : completely";
  mysql_close($connect);  
  header("Location: ". $_SERVER["SCRIPT_NAME"]);
}
# ===
# ส่วนลบข้อมูล
if ($act == "del : confirm") {
  $q  = "delete from categories where CategoryID ='". $_REQUEST{'CategoryID'} . "'";
  $conn = mysql_connect("$host","$user","$password");
  $r = mysql_db_query($db,$q);   
  if ($r) $_SESSION["msg"] = "delete : completely";
  mysql_close($connect);  
  header("Location: ". $_SERVER["SCRIPT_NAME"]);
}
# ===
# ส่วนแก้ไขข้อมูล
if ($act == "edit : confirm") {
  $q  = "update $tb set CategoryName ='". $_REQUEST{'CategoryName'} . "', Description ='". $_REQUEST{'Description'} . "' where CategoryID =" . $_REQUEST{'CategoryID'};
  $conn = mysql_connect("$host","$user","$password");
  $r = mysql_db_query($db,$q);   
  if ($r) $_SESSION["msg"] = "edit : completely";
  mysql_close($connect);  
  header("Location: ". $_SERVER["SCRIPT_NAME"]);
}
?>