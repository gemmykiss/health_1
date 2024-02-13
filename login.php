<?php
session_start();
if(!isset($_SESSION['itnustd'])){
    header('location:login.php');
}else{
    header('location:index.php');
}
require_once '../saml/lib/_autoload.php';
$as = new \SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attributes = $as->getAttributes();
$_SESSION['itnustd'] = $attributes;
$_SESSION['id'] = $attributes['SSO_USER_ID'][0];
$_SESSION['loginUsername'] = $attributes['username'][0];
$_SESSION['username'] = $attributes['SSO_USERNAME'][0];
$_SESSION['firstname'] = $attributes['SSO_FIRSTNAME'][0];
$_SESSION['lastname'] = $attributes['SSO_LASTNAME'][0];
$_SESSION['fullname'] = $attributes['SSO_FULLNAME'][0];
$_SESSION['facID'] = $attributes['SSO_FACULTY_ID'][0];
$_SESSION['facCODE'] = $attributes['SSO_FACULTY_CODE'][0];
$_SESSION['usrtype'] = $attributes['SSO_TYPE'][0];
$_SESSION['nameENG'] = $attributes['SSO_FIRSTNAME_ENG'][0];
$_SESSION['LastnameENG'] = $attributes['SSO_LASTNAME_ENG'][0];
?>