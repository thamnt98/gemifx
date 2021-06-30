<?php

namespace App\Console\Commands;

use App\Models\MT5Connect;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class RefreshSessionMT5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mt5:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mt5Url = 'http://79.143.176.19:17014/ManagerAPIFOREX/';
        $endpoint = $mt5Url . 'LOGIN_SESSION?Email=startingmt5broker@gmail.com&Password=rasa8r&Source=1';
        $client = new Client();
        $response = $client->request('GET', $endpoint);
        $result = json_decode($response->getBody());
        $data['session'] = $result->Session;
        $endpoint = $mt5Url . 'INITIAL_ADD_MANAGER';
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'debug' => true
            ]
        ]);
        $data = [
            "ManagerID" => 1480,
            "ManagerIndex" => 0,
            "MT4_MT5" => 1,
            "CreatedBy" => 1,
            "oStatus" => 1,
            "ServerConfig" => "174.142.252.29:443",
            "ServerCode" => "Live",
            "Password" => "G9istgg_",
            "oDemo" => 1,
            "Session" => $data['session']
        ];
        $body = json_encode($data);
        $response = $client->request('POST', $endpoint, ['body' => $body]);
        $result = json_decode($response->getBody(), true);
        $data['manager_index'] = $result['Result'];
        MT5Connect::where('id', 1)->update($data);
    }
}
