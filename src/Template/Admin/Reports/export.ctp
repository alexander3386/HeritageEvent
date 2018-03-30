<?php
//pr($reportingData);
//exit;
$words	=	array();
foreach ($reportingData[0]['Row'] as $key => $word)
{
$words[$key] = ucwords($key);
}
$line= $words;


$this->Csv->addRow($words);
 foreach ($reportingData as $export)
 {
      $line =$export['Row'];
      $this->Csv->addRow($line);
 }
 echo  $this->Csv->render($filename);
 
?>