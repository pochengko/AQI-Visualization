<?php
class Tcvgh_model extends CI_Model {

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
        $query = $this->db->order_by('Period', 'ASC')->get_where('pc_ILI_Area', array('Year' => '2019'));
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
        return array_merge($query, $query2, $query3);
      } else if ($area == 'North') {
        $this->db->select('Year, ROUND(AVG(ILI_North), 3) ILI, ROUND(AVG(AQI_North), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_North), 3) ILI, ROUND(AVG(AQI_North), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_North), 3) ILI, ROUND(AVG(AQI_North), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        return array_merge($query, $query2, $query3);
      } else if ($area == 'Central') {
        $this->db->select('Year, ROUND(AVG(ILI_Central), 3) ILI, ROUND(AVG(AQI_Central), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Central), 3) ILI, ROUND(AVG(AQI_Central), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Central), 3) ILI, ROUND(AVG(AQI_Central), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        return array_merge($query, $query2, $query3);
      } else if ($area == 'South') {
        $this->db->select('Year, ROUND(AVG(ILI_South), 3) ILI, ROUND(AVG(AQI_South), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_South), 3) ILI, ROUND(AVG(AQI_South), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_South), 3) ILI, ROUND(AVG(AQI_South), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        return array_merge($query, $query2, $query3);
      } else if ($area == 'Kaoping') {
        $this->db->select('Year, ROUND(AVG(ILI_Kaoping), 3) ILI, ROUND(AVG(AQI_Kaoping), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Kaoping), 3) ILI, ROUND(AVG(AQI_Kaoping), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_Kaoping), 3) ILI, ROUND(AVG(AQI_Kaoping), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        return array_merge($query, $query2, $query3);
      } else if ($area == 'East') {
        $this->db->select('Year, ROUND(AVG(ILI_East), 3) ILI, ROUND(AVG(AQI_East), 3) AQI');
        $query = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2016'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_East), 3) ILI, ROUND(AVG(AQI_East), 3) AQI');
        $query2 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2017'))->result_array();
        $this->db->select('Year, ROUND(AVG(ILI_East), 3) ILI, ROUND(AVG(AQI_East), 3) AQI');
        $query3 = $this->db->get_where('airdata7_weekly_complete', array('Year' => '2018'))->result_array();
        return array_merge($query, $query2, $query3);
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
        return array_merge($query, $query2, $query3);
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

    public function get_outbreak($year)
    {
      //if ($Period === FALSE)
      //{
          $query = $this->db->order_by('Period', 'ASC')->get_where('pc_ILI_Outbreak', array('Year' => $this->input->post('selectYear')));
          $temp = $query->result_array();
          $data = array();
          foreach($temp as $t){
            if($t['Year'] == $year){
                array_push($data,$t);
            }
          }
          return $data;

      /*    return $query->result_array();
      }
      $query = $this->db->get_where('pc_ILI_Outbreak', array('Period' => $Period));
      return $query->row_array();*/

    }

    public function get_cigs($Period = FALSE)
    {
      if ($Period === FALSE)
      {
        $query = $this->db->order_by('Period', 'DESC')->get_where('pc_PM25_Area', array('Year' => '2018'), 2);
        return $query->result_array();
      }
      $query = $this->db->get_wehre('pc_PM25_Area', array('Period' => $Period));
      return $query->row_array();
    }


}
