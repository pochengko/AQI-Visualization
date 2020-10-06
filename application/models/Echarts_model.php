<?php
class Echarts_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_data($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'ASC')->get_where('airquality', array('SiteName' => $this->input->post('siteName')));
            return $query->result_array();
        }
        $query = $this->db->get_where('airquality', array('SiteName' => $SiteName));
        return $query->row_array();
    }

    public function get_data2($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'DESC')->get_where('airquality', array('SiteName' => $this->input->post('siteName')), 48);
            return $query->result_array();
        }
        $query = $this->db->get_where('airquality', array('SiteName' => $SiteName));
        return $query->row_array();
    }

    public function get_voc($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'ASC')->get_where('pc_voc', array('SiteName' => $this->input->post('siteName')));
            return $query->result_array();
        }
        $query = $this->db->get_where('pc_voc', array('SiteName' => $SiteName));
        return $query->row_array();
    }

    public function get_airbox($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'DESC')->get_where('pc_airbox', array('device_id' => $this->input->post('siteName')), 72);
            return $query->result_array();
        }
        $query = $this->db->get_where('pc_airbox', array('device_id' => $device));
        return $query->row_array();
    }

    public function get_lora($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'DESC')->get_where('LoRa', array('sensor' => $this->input->post('siteName')), 72);
            return $query->result_array();
        }
        $query = $this->db->get_where('LoRa', array('sensor' => $sensor));
        return $query->row_array();
    }

    public function get_epaiot($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'DESC')->get_where('epaiot', array('device_id' => $this->input->post('siteName')), 72);
            return $query->result_array();
        }
        $query = $this->db->get_where('epaiot', array('device_id' => $device_id));
        return $query->row_array();
    }

    public function get_iisairbox($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'DESC')->get_where('iis_airbox', array('device_id' => $this->input->post('siteName')), 72);
            return $query->result_array();
        }
        $query = $this->db->get_where('iis_airbox', array('device_id' => $device_id));
        return $query->row_array();
    }

    public function get_ab($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'DESC')->get_where('airbox', array('device_id' => $this->input->post('siteName')), 72);
            return $query->result_array();
        }
        $query = $this->db->get_where('airbox', array('device_id' => $device_id));
        return $query->row_array();
    }

    public function get_ab_tc($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'DESC')->get_where('airbox', array('area' => 'taichuang', 'device_id' => $this->input->post('siteName')), 72);
            return $query->result_array();
        }
        $query = $this->db->get_where('airbox', array('device_id' => $device_id));
        return $query->row_array();
    }


    public function get_rt_aqi($siteName){
          //$maxid = $this->db->query("SELECT MAX(id) AS `maxid` FROM `airquality_rt` WHERE SiteName='$siteName'")->row()->maxid;
          //$query = $this->db->select('*')->get_where('airquality_rt', array('id' => $maxid));
          $query = $this->db->get_where('airquality_rt', array('SiteName' => $siteName));
         return $query->row_array();
    }

    public function get_rt_voc($siteName){
          $query = $this->db->get_where('pc_voc_rt', array('SiteName' => $siteName));
         return $query->row_array();
    }

    public function get_rt_airbox($siteName){
          //$maxid = $this->db->query("SELECT MAX(id) AS `maxid` FROM `pc_airbox` WHERE device='$siteName'")->row()->maxid;
          //$query = $this->db->select('*')->get_where('pc_airbox', array('id' => $maxid));
          $query = $this->db->get_where('pc_airbox_rt', array('device_id' => $siteName));
         return $query->row_array();
    }

    public function get_rt_lora($siteName){
          $query = $this->db->get_where('pc_lora_rt', array('sensor' => $siteName));
         return $query->row_array();
    }

    public function get_rt_epaiot($siteName){
          $query = $this->db->get_where('epaiot_rt', array('device_id' => $siteName));
         return $query->row_array();
    }

    public function get_rt_iisairbox($siteName){
          $query = $this->db->get_where('iis_airbox_rt', array('device_id' => $siteName));
         return $query->row_array();
    }

    public function get_rt_ab($siteName){
          $query = $this->db->get_where('airbox_rt', array('device_id' => $siteName));
         return $query->row_array();
    }

    public function get_rt_ab_tc($siteName){
          $query = $this->db->get_where('airbox_rt', array('area' => 'taichuang', 'device_id' => $siteName));
         return $query->row_array();
    }

    public function get_rt_weather($siteName){
          $query = $this->db->get_where('weather_rt', array('stationName' => $siteName));
         return $query->row_array();
    }

    public function get_observation($id = FALSE)
    {
      if ($id === FALSE)
      {
        $query = $this->db->order_by('id', 'ASC')->get_where('observation');
        return $query->result_array();
      }
      $query = $this->db->get_where('observation', array('id' => $id));
      return $query->row_array();
    }

    public function get_voc_observation($id = FALSE)
    {
      if ($id === FALSE)
      {
        $query = $this->db->order_by('id', 'ASC')->get_where('pc_voc_observation', array('status' => '1'));
        return $query->result_array();
      }
      $query = $this->db->get_where('pc_voc_observation', array('id' => $id));
      return $query->row_array();
    }

    public function get_airbox_observation($id = FALSE)
    {
      if ($id === FALSE)
      {
        $query = $this->db->order_by('id', 'ASC')->get_where('pc_airbox_observation');
        return $query->result_array();
      }
      $query = $this->db->get_where('pc_airbox_observation', array('id' => $id));
      return $query->row_array();
    }

    public function get_lora_observation($id = FALSE)
    {
      if ($id === FALSE)
      {
        $query = $this->db->order_by('id', 'ASC')->get_where('pc_lora_observation', array('status' => '1'));
        return $query->result_array();
      }
      $query = $this->db->get_where('pc_lora_observation', array('id' => $id));
      return $query->row_array();
    }

    public function get_epaiot_observation($id = FALSE)
    {
      if ($id === FALSE)
      {
        $query = $this->db->order_by('id', 'ASC')->get_where('epaiot_station', array('status' => '1'));
        return $query->result_array();
      }
      $query = $this->db->get_where('epaiot_station', array('id' => $id));
      return $query->row_array();
    }

    public function get_iisairbox_observation($id = FALSE)
    {
      if ($id === FALSE)
      {
        $query = $this->db->order_by('id', 'ASC')->get_where('iis_airbox_station', array('status' => '1'));
        return $query->result_array();
      }
      $query = $this->db->get_where('iis_airbox_station', array('id' => $id));
      return $query->row_array();
    }

    public function get_ab_observation($id = FALSE)
    {
      if ($id === FALSE)
      {
        $query = $this->db->order_by('id', 'ASC')->get_where('airbox_station', array('status' => '1'));
        return $query->result_array();
      }
      $query = $this->db->get_where('airbox_station', array('id' => $id));
      return $query->row_array();
    }

    public function get_ab_tc_observation($id = FALSE)
    {
      if ($id === FALSE)
      {
        $query = $this->db->order_by('id', 'ASC')->get_where('airbox_station', array('area' => 'taichuang', 'status' => '1'));
        return $query->result_array();
      }
      $query = $this->db->get_where('airbox_station', array('id' => $id));
      return $query->row_array();
    }

    public function get_weather_station($id = FALSE)
    {
      if ($id === FALSE)
      {
        $query = $this->db->order_by('id', 'ASC')->get_where('weather_station_auto');
        return $query->result_array();
      }
      $query = $this->db->get_where('weather_station_auto', array('id' => $id));
      return $query->row_array();
    }

    public function get_cems_factory($id = FALSE)
    {
      if ($id === FALSE)
      {
        $query = $this->db->order_by('id', 'ASC')->get_where('cems_factory');
        return $query->result_array();
      }
      $query = $this->db->get_where('cems_factory', array('id' => $id));
      return $query->row_array();
    }

    public function get_dailydata_item($number = FALSE)
    {
        if ($number === FALSE)
        {
            $query = $this->db->order_by('date', 'ASC')->get_where('pc_airquality_daily_item',array('observation_cn' => $this->input->post('siteName')));
            return $query->result_array();
        }
        $query = $this->db->get_where('pc_airquality_daily_item', array('observation_cn' => $observation_cn));
        return $query->row_array();
    }

    public function get_dailydata_aqi($number = FALSE)
    {
        if ($number === FALSE)
        {
            $query = $this->db->order_by('date', 'ASC')->get_where('pc_airquality_daily_aqi', array('observation_cn' => $this->input->post('siteName')));
            return $query->result_array();
        }
        $query = $this->db->get_where('pc_airquality_daily_aqi', array('observation_cn' => $observation_cn));
        return $query->row_array();
    }

    /*public function get_dailydata_aqi_taichung($number = FALSE)
    {
        if ($number === FALSE)
        {
            $query = $this->db->like('Date', '2017-08-', 'after')->order_by('Date', 'ASC')->get_where('pc_airquality_daily_aqi_new', array('County' => '臺中市'));
            return $query->result_array();
        }
        $query = $this->db->get_where('pc_airquality_daily_aqi_new', array('city_cn' => $city_cn));
        return $query->row_array();
    }*/

    public function get_dailydata_taichung($month, $year)
    {
        $query = $this->db->order_by('Date', 'ASC')->get_where('pc_airquality_daily_aqi_new', array('County' => '臺中市'));
        $temp = $query->result_array();
        $data = array();
        foreach($temp as $t){
          if(explode('-',$t['Date'])[1] == $month && explode('-',$t['Date'])[0] == $year){
              array_push($data,$t);
          }
        }
        return $data;
    }

    public function get_ili_aqi($Period = FALSE)
    {
        if ($Period === FALSE)
        {
            $query = $this->db->order_by('Period', 'ASC')->get_where('airdata7_weekly_complete');
            return $query->result_array();
        }
        $query = $this->db->get_where('airdata7_weekly_complete', array('Period' => $Period));
        return $query->row_array();
    }

    public function get_ili($Period = FALSE)
    {
      if ($Period === FALSE)
      {
        $query = $this->db->order_by('Period', 'ASC')->get_where('pc_ILI_Area');
        return $query->result_array();
      }
      $query = $this->db->get_wehre('pc_ILI_Area', array('Period' => $Period));
      return $query->row_array();
    }

    public function get_pne_flu_death($Period = FALSE)
    {
      if ($Period === FALSE)
      {
        $query = $this->db->order_by('Period', 'ASC')->get_where('pc_Pne_Flu_Death');
        return $query->result_array();
      }
      $query = $this->db->get_wehre('pc_Pne_Flu_Death', array('Period' => $Period));
      return $query->row_array();
    }

    public function get_enterovirus($Period = FALSE)
    {
      if ($Period === FALSE)
      {
        $query = $this->db->order_by('Period', 'ASC')->get_where('pc_Enterovirus');
        return $query->result_array();
      }
      $query = $this->db->get_wehre('pc_Enterovirus', array('Period' => $Period));
      return $query->row_array();
    }

    public function get_aqi($Period = FALSE)
    {
      if ($Period === FALSE)
      {
        $query = $this->db->order_by('Period', 'ASC')->get_where('pc_all_aqi');
        return $query->result_array();
      }
      $query = $this->db->get_wehre('pc_all_aqi', array('Period' => $Period));
      return $query->row_array();
    }

    public function get_pm25($Period = FALSE)
    {
      if ($Period === FALSE)
      {
        $query = $this->db->order_by('Period', 'ASC')->get_where('pc_PM25_Area');
        return $query->result_array();
      }
      $query = $this->db->get_wehre('pc_PM25_Area', array('Period' => $Period));
      return $query->row_array();
    }

    public function get_ili_aqi_area($area)
    {
      if ($area == 'Taipei') {
        $this->db->select('Year, ROUND(AVG(ILI_Taipei), 3) ILI, ROUND(AVG(AQI_Taipei), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Taipei), 3) ILI, ROUND(AVG(AQI_Taipei), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Taipei), 3) ILI, ROUND(AVG(AQI_Taipei), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Taipei), 3) ILI, ROUND(AVG(AQI_Taipei), 3) AQI');
        $query4 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2019'))->result_array();
        return array_merge($query, $query2, $query3, $query4);
      } else if ($area == 'North') {
        $this->db->select('Year, ROUND(AVG(ILI_North), 3) ILI, ROUND(AVG(AQI_North), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_North), 3) ILI, ROUND(AVG(AQI_North), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_North), 3) ILI, ROUND(AVG(AQI_North), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_North), 3) ILI, ROUND(AVG(AQI_North), 3) AQI');
        $query4 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2019'))->result_array();
        return array_merge($query, $query2, $query3, $query4);
      } else if ($area == 'Central') {
        $this->db->select('Year, ROUND(AVG(ILI_Central), 3) ILI, ROUND(AVG(AQI_Central), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Central), 3) ILI, ROUND(AVG(AQI_Central), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Central), 3) ILI, ROUND(AVG(AQI_Central), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Central), 3) ILI, ROUND(AVG(AQI_Central), 3) AQI');
        $query4 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2019'))->result_array();
        return array_merge($query, $query2, $query3, $query4);
      } else if ($area == 'South') {
        $this->db->select('Year, ROUND(AVG(ILI_South), 3) ILI, ROUND(AVG(AQI_South), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_South), 3) ILI, ROUND(AVG(AQI_South), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_South), 3) ILI, ROUND(AVG(AQI_South), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_South), 3) ILI, ROUND(AVG(AQI_South), 3) AQI');
        $query4 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2019'))->result_array();
        return array_merge($query, $query2, $query3, $query4);
      } else if ($area == 'Kaoping') {
        $this->db->select('Year, ROUND(AVG(ILI_Kaoping), 3) ILI, ROUND(AVG(AQI_Kaoping), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Kaoping), 3) ILI, ROUND(AVG(AQI_Kaoping), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Kaoping), 3) ILI, ROUND(AVG(AQI_Kaoping), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Kaoping), 3) ILI, ROUND(AVG(AQI_Kaoping), 3) AQI');
        $query4 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2019'))->result_array();
        return array_merge($query, $query2, $query3, $query4);
      } else if ($area == 'East') {
        $this->db->select('Year, ROUND(AVG(ILI_East), 3) ILI, ROUND(AVG(AQI_East), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_East), 3) ILI, ROUND(AVG(AQI_East), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_East), 3) ILI, ROUND(AVG(AQI_East), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_East), 3) ILI, ROUND(AVG(AQI_East), 3) AQI');
        $query4 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2019'))->result_array();
        return array_merge($query, $query2, $query3, $query4);
      } else {
        $this->db->select('Year,
                           ROUND(AVG(ILI_Taipei), 3) ILI_Taipei, ROUND(AVG(AQI_Taipei), 3) AQI_Taipei,
                           ROUND(AVG(ILI_North), 3) ILI_North, ROUND(AVG(AQI_North), 3) AQI_North,
                           ROUND(AVG(ILI_Central), 3) ILI_Central, ROUND(AVG(AQI_Central), 3) AQI_Central,
                           ROUND(AVG(ILI_South), 3) ILI_South, ROUND(AVG(AQI_South), 3) AQI_South,
                           ROUND(AVG(ILI_Kaoping), 3) ILI_Kaoping, ROUND(AVG(AQI_Kaoping), 3) AQI_Kaoping,
                           ROUND(AVG(ILI_East), 3) ILI_East, ROUND(AVG(AQI_East), 3) AQI_East');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year,
                           ROUND(AVG(ILI_Taipei), 3) ILI_Taipei, ROUND(AVG(AQI_Taipei), 3) AQI_Taipei,
                           ROUND(AVG(ILI_North), 3) ILI_North, ROUND(AVG(AQI_North), 3) AQI_North,
                           ROUND(AVG(ILI_Central), 3) ILI_Central, ROUND(AVG(AQI_Central), 3) AQI_Central,
                           ROUND(AVG(ILI_South), 3) ILI_South, ROUND(AVG(AQI_South), 3) AQI_South,
                           ROUND(AVG(ILI_Kaoping), 3) ILI_Kaoping, ROUND(AVG(AQI_Kaoping), 3) AQI_Kaoping,
                           ROUND(AVG(ILI_East), 3) ILI_East, ROUND(AVG(AQI_East), 3) AQI_East');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year,
                           ROUND(AVG(ILI_Taipei), 3) ILI_Taipei, ROUND(AVG(AQI_Taipei), 3) AQI_Taipei,
                           ROUND(AVG(ILI_North), 3) ILI_North, ROUND(AVG(AQI_North), 3) AQI_North,
                           ROUND(AVG(ILI_Central), 3) ILI_Central, ROUND(AVG(AQI_Central), 3) AQI_Central,
                           ROUND(AVG(ILI_South), 3) ILI_South, ROUND(AVG(AQI_South), 3) AQI_South,
                           ROUND(AVG(ILI_Kaoping), 3) ILI_Kaoping, ROUND(AVG(AQI_Kaoping), 3) AQI_Kaoping,
                           ROUND(AVG(ILI_East), 3) ILI_East, ROUND(AVG(AQI_East), 3) AQI_East');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        $this->db->select('Year,
                           ROUND(AVG(ILI_Taipei), 3) ILI_Taipei, ROUND(AVG(AQI_Taipei), 3) AQI_Taipei,
                           ROUND(AVG(ILI_North), 3) ILI_North, ROUND(AVG(AQI_North), 3) AQI_North,
                           ROUND(AVG(ILI_Central), 3) ILI_Central, ROUND(AVG(AQI_Central), 3) AQI_Central,
                           ROUND(AVG(ILI_South), 3) ILI_South, ROUND(AVG(AQI_South), 3) AQI_South,
                           ROUND(AVG(ILI_Kaoping), 3) ILI_Kaoping, ROUND(AVG(AQI_Kaoping), 3) AQI_Kaoping,
                           ROUND(AVG(ILI_East), 3) ILI_East, ROUND(AVG(AQI_East), 3) AQI_East');
        $query4 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2019'))->result_array();
        return array_merge($query, $query2, $query3, $query4);
      }
    }

    public function get_lagtime($lag_week = FALSE)
    {
        if ($lag_week === FALSE)
        {
            $query = $this->db->order_by('lag_week', 'ASC')->get_where('bs_lm_result_air_df');
            return $query->result_array();
        }
        $query = $this->db->get_where('bs_lm_result_air_df', array('lag_week' => $lag_week));
        return $query->row_array();
    }

    public function get_hourly_xt($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'ASC')->get_where('airquality', array('SiteName' => '西屯'));
            return $query->result_array();
        }
        $query = $this->db->get_where('airquality', array('SiteName' => $SiteName));
        return $query->row_array();
    }

    public function get_vocs($id = FALSE)
    {
      //$query = $this->db->get_where('pc_voc', array('SiteName' => $siteName));
      //return $query->row_array();
        if ($id === FALSE)
        {
            $query = $this->db->order_by('PublishTime', 'ASC')->get_where('pc_voc');
            return $query->result_array();
        }
        $query = $this->db->get_where('pc_voc', array('id' => $id));
        return $query->row_array();
    }

    public function get_predict($Time = FALSE)
    {
        if ($Time === FALSE)
        {
            $query = $this->db->order_by('Time', 'DESC')->get_where('PM25_Taichung_4hrs_pred_history_16', array('sitename' => $this->input->post('siteName')), 56);
            return $query->result_array();
        }
        $query = $this->db->get_where('PM25_Taichung_4hrs_pred_16', array('sitename' => $sitename));
        return $query->row_array();
    }

    public function get_jf($Time = FALSE)
    {
        if ($Time === FALSE)
        {
            $query = $this->db->order_by('Time', 'DESC')->get_where('PM25_Taichung_4hrs_pred_history_16');
            return $query->result_array();
        }
        $query = $this->db->get_where('PM25_Taichung_4hrs_pred_16', array('sitename' => $sitename));
        return $query->row_array();
    }

    public function get_valid_car($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'DESC')->get_where('airquality', array('SiteName' => '交通監測車'), 360);
            return $query->result_array();
        }
        $query = $this->db->get_where('airquality', array('SiteName' => $SiteName));
        return $query->row_array();
    }

    public function get_valid_sensor($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->order_by('id', 'DESC')->get_where('LoRa', array('sensor' => 'B1'), 360);
            return $query->result_array();
        }
        $query = $this->db->get_where('LoRa', array('sensor' => $sensor));
        return $query->row_array();
    }
}
