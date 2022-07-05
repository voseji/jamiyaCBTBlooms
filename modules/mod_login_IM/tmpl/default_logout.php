<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form" class="form-vertical">
<?php if ($params->get('greeting', 1)) : ?>
	<div class="login-greeting">
	<?php if ($params->get('name') == 0) : {
		echo "<p style='font-size:16px; text-transform:uppercase; color:black; font-weight:bold;'>Candidate Name: <br/>". JText::sprintf(htmlspecialchars($user->get('name'))); echo "</p>";
	$reg_number=$user->get('username');
		echo "<p style='font-size:16px; color:green; font-weight:bold;'>Registration Number: ".JText::sprintf( htmlspecialchars($reg_number)); echo "</p>";
	} endif; ?>
	<?php echo "Passport"; 
	
	$con=mysqli_connect("127.0.0.1","root","","jarps");
	// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	  $query = "SELECT candidates.*, files.url
	  FROM candidates 
	  JOIN files ON files.special=candidates.special
	  WHERE candidates.id='".$reg_number."'";
	  $result=mysqli_query($con,$query);
	  $row=mysqli_fetch_assoc($result);
	  $url=$row["url"];
	
	//echo $reg_number;

	?><br/>
	<img src="images/passport/<?php echo $url; ?>" width="100px"/>
<?php endif; ?>
	<div class="logout-button">
		<input type="submit" name="Submit" class="btn btn-primary" value="<?php echo JText::_('JLOGOUT'); ?>" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
