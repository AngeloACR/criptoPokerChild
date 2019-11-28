<?php

add_action( 'admin_menu', 'cripto_menu' );

function cripto_menu() {
 
    add_users_page(
		'Cash Out Status',
		'Manage Cash Out',
		'edit_users',
		'manage_status_handler',
		'cripto_options'
    );
}

function cripto_options() {
	if ( !current_user_can( 'edit_users' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>	<div class="wrap">
		<h1>Cash Out Manager</h1>
		<?php

	// Create the WP_User_Query object
	$wp_user_query = new WP_User_Query(array('role' => 'Subscriber'));

	// Get the results
	$users = $wp_user_query->get_results();

	$meta_key1 = 'cashOutStat';
	$meta_key2 = 'submissionDate';

	// Check for results
	if (!empty($users)) {
		?>		
		
		<ul class="usersList">
			<li class="cashCont bigBox">
				<div id="dStatus" class="cashElem"><h4><b>Date</b></h4></div>
				<div id="username" class="cashElem"><h4><b>Username</b></h4></div>
				<div id="cStatus" class="cashElem"><h4><b>Cashout Status</b></h4></div>
				<div id="sStatus" class="cashElem"><h4><b>Select Status</b></h4></div>
				<div id="aStatus" class="cashElem"><h4><b>Actions</b></h4></div>
			</li>
			<div class="bigBox">
		
		<?php  		

    // loop trough each author
	    foreach ($users as $user) {

	        $userStatus = get_user_meta( $user->id, $meta_key1, true );
	        $date = get_user_meta( $user->id, $meta_key2, true );
			?>
			<form action="<?php echo admin_url( 'admin-post.php' ); ?>">
				<input type="hidden" name="action" value="criptoAction">
				<li class="cashCont">
							
					<div class="cashElem">
						<p><?php echo $date; ?></p>
					</div>
					<div class="cashElem">
					<input type="hidden" name="userId" value=<?php echo $user->id; ?>>
						<p><?php echo $user->user_login; ?></p>
					</div>
					<div class="cashElem">
						<p><?php echo $userStatus; ?></p>
					</div>
					<div class="cashElem">
						<select name="cashStatus">
							<option value="Pending">Pending</option>
							<option value="Done">Done</option>
						</select>
					</div>
					<div class="cashElem">
						<?php submit_button( 'Update' ); ?>
					</div>	
				</li>
			</form>
			<?php
	    }?>
			</div>
	    </ul>
		<?php 
				
	} else {  ?>
		<div class="bigBox" style="text-align: center;">
			<h2>There are no users registered yet. Spread the voice and bring some members to the club!</h2>
		</div>
		<?php
	}?>
	</div>
	<?php
}

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
	?>
	<link rel="stylesheet" type="text/css" href="/wp-content/themes/divi-child/criptoaction.css">
	<?php
}

add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {

	$meta_key1 = 'cashOutStat';
	$meta_value1 = 'Not requested';
    add_user_meta($user_id, $meta_key1, $meta_value1, false);

	$meta_key2 = 'submissionDate';
	$meta_value2 = current_time( 'Y-m-d', $gmt = 0 );

    add_user_meta($user_id, $meta_key2, $meta_value2, false);

}

function my_login_redirect( $url, $request, $user ){
	if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
		if( $user->has_cap( 'administrator') or $user->has_cap( 'author')) {
			$url = admin_url();
		} else {
			$url = home_url();
		}
	}
return $url;
}
add_filter('login_redirect', 'my_login_redirect', 10, 3 );

add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
wp_redirect( home_url() );
exit();
wp_redirect($_SERVER['HTTP_REFERER']);
}

add_action( 'admin_post_criptoAction', 'updateUser' );

function updateUser() {
    if ( isset ( $_GET['userId'] ) ){
        $userId = $_GET['userId'] ;
    }

    if ( isset ( $_GET['cashStatus'] ) ){
        $status = $_GET['cashStatus'] ;
    }

    $meta_key1 = 'cashOutStat';

    update_user_meta($userId, $meta_key1, $status);

    $meta_key2 = 'submissionDate';

	$time = current_time( 'Y-m-d', $gmt = 0 );

    update_user_meta($userId, $meta_key2, $time);

    wp_safe_redirect(
    // Sanitize.
	    esc_url(
	        // Retrieves the site url for the current site.
	        site_url( '/wp-admin/users.php?page=manage_status_handler' )
	    )
	);

	exit();

}

function criptoShort() {
    ob_start();
    get_template_part('criptoStatus');
    return ob_get_clean();   
} 
add_shortcode( 'cripto_short', 'criptoShort' );