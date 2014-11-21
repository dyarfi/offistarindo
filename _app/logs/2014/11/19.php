<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-11-19 15:22:56 --- ERROR: ErrorException [ 2 ]: Attempt to assign property of non-object ~ MODPATH/_modules/page/classes/controller/backend/page.php [ 343 ]
2014-11-19 15:22:56 --- STRACE: ErrorException [ 2 ]: Attempt to assign property of non-object ~ MODPATH/_modules/page/classes/controller/backend/page.php [ 343 ]
--
#0 /Volumes/Data/www/offistarindo/_mod/_modules/page/classes/controller/backend/page.php(343): Kohana_Core::error_handler(2, 'Attempt to assi...', '/Volumes/Data/w...', 343, Array)
#1 [internal function]: Controller_Backend_Page->action_add()
#2 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client/internal.php(116): ReflectionMethod->invoke(Object(Controller_Backend_Page))
#3 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#5 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#6 {main}
2014-11-19 15:23:25 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/solution/check_title/sdfsdfsf was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-11-19 15:23:25 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/solution/check_title/sdfsdfsf was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-11-19 15:23:34 --- ERROR: ErrorException [ 2 ]: Attempt to assign property of non-object ~ MODPATH/_modules/solution/classes/controller/backend/solution.php [ 325 ]
2014-11-19 15:23:34 --- STRACE: ErrorException [ 2 ]: Attempt to assign property of non-object ~ MODPATH/_modules/solution/classes/controller/backend/solution.php [ 325 ]
--
#0 /Volumes/Data/www/offistarindo/_mod/_modules/solution/classes/controller/backend/solution.php(325): Kohana_Core::error_handler(2, 'Attempt to assi...', '/Volumes/Data/w...', 325, Array)
#1 [internal function]: Controller_Backend_Solution->action_add()
#2 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client/internal.php(116): ReflectionMethod->invoke(Object(Controller_Backend_Solution))
#3 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#5 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#6 {main}
2014-11-19 15:23:38 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/solution/check_title/sdfsdfsf was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-11-19 15:23:38 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/solution/check_title/sdfsdfsf was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-11-19 15:23:52 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/solution/check_title/sdfsdfsf was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-11-19 15:23:52 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/solution/check_title/sdfsdfsf was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}