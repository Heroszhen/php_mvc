<?php

namespace src\Service;

class UtilService 
{
    public static function purifyOneFetchAll(array $tab): array 
    {
        foreach ($tab as $key => $value) {
            if (is_numeric($key)) {
                unset($tab[$key]);
            }
        }
        
        return $tab;
    }

    public static function purifyFetchAll(array $tab): array 
    {
        foreach($tab as $key => $item){
            $tab[$key] = self::purifyOneFetchAll($item);
        }

        return $tab;
    }

    public function sendByHostingerMail(
        string $to,
        string $subject,
        string $message
    ): int
    {
        if ($_ENV['env'] === 'dev') {
            ini_set('display_errors', 1);
            error_reporting( E_ALL );
        }
        
        $subject = "Essai de PHP Mail";
        $headers = "De :{$_ENV['reset-password@alexandra-daddario.yangzhen.tech']}";
        $result = mail($to, $subject, $message, $headers);

        return $result;
    }
    
}