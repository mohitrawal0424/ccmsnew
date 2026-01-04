<?php

function session($allowManager = 1, $redirect = 'dashboardproduct.php')
{
    session_start();
    if (isset($_SESSION['username'])) {
        $role = (int)$_SESSION['role'];
        if (!$allowManager) {
            if ($role === 1) {
                header('location:' . $redirect);
            }
        }
    } else {
        header('location: ../index.php');
    }
}

function session_timeout()
{
    if (time() - $_SESSION['logintime'] > 3600) { //subtract new timestamp from the old one
        unset($_SESSION['username'], $_SESSION['logintime']);
        header("Location:../index.php"); //redirect to index.php
        exit;
    } else {
        $_SESSION['logintime'] = time(); //set new timestamp
    }
}
