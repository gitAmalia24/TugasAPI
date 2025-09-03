<?php

function response_json($status_code, $message, $data = null){
    http_response_code($status_code);

    $array = [
        'status'   => $status_code,
        'message'  => $message,
        'time'     => date("Y-m-d H:i:s") // opsional: timestamp server
    ];

    if ($data !== null) {
        $array['data'] = $data;
    }

    return $array;
}

?>
