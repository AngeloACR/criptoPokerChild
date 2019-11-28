<?php 
/* Template Name: criptoStatus */
	$meta_key1 = 'cashOutStat';
	$meta_key2 = 'submissionDate';
	$user = wp_get_current_user(); 
	$userStatus = get_user_meta( $user->id, $meta_key1, true );
	$date = get_user_meta( $user->id, $meta_key2, true );
?>
<p style="text-align: center;">Your request may take a while to appear</p><br>
<ul style="width: 50%; margin: 0 auto;">
	<li class="cashCont bigBox">
		<div id="dStatus" class="cashElem"><h4><b>Date</b></h4></div>
		<div id="username" class="cashElem"><h4><b>Username</b></h4></div>
		<div id="cStatus" class="cashElem"><h4><b>Cashout Status</b></h4></div>
	</li>
	<div class="bigBox">
		<li class="cashCont">
	

			<div class="cashElem">
				<p><?php echo $date; ?></p>
			</div>
			<div class="cashElem">
				<p><?php echo $user->user_login; ?></p>
			</div>
			<div class="cashElem">
				<p><?php echo $userStatus; ?></p>
			</div>
		</li>
	</div>
</ul>

<style>
	.cashCont{
	display: flex;
	flex-direction: row;
	justify-content: center;
	align-items: center;
	margin-bottom: 0 !important;
}

.bigBox{	
	border-width: 1px;
	border-style: solid;
	border-color: grey;
}

.cashElem{
	display: flex;
	width: 30%;
	margin-right: 10px;
	margin-left: 10px;
	height: 50px;
	align-items: center;
}

.cashElem p{
	margin: 0;
	padding: 0;
}

.cashElem select{
	margin: 0;
	padding: 0;
}

.cashElem .submit{
	margin: 0;
	padding: 0;
}

ul.usersList{
	width: 90% !important;
	margin: 0 auto;
}

</style>