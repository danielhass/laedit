<?php

/*
 * Functions to deal with config stuff
 */

function settings_testFile() {
   if(file_exists(config_file) &&
         is_readable(config_file))
      return true;

   echo "File transactions failed, the following should be true, true\n";
   echo "Exists : ".(file_exists(config_file) ? "true" : "false" )."\n";
   echo "Is Readable : ".(is_readable(config_file) ? "true" : "false")."\n";

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