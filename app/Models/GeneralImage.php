<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralImage extends Model
{
    protected $fillable = [
        "banner",
        "logo_header",
        "logo_footer",
        "login",
        "register",
    ];

    // ------------- Function ------------
    public static function getBannner()
    {
        $banner = GeneralImage::first()->banner;
        // dd($banner);
        return $banner;
    }

    public static function getHeader()
    {
        $header = GeneralImage::first()->logo_header;
        // dd($header);
        return $header;
    }

    public static function getFooter()
    {
        $footer = GeneralImage::first()->logo_footer;
        // dd($footer);
        return $footer;
    }

    public static function getLogin()
    {
        $login = GeneralImage::first()->login;
        // dd($login);
        return $login;
    }

    public static function getRegister()
    {
        $register = GeneralImage::first()->register;
        // dd($register);
        return $register;
    }
}
