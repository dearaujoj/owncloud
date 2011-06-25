<?php
if(!isset($_)){//also provide standalone error page
	require_once '../../lib/base.php';
	require( 'template.php' );
	
	$tmpl = new OC_TEMPLATE( '', '404', 'guest' );
	$tmpl->printPage();
	exit;
}
?>
<div id="login">
	<img src="<?php echo image_path("", "weather-clear.png"); ?>" alt="ownCloud" />
	<ul>
		<li class='error'>
			<?php echo $l->t( 'Error 404, Cloud not found' ); ?><br/>
			<p class='hint'><?php if(isset($_['file'])) echo $_['file']?></p>
		</li>
	</ul>
</div>