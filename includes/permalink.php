<?php

//Lấy link theo module
function getLinkModule($module, $id, $table=null, $field=null){
    $prefixUrl = getPrefixLinkService($module);

    if (empty($table)){
        $table = $module;
    }

    if (empty($field)){
        $field = 'slug';
    }

    $sql = "SELECT $field FROM $table WHERE id=$id";

    $moduleDetail = firstRaw($sql);

    if (!empty($moduleDetail)){
        $link = _WEB_HOST_ROOT.'/'.$prefixUrl.'/'.$moduleDetail[$field].'-'.$id.'.html';

        return $link;
    }

    return false;

}

function getPrefixLinkService($module=''){
    $prefixArr = [
        'categorys' => 'dich-vu',

    ];

    if (!empty($prefixArr[$module])){
        return $prefixArr[$module];
    }

    return false;
}