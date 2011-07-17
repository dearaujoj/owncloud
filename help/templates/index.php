
<h1><?php echo $l->t( 'Questions and Answers' ); ?></h1>

<?php if(is_null($_["kbe"])):?>
	Can't connect to Q&amp;A database
<?php else:?>
	<table cellspacing="0" width="100%">
		<tbody>
			<?php foreach($_["kbe"] as $kb): ?>
				<tr>
					<td width="1"><?php if($kb["preview1"] <> "") { echo('<img class="preview" border="0" src="'.$kb["preview1"].'" />'); } ?> </a></td>
					<td class="name"><?php echo $kb["name"]; ?><br /><?php  echo('<span class="type">'.$kb['description'].'</span>'); ?><br />
					<?php if($kb['answer']<>'') echo('<br /><span class="type"><b>Answer:</b></span><br /><span class="type">'.$kb['answer'].'</span>');?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
		$url=OC_HELPER::linkTo( "help", "index.php" ).'?page=';
		$pageNavi=OC_UTIL::getPageNavi($_['pagecount'],$_['page'],$url);
		$pageNavi->printPage();
	?>
	<a target="_blank" class="prettybutton" href="http://apps.owncloud.com/knowledgebase/editquestion.php?action=new"><?php echo $l->t( 'ASK A QUESTION' ); ?></a>
<?php endif;?>


