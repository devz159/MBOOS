<?php if( ! defined("BASEPATH")) exit('No direct script access allowed');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if ( ! function_exists('generateLinkTag')) {
    function generateLinkTag($url) {
        $htmlText ='';

        switch($url) {
            case 'register':
            case 'terms':
            case 'privacy':
                $htmlText .= '<link type="text/css" rel="stylesheet" href="' . base_url() . 'css/style.css" />' . "\n";
                $htmlText .= '<link type="text/css" rel="stylesheet" href="' . base_url() . 'css/style_admin.css" />' . "\n";    
                break;
            case 'profile':
            case 'sign_in':
            case 'validate':
            case 'sign_in_validate':
            case 'passwordrecovery':
            case 'resume':
            case 'my':
                $htmlText .= '<link type="text/css" rel="stylesheet" href="' . base_url() . 'css/style.css" />' . "\n";
                $htmlText .= '<link type="text/css" rel="stylesheet" href="' . base_url() . 'css/style_admin.css" />' . "\n";               
                break;
           default:
               $htmlText .= '<link type="text/css" rel="stylesheet" href="' . base_url() . 'css/style.css" />' . "\n";              
               break;
        }
        
        return $htmlText;
    }

}

if (! function_exists('generateScriptTag')) {
    function generateScriptTag($url) {
        $htmlText = '';

        switch($url) {
            case 'profile':
            case 'resume':
            case 'my':
                $htmlText .= '<script type="text/javascript" src="' . base_url() . 'js/resume.js"></script>' . "\n";
                break;
            default:
                $htmlText .= '<script type="text/javascript" src="' . base_url() . 'js/resume.js"></script>' . "\n";
        }

        return $htmlText;
    }
}


