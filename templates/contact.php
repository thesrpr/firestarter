<?php
/*
Template Name: Contact
*/
?>
<?php 
	global $post; 
	if(isset($_POST['submitted'])) {
	if(trim($_POST['contactName']) === '') {
		$nameError = 'Please enter your name.';
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}

	if(trim($_POST['email']) === '')  {
		$emailError = 'Please enter your email address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	if(trim($_POST['comments']) === '') {
		$commentError = 'Please enter a message.';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}
	
	$mgmt_contact = get_post_meta( $post->ID, '_srpr_mgmt_contact', true ); 
	$booking_contact = get_post_meta( $post->ID, '_srpr_booking_contact', true ); 
	$press_contact = get_post_meta( $post->ID, '_srpr_press_contact', true ); 
	$web_contact = get_post_meta( $post->ID, '_srpr_web_contact', true ); 
	
	if(!isset($hasError)) {
		$recipients = array(
			'management' => ''.$mgmt_contact.'', 
			'booking' => ''.$booking_contact.'', 
			'press' => ''.$press_contact.'', 
			'web' => ''.$web_contact.''
			
		);
	
		$emailTo = $recipients[$_REQUEST['recipient']];
		$subject = '[Website Contact Form] From '.$name;
		$body = "$comments";
		$headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;

		wp_mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}
		
} ?>
<?php get_header();?>
<section id="sitewrap" role="document">
	<section id="content" role="main">	
		<?php if(isset($emailSent) && $emailSent == true) { ?>
			<div class="alert-box success">
				<?php _e('Thanks, your email was sent successfully', 'thesrpr');?>
				<a href="<?php echo home_url(); ?>" class="close"><i class="icon-close"></i></a>
			</div>
		<?php } else { ?>
			<?php if(isset($hasError)) { ?>
				<h1><?php _e('Oops. We have a problem. See error(s) below.', 'thesrpr');?></h1>
			<?php } ?>							
			<?php if($nameError != '') { ?><div class="alert-box alert"><?php echo ($nameError);?></div><?php } ?>
			<?php if($emailError != '') { ?><div class="alert-box alert"><?php echo($emailError);?></div><?php } ?>
			<?php if($commentError != '') { ?><div class="alert-box alert"><?php echo($commentError);?></div>
			<?php } ?>
		<?php } ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
				<?php get_template_part('content', get_post_format()); ?>
				
				<form action="<?php echo esc_url( get_permalink(get_page_by_title('Contact'))); ?>" id="contactForm" method="post" class="custom">
					<label for="Recipient"><?php _e('Who Would You Like to Contact?', 'thesrpr');?></label>
					<select name="recipient" class="expand" style="display:none;" id="customDropdown">  
						<option value="management"><?php _e('Management', 'thesrpr');?></option> 
						<option value="booking"><?php _e('Booking?', 'thesrpr');?></option> 								
						<option value="press"><?php _e('Press', 'thesrpr');?></option> 
						<option value="web"><?php _e('Web/Technical', 'thesrpr');?></option> 
					</select>
					<input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required" placeholder="name" />		
					<input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required email" placeholder="email" />
					<textarea name="comments" id="commentsText" rows="10" class="required" placeholder="message"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
			
					<button type="submit" class="secondary button"><i class="icon-envelope-alt"></i><?php _e('Get In Touch', 'thesrpr');?></button>
					<input type="hidden" name="submitted" id="submitted" value="true" />
				</form>

			</article>
		<?php endwhile; endif; ?>	
	</section><!--  content -->	
<section role="complementary"><?php get_sidebar(); ?></section>
</section>
<?php get_footer();?>
