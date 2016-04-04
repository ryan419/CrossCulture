<?php
class eventbrite {
    var $endpoint = 'https://www.eventbriteapi.com/v3/';
    var $token = '';

    function __construct($oauth_token) {
        $this->token = $oauth_token;
    }

    function __call($method, $args) {
        // Get the URI we need.
        $uri = $this->build_uri($method, $args);
        // Construct the full URL.
        $request_url = $this->endpoint . $uri;
        // This array is used to authenticate our request.
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header'=> "Authorization: Bearer " . $this->token
            )
        );
        // Call the URL and get the data.
        $resp = file_get_contents($request_url, false, stream_context_create($options));
        // Return it as arrays/objects.
        return (array) json_decode($resp);
    }

    function build_uri($method, $args) {
        $url = $args[0];
        $query = $args[1];

        if (array_key_exists('id', $query)){
            return $url. '/'. $query['id'];
        }
        else {
            $getdata = http_build_query($query['data']);
        }
        $uri = $url. '?'. $getdata;
        return $uri;
    }


}
?>
