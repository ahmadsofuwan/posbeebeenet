<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-07-07 08:23:50 --> 404 Page Not Found: StockBBN/Auth
ERROR - 2022-07-07 08:23:56 --> 404 Page Not Found: StockBBN/Auth
ERROR - 2022-07-07 08:24:29 --> 404 Page Not Found: StockBBN/Auth
ERROR - 2022-07-07 09:03:59 --> 404 Page Not Found: Admin/worker
ERROR - 2022-07-07 14:17:52 --> Query error: Unknown column 'worker.teamkey' in 'on clause' - Invalid query: SELECT `worker`.*, `account`.`name` as `createname`, `account`.`role` as `createrole`, `team`.`name` as `teamname`
FROM `worker`
LEFT JOIN `account` ON `account`.`pkey`=`worker`.`createon`
LEFT JOIN `role` ON `role`.`pkey`=`account`.`role`
LEFT JOIN `team` ON `team`.`pkey`=`worker`.`teamkey`
ERROR - 2022-07-07 14:18:15 --> Severity: Warning --> Undefined array key "teamname" C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 26
ERROR - 2022-07-07 14:18:15 --> Severity: Warning --> Undefined array key "rolename" C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 27
ERROR - 2022-07-07 14:18:15 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:18:15 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 31
ERROR - 2022-07-07 14:18:15 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 31
ERROR - 2022-07-07 14:18:15 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 31
ERROR - 2022-07-07 14:18:31 --> Severity: Warning --> Undefined array key "rolename" C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 26
ERROR - 2022-07-07 14:18:31 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 29
ERROR - 2022-07-07 14:18:31 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:18:31 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:18:31 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:19:29 --> Query error: Not unique table/alias: 'role' - Invalid query: SELECT `worker`.*, `account`.`name` as `createname`, `account`.`role` as `createrole`
FROM `worker`
LEFT JOIN `account` ON `account`.`pkey`=`worker`.`createon`
LEFT JOIN `role` ON `role`.`pkey`=`account`.`role`
LEFT JOIN `role` ON `role`.`pkey`=`account`.`role`
ERROR - 2022-07-07 14:19:38 --> Severity: Warning --> Undefined array key "rolename" C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 26
ERROR - 2022-07-07 14:19:38 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 29
ERROR - 2022-07-07 14:19:38 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:19:38 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:19:38 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:20:16 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 29
ERROR - 2022-07-07 14:20:16 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:20:16 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:20:16 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:21:59 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:21:59 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 14:21:59 --> Severity: Warning --> Undefined variable $disable C:\xampp\htdocs\StockBBN\application\views\admin\workerList.php 30
ERROR - 2022-07-07 09:23:05 --> 404 Page Not Found: Admin/teamList
ERROR - 2022-07-07 09:24:58 --> 404 Page Not Found: Admin/team
ERROR - 2022-07-07 09:25:20 --> Severity: Compile Error --> Cannot redeclare Admin::worker() C:\xampp\htdocs\StockBBN\application\controllers\Admin.php 659
ERROR - 2022-07-07 14:35:14 --> Severity: Warning --> Undefined variable $worker C:\xampp\htdocs\StockBBN\application\views\admin\itemInForm.php 43
ERROR - 2022-07-07 14:35:14 --> Severity: Warning --> foreach() argument must be of type array|object, null given C:\xampp\htdocs\StockBBN\application\views\admin\itemInForm.php 43
ERROR - 2022-07-07 14:37:27 --> Severity: Warning --> Undefined variable $team C:\xampp\htdocs\StockBBN\application\views\admin\itemInForm.php 54
ERROR - 2022-07-07 14:37:27 --> Severity: Warning --> foreach() argument must be of type array|object, null given C:\xampp\htdocs\StockBBN\application\views\admin\itemInForm.php 54
ERROR - 2022-07-07 14:47:07 --> Query error: Unknown column 'itemin.wokerkey' in 'on clause' - Invalid query: SELECT `itemin`.*, `account`.`name` as `createname`, `account`.`role` as `createrole`, `role`.`name` as `rolename`, `item`.`name` as `itemname`, `itemtype`.`name` as `itemtypename`, `worker`.`name` as `workername`, `team`.`name` as `teamname`
FROM `itemin`
LEFT JOIN `account` ON `account`.`pkey`=`itemin`.`createon`
LEFT JOIN `role` ON `role`.`pkey`=`account`.`role`
LEFT JOIN `item` ON `item`.`pkey`=`itemin`.`itemkey`
LEFT JOIN `itemtype` ON `itemtype`.`pkey`=`item`.`typekey`
LEFT JOIN `worker` ON `worker`.`pkey`=`itemin`.`wokerkey`
LEFT JOIN `team` ON `team`.`pkey`=`itemin`.`teamkey`
ERROR - 2022-07-07 14:56:43 --> Severity: Warning --> Undefined variable $worker C:\xampp\htdocs\StockBBN\application\views\admin\itemOutForm.php 31
ERROR - 2022-07-07 14:56:43 --> Severity: Warning --> foreach() argument must be of type array|object, null given C:\xampp\htdocs\StockBBN\application\views\admin\itemOutForm.php 31
ERROR - 2022-07-07 14:56:43 --> Severity: Warning --> Undefined variable $team C:\xampp\htdocs\StockBBN\application\views\admin\itemOutForm.php 42
ERROR - 2022-07-07 14:56:43 --> Severity: Warning --> foreach() argument must be of type array|object, null given C:\xampp\htdocs\StockBBN\application\views\admin\itemOutForm.php 42
ERROR - 2022-07-07 14:57:24 --> Severity: Warning --> Undefined variable $worker C:\xampp\htdocs\StockBBN\application\views\admin\itemOutForm.php 42
ERROR - 2022-07-07 14:57:24 --> Severity: Warning --> foreach() argument must be of type array|object, null given C:\xampp\htdocs\StockBBN\application\views\admin\itemOutForm.php 42
ERROR - 2022-07-07 14:57:24 --> Severity: Warning --> Undefined variable $team C:\xampp\htdocs\StockBBN\application\views\admin\itemOutForm.php 53
ERROR - 2022-07-07 14:57:24 --> Severity: Warning --> foreach() argument must be of type array|object, null given C:\xampp\htdocs\StockBBN\application\views\admin\itemOutForm.php 53
