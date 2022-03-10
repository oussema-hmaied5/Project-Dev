<?php

namespace App\Services;


use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
class QrcodeService
{
    /**
     * @var BuilderInterface
     */
   protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder=$builder;
    }
 public function qrcode($query)
 {

 $url='https://www.twitch.tv/';
 $objDateTime = new \DateTime('NOW');
 $dateString = $objDateTime->format('d-m-Y H:i:s');

     $path = dirname(__DIR__, 2).'/public/assets/';
//set qrcode
     $result = $this->builder
     ->data($url . $query)
     ->encoding(new Encoding('UTF-8'))
     ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
      ->size(400)
     ->margin(10)
     ->labelText($dateString)
     ->labelAlignment(new LabelAlignmentCenter())
     ->labelMargin(new Margin(15, 5, 5, 5))
     ->build();
     //gnerate name
     $namePng =uniqid('', '') . '.png';
     $result->saveToFile($path.'qr-code/'.$namePng);

     return $result->getDataUri();

 }

}