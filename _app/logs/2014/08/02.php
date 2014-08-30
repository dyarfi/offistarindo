<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-08-02 04:38:15 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL guide/cache/usage was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 87 ]
2014-08-02 04:38:15 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL guide/cache/usage was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 87 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-08-02 04:52:37 --- ERROR: ReflectionException [ -1 ]: Class controller_backend_index. does not exist ~ MODPATH/userguide/classes/kohana/kodoc/class.php [ 53 ]
2014-08-02 04:52:37 --- STRACE: ReflectionException [ -1 ]: Class controller_backend_index. does not exist ~ MODPATH/userguide/classes/kohana/kodoc/class.php [ 53 ]
--
#0 /Volumes/Data/www/offistarindo/_mod/userguide/classes/kohana/kodoc/class.php(53): ReflectionClass->__construct('controller_back...')
#1 /Volumes/Data/www/offistarindo/_mod/userguide/classes/kohana/kodoc.php(48): Kohana_Kodoc_Class->__construct('controller_back...')
#2 /Volumes/Data/www/offistarindo/_mod/userguide/classes/kohana/kodoc.php(77): Kohana_Kodoc::factory('controller_back...')
#3 /Volumes/Data/www/offistarindo/_mod/userguide/classes/controller/userguide.php(232): Kohana_Kodoc::menu()
#4 [internal function]: Controller_Userguide->action_api()
#5 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client/internal.php(116): ReflectionMethod->invoke(Object(Controller_Userguide))
#6 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#8 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#9 {main}
2014-08-02 04:52:37 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '.', expecting '{' ~ MODPATH/userguide/classes/kohana/kodoc/missing.php(30) : eval()'d code [ 1 ]
2014-08-02 04:52:37 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '.', expecting '{' ~ MODPATH/userguide/classes/kohana/kodoc/missing.php(30) : eval()'d code [ 1 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2014-08-02 05:07:07 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ MODPATH/_modules/reseller/classes/controller/backend/reseller.php [ 805 ]
2014-08-02 05:07:07 --- STRACE: ErrorException [ 8 ]: Undefined variable: content ~ MODPATH/_modules/reseller/classes/controller/backend/reseller.php [ 805 ]
--
#0 /Volumes/Data/www/offistarindo/_mod/_modules/reseller/classes/controller/backend/reseller.php(805): Kohana_Core::error_handler(8, 'Undefined varia...', '/Volumes/Data/w...', 805, Array)
#1 /Volumes/Data/www/offistarindo/_mod/_modules/reseller/classes/controller/backend/reseller.php(407): Controller_Backend_Reseller->_checking_order('1', '33')
#2 [internal function]: Controller_Backend_Reseller->action_edit()
#3 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client/internal.php(116): ReflectionMethod->invoke(Object(Controller_Backend_Reseller))
#4 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#6 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#7 {main}
2014-08-02 05:59:52 --- ERROR: ErrorException [ 8 ]: Undefined property: Model_Reseller::$id ~ MODPATH/_modules/reseller/classes/model/reseller.php [ 113 ]
2014-08-02 05:59:52 --- STRACE: ErrorException [ 8 ]: Undefined property: Model_Reseller::$id ~ MODPATH/_modules/reseller/classes/model/reseller.php [ 113 ]
--
#0 /Volumes/Data/www/offistarindo/_mod/_modules/reseller/classes/model/reseller.php(113): Kohana_Core::error_handler(8, 'Undefined prope...', '/Volumes/Data/w...', 113, Array)
#1 /Volumes/Data/www/offistarindo/_mod/_modules/reseller/classes/controller/backend/reseller.php(809): Model_Reseller->update()
#2 /Volumes/Data/www/offistarindo/_mod/_modules/reseller/classes/controller/backend/reseller.php(227): Controller_Backend_Reseller->_checking_order('1')
#3 [internal function]: Controller_Backend_Reseller->action_add()
#4 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client/internal.php(116): ReflectionMethod->invoke(Object(Controller_Backend_Reseller))
#5 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#7 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#8 {main}
2014-08-02 06:15:57 --- ERROR: ErrorException [ 8 ]: Undefined property: Model_Reseller::$id ~ MODPATH/_modules/reseller/classes/model/reseller.php [ 63 ]
2014-08-02 06:15:57 --- STRACE: ErrorException [ 8 ]: Undefined property: Model_Reseller::$id ~ MODPATH/_modules/reseller/classes/model/reseller.php [ 63 ]
--
#0 /Volumes/Data/www/offistarindo/_mod/_modules/reseller/classes/model/reseller.php(63): Kohana_Core::error_handler(8, 'Undefined prope...', '/Volumes/Data/w...', 63, Array)
#1 /Volumes/Data/www/offistarindo/_mod/_modules/reseller/classes/controller/backend/reseller.php(821): Model_Reseller->load('')
#2 /Volumes/Data/www/offistarindo/_mod/_modules/reseller/classes/controller/backend/reseller.php(227): Controller_Backend_Reseller->_checking_order('1')
#3 [internal function]: Controller_Backend_Reseller->action_add()
#4 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client/internal.php(116): ReflectionMethod->invoke(Object(Controller_Backend_Reseller))
#5 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#7 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#8 {main}
2014-08-02 06:46:53 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '->' (T_OBJECT_OPERATOR), expecting ',' or ';' ~ MODPATH/_modules/banner/views/banner/backend/banner_index.php [ 94 ]
2014-08-02 06:46:53 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '->' (T_OBJECT_OPERATOR), expecting ',' or ';' ~ MODPATH/_modules/banner/views/banner/backend/banner_index.php [ 94 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2014-08-02 06:56:15 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Backend_Banner::$reseller ~ MODPATH/_modules/banner/classes/controller/backend/banner.php [ 292 ]
2014-08-02 06:56:15 --- STRACE: ErrorException [ 8 ]: Undefined property: Controller_Backend_Banner::$reseller ~ MODPATH/_modules/banner/classes/controller/backend/banner.php [ 292 ]
--
#0 /Volumes/Data/www/offistarindo/_mod/_modules/banner/classes/controller/backend/banner.php(292): Kohana_Core::error_handler(8, 'Undefined prope...', '/Volumes/Data/w...', 292, Array)
#1 [internal function]: Controller_Backend_Banner->action_add()
#2 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client/internal.php(116): ReflectionMethod->invoke(Object(Controller_Backend_Banner))
#3 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#5 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#6 {main}
2014-08-02 07:27:42 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''3\'' at line 1 [ SELECT * FROM `tbl_banners` WHERE `order` = '3\' ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 194 ]
2014-08-02 07:27:42 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''3\'' at line 1 [ SELECT * FROM `tbl_banners` WHERE `order` = '3\' ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 194 ]
--
#0 /Volumes/Data/www/offistarindo/_mod/_modules/banner/classes/model/banner.php(192): Kohana_Database_MySQL->query(1, 'SELECT * FROM `...', true)
#1 /Volumes/Data/www/offistarindo/_mod/_modules/banner/classes/controller/backend/banner.php(779): Model_Banner->find(Array)
#2 /Volumes/Data/www/offistarindo/_mod/_modules/banner/classes/controller/backend/banner.php(409): Controller_Backend_Banner->_checking_order('3\', '15', '')
#3 [internal function]: Controller_Backend_Banner->action_edit()
#4 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client/internal.php(116): ReflectionMethod->invoke(Object(Controller_Backend_Banner))
#5 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#7 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#8 {main}
2014-08-02 07:48:58 --- ERROR: ErrorException [ 8 ]: Undefined variable: _temp ~ MODPATH/_modules/banner/classes/controller/backend/banner.php [ 788 ]
2014-08-02 07:48:58 --- STRACE: ErrorException [ 8 ]: Undefined variable: _temp ~ MODPATH/_modules/banner/classes/controller/backend/banner.php [ 788 ]
--
#0 /Volumes/Data/www/offistarindo/_mod/_modules/banner/classes/controller/backend/banner.php(788): Kohana_Core::error_handler(8, 'Undefined varia...', '/Volumes/Data/w...', 788, Array)
#1 /Volumes/Data/www/offistarindo/_mod/_modules/banner/classes/controller/backend/banner.php(409): Controller_Backend_Banner->_checking_order('4', '12', '')
#2 [internal function]: Controller_Backend_Banner->action_edit()
#3 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client/internal.php(116): ReflectionMethod->invoke(Object(Controller_Backend_Banner))
#4 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#6 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#7 {main}
2014-08-02 08:13:32 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Backend_Product::$banner ~ MODPATH/_modules/product/classes/controller/backend/product.php [ 738 ]
2014-08-02 08:13:32 --- STRACE: ErrorException [ 8 ]: Undefined property: Controller_Backend_Product::$banner ~ MODPATH/_modules/product/classes/controller/backend/product.php [ 738 ]
--
#0 /Volumes/Data/www/offistarindo/_mod/_modules/product/classes/controller/backend/product.php(738): Kohana_Core::error_handler(8, 'Undefined prope...', '/Volumes/Data/w...', 738, Array)
#1 [internal function]: Controller_Backend_Product->action_order()
#2 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client/internal.php(116): ReflectionMethod->invoke(Object(Controller_Backend_Product))
#3 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#5 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#6 {main}
2014-08-02 08:38:41 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/sdfgsdfg was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-08-02 08:38:41 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/sdfgsdfg was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-08-02 08:40:17 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/cvzxcvzxcv was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-08-02 08:40:17 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/cvzxcvzxcv was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-08-02 08:43:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/zxcvzxcv zxcvzxcv zxcvzxcv was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-08-02 08:43:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/zxcvzxcv zxcvzxcv zxcvzxcv was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-08-02 08:44:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/cvzxcvzxcv was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-08-02 08:44:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/cvzxcvzxcv was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-08-02 08:47:45 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/zxzczxc was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-08-02 08:47:45 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/zxzczxc was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-08-02 08:50:06 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/zxcvzxcvzxcv zxcvzxcvzxcv was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-08-02 08:50:06 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/zxcvzxcvzxcv zxcvzxcvzxcv was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-08-02 08:54:21 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/xvxcvxcvqweqweqwe was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-08-02 08:54:21 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/xvxcvxcvqweqweqwe was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-08-02 08:56:39 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/zxczxc was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-08-02 08:56:39 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/zxczxc was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}
2014-08-02 08:56:40 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/zxczxc was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
2014-08-02 08:56:40 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL admin-cp/productcategory/check_title/zxczxc was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 111 ]
--
#0 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /Volumes/Data/www/offistarindo/_sys/classes/kohana/request.php(1154): Kohana_Request_Client->execute(Object(Request))
#2 /Volumes/Data/www/offistarindo/index.php(132): Kohana_Request->execute()
#3 {main}