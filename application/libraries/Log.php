<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Logging Class For SAE
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Logging
 * @author		@月夜风KeN
 * @link		http://codeigniter.com/user_guide/general/errors.html
 */
class CI_Log {

	protected $_log_path;
	protected $_threshold	= 1;
	protected $_date_fmt	= 'Y-m-d H:i:s';
	protected $_enabled	= TRUE;
	protected $_levels	= array('ERROR' => '1', 'DEBUG' => '2',  'INFO' => '3', 'ALL' => '4');

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$config =& get_config();
		
		if (is_numeric($config['log_threshold']))
		{
			$this->_threshold = $config['log_threshold'];
		}
		
		if (class_exists('SaeKV'))
		{
			$this->_enabled = TRUE;
		}
		else
		{
			$this->_log_path = ($config['log_path'] != '') ? $config['log_path'] : APPPATH.'logs/';

			if ( ! is_dir($this->_log_path) OR ! is_really_writable($this->_log_path))
			{
				$this->_enabled = FALSE;
			}

			if ($config['log_date_format'] != '')
			{
				$this->_date_fmt = $config['log_date_format'];
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * 针对SAE的日志输出，在日志中心中查看，选择debug选项
	 * @param unknown_type $level
	 * @param unknown_type $message
	 * @param unknown_type $php_error
	 */
	public function write_log($level = 'error', $msg, $php_error = FALSE)
	{
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}

		$level = strtoupper($level);

		if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
		{
			return FALSE;
		}
		
		if (class_exists('SaeKV'))
		{
			sae_set_display_errors(false); // 关闭信息输出
			sae_debug( $level .': '. $msg);//记录日志
			sae_set_display_errors(true); // 记录日志后再打开信息输出，否则会阻止正常的错误信息的显示
			return TRUE;
		}
		else{
			$filepath = $this->_log_path.'log-'.date('Y-m-d').'.php';
			$message  = '';

			if ( ! file_exists($filepath))
			{
				$message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
			}

			if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
			{
				return FALSE;
			}

			$message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date($this->_date_fmt). ' --> '.$msg."\n";

			flock($fp, LOCK_EX);
			fwrite($fp, $message);
			flock($fp, LOCK_UN);
			fclose($fp);

			@chmod($filepath, FILE_WRITE_MODE);
			return TRUE;
		}
	}

}
// END Log Class

/* End of file Log.php */
/* Location: ./system/libraries/Log.php */