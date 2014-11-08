<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mandrill
 *
 * @author lucho
 */
class Mandrill {

	private $json;
	private $key;
	private $template_name;
	private $template_content;
	private $message;
	private $async;
	private $ip_pool;
	private $send_at;

	public function __construct() {
		$this->message = new stdClass();
	}

	public function setTemplateName($templateName) {
		$this->template_name = $templateName;
	}

	public function setKey($key) {
		$this->key = $key;
	}

	public function setSubject($subject) {
		$this->message->subject = $subject;
	}

	public function setFromEmail($from_email) {
		$this->message->from_email = $from_email;
	}

	public function setFromName($from_name) {
		$this->message->from_name = $from_name;
	}

	public function setTrackOpens($track_opens) {
		$this->message->track_opens = $track_opens;
	}

	public function setTrackClicks($track_clicks) {
		$this->message->track_clicks = $track_clicks;
	}

	public function setAutoText($auto_text) {
		$this->message->auto_text = $auto_text;
	}

	public function setUrlStripQs($url_strip_qs) {
		$this->message->url_strip_qs = $url_strip_qs;
	}

	public function setPreserveRecipients($preserve_recipients) {
		$this->message->preserve_recipients = $preserve_recipients;
	}

	public function setViewContentLink($view_content_link) {
		$this->message->view_content_links = $view_content_link;
	}

	/*
	 * Set global_merge_vars
	 * @param array global_merge_vars (key = name, value = content)
	 */

	public function setGlobalMergeVars(array $global_merge_vars) {
		foreach ($global_merge_vars as $key => $value) {
			$var_global = new stdClass();
			$var_global->name = $key;
			$var_global->content = $value;
			$this->message->global_merge_vars[] = $var_global;
		}
	}

	/*
	 * Set merge_vars
	 * @param array merge_vars (email, array(key => name, key => name, key...))
	 */

	public function setMergeVars(array $merge_vars) {
		foreach ($merge_vars as $key => $value) {
			$var_merge = new stdClass();
			$var_merge->rcpt = $value[0];
			foreach ($value[1] as $keyNew => $valueNew) {
				$vars = new stdClass();
				$vars->name = $keyNew;
				$vars->content = $valueNew;
				$var_merge->vars[] = $vars;
			}
			$this->message->merge_vars[] = $var_merge;
		}
	}

	/*
	 * Set users
	 * @param array $users (key = email, value = name)
	 */

	public function setTo(array $users) {
		foreach ($users as $key => $value) {
			$to = new stdClass();
			$to->email = $key;
			$to->name = $value;
			$this->message->to[] = $to;
		}
	}

	/*
	 * An array of string to tag
	 * Set tags
	 * @param array $tags
	 */

	public function setTag(array $tags) {
		$this->message->tags = $tags;
	}

	/*
	 * An array of stdClass
	 * Set images
	 * images->type = mimeType of image;
	 * images->name = Contstant Mandrill Example: "IMAGE_NEW";
	 * images->content = base64_encode(img);
	 */

	public function setImages(array $images) {
		foreach ($images as $image) {
			$this->message->images[] = $image;
		}
	}

	/*
	 * An array of stdClass
	 * Set images
	 * attachment[]->type = mimeType of file;
	 * attachment[]->name = Name attachment, Example "attachment.pdf"
	 * attachment[]->content = base64_encode(file);
	 */

	public function setAttachments(array $attachments) {
		foreach ($attachments as $attachment) {
			$this->message->attachments[] = $attachment;
		}
	}

	/*
	 * Return JSON
	 * @param json Mandrill
	 */

	public function getJson() {
		$this->json = new stdClass();
		$this->json->key = $this->key;
		$this->json->template_name = $this->template_name;
		$this->json->message = $this->message;

		return json_encode($this->json);
	}

	/*
	 * Return JSON
	 * @param json about send
	 */

	function sendEmail($jsonEmail) {
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, 'http://nsemail.nettingbt.com/api.php');
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('data' => $jsonEmail));
		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);
		//echo $buffer;
	}

}