<?php
//2011.2.12
if(!defined('IN_CORP')) {
	exit('Access Denied');
}

//更新管理员用户缓存
function adminuser_cache(){
	global $db,$CACHE;
	$CACHE['adminuser'] = array();
	$user_tb = tname('user');
	$user_group_tb = tname('user_group');
	$query = $db -> query("SELECT * FROM $user_tb,$user_group_tb WHERE $user_tb . `uid` = $user_group_tb . `uid` AND `groupid` = 1");
	while ($value = $db->fetch_array($query)){
			$CACHE['adminuser'][] = $value;
	}
	cache_write('adminuser','CACHE[\'adminuser\']',$CACHE['adminuser']);
}




/*//更新配置文件
function config_cache() {
	global $db, $_SCONFIG;

	$_SCONFIG = array();
	$query = $db->query('SELECT * FROM '.tname('config'));
	while ($value = $db->fetch_array($query)) {
		if($value['var'] == 'privacy') {
			$value['value'] = empty($value['value'])?array():unserialize($value['value']);
		}
		$_SCONFIG[$value['var']] = $value['value'];
	}
	cache_write('config', '_SCONFIG', $_SCONFIG);
}

//更新用户组CACHE
function usergroup_cache() {
	global $db,$CACHE;

	$CACHE['usergroup'] = array();
	$highest = true;
	$lower = '';
	$query = $db->query('SELECT * FROM '.tname('usergroup').";");
	while ($group = $db->fetch_array($query)) {
		$CACHE['usergroup'][$group['groupid']] = $group;
	}
	cache_write('usergroup', "CACHE['usergroup']", $CACHE['usergroup']);
}

//更新词语屏蔽~
function censor_cache() {
	global $CACHE,$db;

	$CACHE['censor'] = $banned = $banwords = array();

	$censorarr = $db->fetch_first("SELECT value FROM ".tname("config")." WHERE var='censor'");
	//print_r($censorarr);
	$censorarr = explode("\n", $censorarr['value']);
	//print_r($censorarr);
	foreach($censorarr as $censor){
		$censor = trim($censor);
		if(empty($censor)) continue;

		list($find, $replace) = explode('=', $censor);
		$findword = $find;
		$find = preg_replace("/\\\{(\d+)\\\}/", ".{0,\\1}", preg_quote($find, '/'));
		switch($replace) {
			case '{BANNED}':
				$banwords[] = preg_replace("/\\\{(\d+)\\\}/", "*", preg_quote($findword, '/'));
				$banned[] = $find;
				break;
			default:
				$CACHE['censor']['filter']['find'][] = '/'.$find.'/i';
				$CACHE['censor']['filter']['replace'][] = $replace;
				break;
		}
	}
	if($banned) {
		$CACHE['censor']['banned'] = '/('.implode('|', $banned).')/i';
		$CACHE['censor']['banword'] = implode(', ', $banwords);
	}

	cache_write('censor', "CACHE['censor']", $CACHE['censor']);
}

//更新广告缓存
function ad_cache() {
	global $CACHE,$db;

	$CACHE['ad'] = array();
	$query = $db->query('SELECT adid, position FROM '.tname('ad')." WHERE system='1' AND available='1'");
	while ($value = $db->fetch_array($query)) {
		$CACHE['ad'][$value['pagetype']][] = $value['adid'];
	}
	cache_write('ad', "CACHE['ad']", $CACHE['ad']);
}

//更新隐私缓存
function privacy_cache() {
	global $CACHE,$db;

	$CACHE['privacy'] = array();
	$query = $db->query('SELECT * FROM '.tname('privacy').";");
	while ($value = $db->fetch_array($query)) {
		$CACHE['privacy'][$value['pid']] = $value;
	}
	cache_write('privacy', "CACHE['privacy']", $CACHE['privacy']);
}

//更新推荐用户缓存
function supUser_cache() {
	global $CACHE,$db;

	$CACHE['supUser'] = array();
	$query = $db->query('SELECT * FROM '.tname('user')." WHERE isup=1");
	while ($value = $db->fetch_array($query)) {
		$CACHE['supUser'][$value['uid']] = $value;
	}
	cache_write('supUser', "CACHE['supUser']", $CACHE['supUser']);
}

//更新超级管理员缓存
function supAdmin_cache() {
	global $CACHE,$db;

	$CACHE['supAdmin'] = array();
	$admins = get_alluser(-1);
	if($admins){
		foreach ($admins as $admin)
			$CACHE['supAdmin'][] = $admin['uid'];
	}
	cache_write('supAdmin', "CACHE['supAdmin']", $CACHE['supAdmin']);
}

//清空模板文件
function tpl_cache() {
	//include_once(CORP_ROOT.'./source/function_cp.php');
	$dir = CORP_ROOT.'./cache/templates';
	$files = sreaddir($dir);
	foreach ($files as $file) {
		@unlink($dir.'/'.$file);
	}
}

//递归清空目录
function deltreedir($dir) {
	$files = sreaddir($dir);
	foreach ($files as $file) {
		if(is_dir("$dir/$file")) {
			deltreedir("$dir/$file");
		} else {
			@unlink("$dir/$file");
		}
	}
}*/

/** 
* 函数名：function arrayeval(array $array,int $level)
* 功  能：将数组转为字符转
* 参  数：$array:待转化字符 $level：行前制表符个数
* 返回值：转化好的字符串
*/ 
function arrayeval($array, $level = 0) {
	$space = '';
	for($i = 0; $i <= $level; $i++) {
		$space .= "\t";
	}
	$evaluate = "Array\n$space(\n";
	$comma = $space;
	foreach($array as $key => $val) {
		$key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
		$val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
		if(is_array($val)) {
			$evaluate .= "$comma$key => ".arrayeval($val, $level + 1);
		} else {
			$evaluate .= "$comma$key => $val";
		}
		$comma = ",\n$space";
	}
	$evaluate .= "\n$space)";
	return $evaluate;
}

/** 
* 函数名：function cache_write(string $name, string $var, array $values)
* 功  能：写入缓存
* 参  数：$name:缓存文件名（前缀为data）$var：参数名 $values:需写入的数组
* 返回值：无
*/ 
function cache_write($name, $var, $values) {
	$cachefile = CORP_ROOT.'./cache/data_'.$name.'.php';
	$cachetext = "<?php\r\n".
		"if(!defined('IN_CORP')) exit('Access Denied');\r\n".
		'$'.$var.'='.arrayeval($values).
		"\r\n?>";
	if(!swritefile($cachefile, $cachetext)) {
		exit("File: $cachefile write error.");
	}
}

/** 
* 函数名：get_cache($name)
* 功  能：取缓存
* 参  数：$name:缓存文件名（前缀为data）$var：参数名 $values:需写入的数组
* 返回值：无
*/ 
function get_cache($name){
	global $CACHE;
	if(!file_exists(CORP_ROOT."./cache/data_$name.php")){
		$cache_name = $name.'_cache';
		$cache_name();
	}else{
		include_once CORP_ROOT."./cache/data_$name.php";
	}
}

/** 
* 函数名：update_cache($name)
* 功  能：更新缓存
* 参  数：$name:缓存文件名（前缀为data）$var：参数名 $values:需写入的数组
* 返回值：无
*/ 
function update_cache($name){
	global $CACHE;
	$cache_name = $name.'_cache';
	$cache_name();
}
?>
