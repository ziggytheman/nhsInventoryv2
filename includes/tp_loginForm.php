<?php

/* 		INCLUDE FILE:   tp_loginForm.php
 *
 * 		folder:			includes/
 *
 * 		used in:        index.php
 *
 * 	===========================================================================
 */

include('includes/variable_initialization.php');
echo '<p>Login Form NHI</p>';

echo '<form name="postLoginHid" action="index.php" method="post">';
echo '<p><label class="field" for="username">User name:</label> 
	<INPUT TYPE=text class="input_text" NAME=username value="" SIZE=12 MAXLENGTH=16></p>
        
	<p><label class="field" for="password">Password:</label> 
	<INPUT TYPE=password class="input_text" NAME=password value="" SIZE=12 MAXLENGTH=16></p>
	<input type="submit"  value="Login" />';
echo '</form>';
?>