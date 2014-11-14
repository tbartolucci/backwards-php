<?php

if (!extension_loaded('mysql')) {

    /**
     * Columns are returned into the array having the fieldname as the array
     * index.
     * @link http://php.net/manual/en/mysql.constants.php
     */
    define ('MYSQL_ASSOC', 1);

    /**
     * Columns are returned into the array having a numerical index to the
     * fields. This index starts with 0, the first field in the result.
     * @link http://php.net/manual/en/mysql.constants.php
     */
    define ('MYSQL_NUM', 2);

    /**
     * Columns are returned into the array having both a numerical index
     * and the fieldname as the array index.
     * @link http://php.net/manual/en/mysql.constants.php
     */
    define ('MYSQL_BOTH', 3);

    /**
     * Use compression protocol
     * @link http://php.net/manual/en/mysql.constants.php
     */
    define ('MYSQL_CLIENT_COMPRESS', 32);

    /**
     * Use SSL encryption. This flag is only available with version 4.x
     * of the MySQL client library or newer. Version 3.23.x is bundled both
     * with PHP 4 and Windows binaries of PHP 5.
     * @link http://php.net/manual/en/mysql.constants.php
     */
    define ('MYSQL_CLIENT_SSL', 2048);

    /**
     * Allow interactive_timeout seconds (instead of wait_timeout) of
     * inactivity before closing the connection.
     * @link http://php.net/manual/en/mysql.constants.php
     */
    define ('MYSQL_CLIENT_INTERACTIVE', 1024);

    /**
     * Allow space after function names
     * @link http://php.net/manual/en/mysql.constants.php
     */
    define ('MYSQL_CLIENT_IGNORE_SPACE', 256);

    $GLOBALS['mysql'] = array();

    /**
     * @param $hostname
     * @param $username
     * @param $password
     * @param null $new_link
     * @param null $client_flags
     * @return bool
     */
    function mysql_connect($hostname, $username, $password, $new_link = null, $client_flags = null) {
        $GLOBALS['mysql'] += array(
            'hostname' => $hostname,
            'username' => $username,
            'password' => $password,
        );

        return true;
    }

    /**
     * @param $hostname
     * @param $username
     * @param $password
     * @param null $client_flags
     * @return bool|resource
     */
    function mysql_pconnect($hostname, $username, $password, $client_flags = null) {
        return mysql_connect($hostname, $username, $password, $client_flags);
    }

    /**
     * @param $database
     * @param null $connection
     * @return mysqli
     */
    function mysql_select_db($database, $connection = null) {
        $link = mysqli_connect($GLOBALS['mysql']['hostname'], $GLOBALS['mysql']['username'], $GLOBALS['mysql']['password'], $database);

        $GLOBALS['mysql'] += array(
            'database' => $database,
            'link'     => $link,
        );

        return $link;
    }

    /**
     * @param null $connection
     * @return bool
     */
    function mysql_close($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_close($link);
    }

    /**
     * @param $query
     * @param null $connection
     * @return bool|mysqli_result
     */
    function mysql_query($query, $connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_query($link, $query);
    }

    /**
     * @param $query
     * @param null $connection
     * @return bool|mysqli_result
     */
    function mysql_unbuffered_query($query, $connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_query($link, $query, MYSQLI_USE_RESULT);
    }

    /**
     * @param $database
     * @param $query
     * @param null $connection
     * @return bool|mysqli_result|resource
     */
    function mysql_db_query($database, $query, $connection = null) {
        mysql_select_db($database, $connection);
        return mysql_query($query, $connection);
    }

    /**
     * @param $result
     * @param int $type
     * @return array|null
     */
    function mysql_fetch_array($result, $type = MYSQL_BOTH) {
        return mysqli_fetch_array($result, $type);
    }

    /**
     * @param $result
     * @return array|null
     */
    function mysql_fetch_assoc($result) {
        return mysqli_fetch_assoc($result);
    }

    /**
     * @param $result
     * @return array|null
     */
    function mysql_fetch_row($result) {
        return mysqli_fetch_row($result);
    }

    /**
     * @param $result
     * @param string $classname
     * @param array $params
     * @return null|object
     */
    function mysql_fetch_object($result, $classname = '', $params = array()) {
        return mysqli_fetch_object($result, $classname, $params);
    }

    /**
     * @param $result
     * @param $row
     * @param int $field
     * @return mixed
     */
    function mysql_result($result, $row, $field = 0) {
        mysqli_data_seek($result, $row);
        $row = mysqli_fetch_row($result);
        return $row[$field];
    }

    /**
     * @param $string
     * @param null $connection
     * @return string
     */
    function mysql_real_escape_string($string, $connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_real_escape_string($link, $string);
    }

    /**
     * @param $string
     * @param null $connection
     * @return string
     */
    function mysql_escape_string($string, $connection = null) {
        return mysql_real_escape_string($string, $connection);
    }

    /**
     * @param $result
     * @return int
     */
    function mysql_num_rows($result) {
        return mysqli_num_rows($result);
    }

    /**
     * @param null $connection
     * @return int|string
     */
    function mysql_insert_id($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_insert_id($link);
    }

    /**
     * @param null $connection
     * @return int
     */
    function mysql_affected_rows($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_affected_rows($link);
    }

    /**
     * @param null $connection
     * @return int
     */
    function mysql_errno($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_errno($link);
    }

    /**
     * @param null $connection
     * @return string
     */
    function mysql_error($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_error($link);
    }

    /**
     * @param null $connection
     * @return bool|mysqli_result|resource
     */
    function mysql_list_dbs($connection = null) {
        return mysql_query('SHOW DATABASES', $connection);
    }

    /**
     * @param $database
     * @param null $connection
     * @return bool|mysqli_result|resource
     */
    function mysql_list_tables($database, $connection = null) {
        return mysql_query('SHOW TABLES FROM ' . $database, $connection);
    }

    /**
     * @param $database
     * @param $table_name
     * @param null $connection
     * @return bool|mysqli_result|resource
     */
    function mysql_list_fields($database, $table_name, $connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysql_query('SHOW COLUMNS FROM ' . $table_name, $link);
    }

    /**
     * @param null $connection
     * @return int
     */
    function mysql_list_processes($connection = null) {
        trigger_error('mysql_list_processes() works differently. It only returns the current process.', E_USER_NOTICE);
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_thread_id($link);
    }

    /**
     * @param $result
     * @return int
     */
    function mysql_num_fields($result) {
        return mysqli_field_count($result);
    }

    /**
     * @param $result
     * @param $row_number
     * @return bool
     */
    function mysql_data_seek($result, $row_number) {
        return mysqli_data_seek($result, $row_number);
    }

    /**
     * @param $result
     * @return array|bool
     */
    function mysql_fetch_lengths($result) {
        return mysqli_fetch_lengths($result);
    }

    /**
     * @param $result
     * @param int $field_offset
     * @return bool|object
     */
    function mysql_fetch_field($result, $field_offset = 0) {
        trigger_error('mysql_fetch_field() works differently. Check your code to verify the results are correct.', E_USER_NOTICE);
        return mysqli_fetch_field($result);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return bool
     */
    function mysql_field_seek($result, $field_offset) {
        return mysqli_field_seek($result, $field_offset);
    }

    /**
     * @param $result
     */
    function mysql_free_result($result) {
        return mysqli_free_result($result);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return mixed
     */
    function mysql_field_name($result, $field_offset) {
        $info = mysqli_fetch_field_direct($result, $field_offset);
        return $info->name;
    }

    /**
     * @param $result
     * @param $field_offset
     * @return mixed
     */
    function mysql_field_table($result, $field_offset) {
        $info = mysqli_fetch_field_direct($result, $field_offset);
        return $info->table;
    }

    /**
     * @param $result
     * @param $field_offset
     * @return mixed
     */
    function mysql_field_len($result, $field_offset) {
        $info = mysqli_fetch_field_direct($result, $field_offset);
        return $info->max_length;
    }

    /**
     * @param $result
     * @param $field_offset
     * @return mixed
     */
    function mysql_field_type($result, $field_offset) {
        $info = mysqli_fetch_field_direct($result, $field_offset);
        return $info->type;
    }

    /**
     * @param $result
     * @param $field_offset
     * @return mixed
     */
    function mysql_field_flags($result, $field_offset) {
        $info = mysqli_fetch_field_direct($result, $field_offset);
        return $info->flags;
    }

    /**
     * @param $result
     * @return bool|void
     */
    function mysql_freeresult($result) {
        return mysql_free_result($result);
    }

    /**
     * @param $result
     * @return int
     */
    function mysql_numfields($result) {
        return mysql_num_fields($result);
    }

    /**
     * @param $connection
     * @return bool|mysqli_result|resource
     */
    function mysql_listdbs($connection) {
        return mysql_list_dbs($connection);
    }

    /**
     * @param $database
     * @param $connection
     * @return bool|mysqli_result|resource
     */
    function mysql_listtables($database, $connection) {
        return mysql_list_tables($database, $connection);
    }

    /**
     * @param $database_name
     * @param $table_name
     * @param null $connection
     * @return bool|mysqli_result|resource
     */
    function mysql_listfields ($database_name, $table_name, $connection = null) {
        return mysql_list_fields($database_name, $table_name, $connection);
    }

    /**
     * @param $result
     * @param $field_index
     * @return mixed|string
     */
    function mysql_fieldname($result, $field_index) {
        return mysql_field_name($result, $field_index);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return mixed|string
     */
    function mysql_fieldtable($result, $field_offset) {
        return mysql_field_table($result, $field_offset);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return int|mixed
     */
    function mysql_fieldlen($result, $field_offset) {
        return mysql_field_len($result, $field_offset);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return mixed|string
     */
    function mysql_fieldtype($result, $field_offset) {
        return  mysql_field_type($result, $field_offset);
    }

    /**
     * @param $result
     * @param $field_offset
     * @return mixed|string
     */
    function mysql_fieldflags($result, $field_offset) {
        return mysql_field_flags($result, $field_offset);
    }

    /**
     * @param null $connection
     * @return bool|string
     */
    function mysql_stat($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_stat($link);
    }

    /**
     * @param null $connection
     * @return int
     */
    function mysql_thread_id ($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_thread_id($link);
    }

    /**
     * @param null $connection
     * @return string
     */
    function mysql_client_encoding ($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_character_set_name($link);
    }

    /**
     * @param null $connection
     * @return bool
     */
    function mysql_ping ($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_ping($link);
    }

    /**
     * @return string
     */
    function mysql_get_client_info() {
        return mysqli_get_client_info($GLOBALS['mysql']['link']);
    }

    /**
     * @param null $connection
     * @return string
     */
    function mysql_get_host_info($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_get_host_info($link);
    }

    /**
     * @param null $connection
     * @return int
     */
    function mysql_get_proto_info($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_get_proto_info($link);
    }

    /**
     * @param null $connection
     * @return string
     */
    function mysql_get_server_info($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_get_server_info($link);
    }

    /**
     * @param null $connection
     * @return string
     */
    function mysql_info($connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_info($link);
    }

    /**
     * @param $charset
     * @param null $connection
     * @return bool
     */
    function mysql_set_charset($charset, $connection = null) {
        $link = (is_resource($connection)) ? $connection : $GLOBALS['mysql']['link'];
        return mysqli_set_charset($link, $charset);
    }

    /**
     * @param $result
     * @param $row
     * @param null $field
     * @return mixed
     */
    function mysql_db_name($result, $row, $field = null) {
        $result = mysql_query($GLOBALS['mysql']['link'], 'SELECT DATABASE()');
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    /**
     * @param $result
     * @param $row
     * @param null $field
     * @return mixed|string
     */
    function mysql_dbname($result, $row, $field = null) {
        return mysql_db_name($result, $row, $field);
    }

    /**
     * @param $result
     * @param $row
     * @param $field
     * @return bool|string
     */
    function mysql_table_name($result, $row, $field) {
        return mysql_tablename($result, $row);
    }

    /**
     * @param $result
     * @param $i
     * @return bool
     */
    function mysql_tablename($result, $i) {
        trigger_error('mysql_tablename() does not have a MySQLi compatible equivalent.', E_USER_NOTICE);
        return false;
    }

    /**
     * @param $database
     * @param $query
     * @param null $connection
     * @return bool|mysqli_result|resource
     */
    function mysql($database, $query, $connection = null) {
        mysql_select_db($database, $connection);
        return mysql_query($query, $connection);
    }

}