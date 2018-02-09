<?php
class myConn{
	/*
		@param
	*/
	public $host;    
	public $dbName;
	public $dbUser;
	public $dbPwd;
	public $dbChar;
	
	/*初始化类*/
	function __construct($host, $dbUser, $dbPwd, $dbName, $dbChar)
	{
		$this->host=$host;
		$this->dbName = $dbName;
		$this->dbUser = $dbUser;
		$this->dbPwd = $dbPwd;
		$this->dbChar = $dbChar;
		
		//链接mysql
		$this->connect();
	}
	
	//链接mysql
	function connect()
	{
		$conn = mysql_connect($this->host, $this->dbUser, $this->dbPwd) or die("mysql can't conn!");
		mysql_select_db($this->dbName, $conn);
		mysql_query("SET NAMES '".$this->dbChar."'");
	}
	
	//统一数据操作
	/*
		$sql : SQL语句
		
		返回值 ： mySql 记录集
	*/
	function query($sql)
	{
		$request = mysql_query($sql);
		return $request;
	}
	
	//返回数据总和
	/*
		$request : SQL操作结果集
		
		返回值 : SQL结果集总条数
	*/
	function sum($request)
	{
		$sum = mysql_num_rows($request);
		return $sum;
	}
	
	//返回表总记录数
	/*
		$param : 字段集
		$tbName : 表名
		$where : 条件
		
		返回值 目标字段的总条数
	*/
	
	function totalRows($param,$tbName,$where='')
	{
		// 字段集为空时处理方式
		if(empty($param))
		{
			$paramStr = '*';
		}else{
			$paramStr = $param;
		}
		
		// 查询条件为空时的处理方式
		if(empty($where))
		{
			$whereStr = '';	
		}else{
			$whereStr = 'WHERE '.$where;
		}
		
		$totalRowsSql = 'SELECT '.$paramStr.' FROM '.$tbName.' '.$whereStr;
		
		$request = $this->query($totalRowsSql);
		
		$totalRows = $this->sum($request);
		
		if(empty($totalRows))
		{
			$totalRows = 0;	
		}
		
		return $totalRows;
	}
	
	//单条查询操作
	/*
		$param : 参数组
		$tbname : 表名
		$where : 条件
		$order : 排序->例如:id DESC
		$limit : 取条数[
		
		返回值 : 单条数据结果集
		
	*/
	function selectOnly($param,$tbname,$where,$order='')
	{
		//排序为空处理方式
		if(empty($order))
		{
			$orderStr ='';
		}else{
			$orderStr = 'ORDER BY '.$order;
		}
		
		//条件为空处理方式
		if(empty($where))
		{
			$whereStr = '';
		}else{
			$whereStr = 'WHERE '.$where;
		}
		
		$sql = 'SELECT '.$param.' FROM '.$tbname.' '.$whereStr.' '.$orderStr;
		$query = $this->query($sql);
		$request = $this->returnArray($query);
		
		return $request; //返回一条结果数组
	}
	
	
	//多条查询操作
	/*
		$param : 参数组
		$tbname : 表名
		$where : 条件
		$order : 排序->例如:id DESC
		$limit : 取条数
		
		******使用案例********
		<?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$about_menu = $bw->selectMany("ID,Subject","tbbase","SortID = 2","`ID` ASC","");
			$menu_sum = count($about_menu);
			for($i = 0; $i<$menu_sum; $i++)
			{
		?>
			<li><a href="contact.php?id=<?php echo $about_menu[$i]['ID']; ?>"><?php echo $about_menu[$i]['Subject']; ?></a></li>
		<?php
			}//end loop
		?>
	*/
	function selectMany($param,$tbname,$where,$order='',$limit='')
	{
		//排序为空处理方式
		if(empty($order))
		{
			$orderStr ="";
		}else{
			$orderStr = 'ORDER BY '.$order;
		}
		
		//条件为空处理方式
		if(empty($where))
		{
			$whereStr = '';
		}else{
			$whereStr = 'WHERE '.$where;
		}
		
		//取条为空处理方式
		if(empty($limit))
		{
			$limitNum = "";
		}else{
			$limitNum = "LIMIT ".$limit;
		}

		$sql = "SELECT ".$param." FROM `".$tbname."` ".$whereStr." ".$orderStr." ".$limitNum;
		$query = $this->query($sql);
		while($rows = $this->returnArray($query))
		{
			$request[] = $rows;
		}
		
		return $request; //返回结果数组
	}
	
	//返回分页要用的值
	/*
		$tbname : 表名
		$where  : where 条件语句 
		$limit : 取条数
	 
		返回值 : $query = array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
	 			          总条数                      总页数              当前页           上一页                   下一页
	*/
	function requestPage($tbname,$where,$limit='')
	{
		$urlAll = $_SERVER['REQUEST_URI'];
		$urlArray = parse_url($urlAll);
		$url = $urlArray['path'];
		
		$page = $_GET['page'];
		
		if(empty($page) || $page < 1)
		{
			$page = 1;
		}

		//条件为空处理方式
		if(empty($where))
		{
			$whereStr = '';
		}else{
			$whereStr = "WHERE ".$where;
		}
		
		$sqlRow = "SELECT * FROM `".$tbname."` ".$whereStr;
		$totalRow = $this->query($sqlRow);
		$totalRow = $this->sum($totalRow);  //总条数
			
		$totalPage = ceil($totalRow/$limit); //总页数
	
		if($page > $totalPage)
		{
			$page = $totalPage;
		}
			
		$pagePrev = $page - 1;  //上一页
		$pageNext = $page + 1;	//下一页
		
		$pageArray = array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
		return $pageArray;
	}
	
	//有分页时执行该函数
	/*
	
	//selectPage($param,$tbname,$where,$order,$limit)
	
	//使用方式
	<ul>
		<?php
			//requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
			$pageSize = 30;
			$tbName = "tbarticle";
			$fatherWhere = "SELECT `SortID` FROM `tbsort` WHERE `ParentID` = 3";
			if(!empty($_GET['cid']))
			{
				$where = "`SortID` NOT IN(".$fatherWhere.") AND `SortID` = ".$_GET['cid'];
			}else{
				$where = "`SortID` NOT IN(".$fatherWhere.")";
			}
			$newsList = $bw->selectPage("ID,Subject,SortID,Addtime",$tbName,$where,"`ID` DESC",$pageSize);
			$pageArray = $bw->requestPage($tbName,$where,$pageSize);
			$news_sum = count($newsList);
			for($i = 0; $i<$news_sum; $i++)
			{
		?>
			<li><span>[<?php echo date("m/d",strtotime($newsList[$i]['Addtime'])); ?>]</span><a href="view.php?id=<?php echo $newsList[$i]['ID']; ?>" title="<?php echo $newsList[$i]['Subject']; ?>" target="_blank"><?php echo mb_substr($newsList[$i]['Subject'],0,30,"utf-8");?></a></li>
		<?
			}//end loop
		?>
	</ul>
	
	
	<div class="page_style">
	共<?php echo $pageArray['totalRow']; ?>条信息&nbsp;&nbsp;&nbsp;页次:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="?cid=<?php echo $_GET['cid']; ?>&page=1">首页</a>&nbsp;&nbsp;
	<a href="?cid=<?php echo $_GET['cid']; ?>&page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
	<a href="?cid=<?php echo $_GET['cid']; ?>&page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
	<a href="?cid=<?php echo $_GET['cid']; ?>&page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
	转到第<select name="page_SEL" id="page_SEL">
			<option value="">页码</option>
			<?php
			  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
			  {
			?>
			<option value="<?php echo $goPage; ?>"><?php echo $goPage; ?></option>
			<?php
			 }
			?>
		</select>
	</div>
	*/
	function selectPage($param, $tbname, $where, $order='', $limit='')
	{
		//获得分页数据
	    $pageArray = $this->requestPage($tbname,$where,$limit);
	
		//排序为空处理方式
		if(empty($order))
		{
			$orderStr ="";
		}else{
			$orderStr = "ORDER BY ".$order;
		}
		
		//条件为空处理方式
		if(empty($where))
		{
			$whereStr = "";
		}else{
			$whereStr = "WHERE ".$where;
		}
		
		//取条为空处理方式
		if(empty($limit))
		{
			$limitNum = "";
		}else{
			$limitNum = "LIMIT ".$limit;
		}
		
		//有分页的时候加上分页
		if(!empty($limit) && !empty($pageArray['page']))
		{
			$limitNum = "LIMIT ".($pageArray['page']-1)*$limit.",".$limit;
		}
		
		$sql = "SELECT ".$param." FROM `".$tbname."` ".$whereStr." ".$orderStr." ".$limitNum;
		//echo $sql;
		$query = $this->query($sql);
		while($rows = $this->returnArray($query))
		{
			$request[] = $rows;
		}
		return $request; //返回结果数组
	}

	/*
		递归调用用于分类
		$id : 当前类别的id
		$parentId : 父id字段的名称
		$tbName : 类别表名
		
		***局限性 较大 以后要升级下......
	*/
	function getChildClass($id, $parentId, $tbName)
	{
	  $selectSql = "SELECT id,className FROM {$tbName} WHERE {$parentId}=".$id;
	  $selectRequest = $this->query($selectSql);
	  while($rs = $this->returnArray($selectRequest))
	  {
		  echo "<option value=".$rs['id'].">";
		  echo $this->getParentId($rs['id'], $parentId, $tbName)."├&nbsp;";
		  echo $rs['className'] ;
		  echo "</option>";
		  if ($this->sum($selectRequest)>0)
		  {
		  	$this->getChildClass($rs["id"], $parentId, $tbName); 
		  }
	  }
	}
	
	//链接上面的getChildClass
	function getParentId($id, $parentId, $tbName)
	{
	  $selectSql = "SELECT {$parentId} FROM {$tbName} WHERE id=".$id;
	  $selectRequest = $this->query($selectSql);
	  $rs = $this->returnArray($selectRequest);
	  if($this->sum($selectRequest)>0&&($rs["{$parentId}"]!=0))
	  {
		  echo '★';
		  $this->getParentId($rs["{$parentId}"], $parentId, $tbName); 
	  }
			
	}
	
	//返回操作结果集
	/*
		$query : 数据操作结果
		
		返回值 ： 记录集
	*/
	function returnArray($query)
	{
		$request = mysql_fetch_array($query);
		return $request;
	}
	
	
	//数据插入
	/*
		$tbName : 表名
		$post   : post 提交数据, 也可以不是表单提交的数组数据
		
		返回值true or false
	*/
	function insert($tbName, $post)
	{
		$elem = array();
		$val  = array();
		foreach($post as $key=>$value)
		{
			$elem[] = $key;
			$val[]  = trim($value);
		}
		$elemSum = count($elem);	
		for($i=0; $i<$elemSum; $i++)
		{
			$elemStr .=$elem[$i];
			$valStr  .="'".$val[$i]."'";
			if($i<$elemSum-1)
			{
				$elemStr .= ', ';
				$valStr  .= ', ';
			}
		}
		$insertSql = "INSERT INTO {$tbName}(".$elemStr.") VALUES (".$valStr.")";
/*		echo $insertSql;
		exit;*/
		$return = $this->query($insertSql);
		if($return)
		{
			return true;	
		}else{
			return false;
		}
		//end 
	}
	
	//删除数据
	/*
		$tbName : 表名
		$where  : where 条件语句
	*/
	function delete($tbName, $where)
	{
		$deleteSql = "DELETE FROM {$tbName} WHERE {$where}";
		$return = $this->query($deleteSql);
		if($return)
		{
			return true;	
		}else{
			return false;	
		}
	}
	
	
	//数据更新
	/*
		$tbName : 表名
		$post   : post 提交数据, 也可以不是表单提交的数组数据
		$where  : 条件
	*/
	function update($tbName, $post, $where)
	{
		$elem = array();
		$val  = array();
		foreach($post as $key=>$value)
		{
			$elem[] = $key;
			$val[]  = trim($value);
		}
		
		$elemSum = count($elem);	
		for($i=0; $i<$elemSum; $i++)
		{
			$elemAndVal .=$elem[$i]." = '".$val[$i]."'";
			if($i<$elemSum-1)
			{
				$elemAndVal .= ', ';
			}
		}
		
		$updateSql = "UPDATE {$tbName} SET ".$elemAndVal." WHERE {$where} LIMIT 1";
		//die($updateSql);
		$return = $this->query($updateSql);
		if($return)
		{
			return true;	
		}else{
			return false;
		}
		//end 
	}
	
	//权限控制
	function shell($username='', $password='')
	{
		//selectOnly($param,$tbname,$where,$order)
		if(empty($username) || empty($password))
		{
			return false;	
		}else{
			$shell = $this->selectOnly('username, password', 'bw_user', "username = '{$username}' AND password = '{$password}'");
			if($shell)
			{
				return true;	
			}else{
				return false;	
			}
		}
	}
	
	//用户登录控制
	function userLogin($username='', $password='')
	{
		//selectOnly($param,$tbname,$where,$order)
		if(empty($username) || empty($password))
		{
			return false;	
		}else{
			$userLogin = $this->selectOnly('username, password', 'bw_member', "username = '{$username}' AND password = '{$password}' AND levels != 0");
			if($userLogin)
			{
				return true;	
			}else{
				return false;	
			}
		}
	}
	
	//会员用户控制(用在二级网站) 要扩展此类则把userLogin vipOrder
	function userOrder($username)
	{
		//selectOnly($param,$tbname,$where,$order)
		if(empty($username))
		{
			return false;	
		}else{
			$userData = $this->selectOnly('levels', 'bw_member', "username = '{$username}'");
			if(empty($userData['levels']))
			{
				return false;
			}else{
				$userVip = $this->selectOnly('username', 'bw_member', "username = '{$username}' AND levels = {$userData['levels']}");
				if($userVip)
				{
					return true;	
				}else{
					return false;	
				}
			}
		}
	}
	
	//消息提示
	/*
		$message : 提示消息
		$url     : 跳转页面
		$history : true 跳转到历史页面, 默认false;
	*/
	function msg($message, $url = '', $history = false)
	{
		if(empty($url))
		{
			echo "<script> alert('{$message}'); </script>";	
		}else{
			if($history)
			{
				echo "<script> alert('{$message}'); history.go(-1); </script>";	
			}else{
				echo "<script> alert('{$message}'); location.href='{$url}'; </script>";	
			}
		}
		
	}
	
	//图片文件上传
	/*
		$path : 文件保存路径
		$MAX_FILE_SIZE : 最大文件大小
		$upForm : 表单名字
		
		返回值:文件存放路径$path.$fileName
	*/
	function upload($path,$MAX_FILE_SIZE,$upForm)
	{
		$save_file_path= $path;// "upload/teacher/" //文件保存路径
		define(MAX_FILE_SIZE,$MAX_FILE_SIZE); //文件大小限制 单位 bit
		$uploadfile   =$_FILES[$upForm]; 
		$file_name    =$uploadfile['name'];
		$file_type    =$uploadfile['type'];
		$file_size    =$uploadfile['size'];
		$file_tmp_name=$uploadfile['tmp_name'];
		$file_error   =$uploadfile['error'];
		$file_name_arr=explode(".",$file_name);//分解文件名
		$file_name_nums_ceil=count($file_name_arr)-1;//取得文件后缀
		$file_name =$save_file_path.date("Ymd").mktime().rand(1000,9999).".".$file_name_arr[$file_name_nums_ceil];//重新组成文件名加扩展
		$file_arr=array("image/pjpeg","image/jpeg","image/gif","image/bmp","image/x-png","image/png");	//上传文件类型 
		if(!in_array($file_type,$file_arr))
		{
			$message="上传文件不符合上传类型!";
			return $message;
		}
		else if($file_size>MAX_FILE_SIZE)
		{
			$message="文件大小超过限制!";
			return $message;
		}
		else if(is_uploaded_file($file_tmp_name) && $file_error==0)
		{
			move_uploaded_file($file_tmp_name,$file_name);
			$message="文件上传成功!";
			$ok_save=$file_name;
		}
		else
		{
			$message="文件上传失败!";
			return $message;
		}	
		if(!empty($ok_save))
		{
			return $ok_save;
		}else{
			return false;
		}
	}
	//加积分
	//$id会员id
	//$log积分日志
	//$jifen增加或减少的积分
	//$tang弹出对话框的内容
	//$biao需要判断的表名
	//$Time需要判断的表名
	//$sl条数
	function jifen($id,$log,$jifen,$tang='',$biao='',$Time='',$sl=0)
	{
		if (!empty($biao)&&!empty($Time)&&!empty($sl)&&$sl!=0)
		{
		$sqlstr="Select * From `".$biao."` Where ".$Time.">='".date("Y-m-d")."'";
		$Rs_query = mysql_query($sqlstr);
		if(mysql_num_rows($Rs_query)<=$sl)
		{
				$suzu['mid'] = $id;
				$suzu['jflog'] = $log;
				$suzu['jfnum'] = $jifen;
				$suzu['jftime'] = date("Y-m-d H:i:s");
			$this->insert('bw_jifen', $suzu);
			$updateSql = "UPDATE bw_member SET jifen=jifen".$jifen." WHERE id=".$id;
		 
				$this->query($updateSql);
						if(!empty($tang))
						{
							$this->msg($tang);
						}
			
		}
		}else{
				$suzu['mid'] = $id;
				$suzu['jflog'] = $log;
				$suzu['jfnum'] = $jifen;
				$suzu['jftime'] = date("Y-m-d H:i:s");
			$this->insert('bw_jifen', $suzu);
			$updateSql = "UPDATE bw_member SET jifen=jifen".$jifen." WHERE id=".$id;
		 
				$this->query($updateSql);
						if(!empty($tang))
						{
							$this->msg($tang);
						}
			}
			
		}
	//去除HTML样式
	function phphtml($content)
	{
		$content = preg_replace("/<a[^>]*>/i", "", $content);   
	   $content = preg_replace("/<\/a>/i", "", $content);    
	   $content = preg_replace("/<div[^>]*>/i", "", $content);   
	   $content = preg_replace("/<\/div>/i", "", $content); 
	   $content = preg_replace("/<img[^>]*>/i", "", $content);       
	   $content = preg_replace("/<\/img>/i", "", $content);  
	   $content = preg_replace("/<p[^>]*>/i", "", $content);       
	   $content = preg_replace("/<\/p>/i", "", $content);     
	   $content = preg_replace("/<!--[^>]*-->/i", "", $content);//注释内容   
	   $content = preg_replace("/style=.+?['|\"]/i",'',$content);//去除样式   
	   $content = preg_replace("/class=.+?['|\"]/i",'',$content);//去除样式   
	   $content = preg_replace("/id=.+?['|\"]/i",'',$content);//去除样式      
	   $content = preg_replace("/lang=.+?['|\"]/i",'',$content);//去除样式       
	   $content = preg_replace("/width=.+?['|\"]/i",'',$content);//去除样式    
	   $content = preg_replace("/height=.+?['|\"]/i",'',$content);//去除样式    
	   $content = preg_replace("/border=.+?['|\"]/i",'',$content);//去除样式    
	   $content = preg_replace("/face=.+?['|\"]/i",'',$content);//去除样式    
	   $content = preg_replace("/face=.+?['|\"]/",'',$content);//去除样式 只允许小写 正则匹配没有带 i 参数
		return $content;   
	}
	//$title 要截取的字符
	//$length 需要截取的数量
	function str_len($title,$length)
	{ 
	$encoding='utf-8'; 
	if(mb_strlen($title,$encoding)>$length){ 
	$title=mb_substr($title,0,$length,$encoding).'...'; 
	} 
	return $title; 
	}
}//end class
?>