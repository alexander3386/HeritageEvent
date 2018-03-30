<?php
foreach ($reportingData[0]['User'] as $key => $word)
{
	$words[$key] = ucwords($key);
}
$line= $words;
$this->Csv->addRow($line);
foreach ($reportingData as $export){
      $line =$export['User'];
      $this->Csv->addRow($line);
}
$filename='report';
echo  $this->Csv->render($filename);
 
?>