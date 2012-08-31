<?php

/*重要的常量定义 *****************************************************************************/
define('AUTH_KEY' , 'taty');					//token key

define('IMG_SERVER' , '');								//图片服务器地址

define('MD5_PASSWORD' , md5('000000'));      			//md5默认密码
define('NO_MD5_PASSWORD' , '000000');      				//明文的默认密码

define('SESSION_TOKEN' , 'sessiontoken');				//前台session token名称
define('ADMIN_SESSION_TOKEN' , 'adminsessiontoken');	//后台ssession token名称



define('COPYRIGHT' , '');
define('COPYRIGHTBR' , '');


/*上传下载路径常量定义 ***************************************************************************/
define('UPLOAD_ATTACHMENT' , 'attachment');

/******************************************************************学历****************************************************************/

define('GRADUATE_EDUCATION',1); //研究生教育
define('DOCTORAL_STUDENTS',11); //博士研究生
define('MASTER_GRADUATE_STUDENT',12); //硕士研究生
define('MASTER_CLASS',13); //硕士生班
define('CENTER_SCHOOL_STUDENT', '1A'); //中央党校研究生
define('PROVINCE_SCHOOL_STUDENT', '1B'); //省（区，市）委党校研究生
define('COLLEGE_EDUCATION',2); //本专科教育
define('UNIVERSITY',21); //大学
define('JUNIOR_COLLEGE',22); //大专
define('UNIVERSITY_REGULAR_EDITION', 23);//大学普通版
define('SECOND_BACHELOR', 24); //第二学士位办
define('CENTRAL_SCHOOL_UNIVERSITY', '2A'); //中央党校大学
define('COMMITTEE_SCHOOL_UNIVERSITY', '2B'); //省（区，市）委党校大学
define('CENTRAL_SCHOOL_DIPLOMA', '2C'); //中央党校大专
define('CENTRAL_SCHOOL_DIPLOMA', '2D'); //省（区，市）委党校大专
define('SECONDARY_OCCUPATION_EDUCATION', 4); //中等职业学校教育
define('SECONDARY_SPECIALIZED', 41); //中等专科
define('OCCUPATION_HIGH_SCHOOL', 44); //职业高中
define('TECHNICAL_SCHOOL', 47); //技工学校
define('ORDINARY_HIGH_SCHOOL_EDUCATION', 6); //普通高中教育
define('ORDINARY_HIGH_SCHOOL', 61); //普通高中
define('JUNIOR_HIGH_SCHOOL_EDUCATION', 7); //初中教育
define('JUNIOR_HIGH_SCHOOL', 71); //初中
define('PRIMARY_EDUCATION', 8); //小学教育
define('PRIMARY_SCHOOL', 81); //小学
define('OTHER_EDUCATION', 9); //其他

//*******************************************************民族*************************************************************************/

define('HANZU', 1); //汉族
define('MENGGUZU', 2); //蒙古族
define('HUIZU', 3); //回族
define('ZANGZU', 4); //藏族
define('WEIWUERZU', 5); //维吾尔族
define('MIAOZU', 6); //苗族
define('YIZU', 7); //彝族
define('ZHUANGZU', 8); //壮族
define('BUYIZU', 9); //布依族
define('CHAOXIANZU', 10); //朝鲜族
define('MANZU', 11); //满族
define('DAIZU', 12); //侗族
define('YAOZU', 13); //瑶族
define('BAIZU', 14); //白族
define('TUJIAZU', 15); //土家族
define('HANIERZU', 16); //哈尼族
define('HASAKEZU', 17); //哈萨克族
define('DAIZU', 18); //傣族
define('LIZU', 19); //黎族
define('LISUZU', 20); //傈僳族
define('WUZU', 21); //佤族
define('SHEZU', 22); //畲族
define('GAOSHANZU', 23); //高山族
define('LAHUZU', 24); //拉祜族
define('SHUIZU', 25); //水族
define('DONGXIANGZU', 26); //东乡族
define('NAXIZU', 27); //纳西族
define('JINGPOZU', 28); //景颇族
define('KEERKEZIZU', 29); //柯尔克孜族
define('TUZU', 30); //土族
define('DAWOERZU', 31); //达斡尔族
define('MULAOZU', 32); //仫佬族
define('QIANGZU', 33); //羌族
define('BULANGZU', 34); //布朗族
define('SALAZU', 35); //撒拉族
define('MAONANZU', 36); //毛南族
define('GELAOZU', 37); //仡佬族
define('XIBOZU', 38); //锡伯族
define('ACHANGZU', 39); //阿昌族
define('PUMIZU', 40); //普米族
define('TAIJIKEZU', 41); //塔吉克族
define('NUZU', 42); //怒族
define('WUZIBIEKE', 43); //乌孜别克族
define('ELUOSIZU', 44); //俄罗斯族
define('EWENZU', 45); //鄂温克族
define('DEANGZU', 46); //德昂族
define('BAOANZU', 47); //保安族
define('YUGUZU', 48); //裕固族
define('JINGZU', 49); //京族
define('TATAERZU', 50); //塔塔尔族
define('DULONGZU', 51); //独龙族
define('ELUNCHUNZU', 52); //鄂伦春族
define('HEZHEZU', 53); //赫哲族
define('MENBAZU', 54); //门巴族
define('LUOBAZU', 55); //珞巴族
define('JINUOZU', 56); //基诺族
define('OTHERZU', 57); //其他
define('FOREIGN_CHINESE_NATIONALITY', 58); //外国血统中国籍人士
