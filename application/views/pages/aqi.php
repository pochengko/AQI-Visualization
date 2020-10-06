<div class="container">
  <!-- Introduction Row -->
  <h1 class="my-4">
    <a href="http://hpc.thu.edu.tw/"><img src="/img/hpc_transparent.png" height="auto" width="30%"></img></a><br>
    </h1>
  <h4>MOST105-2634-E-029-001-時空巨量資料分析平台之設計與實作</h4>
  <h4>MOST106-2621-M-029-001-環境變遷下的永續都會治理:以台中市為例</h4>
  <h4>MOST106-3114-M-029-001-A台灣空氣品質大數據監測平台、機器學習與政策模擬之跨領域研究</h4>
  <h4>TCVGH-T107-7803-建置台灣即時空污微粒暴露對肺炎與流感死亡風險之健康預警系統-以機器自動學習之方法</h4>

<div class="my-4">
  <h2 class="my-4"><b>簡介</b></h2>
  <h4>1. 本研究宗旨提供一個創新應用之研究環境，兼顧效能以及應用加值。實作方面，本系統分成二個階段。</h4>
  <h4>2. 建立一個叢集的(HDFS)作儲存與Spark環境作運算，本研究使用ELK Stack作為視覺化平台與Ceph Object Storage作為資料備份。</h4>
  <h4>3. 串接Open Data API自動導入空氣品質與類流感資料至MySQL。使用PHP篩選與調整環保署所提供的空氣品質及類流感資料，並使用MySQL作為前後端儲存。</h4>
  <h4>4. 運算上，使用Sqoop將資料從MySQL導入HDFS，再使用Spark配合HDFS作為暫存，為了加速存取資料使用Alluxio成為兩端之橋梁。</h4>
  <h4>5. 資料儲存在HDFS，自動傳輸到Alluxio記憶體中，讓Spark在記憶體環境讀取更加快速，由此環境能夠增進兩倍的速度讀取資料。最終由ELK Stack將空氣品質資料及類流感資料匯入，並透過此平台視覺化分析。</h4>
</div>
<div class="container-fluid text-center">

<div class="row">
    <div class="col-md-6">
      <h2>Software Architecture</h2>
      <img src="/img/system.PNG" class="img-responsive" style="width:100%" alt="Image">
    </div>
    <div class="col-md-6">
      <h2>System Architecture</h2>
      <img src="/img/architecture.jpg" class="img-responsive" style="width:100%" alt="Image">
    </div>
  </div>
</div>
<!-- Team Members Row -->
<div class="row">
  <div class="col-lg-12">
    <h2 class="my-4">Our Team</h2>
  </div>
  <div class="col-lg-4 col-sm-6 text-center mb-4">
    <img class="img-circle" src="public/img/CT.jpg" alt="">
    <h3>Chao-Tung Yang*<br>
        <small>Distinguished Professor</small>
      </h3>
    <p>ctyang@thu.edu.tw</p>
  </div>
  <div class="col-lg-4 col-sm-6 text-center mb-4">
    <img class="img-circle" src="public/img/YA.jpg" alt="">
    <h3>Yuan-An Chen<br>
        <small>Postgraduate Student</small>
      </h3>
    <p>a961309@gmail.com</p>
  </div>
  <div class="col-lg-4 col-sm-6 text-center mb-4">
    <img class="img-circle" src="public/img/HOU.jpg" alt="">
    <h3>Hou Lin<br>
        <small>Postgraduate Student</small>
      </h3>
    <p>mike840724@gmail.com</p>
  </div>
  <div class="col-lg-4 col-sm-6 text-center mb-4">
    <img class="img-circle" src="public/img/PC.jpg" alt="">
    <h3>Po-Cheng Ko</br>
        <small>Postgraduate Student</small>
      </h3>
    <p>pocheng0605@gmail.com</p>
  </div>
  <div class="col-lg-12">
    <h4 class="my-4">Graduated</h4>
  </div>
  <div class="col-lg-4 col-sm-6 text-center mb-4">
    <img class="img-circle" src="public/img/CJ.jpg" alt="">
    <h3>Cai-Jin Chen<br>
        <small>Postgraduate Student</small>
      </h3>
    <p>amranchen@yahoo.com</p>
  </div>
  <div class="col-lg-4 col-sm-6 text-center mb-4">
    <img class="img-circle" src="public/img/YT.png" alt="">
    <h3>Yuan-Ting Wang<br>
        <small>Postgraduate Student</small>
      </h3>
    <p>j8060172@yahoo.com.tw</p>
  </div>
  <div class="col-lg-4 col-sm-6 text-center mb-4">
    <img class="img-circle" src="public/img/TY.jpg" alt="">
    <h3>Tzu-Yang Chen<br>
        <small>Postgraduate Student</small>
      </h3>
    <p>applepaoo@gmail.com</p>
  </div>
  <div class="col-lg-4 col-sm-6 text-center mb-4">
    <img class="img-circle" src="public/img/JF.jpg" alt="">
    <h3>Jing-Fang Li<br>
        <small>Postgraduate Student</small>
      </h3>
    <p>mhu6ikb9@gmail.com</p>
  </div>
  <div class="col-lg-4 col-sm-6 text-center mb-4">
    <img class="img-circle" src="public/img/BS.jpg" alt="">
    <h3>Ben-Siang Lu<br>
        <small>Postgraduate Student</small>
      </h3>
    <p>aloo31124@gmail.com</p>
  </div>
</div>
</div>
