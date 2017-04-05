<?php
		session_start();
        if(isset($_SESSION['usrname']))
        {
            unset($_SESSION['usrname']);
        }
        echo '<h1>You have been successfully logout</h1>';
        // Jump to login page
		header('Location: LoginPage.html');
?>