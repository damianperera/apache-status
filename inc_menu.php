<?php

/*
 * PIMPED APACHE-STATUS
 * GENERATE ARRAYS FOR MENUS
 */

// ------------------------------------------------------------
// servergroups and servers
// ------------------------------------------------------------

foreach ($aServergroups as $sGroup => $aServers) {
    foreach ($aServers['servers'] as $sServer => $aData) {
        if (!array_key_exists("disabled", $aData)) {
            if ($sGroup == $aEnv["active"]["group"]) {
                if (count($aServers2Collect) == 1 && $aServers2Collect[0] == $sServer) {
                    $aEnv["links"]["servers"][$sGroup]["subitems"][$sServer]["active"] = true;
                }
            }
            $aEnv["links"]["servers"][$sGroup]["subitems"][$sServer]["url"] = getNewQs(array("servers" => $sServer, "group" => $sGroup, "url" => ""));

            $sLabel = array_key_exists("label", $aData) ? $aData['label'] : $sServer;
            $aEnv["links"]["servers"][$sGroup]["subitems"][$sServer]["label"] = $sLabel;
        }
    }

    // if (count($aServers['servers'])==1) unset ($aEnv["links"]["servers"][$sGroup]["subitems"][$sServer]["active"]);
    if ($sGroup == $aEnv["active"]["group"] 
            // && count($aServers2Collect) <> 1
            ) {
        $aEnv["links"]["servers"][$sGroup]["active"] = true;
    }
    $aEnv["links"]["servers"][$sGroup]["label"] = $aLangTxt['menuGroup'] . ' ' . $sGroup;
    $aEnv["links"]["servers"][$sGroup]["class"] = "group";
    $aEnv["links"]["servers"][$sGroup]["url"] = getNewQs(array("servers" => "", "group" => $sGroup, "url" => ""));
}


// ------------------------------------------------------------
// available views
// ------------------------------------------------------------
$aEnv["links"]["views"]['admin'] = array(
    "label" =>  $aCfg['icons']['admin'] . $aLangTxt['menuAdmin'],
    "url" => './admin/'.getNewQs(),
    "class" => 'adminlink',
    "active" => false,
);
foreach ($aCfg['views'] as $s) {
    $sLabel = '';
    if (array_key_exists($s, $aCfg['icons'])) {
        $sLabel.=$aCfg['icons'][$s] . ' ';
    }
    $sLabel .= $aLangTxt['view_' . $s . '_label'] ? $aLangTxt['view_' . $s . '_label'] : $s;
    $aEnv["links"]["views"][$s] = array(
        "label" => $sLabel,
        "url" => getNewQs(array("view" => $s)),
        "active" => ($s == $aEnv["active"]["view"]),
    );
}

// ------------------------------------------------------------
// available languages
// ------------------------------------------------------------
if ($aCfg['selectLang']) {
    foreach (explode(",", $aCfg['selectLang']) as $s) {
        $aEnv["links"]["lang"][$s] = array(
            "label" => $s,
            "url" => getNewQs(array("lang" => $s)),
            "active" => ($s == $aEnv["active"]["lang"]),
        );
    }
}

// ------------------------------------------------------------
// available skins
// ------------------------------------------------------------
if ($aCfg['selectSkin']) {
    foreach (explode(",", $aCfg['selectSkin']) as $s) {
        $aEnv["links"]["skins"][$s] = array(
            "label" => $s,
            "url" => getNewQs(array("skin" => $s)),
            "active" => ($s == $aEnv["active"]["skin"]),
        );
    }
}

// ------------------------------------------------------------
// autoreload page
// ------------------------------------------------------------
if ($aCfg['autoreload']) {
    foreach ($aCfg['autoreload'] as $iTime) {
        $s = $iTime . " s";
        if ($s == " s")
            $s = "---";
        $aEnv["links"]["reload"][$s] = array(
            "label" => $s,
            "url" => getNewQs(array("reload" => $iTime)),
            "active" => ($iTime == $aEnv["active"]["reload"]),
        );
    }
}