<?php
namespace d17030752\Stock\models;
require_once 'Database.php';
use d17030752\Stock\models\Database;
use Error;
use PDO;

class Stock extends Database
{
    private string $ticker;
    private string $performanceId;
    private mixed $info;
    public function __construct(private string $name)
    {
        parent::__construct();
    }
    public function save()
    {
        $query = $this->connect()->prepare("INSERT INTO stock(name , ticker  , performanceId) VALUES (:name  , :ticker , :performanceId)");
        $query->execute(['name' => $this->name, 'ticker' => $this->ticker, 'performanceId' => $this->performanceId]);
    }
    public static function getAll()
    {
        $db = new Database();
        $query = $db->connect()->query("SELECT * FROM stock");
        $stocks = [];
        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
            $tock = Stock::createFromArray($r);
            array_push($stocks, $tock);
        }
        return $stocks;
    }
    public static function createFromArray($arr)
    {
        $stock = new Stock($arr['name']);
        $stock->setTicker($arr['ticker']);
        $stock->setPerformanceId($arr['performanceId']);
        $stock->loadStock();
        return $stock;
    }
    public function setTicker($value)
    {
        return $this->ticker = $value;
    }
    public function setPerformanceId($value)
    {
        return $this->performanceId = $value;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getTicker()
    {
        return $this->ticker;
    }
    public function getStock()
    {
        return $this->info;
    }

public static function existsOnDb($name)
{ $db = new Database();
    $query = $db->connect()->prepare("SELECT * FROM stock WHERE ticker =:name");
    $query->execute(['name'=>$name]);

    return $query->rowCount()>0;
}
    public function isStockReal()
    {
        try {
            $this->loadProvider();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function loadProvider()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://ms-finance.p.rapidapi.com/market/v2/auto-complete?q=" . $this->name,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: ms-finance.p.rapidapi.com",
                "X-RapidAPI-Key:fa92cfa170mshb7c660c26113533p1152c6jsnaea351473feb"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            /* echo "cURL Error #:" . $err; */
            throw new Error($err);
        } else {
            $json = json_decode($response);
            $this->performanceId = $json->results[0]->performanceId;
            $this->name = $json->results[0]->name;
            $this->ticker = $json->results[0]->ticker;
        }
    }
    public function loadStock()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://ms-finance.p.rapidapi.com/stock/v2/get-realtime-data?performanceId=" . $this->performanceId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: ms-finance.p.rapidapi.com",
                "X-RapidAPI-Key:fa92cfa170mshb7c660c26113533p1152c6jsnaea351473feb"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //            echo "cURL Error #:" . $err;
            throw new Error($err);
        } else {
            $this->info = json_decode($response);
        }
    }
}
