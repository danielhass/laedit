<?php

/*
 * Functions to deal with config stuff
 */

function settings_testFile() {
   if(file_exists(config_file) &&
         is_readable(config_file))
      return true;
   Error::push("Settings file not usable (".config_file.")");
   Error::push("Exists (should be true): ".(file_exists(config_file) ? "true" : "false" ));
   Error::push("Readable (should be true): ".(is_readable(config_file) ? "true" : "false"));

   return false;
}
function settings_ldap_server() {
   $ini = parse_ini_file(config_file);
   return $ini['ldap-server'];
}

function settings_ldap_base_dn() {
   $ini = parse_ini_file(config_file);
   return $ini['ldap-base-dn'];
}

function settings_ldap_tls_connect() {
   $ini = parse_ini_file(config_file);
   return $ini['ldap-use-tls'];
}

function settings_instance() {
   $ini = parse_ini_file(config_file);
   return $ini['instance'];
}

function settings_loginservice() {
   $ini = parse_ini_file(config_file);
   return $ini['loginservice'];
}
?>