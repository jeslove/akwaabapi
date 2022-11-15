<?php 
namespace core\Sendmail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMail
{
	private  $mails;

	public function __construct()
	{
		$this->mails = new PHPMailer(true);
	}

	public function RenderMailPost($address,$subject,$message,$logo)
	{
		switch (USERCASE) {
			case 'Localhost':
				$this->UseLocalPost();
				$this->MailPost($address,$subject,$message,$logo);
			break;

			case 'Live':
				$this->MailPost($address,$subject,$message,$logo);
			break;
			
			default:
			  echo json_encode(['status'=>'error','response'=>'Please set the route to post mail in the config file']);
			break;
		}
	}


	public function RenderMailAttachment($address,$subject,$message,$logo,$attach)
	{
		switch (USERCASE) {
			case 'Localhost':
				$this->UseLocalPost();
				$this->MailAttachment($address,$subject,$message,$logo,$attach);
			break;

			case 'Live':
				$this->MailAttachment($address,$subject,$message,$logo,$attach);
			break;
			
			default:
			  echo json_encode(['status'=>'error','response'=>'Please set the route to post mail in the config file']);
			break;
		}
	}

	/** USING SMTP VIA LOCALHOST SERVE CONNECTION */
	private function UseLocalPost()
	{
		//Server settings
		$this->mails->isSMTP();                                           
		$this->mails->Host       = EMAIL_SMTP_HOST;                     
		$this->mails->SMTPAuth   = true;                                   
		$this->mails->Username   = EMAIL_SMTP_USERNAME;                     
		$this->mails->Password   = EMAIL_SMTP_PASSWORD;                               
		$this->mails->SMTPSecure = EMAIL_SECURITY_PORT;   
		$this->mails->Port       = EMAIL_SMTP_PORT;        
	}

	/** SEND MAIL WITHOUT ATTACHMENT */
	private function MailPost($address,$subject,$message,$logo)
	{
		try {
			//Recipients
			$this->mails->setFrom(SET_FROM_MAIL, SET_FROM);
			$this->mails->addAddress("$address"); 
			$this->mails->addReplyTo(SET_FROM_MAIL, 'Information');
		
			//Attachments
			$this->mails->addEmbeddedImage('api/images/'.$logo, 'logo');
		
			//Content
			$this->mails->isHTML(true); 
			$this->mails->Subject = $subject;
			$this->mails->Body    = $message;

			return ($this->mails->send()) ? true : false;
		} 
		catch (Exception $e)
		{
			echo json_encode(['status'=>'error','response'=>$this->mails->ErrorInfo]);
		}
	}

	/** SEND MAIL WITH ATTACHMENT */
	private function MailAttachment($address,$subject,$message,$logo,$attach)
	{
		try {
			//Recipients
			$this->mails->setFrom(SET_FROM_MAIL, SET_FROM);
			$this->mails->addAddress("$address"); 
			$this->mails->addReplyTo(SET_FROM_MAIL, 'Information');
		
			//Attachments
			$this->mails->addAttachment('api/attachment/'.$attach);         //Add attachments
			$this->mails->addEmbeddedImage('api/images/'.$logo, 'logo');
		
			//Content
			$this->mails->isHTML(true);
			$this->mails->Subject = $subject;
			$this->mails->Body    = $message;
			
			return ($this->mails->send()) ? true : false;
		} 
		catch (Exception $e)
		{
			echo json_encode(['status'=>'error','response'=>$this->mails->ErrorInfo]);
		}
	}
}