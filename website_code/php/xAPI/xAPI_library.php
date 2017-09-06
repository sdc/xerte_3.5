<?php

function xAPI_html_page_create($template_name, $type, $lo_name, $language, $tsugi) {

global $xerte_toolkits_site, $dir_path, $delete_file_array, $zipfile, $youtube_api_key;

	$version = file_get_contents(dirname(__FILE__) . "/../../../version.txt");
	if($tsugi)
	{
		$xapi_html_page_content = file_get_contents($xerte_toolkits_site->basic_template_path . $type . "/player_html5/rloObject.php");
	}else{
		$xapi_html_page_content = file_get_contents($xerte_toolkits_site->basic_template_path . $type . "/player_html5/rloObject.htm");

	}
	$xapi_html_page_content = str_replace("%VERSION%", $version , $xapi_html_page_content);
    $xapi_html_page_content = str_replace("%VERSION_PARAM%", "", $xapi_html_page_content);
    $xapi_html_page_content = str_replace("%TITLE%",$lo_name,$xapi_html_page_content);
    $xapi_html_page_content = str_replace("%TEMPLATEPATH%","",$xapi_html_page_content);
    $xapi_html_page_content = str_replace("%XMLPATH%","",$xapi_html_page_content);
    $xapi_html_page_content = str_replace("%XMLFILE%","template.xml",$xapi_html_page_content);
    $xapi_html_page_content = str_replace("%THEMEPATH%", "themes/" . $template_name . "/",$xapi_html_page_content);
    $xapi_html_page_content = str_replace("%OFFLINESCRIPTS%", "",$xapi_html_page_content);
    $xapi_html_page_content = str_replace("%OFFLINEINCLUDES%", "",$xapi_html_page_content);
    $xapi_html_page_content = str_replace("%MATHJAXPATH%", "https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/", $xapi_html_page_content);
	
    $endpoint = $xerte_toolkits_site->LRS_Endpoint;
    $secret = $xerte_toolkits_site->LRS_Secret;
    $key = $xerte_toolkits_site->LRS_Key;
	
	$tracking = "<script type=\"text/javascript\" src=\"xttracking_xapi.js\"></script>\n";
	$tracking .= "<script type=\"text/javascript\" src=\"languages/js/en-GB/xttracking_xapi.js\"></script>\n";
	$tracking .= "<script type=\"text/javascript\" src=\"tincan.js\"></script>\n";
	$tracking .= "<script>var lrsEndpoint=\"$endpoint\";var lrsPassword=\"$secret\"; var lrsUsername=\"$key\";</script>";
	if (file_exists($dir_path . "languages/js/" . $language . "/xttracking_xapi.js") && $language != "en-GB")
	{
		$tracking .= "<script type=\"text/javascript\" src=\"languages/js/" . $language . "/xttracking_xapi.js\"></script>";
	}
	$xapi_html_page_content = str_replace("%TRACKING_SUPPORT%",$tracking,$xapi_html_page_content);
	$xapi_html_page_content = str_replace("%YOUTUBEAPIKEY%", $youtube_api_key, $xapi_html_page_content);
	
	if($tsugi)
	{
		$index_file = "index.php";
	}else{
		$index_file = "index.htm";
	}
	$file_handle = fopen($dir_path . $index_file, 'w');
	
	fwrite($file_handle,$xapi_html_page_content,strlen($xapi_html_page_content));
	fclose($file_handle);
	
	$zipfile->add_files($index_file);
	
	array_push($delete_file_array,  $dir_path . $index_file);
	
	
	/*
	$file = fopen("debug.txt", "a+");
	fwrite($file, $tracking."\n");
	fclose($file);
	*/
}

?>