<?php
switch ($_GET['module']) {
     case "controller_auth":
          include 'views/html/top-page_auth.html';
          break;
     case "controller_home":
         include 'views/html/top-page_home.html';
         break;
     case "controller_shop":
         include 'views/html/top-page_shop.html';
         break;
     default:
         break;
 }




