<?php

    $YMD = $_GET["YMD"];
    if($YMD == null){
        $YMD = date("Ymd", time());
    }
    function curl($url){
        $req = curl_init();
        curl_setopt($req, CURLOPT_URL, $url);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req, CONNECTION_TIMEOUT, 10);
        curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($req, CURLOPT_CUSTOMREQUEST, "GET");
        $res = curl_exec($req);
        $code = curl_getinfo($req, CURLINFO_HTTP_CODE);
        return array(
            "code" => $code,
            "res" => $res
        );
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>선린 급식</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="logo.png" alt="학교 로고">
      <h1>SRIHS</h1>
    </div>
  </header>
  <main>
    <div class="meal">
      <h2>맛있는 급식</h2>
      <div class="meal-info">
        <div class="meal-image">
          <img src="layer7.png" alt="급식 이미지">
        </div>
        <div class="meal-text">
            <?php
                $url = "https://open.neis.go.kr/hub/mealServiceDietInfo?KEY=**yourKeyHere**&Type=json&pIndex=1&pSize=10&ATPT_OFCDC_SC_CODE=B10&SD_SCHUL_CODE=7010536&MLSV_YMD=".$YMD;
                extract(curl($url));
                $res = json_decode($res, true);
                if(isset($res["RESULT"]["MESSAGE"])){
                    echo $res["RESULT"]["MESSAGE"];
                }
                echo $res["mealServiceDietInfo"][1]["row"][0]["DDISH_NM"]."<br>";
            ?>
        </div>
      </div>
      <div class="date-navigation">
        <a href="/index.php?YMD=<?php $_YMD = new DateTime($YMD);$_YMD->modify("-1 day");echo $_YMD->format("Ymd");?>">이전 날짜</a>
        <p><?php echo ((new DateTime($YMD))->format("Y년 m월 d일")) ?></p>
        <a href="/index.php?YMD=<?php $_YMD = new DateTime($YMD);$_YMD->modify("+1 day");echo $_YMD->format("Ymd");?>">다음 날짜</a>
      </div>
    </div>
  </main>
  <footer>
    <nav>
    </nav>
  </footer>
</body>
</html>
