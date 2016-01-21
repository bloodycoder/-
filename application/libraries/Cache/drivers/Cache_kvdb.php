<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cache_KVDB
 * 见 其它 同级子类 注释
 * @author ogopogo
 * @edit @月夜风KeN
 * 修改：若缓存设置ttl为0时，则不进行自动删除，永不过期。与memchced保持一致。
 */
class Cache_KVDB extends CI_Driver{
   private $_kvdb;
   private $_hasKVDB = false;
   
   protected $_prefixKey;
   
   //SAE kvdb缓存初始化
   public function __construct() {
		$this->_kvdb = new SaeKV();
		$this->_hasKVDB = $this->_kvdb->init();
		$CI =& get_instance();
		$path = $CI->config->item('cache_path');
		$this->_prefixKey = ($path == '') ? 'system_cache_' : $path;
   }
   
   	// ------------------------------------------------------------------------

	/**
	 * Fetch from cache
	 *
	 * @param 	mixed		unique key id
	 * @return 	mixed		data on success/false on failure
	 */
   public function get($id) {
        $stored = $this->_kvdb->get($this->_prefixKey.$id);
        if ($stored == FALSE) {
            return FALSE;
        }
        $stored = unserialize($stored);
		if( $stored['ttl'] > 0 )
		{
			if (time() > $stored['time'] + $stored['ttl']) {
				$this->_kvdb->delete( $id );
				return FALSE;
			}
		}
        return $stored['data'];
    }

	// ------------------------------------------------------------------------

	/**
	 * Save into cache
	 *
	 * @param 	string		unique key
	 * @param 	mixed		data to store
	 * @param 	int			length of time (in seconds) the cache is valid 
	 *						- Default is 60 seconds
	 *						- $ttl 为0时，永不过期
	 * @return 	boolean		true on success/false on failure
	 */
	public function save($id, $data, $ttl = 60){
		$contents = array(
				'time'		=> time(),
				'ttl'		=> $ttl,			
				'data'		=> $data
			);
		$this->_kvdb->set($this->_prefixKey.$id, serialize($contents));
		return TRUE;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Delete from Cache
	 *
	 * @param 	mixed		unique identifier of item in cache
	 * @return 	boolean		true on success/false on failure
	 */
   public function delete($id) {
        return $this->_kvdb->delete($this->_prefixKey.$id) ;
    }
	
	// ------------------------------------------------------------------------

	/**
	 * Clean the Cache
	 * 可以通过关闭再打开kvdb来清除所有数据，但sae目前不支持通过程序打开关闭，只能循环读取删除
	 *
	 * @return 	boolean		false on failure/true on success
	 */	
   public function clean() {
       while(true){
            $ret = $this->_kvdb->pkrget($this->_prefixKey, 100);
            if( $ret == FALSE ){
                break;
            }
            foreach ($ret as $key => $value) {
                $this->_kvdb->delete($key);
            }
       }
        
       return TRUE;
    }
	
	// ------------------------------------------------------------------------

	/**
	 * Cache Info
	 *
	 * Not supported by file-based caching
	 *
	 * @param 	string	user/filehits
	 * @return 	mixed 	FALSE
	 */
    public function cache_info($type = NULL) {
        return $this->_kvdb->get_options();
    }
	
	// ------------------------------------------------------------------------

	/**
	 * Get Cache Metadata
	 *
	 * @param 	mixed		key to get cache metadata on
	 * @return 	mixed		FALSE on failure, array on success.
	 */
    public function get_metadata($id) {
       $stored = $this->_kvdb->get($this->_prefixKey.$id);
        if ($stored == FALSE) {
            return FALSE;
        }
        $stored = unserialize($stored);
        if (count($stored) !== 3) {
            return FALSE;
        }
        return array(
            'expire' => $stored['ttl']?($stored['time']+$stored['ttl']):0, //如果数据永不过期，返回的expire为0
            'mtime' => $stored['time'],
            'data' => $stored['data']
        );
    }
    
	// ------------------------------------------------------------------------

	/**
	 * Is supported
	 *
	 * In the file driver, check to see that the cache directory is indeed writable
	 * 
	 * @return boolean
	 */
   public function is_supported() {
        if ( ! $this->_hasKVDB ) {
            return FALSE;
        }
        return TRUE;
    }
}
// End Class

/* End of file Cache_kvdb.php */
/* Location: ./system/libraries/Cache/drivers/Cache_kvdb.php */