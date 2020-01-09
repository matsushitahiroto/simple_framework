<?php
ini_set('display_errors', 0);
ini_set('date.timezone', 'Asia/Tokyo');
ini_set('error_reporting', E_ALL);
ini_set('log_errors', 'Off');
ini_set('error_log', '/log/error.log');
ini_set('default_charset', 'UTF-8');
ini_set('mbstring.language', 'Japanese');
ini_set('session.cookie_httponly', 1);

const SITE_URL = 'http://localhost:8080/simple_framework/public/index.php';
const CSS_URL = 'http://localhost:8080/simple_framework/public/example.css';
const PREFIX = 'App\\';
const APP_PATH = '../app/';
const CONTROLLER_PATH = 'App\\Controller\\';
const VIEWS_PATH = '../resources/views/';
const ERROR_PATH = '../resources/errors/';
