<?php

require('RntAuth.php');

$auth = new RntAuth();

if(!$auth->init('baza.db', 'users', 'admin', 'admin')) echo $auth->getError();


$id = $auth->getUserId('admin', 'admin');

if($id) echo $auth->getUserName($id);
else echo $auth->getError();

?>
