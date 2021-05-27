<?php

const VERSION = '1.0.5';

function getCommonSettings() {

    $version = VERSION;
    return array(
        'version' => VERSION,
        'title' => "Bodwell MYChild Portal (v{$version})",
        'hostName' => $_SERVER['SERVER_NAME'],
        'hostAddr' => $_SERVER['SERVER_ADDR'],
    );

}

function getEnvironmentSettings() {

    $version = VERSION;
    $hostName = $_SERVER['SERVER_NAME'];
    $scriptFileName = "mychild-portal-web-{$version}.js";
    $adminScriptName = "mychild-portal-admin-{$version}.js";
    $returnUrl = "";
    $backdoor = array(
        '45c0x:2|ch//',
    );

    switch($hostName) {

        case 'mychild.bodwell.edu':
            return array(
                'env' => 'production',
                'debug' => false,
                'basePath' => '/',
                'adminPath' => '/admin/',
                'returnUrl' => $returnUrl,
                'script' => '/assets/'.$scriptFileName,
                'adminScript' => '/assets/'.$adminScriptName,
                'apiPath' => "https://{$hostName}/api/index.php",
                'pdo' => array(
             
                ),
                'smtp' => array(
                    'debug' => false,
                    'host' => 'smtp.sendgrid.net',
                    'port' => '587',
                    'secure' => 'TLS',
                    'auth' => true,
                ),
                'backdoor' => $backdoor,
            );
        case 'dev.bodwell.edu':
            return array(
                'env' => 'staging',
                'debug' => true,
                'basePath' => '/mychild.bodwell.edu/',
                'adminPath' => '/mychild.bodwell.edu/?page=dashboard',
                'returnUrl' => $returnUrl,
                'script' => '/mychild.bodwell.edu/assets/'.$scriptFileName,
                'adminScript' => '/mychild.bodwell.edu/assets/'.$adminScriptName,
                'apiPath' => "http://{$hostName}/mychild.bodwell.edu/api/index.php",
                'adminApiPath' => "http://{$hostName}/mychild.bodwell.edu/api/index.php",
                'pdo' => array(
                ),
                'bypassAuth' => false,
                'smtp' => array(
                    'debug' => false,
                    'port' => '25',
                    'secure' => 'TLS',
                    'auth' => false,
                    'username' => '',
                    'password' => '',
                ),
                'backdoor' => $backdoor,
            );
        case 'localhost':
        return array(
            'env' => 'production',
            'debug' => true,
            'basePath' => '/mychild.bodwell.edu/',
            'adminPath' => '/?page=dashboard',
            'returnUrl' => $returnUrl,
            'script' => '/assets/'.$scriptFileName,
            'adminScript' => '/assets/'.$adminScriptName,
            'apiPath' => "http://{$hostName}/mychild.bodwell.edu/api/index.php",
            'adminApiPath' => "http://{$hostName}/api/index.php",
            'pdo' => array(
            ),
            'bypassAuth' => false,
            'smtp' => array(
                'debug' => false,
                'port' => '25',
                'secure' => 'TLS',
                'auth' => false,
                'username' => '',
                'password' => '',
            ),
            'backdoor' => $backdoor,
        );
        default:
            return array(
                'env' => 'development',
                'debug' => true,
                'basePath' => '/',
                'adminPath' => '/admin/',
                'returnUrl' => $returnUrl,
                'script' => '/assets/'.$scriptFileName,
                'adminScript' => '/assets/'.$adminScriptName,
                'apiPath' => "http://{$hostName}/api/index.php",
                'pdo' => array(
                    'database' => 'mysql',
                    'user' => 'root',
                    'pass' => 'root',
                ),
                'testing' => array(
                    'staffId' => 'F0123',
                    'staffRole' => '99',
                    'password' => 'c4e7e3792c',
                ),
                'bypassAuth' => true,
                'smtp' => array(
                    'debug' => 0,
                    'host' => 'smtp.van.terago.ca',
                    'port' => '25',
                    'secure' => '',
                    'auth' => false,
                    'username' => '',
                    'password' => '',
                ),
            );
    }

}

$settings = array_merge(getCommonSettings(), getEnvironmentSettings());
