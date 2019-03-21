<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<?php

class User {
  var $firstname = "";
  var $surname = "";
  var $deptno = "";

  function __construct($fname, $sname, $dno) {
    $this->firstname = $fname;
    $this->surname = $sname;
    $this->deptno = $dno;
  }

  function store() {
    require('cvar.php');
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "insert into nametable(firstname, surname, dnumber) values(\"".$this->firstname."\",\"".$this->surname."\",".$this->deptno.")";
    //print($sql);
    if  (!$conn->query($sql)) { return $conn->error; }
    $conn->close();
    return "ok";
  }
};

function display_user_dept_form() {
  //get stuff from database
  require('cvar.php');
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
  $sql = "SELECT * from department";
  $result = $conn->query($sql);
  $opts = "<select class=\"form-control mb-4\" name=dept>";
  while($row = $result->fetch_assoc()) {
      //print($row["dnumber"]." ".$row["dname"]);
      $opts = $opts."<option value=\"".$row["dnumber"]."\">".$row["dname"]."</option>";
  }
  $opts = $opts."</select>";
  $conn->close();

  print("<form class=\"text-center border border-light p-5\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("First name: <input class=\"form-control mb-4\" required=\"true\" type=\"text\" name=\"user_name\">");
  print("<br/>");
  print("Last name: <input class=\"form-control mb-4\" required=\"true\" type=\"text\" name=\"last_name\">");
  print("<br/>");
  print("Department<br/>");
  print($opts);
  print("<br/>");
  print("<input type=\"submit\" value=\"Submit\">");
  print("</form>");
}

function store_name_data() {
  //get stuff from variables
  $u = $_POST['user_name'];
  $l = $_POST['last_name'];
  $d = $_POST['dept'];
  $u1 = filter_var($u);
  $l1 = filter_var($l);
  $d1 = filter_var($d);

  $person = new User($u1,$l1,$d1);
  $res = $person->store();
  print($res);
}


function digest_login() {
   $realm = 'Restricted area';
   //user => password
   $users = array('admin' => 'mypass', 'guest' => 'guest');

   if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
        die('Text to send if user hits Cancel button');
    }
    // analyze the PHP_AUTH_DIGEST variable
    if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
        !isset($users[$data['username']])) {
        echo('Wrong Credentials!');
        unset($_SERVER['PHP_AUTH_DIGEST']);
        digest_login();
    }
    // generate the valid response
    $A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
    $A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
    $valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);
 if ($data['response'] != $valid_response) {
        echo('Wrong Credentials!');
        unset($_SERVER['PHP_AUTH_DIGEST']);
        digest_login();
    }
    else {
       // ok, valid username & password
       echo 'You are logged in as: ' . $data['username'];
       return $data['username']; 
    }
}
// function to parse the http auth header
function http_digest_parse($txt) {
    // protect against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));
    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }
    return $needed_parts ? false : $data;
}
$name = digest_login();
session_start();
if (isset($_POST['user_name'])) {
  store_name_data();
} else {
  display_user_dept_form();
}
$_SESSION['username'] = $name;
?>
</html>
