<?php

namespace App\Http\Helpers;

class DbHelper
{
    private static $koneksi;

    public static function getConnection()
    {
        if (self::$koneksi === null) {
            $servername = env('DB_HOST', 'localhost');
            $username = env('DB_USERNAME', 'root');
            $password = env('DB_PASSWORD', '');
            $dbname = env('DB_DATABASE', 'puskesmas');

            self::$koneksi = new \mysqli($servername, $username, $password, $dbname);

            if (self::$koneksi->connect_error) {
                die("Koneksi gagal: " . self::$koneksi->connect_error);
            }

            self::$koneksi->set_charset("utf8");
        }

        return self::$koneksi;
    }

    public static function query($sql)
    {
        $koneksi = self::getConnection();
        return $koneksi->query($sql);
    }

    public static function close()
    {
        if (self::$koneksi !== null) {
            self::$koneksi->close();
            self::$koneksi = null;
        }
    }
}
