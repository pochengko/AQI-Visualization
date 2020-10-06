<?php
public function getairboxjson(){
  $jsonurl = "https://data.lass-net.org/data/last-all-airbox.json";
  $json_data = json_encode($jsonurl,JSON_UNESCAPED_UNICODE);

  echo $json_data;
  }
