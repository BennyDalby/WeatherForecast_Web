
<?php
if($_GET)
{
  
    if($_GET['city1'] && $_GET['city'] && isset($_GET['temp']) && (isset($_GET['state_options'])!='state'))
    {
    $newadress =$_GET['city1'].",".$_GET['city'].",".isset($_GET['state_options']);
    
    $data_arr=geocode($newadress);
    
    }
}
?>


 <?php
 
// function to geocode address, it will return false if unable to geocode address
function geocode($address)
{
 
    // url encode the address
    //echo $address;
    $address = urlencode($address);
    //echo $address;
    $key="AIzaSyBNPXdy7idIMrlW5TADAqUvAgOernZxB68" ;
     
    $url="https://maps.google.com/maps/api/geocode/xml?address=".$address."&key=".$key;
    //echo $url;
    //$url="https://maps.google.com/maps/AIzaSyBNPXdy7idIMrlW5TADAqUvAgOernZxB68/geocode/xml?address" ;
    $response_xml_data = file_get_contents($url);
   //$response_xml_data = iconv("cp1251", "UTF-8", $response_xml_data);
    $response_xml_data = simplexml_load_string($response_xml_data);
    
    //echo ($response_xml_data->result[0]->geometry[0]->location[0]->lat);
    
     
    if($response_xml_data && $response_xml_data->status!="ZERO_RESULTS")
    {	

    	if (isset($_GET['temp'])) 
    	{  // if ANY of the options was checked
           $radiovalue=$_GET['temp']; 

           if($radiovalue=="farenheit")
           {
           	$radiovalue="us";
           }

           else 
           {
           	$radiovalue="si";
           }
       }
    		$latitude = $response_xml_data->result[0]->geometry[0]->location[0]->lat;
    		$longitude = $response_xml_data->result[0]->geometry[0]->location[0]->lng ;
    		if($latitude && $longitude)
    		{
    			//echo "hoooray";
    		
    		$url = "https://api.forecast.io/forecast/89beca0c0ce0f995630e84225452e7d2/".$latitude.",".$longitude."?units=".$radiovalue."&exclude=flags" ;
    		//echo $url;
    		$response_json_data = file_get_contents($url) ;
    		$obj = json_decode($response_json_data,true);
    		echo json_encode($obj) ;

    	}
    }

}
    		

    		?>
  




