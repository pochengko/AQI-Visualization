<?php
class Echarts extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('echarts_model');
    }

    public function getdata()
    {
        $data = array();
        $data['airquality'] = $this->echarts_model->get_data();
        $data['newAQI'] = $this->echarts_model->get_rt_aqi($_POST['siteName']);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getdata2()
    {
        $data = array();
        $data['airquality'] = $this->echarts_model->get_data2();
        $data['newAQI'] = $this->echarts_model->get_rt_aqi($_POST['siteName']);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getvoc()
    {
        $data = array();
        $data['voc'] = $this->echarts_model->get_voc();
        $data['newVOC'] = $this->echarts_model->get_rt_voc($_POST['siteName']);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getairbox()
    {
        $data = array();
        $data['airbox'] = $this->echarts_model->get_airbox();
        $data['newAirBox'] = $this->echarts_model->get_rt_airbox($_POST['siteName']);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getlora()
    {
        $data = array();
        $data['lora'] = $this->echarts_model->get_lora();
        $data['newlora'] = $this->echarts_model->get_rt_lora($_POST['siteName']);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getepaiot()
    {
        $data = array();
        $data['epaiot'] = $this->echarts_model->get_epaiot();
        $data['newepaiot'] = $this->echarts_model->get_rt_epaiot($_POST['siteName']);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getiisairbox()
    {
        $data = array();
        $data['iisairbox'] = $this->echarts_model->get_iisairbox();
        $data['newiisairbox'] = $this->echarts_model->get_rt_iisairbox($_POST['siteName']);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getab()
    {
        $data = array();
        $data['ab'] = $this->echarts_model->get_ab();
        $data['newab'] = $this->echarts_model->get_rt_ab($_POST['siteName']);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getabtc()
    {
        $data = array();
        $data['abtc'] = $this->echarts_model->get_ab_tc();
        $data['newabtc'] = $this->echarts_model->get_rt_ab_tc($_POST['siteName']);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getweather()
    {
        $data = array();
        $data['weather'] = $this->echarts_model->get_weather();
        $data['newweather'] = $this->echarts_model->get_rt_weather($_POST['siteName']);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getobservation()
    {
        $data = array();
        $observation = $this->echarts_model->get_observation();
        foreach ($observation as $value) {
            $newAQI = $this->echarts_model->get_rt_aqi($value['observationName']);
            if ($newAQI['AQI'] == NULL) {
              $newAQI['AQI'] = 'NA';
            }
            if ($newAQI['PM10'] == NULL) {
              $newAQI['PM10'] = 'NA';
            }
            if ($newAQI['O3'] == NULL) {
              $newAQI['O3'] = 'NA';
            }
            if ($newAQI['PM25'] == NULL) {
              $newAQI['PM25'] = 'NA';
            }
            if ($newAQI['CO'] == NULL) {
              $newAQI['CO'] = 'NA';
            }
            if ($newAQI['SO2'] == NULL) {
              $newAQI['SO2'] = 'NA';
            }
            if ($newAQI['NO2'] == NULL) {
              $newAQI['NO2'] = 'NA';
            }
            $array = array("observationName" => $value['observationName'], "siteName" => $value['siteName'], "county" => $value['county'], "longitude" => $value['longitude'], "latitude" => $value['latitude'],"AQI" => $newAQI['AQI'],
                           "PM10" => $newAQI['PM10'], "PM25" => $newAQI['PM25'], "CO" => $newAQI['CO'], "SO2" => $newAQI['SO2'], "NO2" => $newAQI['NO2'], "O3" => $newAQI['O3']);
            array_push($data,$array);
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }


    public function getobserve()
    {
        $data = array();
        $observation = $this->echarts_model->get_observation();
        foreach ($observation as $value) {
            $newAQI = $this->echarts_model->get_rt_aqi($value['observationName']);
            if ($newAQI['AQI'] == NULL) {
              $newAQI['AQI'] = 'NA';
            }
            if ($newAQI['PM25'] == NULL) {
              $newAQI['PM25'] = 'NA';
            }

            $array = array("observationName" => $value['observationName'], "AQI" => $newAQI['AQI'], "PM25" => $newAQI['PM25']);
            array_push($data,$array);
        }

        echo json_encode($data[86],JSON_UNESCAPED_UNICODE);
        echo json_encode($data[88],JSON_UNESCAPED_UNICODE);

    }

    public function getvocobservation()
    {
        $data = array();
        $observation = $this->echarts_model->get_voc_observation();
        foreach ($observation as $value) {
            $newVOC = $this->echarts_model->get_rt_voc($value['observationName']);
            if ($newVOC['Humidity'] == NULL) {
              $newVOC['Humidity'] = 'NA';
            }
            if ($newVOC['Illuminance'] == NULL) {
              $newVOC['Illuminance'] = 'NA';
            }
            if ($newVOC['PM1'] == NULL) {
              $newVOC['PM1'] = 'NA';
            }
            if ($newVOC['PM10'] == NULL) {
              $newVOC['PM10'] = 'NA';
            }
            if ($newVOC['PM25'] == NULL) {
              $newVOC['PM25'] = 'NA';
            }
            if ($newVOC['Temperature'] == NULL) {
              $newVOC['Temperature'] = 'NA';
            }
            if ($newVOC['VOC'] == NULL) {
              $newVOC['VOC'] = 'NA';
            }
            $array = array("observationName" => $value['observationName'],  "longitude" => $value['longitude'], "latitude" => $value['latitude'],
                           "Illuminance" => $newVOC['Illuminance'], "PM10" => $newVOC['PM10'], "PM25" => $newVOC['PM25'], "PM1" => $newVOC['PM1'], "Humidity" => $newVOC['Humidity'], "Temperature" => $newVOC['Temperature'], "VOC" => $newVOC['VOC']);
            array_push($data,$array);
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getairboxobservation()
    {
      $data = array();
      $observation = $this->echarts_model->get_airbox_observation();
      foreach ($observation as $value) {
          $newairbox = $this->echarts_model->get_rt_airbox($value['device_id']);
          if ($newairbox['humidity'] == NULL) {
            $newairbox['humidity'] = 'NA';
          }
          if ($newairbox['PM25'] == NULL) {
            $newairbox['PM25'] = 'NA';
          }
          if ($newairbox['temperature'] == NULL) {
            $newairbox['temperature'] = 'NA';
          }
          $array = array("device_id" => $value['device_id'],  "longitude" => $value['longitude'], "latitude" => $value['latitude'],
                         "PM25" => $newairbox['PM25'], "humidity" => $newairbox['humidity'], "temperature" => $newairbox['temperature']);
          array_push($data,$array);
      }
      echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getloraobservation()
    {
      $data = array();
      $observation = $this->echarts_model->get_lora_observation();
      foreach ($observation as $value) {
          $newlora = $this->echarts_model->get_rt_lora($value['observationName']);
          if ($newlora['hum'] == NULL || $newlora['hum'] > 100 || $newlora['hum'] < 0) {
            $newlora['hum'] = 'NA';
          }
          if ($newlora['PM25'] == NULL || $newlora['PM25'] > 501 || $newlora['PM25'] < 0) {
            $newlora['PM25'] = 'NA';
          }
          if ($newlora['PM10'] == NULL || $newlora['PM10'] > 424 || $newlora['PM10'] < 0) {
            $newlora['PM10'] = 'NA';
          }
          if ($newlora['temp'] == NULL || $newlora['temp'] > 40 || $newlora['temp'] < 0) {
            $newlora['temp'] = 'NA';
          }
          $array = array("observationName" => $value['observationName'],  "longitude" => $value['longitude'], "latitude" => $value['latitude'],
                         "PM10" => $newlora['PM10'], "PM25" => $newlora['PM25'], "hum" => $newlora['hum'], "temp" => $newlora['temp']);
          array_push($data,$array);
      }
      echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getepaiotobservation()
    {
      $data = array();
      $observation = $this->echarts_model->get_epaiot_observation();
      foreach ($observation as $value) {
          $newepaiot = $this->echarts_model->get_rt_epaiot($value['device_id']);
          if ($newepaiot['humidity'] == NULL || $newepaiot['humidity'] > 100 || $newepaiot['humidity'] < 0) {
            $newepaiot['humidity'] = 'NA';
          }
          if ($newepaiot['PM25'] == NULL || $newepaiot['PM25'] > 501 || $newepaiot['PM25'] < 0) {
            $newepaiot['PM25'] = 'NA';
          }
          if ($newepaiot['temperature'] == NULL || $newepaiot['temperature'] > 40 || $newepaiot['temperature'] < 0) {
            $newepaiot['temperature'] = 'NA';
          }
          $array = array("device_id" => $value['device_id'],  "lon" => $value['lon'], "lat" => $value['lat'],
                         "PM25" => $newepaiot['PM25'], "humidity" => $newepaiot['humidity'], "temperature" => $newepaiot['temperature']);
          array_push($data,$array);
      }
      echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getiisairboxobservation()
    {
      $data = array();
      $observation = $this->echarts_model->get_iisairbox_observation();
      foreach ($observation as $value) {
          $newiisairbox = $this->echarts_model->get_rt_iisairbox($value['device_id']);
          if ($newiisairbox['PM25'] == NULL || $newiisairbox['PM25'] > 501 || $newiisairbox['PM25'] < 0) {
            $newiisairbox['PM25'] = 'NA';
          }
          $array = array("device_id" => $value['device_id'],  "gps_lon" => $value['gps_lon'], "gps_lat" => $value['gps_lat'],
                         "PM25" => $newiisairbox['PM25']);
          array_push($data,$array);
      }
      echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getabobservation()
    {
      $data = array();
      $observation = $this->echarts_model->get_ab_observation();
      foreach ($observation as $value) {
          $newab = $this->echarts_model->get_rt_ab($value['device_id']);
          if ($newab['pm25'] == NULL || $newab['pm25'] > 501 || $newab['pm25'] < 0) {
            $newab['pm25'] = 'NA';
          }
          $array = array("device_id" => $value['device_id'],  "lon" => $value['lon'], "lat" => $value['lat'],
                         "pm25" => $newab['pm25']);
          array_push($data,$array);
      }
      echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getabtcobservation()
    {
      $data = array();
      $observation = $this->echarts_model->get_ab_tc_observation();
      foreach ($observation as $value) {
          $newabtc = $this->echarts_model->get_rt_ab_tc($value['device_id']);
          if ($newabtc['pm25'] == NULL || $newabtc['pm25'] > 501 || $newabtc['pm25'] < 0) {
            $newabtc['pm25'] = 'NA';
          }
          $array = array("device_id" => $value['device_id'],  "lon" => $value['lon'], "lat" => $value['lat'],
                         "pm25" => $newabtc['pm25']);
          array_push($data,$array);
      }
      echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getcemsfactory()
    {
      $data = array();
      $observation = $this->echarts_model->get_cems_factory();
      /*foreach ($observation as $value) {
          $newiisairbox = $this->echarts_model->get_rt_iisairbox($value['device_id']);
          if ($newiisairbox['PM25'] == NULL || $newiisairbox['PM25'] > 501 || $newiisairbox['PM25'] < 0) {
            $newiisairbox['PM25'] = 'NA';
          }
          $array = array("device_id" => $value['device_id'],  "gps_lon" => $value['gps_lon'], "gps_lat" => $value['gps_lat'],
                         "PM25" => $newiisairbox['PM25']);
          array_push($data,$array);
      }*/
      echo json_encode($observation,JSON_UNESCAPED_UNICODE);
    }

    public function getweatherstation()
    {
      $data = array();
      $observation = $this->echarts_model->get_weather_station();
      /*foreach ($observation as $value) {
          $newweather = $this->echarts_model->get_rt_weather($value['stationName']);
          if ($newweather['id'] == NULL) {
            $newweather['id'] = 'NA';
          }
          $array = array("station_name" => $value['station_name'],  "lon" => $value['lon'], "lat" => $value['lat'],
                         "id" => $newweather['id']);
          array_push($data,$array);
      }*/
      echo json_encode($observation,JSON_UNESCAPED_UNICODE);
    }

    public function getdailydataitem()
    {
        $data['airquality_daily_item'] = $this->echarts_model->get_dailydata_item();
        echo json_encode($data['airquality_daily_item'],JSON_UNESCAPED_UNICODE);
    }

    public function getdailydataaqi()
    {
        $data['airquality_daily_aqi'] = $this->echarts_model->get_dailydata_aqi();
        echo json_encode($data['airquality_daily_aqi'],JSON_UNESCAPED_UNICODE);
    }

    /*public function getdailydataaqitc()
    {
        $data['airquality_daily_aqi_taichung'] = $this->echarts_model->get_dailydata_aqi_taichung();
        echo json_encode($data['airquality_daily_aqi_taichung'],JSON_UNESCAPED_UNICODE);
    }*/


    public function getdailydatatc()
    {
        $data['airquality_daily_taichung'] = $this->echarts_model->get_dailydata_taichung($_POST['selectMonth'], $_POST['selectYear']);
        echo json_encode($data['airquality_daily_taichung'],JSON_UNESCAPED_UNICODE);
    }

    public function getiliaqi()
    {
        $data['iliaqi'] = $this->echarts_model->get_ili_aqi();
        echo json_encode($data['iliaqi'],JSON_UNESCAPED_UNICODE);
    }

    public function getili()
    {
      $data['ili'] = $this->echarts_model->get_ili();
      echo json_encode($data['ili'],JSON_UNESCAPED_UNICODE);
    }

    public function getaqi()
    {
      $data['aqi'] = $this->echarts_model->get_aqi();
      echo json_encode($data['aqi'],JSON_UNESCAPED_UNICODE);
    }

    public function getpm25()
    {
      $data['pm25'] = $this->echarts_model->get_pm25();
      echo json_encode($data['pm25'],JSON_UNESCAPED_UNICODE);
    }

    public function getpnefludeath()
    {
      $data['pnefludeath'] = $this->echarts_model->get_pne_flu_death();
      echo json_encode($data['pnefludeath'],JSON_UNESCAPED_UNICODE);
    }

    public function getenterovirus()
    {
      $data['enterovirus'] = $this->echarts_model->get_enterovirus();
      echo json_encode($data['enterovirus'],JSON_UNESCAPED_UNICODE);
    }

    public function getiliaqiarea()
    {
      $data['iliaqiarea'] = $this->echarts_model->get_ili_aqi_area($_GET['Area']);
      echo json_encode($data['iliaqiarea'],JSON_UNESCAPED_UNICODE);
    }

    public function getlagtime()
    {
        $data['lagtime'] = $this->echarts_model->get_lagtime();
        echo json_encode($data['lagtime'],JSON_UNESCAPED_UNICODE);
    }

    public function gethourlyxt()
    {
      $data['hourlyxt'] = $this->echarts_model->get_hourly_xt();
      echo json_encode($data['hourlyxt'],JSON_UNESCAPED_UNICODE);
    }

    public function getvocs()
    {
      $data['vocs'] = $this->echarts_model->get_vocs();
      echo json_encode($data['vocs'],JSON_UNESCAPED_UNICODE);
    }

    public function getpredict()
    {
      $data['predict'] = $this->echarts_model->get_predict();
      echo json_encode($data['predict'],JSON_UNESCAPED_UNICODE);
    }

    public function getjf()
    {
      $data['jf'] = $this->echarts_model->get_jf();
      echo json_encode($data['jf'],JSON_UNESCAPED_UNICODE);
    }

    public function getvalidcar()
    {
      $data['car'] = $this->echarts_model->get_valid_car();
      echo json_encode($data['car'],JSON_UNESCAPED_UNICODE);
    }

    public function getvalidsensor()
    {
      $data['sensor'] = $this->echarts_model->get_valid_sensor();
      /*if ($data['sensor'][7] == NULL || $data['sensor'][7] > 501 || $data['sensor'][7] < 0) {
        $data['sensor'][7] = 'NA';
      }*/
      echo json_encode($data['sensor'],JSON_UNESCAPED_UNICODE);
    }


    //頁面
    public function aqi()
    {
        $data['title'] = 'AQI';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/aqi', $data);
        $this->load->view('templates/footer');
    }

    public function historyAQI()
    {
        $data['title'] = 'HistoryAQI';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/historyAQI', $data);
        $this->load->view('templates/footer');
    }

    public function figure()
    {
        $data['title'] = 'Parallel';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/figure', $data);
        $this->load->view('templates/footer');
    }

    public function scatter()
    {
      $data['title'] = 'Scatter';

      $this->load->view('templates/header', $data);
      $this->load->view('echarts/scatter', $data);
      $this->load->view('templates/footer');
    }

    public function iliaqi()
    {
        $data['title'] = 'ILIAQI';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/iliaqi', $data);
        $this->load->view('templates/footer');
    }

    public function aqiili()
    {
        $data['title'] = 'AQIILI';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/aqiili', $data);
        $this->load->view('templates/footer');
    }

    public function geo()
    {
        $data['title'] = 'GEO';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/geo', $data);
        $this->load->view('templates/footer');
    }

    public function taichung()
    {
        $data['title'] = 'Taichung';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/taichung', $data);
        $this->load->view('templates/footer');
    }

    public function taichungms()
    {
        $data['title'] = 'Taichung MS';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/taichungms', $data);
        $this->load->view('templates/footer');
    }

    public function taichungairbox()
    {
        $data['title'] = 'Taichung Airbox';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/taichungairbox', $data);
        $this->load->view('templates/footer');
    }

    public function thu()
    {
        $data['title'] = 'Tunghai';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/thu', $data);
        $this->load->view('templates/footer');
    }

    public function tc()
    {
        $data['title'] = 'TC';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/tc', $data);
        $this->load->view('templates/footer');
    }

    public function lagtime()
    {
        $data['title'] = 'LagTime';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/lagtime', $data);
        $this->load->view('templates/footer');
    }

    public function pm25()
    {
        $data['title'] = 'PM2.5';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/pm25', $data);
        $this->load->view('templates/footer');
    }

    public function airpollution()
    {
        $data['title'] = 'PM2.5';

        $this->load->view('echarts/airpollution', $data);
    }

    public function taichungnone()
    {
        $data['title'] = 'PM2.5';

        $this->load->view('echarts/taichungnone', $data);
    }

    public function pm10()
    {
        $data['title'] = 'PM10';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/pm10', $data);
        $this->load->view('templates/footer');
    }

    public function no2()
    {
        $data['title'] = 'NO2';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/no2', $data);
        $this->load->view('templates/footer');
    }

    /*
    public function no()
    {
        $data['title'] = 'NO';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/no', $data);
        $this->load->view('templates/footer');
    }
    */

    public function o3()
    {
        $data['title'] = 'O3';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/o3', $data);
        $this->load->view('templates/footer');
    }

    public function so2()
    {
        $data['title'] = 'SO2';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/so2', $data);
        $this->load->view('templates/footer');
    }

    public function co()
    {
        $data['title'] = 'CO';

        $this->load->view('templates/header', $data);
        $this->load->view('echarts/co', $data);
        $this->load->view('templates/footer');
    }

    public function xt()
    {
      $data['title'] = 'XT';

      $this->load->view('templates/header', $data);
      $this->load->view('echarts/xt', $data);
      $this->load->view('templates/footer');
    }

    public function xt_log()
    {
      $data['title'] = 'XT_Log';

      $this->load->view('templates/header', $data);
      $this->load->view('echarts/xt_log', $data);
      $this->load->view('templates/footer');
    }

    public function iliaqiyr()
    {
      $data['title'] = 'iliaqiyr';

      $this->load->view('templates/header', $data);
      $this->load->view('echarts/iliaqiyr', $data);
      $this->load->view('templates/footer');
    }

    public function vocs()
    {
      $data['title'] = 'VOCs';

      $this->load->view('templates/header', $data);
      $this->load->view('echarts/vocs', $data);
      $this->load->view('templates/footer');
    }

    public function ilipne()
    {
      $data['title'] = 'ILIPNE';

      $this->load->view('templates/header', $data);
      $this->load->view('echarts/ilipne', $data);
      $this->load->view('templates/footer');
    }

    public function forecast()
    {
      $data['title'] = 'Forecast';

      $this->load->view('templates/header', $data);
      $this->load->view('echarts/forecast', $data);
      $this->load->view('templates/footer');
    }

    public function jf()
    {
      $data['title'] = 'Predict';

      $this->load->view('templates/header', $data);
      $this->load->view('echarts/jf', $data);
      $this->load->view('templates/footer');
    }

    public function valid()
    {
      $data['title'] = 'Valid';

      $this->load->view('templates/header', $data);
      $this->load->view('echarts/valid', $data);
      $this->load->view('templates/footer');
    }

    public function gauge()
    {
      $data['title'] = 'THU';

      $this->load->view('echarts/gauge', $data);
    }

}
