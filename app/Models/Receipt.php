<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Receipt extends Model
{

    /**
     * @param $qrcodeString
     * @return mixed
     */
    public static function scan($qrcodeString)
    {
        $qrcodeData = self::qrcodeParse($qrcodeString);
        return json_decode(self::recieptCheck($qrcodeData), true);
    }


    /**
     * @param $qrcodeString
     * @return array
     */
    private static function qrcodeParse($qrcodeString)
    {
        preg_match('/t=[\s\S]+?&/', $qrcodeString, $t);
        preg_match('/s=[\s\S]+?&/', $qrcodeString, $s);
        preg_match('/fn=[\s\S]+?&/', $qrcodeString, $fn);
        preg_match('/i=[\s\S]+?&/', $qrcodeString, $fd);
        preg_match('/fp=[\s\S]+?&/', $qrcodeString, $fp);
        preg_match('/&n=[\s\S]+/', $qrcodeString, $n);

        return [
            't' => str_replace(['t=', '&'], '', $t[0]),
            's' => str_replace(['s=', '&'], '', $s[0]),
            'fn' => str_replace(['fn=', '&'], '', $fn[0]),
            'fd' => str_replace(['i=', '&'], '', $fd[0]),
            'fp' => str_replace(['fp=', '&'], '', $fp[0]),
            'n' => str_replace(['&n=', ' '], '', $n[0]),
        ];
    }


    /**
     * @param $qrcodeData
     * @return \Illuminate\Http\Client\Response
     */
    private static function recieptCheck($qrcodeData)
    {
        return Http::asForm()->post('https://proverkacheka.com/api/v1/check/get', [
            'fn' => $qrcodeData['fn'],
            'fd' => $qrcodeData['fd'],
            'fp' => $qrcodeData['fp'],
            't' => $qrcodeData['t'],
            'n' => $qrcodeData['n'],
            's' => $qrcodeData['s'],
            'qr' => '1',
            'token' => '1328.N4gEdrnYHiYuHAA64',
        ]);
    }
}
