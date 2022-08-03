<?php
/*

TXDOT SPY SCRIPT

Features:
Easy to select Cameras & Cities
Refreshes every 30 Seconds
Enlarge camera on click
Display 12 different cameras
Live time and date and information

*/
function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}
function convertTXDot($area,$city) {
  $area = urlencode($area);
  $city = urlencode($city);
 $link = "https://its.txdot.gov/its/DistrictIts/GetCctvSnapshotByIcdId?icdId=$area&districtCode=$city"; 
  $link = json_decode(file_get_contents_curl($link),1);
  $linkb64 = $link["snippet"];
  $base64 = 'data:image/' . "jfif" . ';base64,' . $linkb64;
  return '<img onclick="imgEnlarge(this)" onclick="imgAssign()" src="' . $base64 . '" style="width:400px;height:300px" title="' . $link["icd_Id"] . '">';
}
?>
<html>
  <head>
<title>TXDOT SPY</title>
<meta http-equiv="refresh" content="30" />
  </head>
  <body style="background-color:black;" onload=display_ct();>
<center>
<?php echo convertTXDot("IH35 @ Oak St","DAL"); ?>
<?php echo convertTXDot("US75 @ Stacy Rd South","DAL"); ?>
<?php echo convertTXDot("US75 @ Stacy Rd North","DAL"); ?>
<?php echo convertTXDot("LBJ Express IH635 @ Joe Ratcliff WB Express Lanes","DAL"); ?>
<?php echo convertTXDot("US75 @ IH635 North","DAL"); ?>
<?php echo convertTXDot("US75 @ Midpark","DAL"); ?>
<?php echo convertTXDot("US75 @ Spring Valley","DAL"); ?>  
<?php echo convertTXDot("US75 @ Spring Valley North","DAL"); ?>
<?php echo convertTXDot("US75 @ Arapaho","DAL"); ?>  
<?php echo convertTXDot("IH35E @ SRT Express Lanes","DAL"); ?>
<?php echo convertTXDot("IH35E @ SRT (SH121 Bypass) NB","DAL"); ?>
<?php echo convertTXDot("LBJ Express IH635 @ Midway WB","DAL"); ?>
  <h3 style="color:white;">TX DOT SPY - <span id='ct' ></span> - Refreshing in <span id="countdowntimer">30 </span> seconds</h3>
</center>
    <script type="text/javascript">
      var imgEnlarged = 0;
var otherEnlargedImgs = [0, 0, 0, 0, 0, 0, 0, 0,];
function imgEnlarge(e){
  if (imgEnlarged==0){ //Basic function if no enlarged, enlarge click element
    e.style.width = "700px";
    e.style.height = "600px";
    imgEnlarged = 1;
    otherEnlargedImgs[e] = 1 
  }
  else if (imgEnlarged==1) { //If an image is enlarged, is it this one? If so, resize image
    e.style.width = "400px";
    e.style.height = "300px";
    imgEnlarged = 0;
    otherEnlargedImgs[0] = 0
  }
  else if (imgEnlarged==1 && imgEnlargedOther==1)  { //if enlarged, which? Close other, open current element
    e.style.width = "400px";
    e.style.height = "300px";
    imgEnlarged = 1
    otherEnlargedImgs[0] = 1
  }
}
function imgAssign() {

}
    var timeleft = 30;
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0)
        clearInterval(downloadTimer);
    },1000);
      function display_c(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('display_ct()',refresh)
}

function display_ct() {
var x = new Date()
document.getElementById('ct').innerHTML = x;
display_c();
 }
</script>
  </body>
    </html>
