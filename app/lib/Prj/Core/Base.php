<?php
class Prj_Core_Base{
  	public function __construct() {

  	}
}
	/**
	 * function validate_alphanumeric_underscore()
	 *
	 * @param unknown_type $str
	 */
    function validate_alphanumeric_underscore($str)
	{
    	return preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$str);
	}

	function validate_local_username($str)
	{
		return preg_match('/^[a-zA-Z0-9._-]+$/',$str);
	}


	function createDateRangeArray($strDateFrom,$strDateTo) {
		//objp($strDateFrom);
		// takes two dates formatted as YYYY-MM-DD and creates an
		// inclusive array of the dates between the from and to dates.

		// could test validity of dates here but I'm already doing
		// that in the main script

		$aryRange=array();

		$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
		$iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

		if ($iDateTo>=$iDateFrom) {
	    	array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

			while ($iDateFrom<$iDateTo) {
				$iDateFrom+=86400; // add 24 hours
				array_push($aryRange,date('Y-m-d',$iDateFrom));
			}
	  	}
	  	return $aryRange;
	}
    function dateRange($page = 1, $from_interval = 7)
    {
		$to_days = ($page - 1) * $from_interval;
		$from_days = $page * $from_interval - 1;

    	# create a range to fill in rows with no trips
    	$date_to 	= date('Y-m-d', strtotime('-' . $to_days .' days'));
    	$date_from 	= date('Y-m-d', strtotime('-' . $from_days .' days'));
    	$dates 		= createDateRangeArray($date_from, $date_to);

    	rsort($dates);

    	return $dates;
    }

    /**
     * @method mysql_time
     * @param integer $unix_time
     * @return string
     */
    function mysql_time($unix_time=0) {
        // unix time is since epoch
        if (empty($unix_time)) {
            $unix_time = time();
        }
        return date('Y-m-d H:i:s', $unix_time);
    }

    function url_validate( $link )
    {
        $url_parts = @parse_url( $link );

        if ( empty( $url_parts["host"] ) ) return( false );

        if ( !empty( $url_parts["path"] ) )
        {
            $documentpath = $url_parts["path"];
        }
        else
        {
            $documentpath = "/";
        }

        if ( !empty( $url_parts["query"] ) )
        {
            $documentpath .= "?" . $url_parts["query"];
        }

        $host = $url_parts["host"];
        $port = $url_parts["port"];
        // Now (HTTP-)GET $documentpath at $host";

        if (empty( $port ) ) $port = "80";
        $socket = @fsockopen( $host, $port, $errno, $errstr, 30 );
        if (!$socket)
        {
            return(false);
        }
        else
        {
            fwrite ($socket, "HEAD ".$documentpath." HTTP/1.0\r\nHost: $host\r\n\r\n");
            $http_response = fgets( $socket, 22 );

            if ( ereg("200 OK", $http_response, $regs ) )
            {
                return(true);
                fclose( $socket );
            } else
            {
//                echo "HTTP-Response: $http_response<br>";
                return(false);
            }
        }
    }
?>