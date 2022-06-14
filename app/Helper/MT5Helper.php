<?php

namespace App\Helper;

use App\Models\MT5Connect;
use GuzzleHttp\Client;

class MT5Helper
{
    protected static $mt5Url = 'http://176.9.76.135:8261/ForexManagerAPI/';

    public static function getMT5Connect(){
        return MT5Connect::first();
    }

    public function getGroups()
    {
        $mt5 = self::getMT5Connect();
        $endpoint = self::$mt5Url . 'GET_GROUPS?Session=' . $mt5->session . '&ManagerIndex=' . $mt5->manager_index;
        $client = new Client();
        $response = $client->request('GET', $endpoint);
        $result = json_decode($response->getBody());
        return $result->lstGroups;
    }

    public function openAccount($data)
    {
        $mt5 = self::getMT5Connect();
        $endpoint = self::$mt5Url . 'ADD_MT_USER';
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'debug' => true
            ]
        ]);
        $data ['ManagerIndex'] = $mt5->manager_index;
        $data ["Session"] = $mt5->session;
        $body = json_encode($data);
        $response = $client->request('POST', $endpoint, ['body' => $body]);
        $result = json_decode($response->getBody(), true);
        return $result;
    }

    public function getAccountInfo($login)
    {
        try{
            $mt5 = self::getMT5Connect();
            $endpoint = self::$mt5Url . 'GET_USER_INFO?Session=' . $mt5->session . '&ManagerIndex=' . $mt5->manager_index . '&Account=' . $login;
            $client = new Client();
            $response = $client->request('GET', $endpoint, [
                'timeout' => 30,
                'connect_timeout' => 30
            ]);
            $result = json_decode($response->getBody());
            return $result;
        }catch(\Exception $e) {
            return null;
        }
    }

    public function changeMasterPassword($data)
    {
        $mt5 = self::getMT5Connect();
        $endpoint = self::$mt5Url . 'CHANGE_MASTER_PASSWORD?Session=' . $mt5->session .  '&ManagerIndex=' . $mt5->manager_index .'&Account=' . $data['login'] . '&Password=' . $data['password'];
        $client = new Client();
//        dd($endpoint);
        $response = $client->request('GET', $endpoint);
        $result = json_decode($response->getBody());
        return $result;
    }
}
