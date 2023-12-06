<?php 

function toTimeISO($time){
    return date('c', strtotime($time));
}

function modelTimeISO($data, $fields){
    if(isset($data['data'][0])){
        foreach($data['data'] as $i => $d){
            foreach($fields as $field){
                if(!isset($d[$field])) continue;
                $data['data'][$i][$field] = toTimeISO($d[$field]);
            }
        }
        return $data;
    }
    
    foreach($fields as $field){
        if(!isset($data['data'][$field])) continue;
        $data['data'][$field] = toTimeISO($data['data'][$field]);
    }
    return $data;
}

function getErrors($errors){
    if(!$errors) return null;
    $text = '';
    foreach($errors as $key => $val){
        $text .= $val.' ';
    }
    return trim($text);
}

function rupiah($price){
    return 'Rp'.number_format($price,0);
}

?>