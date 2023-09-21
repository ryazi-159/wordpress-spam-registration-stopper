//Email Check for Spammers
add_filter( 'registration_errors', 'disable_user_registration_for_email_domain', 10, 3 );
function disable_user_registration_for_email_domain ( $errors, $sanitized_user_login, $user_email ) {
	// only if it's an email address at all 
	if ( ! is_email( $user_email ) ) {
		return $errors;
	}
	// get domain from email address
	$email_domain = substr( $user_email, strrpos( $user_email, '@' ) + 1 );
	$block_domains = [ // partial domain names allowed (doesn't need to include TLD for example)
		'mailbox.imailfree.cc',
	];
	foreach ( $block_domains as $domain_partial ) {
		if ( stripos( $email_domain, $domain_partial ) !== false ) {
			// throw registration error
			$errors->add( 'email_error', '<strong>ERROR</strong>: Registration not allowed.' );
		}
	}
	return $errors;
}
