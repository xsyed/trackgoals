<?php
session_start();

require_once('../../config.php');
require 'Friend.class.php';

// FRIEND OBJECT
$frnd_obj = new Friend($pdo);