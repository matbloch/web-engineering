<?php


class ContactForm {
									 
	public function __construct() {
	
		/* init variables */
		$this->init();
	

	}
	
	/*------------------------------------*\
		INIT
	\*------------------------------------*/
	
	public function init(){
	
	}
	
	public function handle_contact_request() {
	
		if(empty($_POST) || empty($_POST['submit_request'])){
			return false;
		}

		$data = array();
		$required = array('firstname','lastname', 'message');
		
		// extract
		foreach($required as $keyname){
			if(empty($_POST[$keyname])){
				echo '<div class="feedback error">Please fill in all the fields.</div>';
				return;
			}
			$data[$keyname] = trim($_POST[$keyname]);
		}
		
		// send mail
		if($this->send_notification_mail($data)){
			echo '<div class="feedback success">Your message has been sucessfully sent.</div>';
		}else{
			echo '<div class="feedback error">An unknown error occured.</div>';
		}
		
	}
	
	private function send_notification_mail($data){
	/* send a mail to the administrator about a new request */
	
		$user = get_user_by( 'slug', 'admin' );
		$mail_to = $user->user_email;		// get the administrators email
		$mail_from = $user->user_email;
	
		$topic = "LaraJade - new contact request";
		$message = "
					<br><strong>Name:</strong> ".$data['firstname']." ".$data['lastname']."
					<br><strong>Message:</strong> ".$data['message']."
					
					<i>This message has been sent from the contact form of the Lara Jade Homepage.</i>";
					
		return $this->send_email($topic, $message, $mail_to, $mail_from);
	}
	
	private function send_email($topic, $message, $mail_to, $mail_from){
	
		$headers = "From: Lara Jade <" . $mail_from . ">\r\n";
		// $headers .= "Reply-To: ". $mail_from . "\r\n";
		// $headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html;";
		
		$message = '<html><body>'.$message.'</body></html>';
		add_filter('wp_mail_charset',create_function('', 'return \''.get_option('blog_charset').'\'; '));
		if (@wp_mail($mail_to, $topic, $message, $headers)){
			return true;
		}else{return false;}
	
	}
	/*------------------------------------*\
		DISPLAY FUNCTIONS
	\*------------------------------------*/
	
	public function display_contact_form(){
	?>
		<div class="row">
		<div class="col-6 padding-r-20">
			<form class="row clr-white" name="contact_form" action="#" method="post">
				<div class="padding-b-10"><label>First name:</label><input type="text" name="firstname" ></div>
				<div class="padding-b-10"><label>Lirst name:</label><input type="text" name="lastname" ></div>
				<textarea type="text" name="message" rows="7"></textarea>
				<br>
				<button  name="submit_request" value="submit_request" type="submit">Submit</button>
			</form>
		</div>
		<div class="col-6 padding-20 bg-clr-white-transp">
			<div >
				<strong >Email</strong><strong class="float-right"><?php echo get_theme_mod( 'contact_email', '' ); ?></strong>
				<br>
				<strong >Fax</strong><strong class="float-right"> <?php echo get_theme_mod( 'contact_phone', '' ); ?> </strong>
				<br>
				<strong >Address: <br></strong><strong> <?php echo get_theme_mod( 'contact_address', 'No contact address has been set yet.' ); ?>
				</strong>
			</div>
		</div>
		</div>
	<?php
	}
	

}
