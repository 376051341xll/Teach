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
	
	/*��ʼ����*/
	function __construct($host, $dbUser, $dbPwd, $dbName, $dbChar)
	{
		$this->host=$host;
		$this->dbName = $dbName;
		$this->dbUser = $dbUser;
		$this->dbPwd = $dbPwd;
		$this->dbChar = $dbChar;
		
		//����mysql
		$this->connect();
	}
	
	//����mysql
	function connect()
	{
		$conn = mysql_connect($this->host, $this->dbUser, $this->dbPwd) or die("mysql can't conn!");
		mysql_select_db($this->dbName, $conn);
		mysql_query("SET NAMES '".$this->dbChar."'");
	}
	
	//ͳһ���ݲ���
	/*
		$sql : SQL���
		
		����ֵ �� mySql ��¼��
	*/
	function query($sql)
	{
		$request = mysql_query($sql);
		return $request;
	}
	
	//���������ܺ�
	/*
		$request : SQL���������
		
		����ֵ : SQL�����������
	*/
	function sum($request)
	{
		$sum = mysql_num_rows($request);
		return $sum;
	}
	
	//���ر��ܼ�¼��
	/*
		$param : �ֶμ�
		$tbName : ����
		$where : ����
		
		����ֵ Ŀ���ֶε�������
	*/
	
	function totalRows($param,$tbName,$where='')
	{
		// �ֶμ�Ϊ��ʱ����ʽ
		if(empty($param))
		{
			$paramStr = '*';
		}else{
			$paramStr = $param;
		}
		
		// ��ѯ����Ϊ��ʱ�Ĵ���ʽ
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
	
	//������ѯ����
	/*
		$param : ������
		$tbname : ����
		$where : ����
		$order : ����->����:id DESC
		$limit : ȡ����[
		
		����ֵ : �������ݽ����
		
	*/
	function selectOnly($param,$tbname,$where,$order='')
	{
		//����Ϊ�մ���ʽ
		if(empty($order))
		{
			$orderStr ='';
		}else{
			$orderStr = 'ORDER BY '.$order;
		}
		
		//����Ϊ�մ���ʽ
		if(empty($where))
		{
			$whereStr = '';
		}else{
			$whereStr = 'WHERE '.$where;
		}
		
		$sql = 'SELECT '.$param.' FROM '.$tbname.' '.$whereStr.' '.$orderStr;
		$query = $this->query($sql);
		$request = $this->returnArray($query);
		
		return $request; //����һ���������
	}
	
	
	//������ѯ����
	/*
		$param : ������
		$tbname : ����
		$where : ����
		$order : ����->����:id DESC
		$limit : ȡ����
		
		******ʹ�ð���********
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
		//����Ϊ�մ���ʽ
		if(empty($order))
		{
			$orderStr ="";
		}else{
			$orderStr = 'ORDER BY '.$order;
		}
		
		//����Ϊ�մ���ʽ
		if(empty($where))
		{
			$whereStr = '';
		}else{
			$whereStr = 'WHERE '.$where;
		}
		
		//ȡ��Ϊ�մ���ʽ
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
		
		return $request; //���ؽ������
	}
	
	//���ط�ҳҪ�õ�ֵ
	/*
		$tbname : ����
		$where  : where ������� 
		$limit : ȡ����
	 
		����ֵ : $query = array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
	 			          ������                      ��ҳ��              ��ǰҳ           ��һҳ                   ��һҳ
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

		//����Ϊ�մ���ʽ
		if(empty($where))
		{
			$whereStr = '';
		}else{
			$whereStr = "WHERE ".$where;
		}
		
		$sqlRow = "SELECT * FROM `".$tbname."` ".$whereStr;
		$totalRow = $this->query($sqlRow);
		$totalRow = $this->sum($totalRow);  //������
			
		$totalPage = ceil($totalRow/$limit); //��ҳ��
	
		if($page > $totalPage)
		{
			$page = $totalPage;
		}
			
		$pagePrev = $page - 1;  //��һҳ
		$pageNext = $page + 1;	//��һҳ
		
		$pageArray = array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
		return $pageArray;
	}
	
	//�з�ҳʱִ�иú���
	/*
	
	//selectPage($param,$tbname,$where,$order,$limit)
	
	//ʹ�÷�ʽ
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
	��<?php echo $pageArray['totalRow']; ?>����Ϣ&nbsp;&nbsp;&nbsp;ҳ��:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>ҳ&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="?cid=<?php echo $_GET['cid']; ?>&page=1">��ҳ</a>&nbsp;&nbsp;
	<a href="?cid=<?php echo $_GET['cid']; ?>&page=<?php echo $pageArray['pagePrev']; ?>">��һҳ</a>&nbsp;&nbsp;
	<a href="?cid=<?php echo $_GET['cid']; ?>&page=<?php echo $pageArray['pageNext']; ?>">��һҳ</a>&nbsp;&nbsp;
	<a href="?cid=<?php echo $_GET['cid']; ?>&page=<?php echo $pageArray['totalPage']; ?>">βҳ</a>&nbsp;&nbsp;
	ת����<select name="page_SEL" id="page_SEL">
			<option value="">ҳ��</option>
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
		//��÷�ҳ����
	    $pageArray = $this->requestPage($tbname,$where,$limit);
	
		//����Ϊ�մ���ʽ
		if(empty($order))
		{
			$orderStr ="";
		}else{
			$orderStr = "ORDER BY ".$order;
		}
		
		//����Ϊ�մ���ʽ
		if(empty($where))
		{
			$whereStr = "";
		}else{
			$whereStr = "WHERE ".$where;
		}
		
		//ȡ��Ϊ�մ���ʽ
		if(empty($limit))
		{
			$limitNum = "";
		}else{
			$limitNum = "LIMIT ".$limit;
		}
		
		//�з�ҳ��ʱ����Ϸ�ҳ
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
		return $request; //���ؽ������
	}

	/*
		�ݹ�������ڷ���
		$id : ��ǰ����id
		$parentId : ��id�ֶε�����
		$tbName : ������
		
		***������ �ϴ� �Ժ�Ҫ������......
	*/
	function getChildClass($id, $parentId, $tbName)
	{
	  $selectSql = "SELECT id,className FROM {$tbName} WHERE {$parentId}=".$id;
	  $selectRequest = $this->query($selectSql);
	  while($rs = $this->returnArray($selectRequest))
	  {
		  echo "<option value=".$rs['id'].">";
		  echo $this->getParentId($rs['id'], $parentId, $tbName)."��&nbsp;";
		  echo $rs['className'] ;
		  echo "</option>";
		  if ($this->sum($selectRequest)>0)
		  {
		  	$this->getChildClass($rs["id"], $parentId, $tbName); 
		  }
	  }
	}
	
	//���������getChildClass
	function getParentId($id, $parentId, $tbName)
	{
	  $selectSql = "SELECT {$parentId} FROM {$tbName} WHERE id=".$id;
	  $selectRequest = $this->query($selectSql);
	  $rs = $this->returnArray($selectRequest);
	  if($this->sum($selectRequest)>0&&($rs["{$parentId}"]!=0))
	  {
		  echo '��';
		  $this->getParentId($rs["{$parentId}"], $parentId, $tbName); 
	  }
			
	}
	
	//���ز��������
	/*
		$query : ���ݲ������
		
		����ֵ �� ��¼��
	*/
	function returnArray($query)
	{
		$request = mysql_fetch_array($query);
		return $request;
	}
	
	
	//���ݲ���
	/*
		$tbName : ����
		$post   : post �ύ����, Ҳ���Բ��Ǳ��ύ����������
		
		����ֵtrue or false
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
	
	//ɾ������
	/*
		$tbName : ����
		$where  : where �������
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
	
	
	//���ݸ���
	/*
		$tbName : ����
		$post   : post �ύ����, Ҳ���Բ��Ǳ��ύ����������
		$where  : ����
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
	
	//Ȩ�޿���
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
	
	//�û���¼����
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
	
	//��Ա�û�����(���ڶ�����վ) Ҫ��չ�������userLogin vipOrder
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
	
	//��Ϣ��ʾ
	/*
		$message : ��ʾ��Ϣ
		$url     : ��תҳ��
		$history : true ��ת����ʷҳ��, Ĭ��false;
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
	
	//ͼƬ�ļ��ϴ�
	/*
		$path : �ļ�����·��
		$MAX_FILE_SIZE : ����ļ���С
		$upForm : ������
		
		����ֵ:�ļ����·��$path.$fileName
	*/
	function upload($path,$MAX_FILE_SIZE,$upForm)
	{
		$save_file_path= $path;// "upload/teacher/" //�ļ�����·��
		define(MAX_FILE_SIZE,$MAX_FILE_SIZE); //�ļ���С���� ��λ bit
		$uploadfile   =$_FILES[$upForm]; 
		$file_name    =$uploadfile['name'];
		$file_type    =$uploadfile['type'];
		$file_size    =$uploadfile['size'];
		$file_tmp_name=$uploadfile['tmp_name'];
		$file_error   =$uploadfile['error'];
		$file_name_arr=explode(".",$file_name);//�ֽ��ļ���
		$file_name_nums_ceil=count($file_name_arr)-1;//ȡ���ļ���׺
		$file_name =$save_file_path.date("Ymd").mktime().rand(1000,9999).".".$file_name_arr[$file_name_nums_ceil];//��������ļ�������չ
		$file_arr=array("image/pjpeg","image/jpeg","image/gif","image/bmp","image/x-png","image/png");	//�ϴ��ļ����� 
		if(!in_array($file_type,$file_arr))
		{
			$message="�ϴ��ļ��������ϴ�����!";
			return $message;
		}
		else if($file_size>MAX_FILE_SIZE)
		{
			$message="�ļ���С��������!";
			return $message;
		}
		else if(is_uploaded_file($file_tmp_name) && $file_error==0)
		{
			move_uploaded_file($file_tmp_name,$file_name);
			$message="�ļ��ϴ��ɹ�!";
			$ok_save=$file_name;
		}
		else
		{
			$message="�ļ��ϴ�ʧ��!";
			return $message;
		}	
		if(!empty($ok_save))
		{
			return $ok_save;
		}else{
			return false;
		}
	}
	//�ӻ���
	//$id��Աid
	//$log������־
	//$jifen���ӻ���ٵĻ���
	//$tang�����Ի��������
	//$biao��Ҫ�жϵı���
	//$Time��Ҫ�жϵı���
	//$sl����
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
	//ȥ��HTML��ʽ
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
	   $content = preg_replace("/<!--[^>]*-->/i", "", $content);//ע������   
	   $content = preg_replace("/style=.+?['|\"]/i",'',$content);//ȥ����ʽ   
	   $content = preg_replace("/class=.+?['|\"]/i",'',$content);//ȥ����ʽ   
	   $content = preg_replace("/id=.+?['|\"]/i",'',$content);//ȥ����ʽ      
	   $content = preg_replace("/lang=.+?['|\"]/i",'',$content);//ȥ����ʽ       
	   $content = preg_replace("/width=.+?['|\"]/i",'',$content);//ȥ����ʽ    
	   $content = preg_replace("/height=.+?['|\"]/i",'',$content);//ȥ����ʽ    
	   $content = preg_replace("/border=.+?['|\"]/i",'',$content);//ȥ����ʽ    
	   $content = preg_replace("/face=.+?['|\"]/i",'',$content);//ȥ����ʽ    
	   $content = preg_replace("/face=.+?['|\"]/",'',$content);//ȥ����ʽ ֻ����Сд ����ƥ��û�д� i ����
		return $content;   
	}
	//$title Ҫ��ȡ���ַ�
	//$length ��Ҫ��ȡ������
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