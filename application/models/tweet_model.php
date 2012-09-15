<?php
class Tweet_model extends CI_Model 
{
	
	protected $tweet_folder = "web/tweet_cache/";

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function get_latest_tweets() 
	{
		$tweeters = array(
			array(	"screen_name" => "VisualiseringC", 
					"last_update" => 10),
			array(	"screen_name" => "GaiaSystem", 
					"last_update" => 1),
		);
		
		$all_tweets = array();
		foreach($tweeters as $t) {
			$path = $this->tweet_folder.$t['screen_name'].".txt";
			if(!file_exists($path) || $t['last_update'] > 10) {
				$url = "https://api.twitter.com/1/statuses/user_timeline.json";
				$url .= "?include_rts=false";
				$url .= "&screen_name=". $t['screen_name'];
				$url .= "&count=10";
				$ch = curl_init($url);
				$fp = fopen($path, "w");
				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_setopt($ch, CURLOPT_HEADER, 0);

				curl_exec($ch);
				curl_close($ch);
				fclose($fp);
			}
			$fp = fopen($path, "r");
			$contents = fread($fp, filesize($path));
			$arr = json_decode($contents);
			$all_tweets = array_merge($all_tweets,$arr);
		} 
		
		// sort by DESC post date
		usort($all_tweets, "Tweet_model_array_sort");
		
		// only return the 10 latest
		$i = 0;
		foreach($all_tweets as $tweet) 
		{
			if($i > 9) 
			{
				unset($all_tweets[$i]);
			}
			$i++;
		}
		
		return $all_tweets;
	}
	

}
function Tweet_model_array_sort($a, $b)
{
	$d1 = strtotime($a->created_at);
	$d2 = strtotime($b->created_at);
    return $d1 < $d2;
}
