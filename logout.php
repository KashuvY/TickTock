<?php 
  // On logout, send user back to home page before login
  // and clear all of the session data
  session_start(); 
  session_unset(); 
  session_destroy(); 
  header("Location: index.html"); 
  exit; 
?> 