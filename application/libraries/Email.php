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
 * CodeIgniter Email Class for SAE
 *
 * CodeIgniter发送邮件类，使用SAE原生Mail改写，仅支持SMTP协议。不支持密送，默认关闭自动换行
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @edit 	@月夜风KeN
 * @link		http://codeigniter.com/user_guide/libraries/email.html		and		http://apidoc.sinaapp.com/sae/SaeMail.html
 * @add		增加初始化参数 tls, compress, callback_url  参数说明见 http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a116
 * @delete 	删除参数 useragent, mailpath, smtp_timeout, charset(默认utf8), priority, crlf, bcc_batch_mode, bcc_batch_size
 */
  
class SAE_Email {

	var	$protocol		= "smtp";	// mail/sendmail/smtp
	var	$smtp_host		= "";		// SMTP Server.  Example: mail.earthlink.net
	var	$smtp_user		= "";		// SMTP Username
	var	$smtp_pass		= "";		// SMTP Password
	var	$smtp_port		= "25";		// SMTP Port
	var	$smtp_crypto	= "";		// SMTP Encryption. Can be null, tls or ssl.
	var	$wordwrap		= FALSE;		// TRUE/FALSE  Turns word-wrap on/off
	var	$wrapchars		= "76";		// Number of characters to wrap at.
	var	$mailtype		= "TEXT";	// text/html  Defines email formatting
	var	$validate		= FALSE;	// TRUE/FALSE.  Enables email validation
	var	$newline		= "\n";		// Default newline. "\r\n" or "\n" (Use "\r\n" to comply with RFC 822)
	var	$_subject		= "";
	var	$_body			= "";
	var	$_finalbody		= "";
	var	$_debug_msg		= array();
	var	$_attach_name	= array();
	var	$_attach_type	= array();
	var	$_attach_disp	= array();
	var	$_protocols		= array('mail', 'sendmail', 'smtp');
	var	$_options = array();
	
	var	$_sae_mail = NULL; //SAE Mail对象
	//新增参数
	var	$tls = FALSE; 	//是否加密SMTP连接 Gmail需要设置
	var	$compress = ''; 	//设置此参数, sae mail将所有附件压缩为一个zip文件, 此参数作为文件名(不带.zip)
	var	$callback_url = '';		//SMTP发送失败时的回调地址，回调方式为post，postdata格式：timestamp=时间戳&from=from地址&to=to地址（如有多个to，则以,分割） 

	/**
	 * Constructor - Sets Email Preferences
	 *
	 * The constructor can be passed an array of config values
	 */
	public function __construct($config = array())
	{
		$this->initialize($config);
		log_message('debug', "SAE Email Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
	public function initialize($config = array())
	{
		$this->_sae_mail = new SaeMail(); //SAE mail初始化
		
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$method = 'set_'.$key;

				if (method_exists($this, $method))
				{
					$this->$method($val);
				}
				else
				{
					$this->$key = $val;
				}
			}
		}
		
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize the Email Object
	 *
	 * @access	public
	 * @return	void
	 */
	public function clear($clear_attachments = FALSE)
	{
		$this->_sae_mail->clean();

		return TRUE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Quick Way to Send Email
	 * 快速发送邮件，使用参数参考 http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a200
	 * @access	public
	 * @return	void
	 */
	public function quick_send($to, $subject, $msgbody, $smtp_user, $smtp_pass, $smtp_host='', $smtp_port=25, $smtp_tls=false)
	{
		$this->_sae_mail->quickSend($to, $subject, $msgbody, $smtp_user, $smtp_pass, $smtp_host, $smtp_port, $smtp_tls);
		
		return $this->clear();
	}	

	// --------------------------------------------------------------------

	/**
	 * Set FROM
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function from($from, $name = '')
	{
		if (preg_match( '/\<(.*)\>/', $from, $match))
		{
			$from = $match['1'];
		}

		if ($this->validate)
		{
			$this->validate_email($this->_str_to_array($from));
		}

		if ($name == '')
		{
			$name = $from;
			$this->_set_option('from', $from);
		}
		else
		{
			$encode = $this->_get_str_encode($name);
			if( $encode != "UTF-8" )
			{
				$name = iconv($encode,"UTF-8",$name);
			}
			$this->_set_option('from', '=?UTF-8?B?'.base64_encode($name).'?= <'.$from.'>');
		}
		
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Recipients
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function to($to)
	{
		$to = $this->_str_to_array($to);
		$to = $this->clean_email($to);

		if ($this->validate)
		{
			$this->validate_email($to);
		}

		if ($this->_get_protocol() == 'smtp')
		{
			$this->_set_option('to', implode(",", $to));
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set CC
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function cc($cc)
	{
		$cc = $this->_str_to_array($cc);
		$cc = $this->clean_email($cc);

		if ($this->validate)
		{
			$this->validate_email($cc);
		}

		$this->_set_option('cc', implode(",", $cc));

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Email Subject
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function subject($subject)
	{
		$this->_set_option('subject', $subject);
		return $this;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set SMTP HOST
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function set_smtp_host($smtp_host)
	{
		$this->_set_option('smtp_host', $smtp_host);
		return $this;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set SMTP Username
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function set_smtp_user($smtp_username)
	{
		$this->_set_option('smtp_username', $smtp_username);
		return $this;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set SMTP Password
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function set_smtp_pass($smtp_password)
	{
		$this->_set_option('smtp_password', $smtp_password);
		return $this;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set SMTP Port
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function set_smtp_port($smtp_port = 25)
	{
		$this->_set_option('smtp_port', $smtp_port);
		return $this;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set SMTP Tls
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function set_tls($tls = FALSE)
	{
		$this->_set_option('tls', $tls);
		return $this;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set Attach Compress Name
	 * 设置了此参数，SAE Mail会把所有附件压缩成一个zip文件.
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function set_compress($compress_name)
	{
		$this->_set_option('compress', $compress_name.'.zip');
		return $this;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set Callback Url
	 * 设置了此参数，SMTP发送失败时的回调地址，回调方式为post，postdata格式：timestamp=时间戳&from=from地址&to=to地址（如有多个to，则以,分割）
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function set_callback_url($callback_url)
	{
		$this->_set_option('callback_url', $callback_url);
		return $this;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set Body
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function message($body)
	{
		$encode = $this->_get_str_encode($body);
		if( $encode != "UTF-8" )
		{
			$body = iconv($encode,"UTF-8",$body);
		}
	
		$this->_body = rtrim(str_replace("\r", "", $body));

		if ($this->wordwrap === TRUE  AND  $this->mailtype != 'HTML')
		{
			$this->_body = $this->word_wrap($this->_body);
		}
		
		/* strip slashes only if magic quotes is ON
		   if we do it with magic quotes OFF, it strips real, user-inputted chars.

		   NOTE: In PHP 5.4 get_magic_quotes_gpc() will always return 0 and
			 it will probably not exist in future versions at all.
		*/
		if ( ! is_php('5.4') && get_magic_quotes_gpc())
		{
			$this->_body = stripslashes($this->_body);
		}
		
		$this->_finalbody = $this->_body;

		$this->_set_option('content', $this->_body);
		
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Assign file attachments
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function attach($filename, $file_path)
	{
		$ret = $this->_sae_mail->setAttach( array($filename => file_get_contents($file_path)) );
		if( ! $ret ){
			$this->_set_error_message('lang:email_attachment_missing');
			return FALSE;
		}
		$this->_attach_name[] = $filename;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Mail option
	 *
	 * @access	protected
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	protected function _set_option($option, $value)
	{
		$this->_options[$option] = $value;
		$this->_sae_mail->setOpt( array($option => $value) );
	}

	// --------------------------------------------------------------------

	/**
	 * Convert a String to an Array
	 *
	 * @access	protected
	 * @param	string
	 * @return	array
	 */
	protected function _str_to_array($email)
	{
		if ( ! is_array($email))
		{
			if (strpos($email, ',') !== FALSE)
			{
				$email = preg_split('/[\s,]/', $email, -1, PREG_SPLIT_NO_EMPTY);
			}
			else
			{
				$email = trim($email);
				settype($email, "array");
			}
		}
		return $email;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Mailtype
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function set_mailtype($type = 'TEXT')
	{
		$this->mailtype = ( strtolower($type) == 'html' ) ? 'HTML' : 'TEXT';
		$this->_set_option('content_type', $this->mailtype);
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Wordwrap
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function set_wordwrap($wordwrap = TRUE)
	{
		$this->wordwrap = ($wordwrap === FALSE) ? FALSE : TRUE;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Protocol
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function set_protocol($protocol = 'smtp')
	{
		$this->protocol = ( ! in_array($protocol, $this->_protocols, TRUE)) ? 'smtp' : strtolower($protocol);
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Mail Protocol
	 *
	 * @access	protected
	 * @param	bool
	 * @return	string
	 */
	protected function _get_protocol($return = TRUE)
	{
		$this->protocol = strtolower($this->protocol);
		$this->protocol = ( ! in_array($this->protocol, $this->_protocols, TRUE)) ? 'smtp' : $this->protocol;

		if ($return == TRUE)
		{
			return $this->protocol;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Validate Email Address
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function validate_email($email)
	{
		if ( ! is_array($email))
		{
			$this->_set_error_message('lang:email_must_be_array');
			return FALSE;
		}

		foreach ($email as $val)
		{
			if ( ! $this->valid_email($val))
			{
				$this->_set_error_message('lang:email_invalid_address', $val);
				return FALSE;
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Email Validation
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function valid_email($address)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $address)) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Clean Extended Email Address: Joe Smith <joe@smith.com>
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function clean_email($email)
	{
		if ( ! is_array($email))
		{
			if (preg_match('/\<(.*)\>/', $email, $match))
			{
				return $match['1'];
			}
			else
			{
				return $email;
			}
		}

		$clean_email = array();

		foreach ($email as $addy)
		{
			if (preg_match( '/\<(.*)\>/', $addy, $match))
			{
				$clean_email[] = $match['1'];
			}
			else
			{
				$clean_email[] = $addy;
			}
		}

		return $clean_email;
	}

	// --------------------------------------------------------------------

	/**
	 * Word Wrap
	 *
	 * @access	public
	 * @param	string
	 * @param	integer
	 * @return	string
	 */
	public function word_wrap($str, $charlim = '')
	{
		// Se the character limit
		if ($charlim == '')
		{
			$charlim = ($this->wrapchars == "") ? "76" : $this->wrapchars;
		}

		// Reduce multiple spaces
		$str = preg_replace("| +|", " ", $str);

		// Standardize newlines
		if (strpos($str, "\r") !== FALSE)
		{
			$str = str_replace(array("\r\n", "\r"), "\n", $str);
		}

		// If the current word is surrounded by {unwrap} tags we'll
		// strip the entire chunk and replace it with a marker.
		$unwrap = array();
		if (preg_match_all("|(\{unwrap\}.+?\{/unwrap\})|s", $str, $matches))
		{
			for ($i = 0; $i < count($matches['0']); $i++)
			{
				$unwrap[] = $matches['1'][$i];
				$str = str_replace($matches['1'][$i], "{{unwrapped".$i."}}", $str);
			}
		}

		// Use PHP's native public function to do the initial wordwrap.
		// We set the cut flag to FALSE so that any individual words that are
		// too long get left alone.  In the next step we'll deal with them.
		$str = wordwrap($str, $charlim, "\n", FALSE);

		// Split the string into individual lines of text and cycle through them
		$output = "";
		foreach (explode("\n", $str) as $line)
		{
			// Is the line within the allowed character count?
			// If so we'll join it to the output and continue
			if (strlen($line) <= $charlim)
			{
				$output .= $line.$this->newline;
				continue;
			}

			$temp = '';
			while ((strlen($line)) > $charlim)
			{
				// If the over-length word is a URL we won't wrap it
				if (preg_match("!\[url.+\]|://|wwww.!", $line))
				{
					break;
				}

				// Trim the word down
				$temp .= substr($line, 0, $charlim-1);
				$line = substr($line, $charlim-1);
			}

			// If $temp contains data it means we had to split up an over-length
			// word into smaller chunks so we'll add it back to our current line
			if ($temp != '')
			{
				$output .= $temp.$this->newline.$line;
			}
			else
			{
				$output .= $line;
			}

			$output .= $this->newline;
		}

		// Put our markers back
		if (count($unwrap) > 0)
		{
			foreach ($unwrap as $key => $val)
			{
				$output = str_replace("{{unwrapped".$key."}}", $val, $output);
			}
		}

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Send Email
	 *
	 * @access	public
	 * @return	bool
	 */
	public function send()
	{
		if ( ! $this->_sae_mail->send() )
		{
			log_message('error', "Email Send Fail. Wrong: ".$this->_sae_mail->errno() . ' ' . $this->_sae_mail->errmsg());
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Debug Message
	 *
	 * @access	public
	 * @return	string
	 */
	public function print_debugger()
	{
		$msg = '';

		if (count($this->_debug_msg) > 0)
		{
			foreach ($this->_debug_msg as $val)
			{
				$msg .= $val;
			}
		}

		$msg .= "<pre>Options: ".print_r($this->_options) ."\n".htmlspecialchars($this->_subject)."\n".htmlspecialchars($this->_finalbody).'</pre>';
		return $msg;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Message
	 *
	 * @access	protected
	 * @param	string
	 * @return	string
	 */
	protected function _set_error_message($msg, $val = '')
	{
		$CI =& get_instance();
		$CI->lang->load('email');

		if (substr($msg, 0, 5) != 'lang:' || FALSE === ($line = $CI->lang->line(substr($msg, 5))))
		{
			$this->_debug_msg[] = str_replace('%s', $val, $msg)."<br />";
		}
		else
		{
			$this->_debug_msg[] = str_replace('%s', $val, $line)."<br />";
		}
	}
	
	//Get the encoding type of the String 
	protected function _get_str_encode($str){
		return mb_detect_encoding($str, array("UTF-8","GB2312","GBK"));
	}

}
// END SAE_Email class

/* End of file Email.php */
/* Location: ./application/libraries/Email.php */