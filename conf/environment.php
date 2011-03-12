<?php

/**
 * Any enviroment specific stuff goes in here.
 */

global $_picnic_release, $_picnic_path, $_config_path, $_ENVIRONMENT, $_PATHS;

// picnic release info
$_picnic_release = "0.23";

// put picnic default path here else as:
// SetEnv PICNIC_PATH "/path/to/picnicphp/lib"
// in apache config
$_picnic_default_path = "/Users/neel/Work/picnic/lib";

// optionally override project config path here else as:
// SetEnv PRJ_CONFIG_PATH 
// in apache config
## $_config_default_path = "/path/to/project/conf"

// this must be the path to the lib directory which contains 'Pfw'
$_picnic_path = getenv("PICNIC_PATH");
if (empty($_picnic_path)) {
    $_picnic_path = $_picnic_default_path;
}

$_config_path = getenv('PRJ_CONFIG_PATH');
if (empty($_config_path)) {
    $_config_path = $_config_default_path;
}

// set your environment name, which affects which config files are loaded
if (!isset($_ENVIRONMENT)) {
    if ($ext_env = getenv("PFW_ENVIRONMENT")) {
        $_ENVIRONMENT = $ext_env;
    } else {
        $_ENVIRONMENT = "development";
    }
}

?>