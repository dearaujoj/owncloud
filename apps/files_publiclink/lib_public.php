<?php
class OC_PublicLink{
	/**
	 * create a new public link
	 * @param string path
	 * @param int (optional) expiretime time the link expires, as timestamp
	 */
	public function __construct($path,$expiretime=0){
		if($path and  OC_FILESYSTEM::file_exists($path) and OC_FILESYSTEM::is_readable($path)){
			$user=OC_USER::getUser();
			$token=sha1("$user-$path-$expiretime");
			$query=OC_DB::prepare("INSERT INTO *PREFIX*publiclink VALUES(?,?,?,?)");
			$result=$query->execute(array($token,$path,$user,$expiretime));
			if( PEAR::isError($result)) {
				$entry = 'DB Error: "'.$result->getMessage().'"<br />';
				$entry .= 'Offending command was: '.$result->getDebugInfo().'<br />';
				error_log( $entry );
				die( $entry );
			}
			$this->token=$token;
		}
	}
	
	/**
	 * get the path of that shared file
	 */
	public static function getPath($token){
		//remove expired links
		$query=OC_DB::prepare("DELETE FROM *PREFIX*publiclink WHERE expire_time < ? AND expire_time!=0");
		$query->execute(array(time()));
		
		//get the path and the user
		$query=OC_DB::prepare("SELECT user,path FROM *PREFIX*publiclink WHERE token=?");
		$result=$query->execute(array($token));
		$data=$result->fetchAll();
		if(count($data)>0){
			$path=$data[0]['path'];
			$user=$data[0]['user'];
			
			//prepare the filesystem
			OC_UTIL::setupFS($user, 'files', true);
			
			return $path;
		}else{
			return false;
		}
	}
	
	/**
	 * get the token for the public link
	 * @return string
	 */
	public function getToken(){
		return $this->token;
	}
	
	/**
	 * gets all public links
	 * @return array
	 */
	static public function getLinks(){
		$query=OC_DB::prepare("SELECT * FROM *PREFIX*publiclink WHERE user=?");
		return $query->execute(array(OC_USER::getUser()))->fetchAll();
	}

	/**
	 * delete a public link
	 */
	static public function delete($token){
		$query=OC_DB::prepare("SELECT user,path FROM *PREFIX*publiclink WHERE token=?");
		$result=$query->execute(array($token))->fetchAll();
		if(count($result)>0 and $result[0]['user']==OC_USER::getUser()){
			$query=OC_DB::prepare("DELETE FROM *PREFIX*publiclink WHERE token=?");
			$query->execute(array($token));
		}
	}
	
	private $token;
}
?>
