<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

function getLang(){
    // Devuelve idioma actual
    return App::currentLocale();
}
function getLangLong(){
    $lang = App::currentLocale();
    switch($lang){
        case 'es':
            return 'Spanish';
            break;
        case 'en':
            return 'English';
            break;
        case 'ro':
            return 'Romanian';
            break;
        default:
            return null;
            break;
    }
}
function getLangLongWithLanguages(){
    $lang = App::currentLocale();
    switch($lang){
        case 'es':
            return Lang::get('messages.spanish');
            break;
        case 'en':
            return Lang::get('messages.english');
            break;
        case 'ro':
            return Lang::get('messages.romanian');
            break;
        default:
            return null;
            break;
    }
}

function changeShipmentStatus($status){
    switch($status){
        case 'Initial':
            return Lang::get('messages.initial');
            break;
        case 'Sent':
            return Lang::get('messages.sent');
            break;
        case 'In progress':
            return Lang::get('messages.in-progress');
            break;
        case 'Rejected':
            return Lang::get('messages.rejected');
            break;
        case 'Completed':
            return Lang::get('messages.completed');
            break;
        default:
            return null;
            break;
    }
}
/*
class LANGUAGE{
    public static function getLang(){
        // Devuelve idioma actual
        return App::currentLocale();
    }
    public static function getLangLong(){
        $lang = App::currentLocale();
        switch($lang){
            case 'es':
                return 'Spanish';
                break;
            case 'en':
                return 'English';
                break;
            case 'ro':
                return 'Romanian';
                break;
            default:
                return null;
                break;
        }
    }
}

*/