<?php
/**
 * CalibreFx Lib
 *
 * CalibreFx Plugin Libraries
 *
 * @package		calibrefxlib
 * @author		CalibreFx Dev Team
 * @copyright	Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://www.CalibreFx.com
 * @since		Version 1.0
 * @filesource
 */
 
/**
 * Email Libraries
 *
 * CalibreFx Email Library
 *
 * @package		calibrefxlib
 * @subpackage	Library
 * @category	Email Library
 * @author		CalibreFx Dev Team
 * @link		http://www.CalibreFx.com
 */
// ------------------------------------------------------------------------

class CFX_Email {
    public $useragent			= 'CalibreFx Mail';
	public $mailpath			= '/usr/sbin/sendmail';	// Sendmail path
	public $protocol			= 'mail';		// mail/sendmail/smtp
	public $smtp_host			= '';			// SMTP Server. Example: mail.earthlink.net
	public $smtp_user			= '';			// SMTP Username
	public $smtp_pass			= '';			// SMTP Password
	public $smtp_port			= 25;			// SMTP Port
	public $smtp_timeout		= 5;			// SMTP Timeout in seconds
	public $smtp_crypto			= '';			// SMTP Encryption. Can be null, tls or ssl.
	public $wordwrap			= TRUE;			// TRUE/FALSE  Turns word-wrap on/off
	public $wrapchars			= 76;			// Number of characters to wrap at.
	public $mailtype			= 'text';		// text/html  Defines email formatting
	public $charset				= 'utf-8';		// Default char set: iso-8859-1 or us-ascii
	public $multipart			= 'mixed';		// "mixed" (in the body) or "related" (separate)
	public $alt_message			= '';			// Alternative message for HTML emails
	public $validate			= FALSE;		// TRUE/FALSE.  Enables email validation
	public $priority			= 3;			// Default priority (1 - 5)
	public $newline				= "\n";			// Default newline. "\r\n" or "\n" (Use "\r\n" to comply with RFC 822)
	public $crlf				= "\n";			// The RFC 2045 compliant CRLF for quoted-printable is "\r\n".  Apparently some servers,
									// even on the receiving end think they need to muck with CRLFs, so using "\n", while
									// distasteful, is the only thing that seems to work for all environments.
	public $dsn					= FALSE;		// Delivery Status Notification
	public $send_multipart		= TRUE;		// TRUE/FALSE - Yahoo does not like multipart alternative, so this is an override.  Set to FALSE for Yahoo.
	public $bcc_batch_mode		= FALSE;	// TRUE/FALSE - Turns on/off Bcc batch feature
	public $bcc_batch_size		= 200;		// If bcc_batch_mode = TRUE, sets max number of Bccs in each batch

	protected $_safe_mode		= FALSE;
	protected $_subject			= '';
	protected $_body			= '';
	protected $_finalbody		= '';
	protected $_alt_boundary	= '';
	protected $_atc_boundary	= '';
	protected $_header_str		= '';
	protected $_smtp_connect	= '';
	protected $_encoding		= '8bit';
	protected $_IP				= FALSE;
	protected $_smtp_auth		= FALSE;
	protected $_replyto_flag	= FALSE;
	protected $_debug_msg		= array();
	protected $_recipients		= array();
	protected $_cc_array		= array();
	protected $_bcc_array		= array();
	protected $_headers			= array();
	protected $_attach_name		= array();
	protected $_attach_type		= array();
	protected $_attach_disp		= array();
	protected $_protocols		= array('mail', 'sendmail', 'smtp');
	protected $_base_charsets	= array('us-ascii', 'iso-2022-');	// 7-bit charsets (excluding language suffix)
	protected $_bit_depths		= array('7bit', '8bit');
	protected $_priorities		= array('1 (Highest)', '2 (High)', '3 (Normal)', '4 (Low)', '5 (Lowest)');

	protected $_phpmailer;
	protected $_calibrefx;

	/**
	 * Constructor - Sets Email Preferences
	 *
	 * The constructor can be passed an array of config values
	 *
	 * @return	void
	 */
	public function __construct($config = array())
	{
		global $phpmailer;
		global $calibrefx;

		$this->_phpmailer = $phpmailer;
		$this->_calibrefx = $calibrefx;

		if (count($config) > 0)
		{
			$this->initialize($config);
		}
		else
		{
			$this->_smtp_auth = ! ($this->smtp_user === '' && $this->smtp_pass === '');
			$this->_safe_mode = (bool) @ini_get('safe_mode');
		}

		calibrefx_log_message('debug', 'Email Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize the Email Data
	 *
	 * @param	bool
	 * @return	object
	 */
	public function clear($clear_attachments = FALSE)
	{
		$this->_subject		= '';
		$this->_body		= '';
		$this->_finalbody	= '';
		$this->_header_str	= '';
		$this->_replyto_flag	= FALSE;
		$this->_recipients	= array();
		$this->_cc_array	= array();
		$this->_bcc_array	= array();
		$this->_headers		= array();
		$this->_debug_msg	= array();

		$this->set_header('User-Agent', $this->useragent);
		$this->set_header('Date', $this->_set_date());

		if ($clear_attachments !== FALSE)
		{
			$this->_attach_name = array();
			$this->_attach_type = array();
			$this->_attach_disp = array();
		}

		// Empty out the values that may be set
		$this->_phpmailer->ClearAddresses();
		$this->_phpmailer->ClearAllRecipients();
		$this->_phpmailer->ClearAttachments();
		$this->_phpmailer->ClearBCCs();
		$this->_phpmailer->ClearCCs();
		$this->_phpmailer->ClearCustomHeaders();
		$this->_phpmailer->ClearReplyTos();

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set FROM
	 *
	 * @param	string
	 * @param	string
	 * @return	object
	 */
	public function from($from, $name = '')
	{
		if (preg_match('/\<(.*)\>/', $from, $match))
		{
			$from = $match[1];
		}

		if ($this->validate)
		{
			$this->validate_email($this->_str_to_array($from));
		}

		// prepare the display name
		if ($name !== '')
		{
			// only use Q encoding if there are characters that would require it
			if ( ! preg_match('/[\200-\377]/', $name))
			{
				// add slashes for non-printing characters, slashes, and double quotes, and surround it in double quotes
				$name = '"'.addcslashes($name, "\0..\37\177'\"\\").'"';
			}
			else
			{
				$name = $this->_prep_q_encoding($name, TRUE);
			}
		}

		$this->set_header('From', $name.' <'.$from.'>');
		$this->set_header('Return-Path', '<'.$from.'>');

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Reply-to
	 *
	 * @param	string
	 * @param	string
	 * @return	object
	 */
	public function reply_to($replyto, $name = '')
	{
		if (preg_match('/\<(.*)\>/', $replyto, $match))
		{
			$replyto = $match[1];
		}

		if ($this->validate)
		{
			$this->validate_email($this->_str_to_array($replyto));
		}

		if ($name === '')
		{
			$name = $replyto;
		}

		if (strpos($name, '"') !== 0)
		{
			$name = '"'.$name.'"';
		}

		$this->set_header('Reply-To', $name.' <'.$replyto.'>');
		$this->_replyto_flag = TRUE;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Recipients
	 *
	 * @param	string
	 * @return	object
	 */
	public function to($to)
	{
		$to = $this->_str_to_array($to);
		$to = $this->clean_email($to);

		if ($this->validate)
		{
			$this->validate_email($to);
		}

		if ($this->_get_protocol() !== 'mail')
		{
			$this->set_header('To', implode(', ', $to));
		}

		switch ($this->_get_protocol())
		{
			case 'smtp':
				$this->_recipients = $to;
			break;
			case 'sendmail':
			case 'mail':
				$this->_recipients = implode(', ', $to);
			break;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set CC
	 *
	 * @param	string
	 * @return	object
	 */
	public function cc($cc)
	{
		$cc = $this->clean_email($this->_str_to_array($cc));

		if ($this->validate)
		{
			$this->validate_email($cc);
		}

		$this->set_header('Cc', implode(', ', $cc));

		if ($this->_get_protocol() === 'smtp')
		{
			$this->_cc_array = $cc;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set BCC
	 *
	 * @param	string
	 * @param	string
	 * @return	object
	 */
	public function bcc($bcc, $limit = '')
	{
		if ($limit !== '' && is_numeric($limit))
		{
			$this->bcc_batch_mode = TRUE;
			$this->bcc_batch_size = $limit;
		}

		$bcc = $this->clean_email($this->_str_to_array($bcc));

		if ($this->validate)
		{
			$this->validate_email($bcc);
		}

		if ($this->_get_protocol() === 'smtp' OR ($this->bcc_batch_mode && count($bcc) > $this->bcc_batch_size))
		{
			$this->_bcc_array = $bcc;
		}
		else
		{
			$this->set_header('Bcc', implode(', ', $bcc));
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Email Subject
	 *
	 * @param	string
	 * @return	object
	 */
	public function subject($subject)
	{
		$subject = $this->_prep_q_encoding($subject);
		$this->set_header('Subject', $subject);
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Body
	 *
	 * @param	string
	 * @return	object
	 */
	public function message($body)
	{
		$this->_body = rtrim(str_replace("\r", '', $body));

		/* strip slashes only if magic quotes is ON
		   if we do it with magic quotes OFF, it strips real, user-inputted chars.

		   NOTE: In PHP 5.4 get_magic_quotes_gpc() will always return 0 and
			 it will probably not exist in future versions at all.
		*/
		if ( ! is_php('5.4') && get_magic_quotes_gpc())
		{
			$this->_body = stripslashes($this->_body);
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Assign file attachments
	 *
	 * @param	string
	 * @return	object
	 */
	public function attach($filename, $disposition = '', $newname = NULL, $mime = '')
	{
		$this->_attach_name[] = array($filename, $newname);
		$this->_attach_disp[] = empty($disposition) ? 'attachment' : $disposition; // Can also be 'inline'  Not sure if it matters
		$this->_attach_type[] = $mime;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Add a Header Item
	 *
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function set_header($header, $value)
	{
		$this->_headers[$header] = $value;
	}

	// --------------------------------------------------------------------

	/**
	 * Convert a String to an Array
	 *
	 * @param	string
	 * @return	array
	 */
	protected function _str_to_array($email)
	{
		if ( ! is_array($email))
		{
			return (strpos($email, ',') !== FALSE)
				? preg_split('/[\s,]/', $email, -1, PREG_SPLIT_NO_EMPTY)
				: (array) trim($email);
		}

		return $email;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Multipart Value
	 *
	 * @param	string
	 * @return	object
	 */
	public function set_alt_message($str = '')
	{
		$this->alt_message = (string) $str;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Mailtype
	 *
	 * @param	string
	 * @return	object
	 */
	public function set_mailtype($type = 'text')
	{
		$this->mailtype = ($type === 'html') ? 'html' : 'text';
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Wordwrap
	 *
	 * @param	bool
	 * @return	object
	 */
	public function set_wordwrap($wordwrap = TRUE)
	{
		$this->wordwrap = (bool) $wordwrap;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Protocol
	 *
	 * @param	string
	 * @return	object
	 */
	public function set_protocol($protocol = 'mail')
	{
		$this->protocol = in_array($protocol, $this->_protocols, TRUE) ? strtolower($protocol) : 'mail';
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Priority
	 *
	 * @param	int
	 * @return	object
	 */
	public function set_priority($n = 3)
	{
		$this->priority = preg_match('/^[1-5]$/', $n) ? (int) $n : 3;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Newline Character
	 *
	 * @param	string
	 * @return	object
	 */
	public function set_newline($newline = "\n")
	{
		$this->newline = in_array($newline, array("\n", "\r\n", "\r")) ? $newline : "\n";
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set CRLF
	 *
	 * @param	string
	 * @return	object
	 */
	public function set_crlf($crlf = "\n")
	{
		$this->crlf = ($crlf !== "\n" && $crlf !== "\r\n" && $crlf !== "\r") ? "\n" : $crlf;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Message Boundary
	 *
	 * @return	void
	 */
	protected function _set_boundaries()
	{
		$this->_alt_boundary = 'B_ALT_'.uniqid(''); // multipart/alternative
		$this->_atc_boundary = 'B_ATC_'.uniqid(''); // attachment boundary
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Message ID
	 *
	 * @return	string
	 */
	protected function _get_message_id()
	{
		$from = str_replace(array('>', '<'), '', $this->_headers['Return-Path']);
		return '<'.uniqid('').strstr($from, '@').'>';
	}

	// --------------------------------------------------------------------

	/**
	 * Get Mail Protocol
	 *
	 * @param	bool
	 * @return	mixed
	 */
	protected function _get_protocol($return = TRUE)
	{
		$this->protocol = strtolower($this->protocol);
		in_array($this->protocol, $this->_protocols, TRUE) OR $this->protocol = 'mail';

		if ($return === TRUE)
		{
			return $this->protocol;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Mail Encoding
	 *
	 * @param	bool
	 * @return	string
	 */
	protected function _get_encoding($return = TRUE)
	{
		in_array($this->_encoding, $this->_bit_depths) OR $this->_encoding = '8bit';

		foreach ($this->_base_charsets as $charset)
		{
			if (strpos($charset, $this->charset) === 0)
			{
				$this->_encoding = '7bit';
			}
		}

		if ($return === TRUE)
		{
			return $this->_encoding;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get content type (text/html/attachment)
	 *
	 * @return	string
	 */
	protected function _get_content_type()
	{
		if ($this->mailtype === 'html')
		{
			return (count($this->_attach_name) === 0) ? 'html' : 'html-attach';
		}
		elseif	($this->mailtype === 'text' && count($this->_attach_name) > 0)
		{
			return 'plain-attach';
		}
		else
		{
			return 'plain';
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set RFC 822 Date
	 *
	 * @return	string
	 */
	protected function _set_date()
	{
		$timezone = date('Z');
		$operator = ($timezone[0] === '-') ? '-' : '+';
		$timezone = abs($timezone);
		$timezone = floor($timezone/3600) * 100 + ($timezone % 3600) / 60;

		return sprintf('%s %s%04d', date('D, j M Y H:i:s'), $operator, $timezone);
	}

	// --------------------------------------------------------------------

	/**
	 * Mime message
	 *
	 * @return	string
	 */
	protected function _get_mime_message()
	{
		return 'This is a multi-part message in MIME format.'.$this->newline.'Your email application may not support this format.';
	}

	// --------------------------------------------------------------------

	/**
	 * Validate Email Address
	 *
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
	 * @param	string
	 * @return	bool
	 */
	public function valid_email($email)
	{
		return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	// --------------------------------------------------------------------

	/**
	 * Clean Extended Email Address: Joe Smith <joe@smith.com>
	 *
	 * @param	string
	 * @return	string
	 */
	public function clean_email($email)
	{
		if ( ! is_array($email))
		{
			return preg_match('/\<(.*)\>/', $email, $match) ? $match[1] : $email;
		}

		$clean_email = array();

		foreach ($email as $addy)
		{
			$clean_email[] = preg_match('/\<(.*)\>/', $addy, $match) ? $match[1] : $addy;
		}

		return $clean_email;
	}

	// --------------------------------------------------------------------

	/**
	 * Build alternative plain text message
	 *
	 * This public function provides the raw message for use
	 * in plain-text headers of HTML-formatted emails.
	 * If the user hasn't specified his own alternative message
	 * it creates one by stripping the HTML
	 *
	 * @return	string
	 */
	protected function _get_alt_message()
	{
		if ($this->alt_message !== '')
		{
			return $this->word_wrap($this->alt_message, '76');
		}

		$body = preg_match('/\<body.*?\>(.*)\<\/body\>/si', $this->_body, $match) ? $match[1] : $this->_body;
		$body = str_replace("\t", '', preg_replace('#<!--(.*)--\>#', '', trim(strip_tags($body))));

		for ($i = 20; $i >= 3; $i--)
		{
			$body = str_replace(str_repeat("\n", $i), "\n\n", $body);
		}

		return $this->word_wrap($body, 76);
	}

	// --------------------------------------------------------------------

	/**
	 * Word Wrap
	 *
	 * @param	string
	 * @param	int
	 * @return	string
	 */
	public function word_wrap($str, $charlim = '')
	{
		// Se the character limit
		if ($charlim === '')
		{
			$charlim = ($this->wrapchars === '') ? 76 : $this->wrapchars;
		}

		// Reduce multiple spaces
		$str = preg_replace('| +|', ' ', $str);

		// Standardize newlines
		if (strpos($str, "\r") !== FALSE)
		{
			$str = str_replace(array("\r\n", "\r"), "\n", $str);
		}

		// If the current word is surrounded by {unwrap} tags we'll
		// strip the entire chunk and replace it with a marker.
		$unwrap = array();
		if (preg_match_all('|(\{unwrap\}.+?\{/unwrap\})|s', $str, $matches))
		{
			for ($i = 0, $c = count($matches[0]); $i < $c; $i++)
			{
				$unwrap[] = $matches[1][$i];
				$str = str_replace($matches[1][$i], '{{unwrapped'.$i.'}}', $str);
			}
		}

		// Use PHP's native public function to do the initial wordwrap.
		// We set the cut flag to FALSE so that any individual words that are
		// too long get left alone. In the next step we'll deal with them.
		$str = wordwrap($str, $charlim, "\n", FALSE);

		// Split the string into individual lines of text and cycle through them
		$output = '';
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
			do
			{
				// If the over-length word is a URL we won't wrap it
				if (preg_match('!\[url.+\]|://|wwww.!', $line))
				{
					break;
				}

				// Trim the word down
				$temp .= substr($line, 0, $charlim-1);
				$line = substr($line, $charlim-1);
			}
			while (strlen($line) > $charlim);

			// If $temp contains data it means we had to split up an over-length
			// word into smaller chunks so we'll add it back to our current line
			if ($temp !== '')
			{
				$output .= $temp.$this->newline;
			}

			$output .= $line.$this->newline;
		}

		// Put our markers back
		if (count($unwrap) > 0)
		{
			foreach ($unwrap as $key => $val)
			{
				$output = str_replace('{{unwrapped'.$key.'}}', $val, $output);
			}
		}

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Build final headers
	 *
	 * @return	string
	 */
	protected function _build_headers()
	{
		$this->set_header('X-Sender', $this->clean_email($this->_headers['From']));
		$this->set_header('X-Mailer', $this->useragent);
		$this->set_header('X-Priority', $this->_priorities[$this->priority - 1]);
		$this->set_header('Message-ID', $this->_get_message_id());
		$this->set_header('Mime-Version', '1.0');
	}

	// --------------------------------------------------------------------

	/**
	 * Write Headers as a string
	 *
	 * @return	void
	 */
	protected function _write_headers()
	{
		if ($this->protocol === 'mail')
		{
			$this->_subject = $this->_headers['Subject'];
			unset($this->_headers['Subject']);
		}

		reset($this->_headers);
		$this->_header_str = '';

		foreach ($this->_headers as $key => $val)
		{
			$val = trim($val);

			if ($val !== '')
			{
				$this->_header_str .= $key.': '.$val.$this->newline;
			}
		}

		if ($this->_get_protocol() === 'mail')
		{
			$this->_header_str = rtrim($this->_header_str);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Build Final Body and attachments
	 *
	 * @return	void
	 */
	protected function _build_message()
	{
		if ($this->wordwrap === TRUE && $this->mailtype !== 'html')
		{
			$this->_body = $this->word_wrap($this->_body);
		}

		$this->_set_boundaries();
		$this->_write_headers();

		$hdr = ($this->_get_protocol() === 'mail') ? $this->newline : '';
		$body = '';

		switch ($this->_get_content_type())
		{
			case 'plain' :

				$hdr .= 'Content-Type: text/plain; charset='.$this->charset.$this->newline
					.'Content-Transfer-Encoding: '.$this->_get_encoding();

				if ($this->_get_protocol() === 'mail')
				{
					$this->_header_str .= $hdr;
					$this->_finalbody = $this->_body;
				}
				else
				{
					$this->_finalbody = $hdr . $this->newline . $this->newline . $this->_body;
				}

				return;

			case 'html' :

				if ($this->send_multipart === FALSE)
				{
					$hdr .= 'Content-Type: text/html; charset='.$this->charset.$this->newline
						.'Content-Transfer-Encoding: quoted-printable';
				}
				else
				{
					$hdr .= 'Content-Type: multipart/alternative; boundary="'.$this->_alt_boundary.'"'.$this->newline.$this->newline;

					$body .= $this->_get_mime_message().$this->newline.$this->newline
						.'--'.$this->_alt_boundary.$this->newline

						.'Content-Type: text/plain; charset='.$this->charset.$this->newline
						.'Content-Transfer-Encoding: '.$this->_get_encoding().$this->newline.$this->newline
						.$this->_get_alt_message().$this->newline.$this->newline.'--'.$this->_alt_boundary.$this->newline

						.'Content-Type: text/html; charset='.$this->charset.$this->newline
						.'Content-Transfer-Encoding: quoted-printable'.$this->newline.$this->newline;
				}

				$this->_finalbody = $body.$this->_prep_quoted_printable($this->_body).$this->newline.$this->newline;


				if ($this->_get_protocol() === 'mail')
				{
					$this->_header_str .= $hdr;
				}
				else
				{
					$this->_finalbody = $hdr.$this->_finalbody;
				}


				if ($this->send_multipart !== FALSE)
				{
					$this->_finalbody .= '--'.$this->_alt_boundary.'--';
				}

				return;

			case 'plain-attach' :

				$hdr .= 'Content-Type: multipart/'.$this->multipart.'; boundary="'.$this->_atc_boundary.'"'.$this->newline.$this->newline;

				if ($this->_get_protocol() === 'mail')
				{
					$this->_header_str .= $hdr;
				}

				$body .= $this->_get_mime_message().$this->newline.$this->newline
					.'--'.$this->_atc_boundary.$this->newline

					.'Content-Type: text/plain; charset='.$this->charset.$this->newline
					.'Content-Transfer-Encoding: '.$this->_get_encoding().$this->newline.$this->newline

					.$this->_body.$this->newline.$this->newline;

			break;
			case 'html-attach' :

				$hdr .= 'Content-Type: multipart/'.$this->multipart.'; boundary="'.$this->_atc_boundary.'"'.$this->newline.$this->newline;

				if ($this->_get_protocol() === 'mail')
				{
					$this->_header_str .= $hdr;
				}

				$body .= $this->_get_mime_message().$this->newline.$this->newline
					.'--'.$this->_atc_boundary.$this->newline

					.'Content-Type: multipart/alternative; boundary="'.$this->_alt_boundary.'"'.$this->newline.$this->newline
					.'--'.$this->_alt_boundary.$this->newline

					.'Content-Type: text/plain; charset='.$this->charset.$this->newline
					.'Content-Transfer-Encoding: '.$this->_get_encoding().$this->newline.$this->newline
					.$this->_get_alt_message().$this->newline.$this->newline.'--'.$this->_alt_boundary.$this->newline

					.'Content-Type: text/html; charset='.$this->charset.$this->newline
					.'Content-Transfer-Encoding: quoted-printable'.$this->newline.$this->newline

					.$this->_prep_quoted_printable($this->_body).$this->newline.$this->newline
					.'--'.$this->_alt_boundary.'--'.$this->newline.$this->newline;

			break;
		}

		$attachment = array();
		for ($i = 0, $c = count($this->_attach_name), $z = 0; $i < $c; $i++)
		{
			$filename = $this->_attach_name[$i][0];
			$basename = is_null($this->_attach_name[$i][1]) ? basename($filename) : $this->_attach_name[$i][1];
			$ctype = $this->_attach_type[$i];
			$file_content = '';

			if ($this->_attach_type[$i] === '')
			{
				if ( ! file_exists($filename))
				{
					$this->_set_error_message('lang:email_attachment_missing', $filename);
					return FALSE;
				}

				$file = filesize($filename) +1;

				if ( ! $fp = fopen($filename, FOPEN_READ))
				{
					$this->_set_error_message('lang:email_attachment_unreadable', $filename);
					return FALSE;
				}

				$ctype = $this->_mime_types(pathinfo($filename, PATHINFO_EXTENSION));
				$file_content = fread($fp, $file);
				fclose($fp);
			}
			else
			{
				$file_content =& $this->_attach_content[$i];
			}

			$attachment[$z++] = '--'.$this->_atc_boundary.$this->newline
				.'Content-type: '.$ctype.'; '
				.'name="'.$basename.'"'.$this->newline
				.'Content-Disposition: '.$this->_attach_disp[$i].';'.$this->newline
				.'Content-Transfer-Encoding: base64'.$this->newline;

			$attachment[$z++] = chunk_split(base64_encode($file_content));
		}

		$body .= implode($this->newline, $attachment).$this->newline.'--'.$this->_atc_boundary.'--';
		$this->_finalbody = ($this->_get_protocol() === 'mail') ? $body : $hdr.$body;
		return;
	}

	// --------------------------------------------------------------------

	/**
	 * Prep Quoted Printable
	 *
	 * Prepares string for Quoted-Printable Content-Transfer-Encoding
	 * Refer to RFC 2045 http://www.ietf.org/rfc/rfc2045.txt
	 *
	 * @param	string
	 * @param	int
	 * @return	string
	 */
	protected function _prep_quoted_printable($str, $charlim = '')
	{
		// Set the character limit
		// Don't allow over 76, as that will make servers and MUAs barf
		// all over quoted-printable data
		if ($charlim === '' OR $charlim > 76)
		{
			$charlim = 76;
		}

		// Reduce multiple spaces & remove nulls
		$str = preg_replace(array('| +|', '/\x00+/'), array(' ', ''), $str);

		// Standardize newlines
		if (strpos($str, "\r") !== FALSE)
		{
			$str = str_replace(array("\r\n", "\r"), "\n", $str);
		}

		// We are intentionally wrapping so mail servers will encode characters
		// properly and MUAs will behave, so {unwrap} must go!
		$str = str_replace(array('{unwrap}', '{/unwrap}'), '', $str);

		$escape = '=';
		$output = '';

		foreach (explode("\n", $str) as $line)
		{
			$length = strlen($line);
			$temp = '';

			// Loop through each character in the line to add soft-wrap
			// characters at the end of a line " =\r\n" and add the newly
			// processed line(s) to the output (see comment on $crlf class property)
			for ($i = 0; $i < $length; $i++)
			{
				// Grab the next character
				$char = $line[$i];
				$ascii = ord($char);

				// Convert spaces and tabs but only if it's the end of the line
				if ($i === ($length - 1) && ($ascii === 32 OR $ascii === 9))
				{
					$char = $escape.sprintf('%02s', dechex($ascii));
				}
				elseif ($ascii === 61) // encode = signs
				{
					$char = $escape.strtoupper(sprintf('%02s', dechex($ascii)));  // =3D
				}

				// If we're at the character limit, add the line to the output,
				// reset our temp variable, and keep on chuggin'
				if ((strlen($temp) + strlen($char)) >= $charlim)
				{
					$output .= $temp.$escape.$this->crlf;
					$temp = '';
				}

				// Add the character to our temporary line
				$temp .= $char;
			}

			// Add our completed line to the output
			$output .= $temp.$this->crlf;
		}

		// get rid of extra CRLF tacked onto the end
		return substr($output, 0, strlen($this->crlf) * -1);
	}

	// --------------------------------------------------------------------

	/**
	 * Prep Q Encoding
	 *
	 * Performs "Q Encoding" on a string for use in email headers.  It's related
	 * but not identical to quoted-printable, so it has its own method
	 *
	 * @param	string
	 * @param	bool	set to TRUE for processing From: headers
	 * @return	string
	 */
	protected function _prep_q_encoding($str, $from = FALSE)
	{
		$str = str_replace(array("\r", "\n"), array('', ''), $str);

		// Line length must not exceed 76 characters, so we adjust for
		// a space, 7 extra characters =??Q??=, and the charset that we will add to each line
		$limit = 75 - 7 - strlen($this->charset);

		// these special characters must be converted too
		$convert = array('_', '=', '?');

		if ($from === TRUE)
		{
			$convert[] = ',';
			$convert[] = ';';
		}

		$output = '';
		$temp = '';

		for ($i = 0, $length = strlen($str); $i < $length; $i++)
		{
			// Grab the next character
			$char = $str[$i];
			$ascii = ord($char);

			// convert ALL non-printable ASCII characters and our specials
			if ($ascii < 32 OR $ascii > 126 OR in_array($char, $convert))
			{
				$char = '='.dechex($ascii);
			}

			// handle regular spaces a bit more compactly than =20
			if ($ascii === 32)
			{
				$char = '_';
			}

			// If we're at the character limit, add the line to the output,
			// reset our temp variable, and keep on chuggin'
			if ((strlen($temp) + strlen($char)) >= $limit)
			{
				$output .= $temp.$this->crlf;
				$temp = '';
			}

			// Add the character to our temporary line
			$temp .= $char;
		}

		// wrap each line with the shebang, charset, and transfer encoding
		// the preceding space on successive lines is required for header "folding"
		return trim(preg_replace('/^(.*)$/m', ' =?'.$this->charset.'?Q?$1?=', $output.$temp));
	}

	// --------------------------------------------------------------------

	/**
	 * Send Email
	 *
	 * @return	bool
	 */
	public function send()
	{
		if ($this->_replyto_flag === FALSE)
		{
			$this->reply_to($this->_headers['From']);
		}

		if ( ! isset($this->_recipients) && ! isset($this->_headers['To'])
			&& ! isset($this->_bcc_array) && ! isset($this->_headers['Bcc'])
			&& ! isset($this->_headers['Cc']))
		{
			$this->_set_error_message('lang:email_no_recipients');
			return FALSE;
		}

		$this->_build_headers();

		if ($this->bcc_batch_mode && count($this->_bcc_array) > $this->bcc_batch_size)
		{
			return $this->batch_bcc_send();
		}

		$this->_build_message();
		
		return $this->_spool_email();
	}

	// --------------------------------------------------------------------

	/**
	 * Batch Bcc Send. Sends groups of BCCs in batches
	 *
	 * @return	void
	 */
	public function batch_bcc_send()
	{
		$float = $this->bcc_batch_size - 1;
		$set = '';
		$chunk = array();

		for ($i = 0, $c = count($this->_bcc_array); $i < $c; $i++)
		{
			if (isset($this->_bcc_array[$i]))
			{
				$set .= ', '.$this->_bcc_array[$i];
			}

			if ($i === $float)
			{
				$chunk[] = substr($set, 1);
				$float += $this->bcc_batch_size;
				$set = '';
			}

			if ($i === $c-1)
			{
				$chunk[] = substr($set, 1);
			}
		}

		for ($i = 0, $c = count($chunk); $i < $c; $i++)
		{
			unset($this->_headers['Bcc']);

			$bcc = $this->clean_email($this->_str_to_array($chunk[$i]));

			if ($this->protocol !== 'smtp')
			{
				$this->set_header('Bcc', implode(', ', $bcc));
			}
			else
			{
				$this->_bcc_array = $bcc;
			}

			$this->_build_message();
			$this->_spool_email();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unwrap special elements
	 *
	 * @return	void
	 */
	protected function _unwrap_specials()
	{
		$this->_finalbody = preg_replace_callback('/\{unwrap\}(.*?)\{\/unwrap\}/si', array($this, '_remove_nl_callback'), $this->_finalbody);
	}

	// --------------------------------------------------------------------

	/**
	 * Strip line-breaks via callback
	 *
	 * @return	string
	 */
	protected function _remove_nl_callback($matches)
	{
		if (strpos($matches[1], "\r") !== FALSE OR strpos($matches[1], "\n") !== FALSE)
		{
			$matches[1] = str_replace(array("\r\n", "\r", "\n"), '', $matches[1]);
		}

		return $matches[1];
	}

	// --------------------------------------------------------------------

	/**
	 * Spool mail to the mail server
	 *
	 * @return	bool
	 */
	protected function _spool_email()
	{
		$this->_unwrap_specials();

		$method = '_send_with_'.$this->_get_protocol();
		if ( ! $this->$method())
		{
			$this->_set_error_message('lang:email_send_failure_'.($this->_get_protocol() === 'mail' ? 'phpmail' : $this->_get_protocol()));
			return FALSE;
		}

		$this->_set_error_message('lang:email_sent', $this->_get_protocol());
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Send using mail()
	 *
	 * @return	bool
	 */
	protected function _send_with_mail()
	{
		return wp_mail($this->_recipients, $this->_subject, $this->_finalbody, $this->_header_str);
	}

	// --------------------------------------------------------------------

	/**
	 * Send using Sendmail
	 *
	 * @return	bool
	 */
	protected function _send_with_sendmail()
	{
		return wp_mail($this->_recipients, $this->_subject, $this->_finalbody, $this->_header_str);
	}

	// --------------------------------------------------------------------

	/**
	 * Send using SMTP
	 *
	 * @return	bool
	 */
	protected function _send_with_smtp()
	{
		add_action('phpmailer_init',array(&$this,'_send_smtp'));
		return wp_mail($this->_recipients, $this->_subject, $this->_finalbody, $this->_header_str);
	}

	public function _send_smtp($phpmailer){

		$this->_phpmailer->Mailer = "smtp";
		//$this->_phpmailer->From = $this->_calibrefx->theme_settings_m->get('smtp_from_email');
		//$this->_phpmailer->FromName = $this->_calibrefx->theme_settings_m->get('smtp_from_name');
		//$this->_phpmailer->Sender = $this->_phpmailer->From; //Return-Path
		//$this->_phpmailer->AddReplyTo($this->_phpmailer->From,$this->_phpmailer->FromName); //Reply-To
		$this->_phpmailer->Host = $this->_calibrefx->theme_settings_m->get('smtp_host');
		$this->_phpmailer->SMTPSecure = $this->_calibrefx->theme_settings_m->get('smtp_secure');
		$this->_phpmailer->Port = $this->_calibrefx->theme_settings_m->get('smtp_port');
		$this->_phpmailer->SMTPAuth = ($this->_calibrefx->theme_settings_m->get('smtp_use_auth')=="yes") ? TRUE : FALSE;
		if($this->_phpmailer->SMTPAuth){
			$this->_phpmailer->Username = $this->_calibrefx->theme_settings_m->get('smtp_username');
			$this->_phpmailer->Password = $this->_calibrefx->theme_settings_m->get('smtp_password');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Hostname
	 *
	 * @return	string
	 */
	protected function _get_hostname()
	{
		return isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost.localdomain';
	}

	// --------------------------------------------------------------------

	/**
	 * Get IP
	 *
	 * @return	string
	 */
	protected function _get_ip()
	{
		if ($this->_IP !== FALSE)
		{
			return $this->_IP;
		}

		$cip = ( ! empty($_SERVER['HTTP_CLIENT_IP'])) ? $_SERVER['HTTP_CLIENT_IP'] : FALSE;
		$rip = ( ! empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : FALSE;
		if ($cip) $this->_IP = $cip;
		elseif ($rip) $this->_IP = $rip;
		else
		{
			$fip = ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : FALSE;
			if ($fip)
			{
				$this->_IP = $fip;
			}
		}

		if (strpos($this->_IP, ',') !== FALSE)
		{
			$x = explode(',', $this->_IP);
			$this->_IP = end($x);
		}

		if ( ! preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $this->_IP))
		{
			$this->_IP = '0.0.0.0';
		}

		return $this->_IP;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Debug Message
	 *
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

		return $msg.'<pre>'.$this->_header_str."\n".htmlspecialchars($this->_subject)."\n".htmlspecialchars($this->_finalbody).'</pre>';
	}

	// --------------------------------------------------------------------

	/**
	 * Set Message
	 *
	 * @param	string
	 * @return	void
	 */
	protected function _set_error_message($msg, $val = '')
	{
		$this->_debug_msg[] = $msg . ' : ' . $val;
	}

	// --------------------------------------------------------------------

	/**
	 * Mime Types
	 *
	 * @param	string
	 * @return	string
	 */
	protected function _mime_types($ext = '')
	{
		static $mimes;

		$ext = strtolower($ext);

		if ( ! is_array($mimes))
		{
			$mimes =& get_mimes();
		}

		if (isset($mimes[$ext]))
		{
			return is_array($mimes[$ext])
				? current($mimes[$ext])
				: $mimes[$ext];
		}

		return 'application/x-unknown-content-type';
	}
}