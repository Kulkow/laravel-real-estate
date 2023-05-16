<?php
namespace App\Models\Google;
use Illuminate\Support\Facades\Storage;


class SheetConnector {

    public function connect() : \Google\Client
    {
        $service_file = Storage::disk('secret-google')->path(env('GOOGLE_SHEET_SECRET'));
        $client = new \Google\Client();
        $client->setApplicationName("Client_Sheets");
        $client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig($service_file);
        return $client;
    }

}
