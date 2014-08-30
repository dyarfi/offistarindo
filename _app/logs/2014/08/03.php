<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-08-03 02:17:44 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '$content_vars' (T_VARIABLE) ~ MODPATH/_modules/banner/classes/controller/backend/banner.php [ 295 ]
2014-08-03 02:17:44 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '$content_vars' (T_VARIABLE) ~ MODPATH/_modules/banner/classes/controller/backend/banner.php [ 295 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2014-08-03 02:34:17 --- ERROR: ErrorException [ 1 ]: Call to undefined function print_t() ~ MODPATH/_modules/banner/classes/controller/backend/banner.php [ 293 ]
2014-08-03 02:34:17 --- STRACE: ErrorException [ 1 ]: Call to undefined function print_t() ~ MODPATH/_modules/banner/classes/controller/backend/banner.php [ 293 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2014-08-03 03:47:15 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/product/check_title/sdfasdf was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-08-03 03:47:15 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/product/check_title/sdfasdf was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-08-03 03:49:15 --- ERROR: ErrorException [ 1 ]: Unsupported operand types ~ MODPATH/_modules/product/views/product/backend/product_add.php [ 217 ]
2014-08-03 03:49:15 --- STRACE: ErrorException [ 1 ]: Unsupported operand types ~ MODPATH/_modules/product/views/product/backend/product_add.php [ 217 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2014-08-03 03:49:44 --- ERROR: ErrorException [ 1 ]: Unsupported operand types ~ MODPATH/_modules/product/views/product/backend/product_add.php [ 217 ]
2014-08-03 03:49:44 --- STRACE: ErrorException [ 1 ]: Unsupported operand types ~ MODPATH/_modules/product/views/product/backend/product_add.php [ 217 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}