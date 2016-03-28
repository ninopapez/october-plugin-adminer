<?php

    namespace Martin\Adminer\Classes;

    use Martin\Adminer\Models\Settings as Settings;

    class OctoberAdminerHelper {

        public static function getAutologinURL() {
            if(Settings::get('autologin', 0) == 0) { return ''; }
            $connection = self::getMySQLParams();
            if($connection['driver'] == 'mysql') {
                $server = self::getServerAddress();
                $params = '?server='.$server.'&username='.$connection['username'].'&db='.$connection['database'];
            } else {
                $params = '';
            }
            return $params;
        }

        public static function getAutologinParams() {
            $connection = self::getMySQLParams();
            $server     = self::getServerAddress();
            return [
                'driver'   => $connection['driver'],
                'server'   => $server,
                'username' => $connection['username'],
                'password' => $connection['password']
            ];
        }

        private static function getMySQLParams() {
            $default    = config('database.default');
            $default = 'mysql';
            $connection = config('database.connections.' . $default);
            return $connection;
        }

        private static function getServerAddress() {
            $connection = self::getMySQLParams();
            $server = $connection['host'] . (($connection['port'] != '') ? ':' . $connection['port'] : '');
            return $server;
        }

    }

?>