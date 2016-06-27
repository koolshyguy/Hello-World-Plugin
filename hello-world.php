<?php
/*
Plugin Name: Hello World Plugin
Author: Vishal 
Description: A test plugin that says Hello.
Version: 1.0
*/
class abc{
     function __construct() {
        require(plugin_dir_path( __FILE__ ) .'../plugin-update-checker/plugin-update-checker.php');
        $MyUpdateChecker = new PluginUpdateChecker_3_1(
            'http://localhost/metadata/metadata.json',
            __FILE__
        );
        if ( is_admin() ) {
            /*$license_manager = new Wp_License_Manager_Client(
               'hello-world-plugin',
                'Hello World Plugin',
                'hello-world-plugin-text',
                'https://github.com/koolshyguy/Hello-World-Plugin/releases/tag/v1',
                'plugin',
                __FILE__
            );
            $this->license_manager = $license_manager;*/
        }
    
        //add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_for_update' ) );
     }

function check_for_update( $transient ) {
    if ( empty( $transient->checked ) ) {
        return $transient;
    }
 
        $info = $this->license_manager;
        
        $api_params = array(
            'edd_action' 	=> 'get_version',
            'name' 			=> "hello-world-plugin",
            'slug' 			=> "hello-world-plugin"
        );
        $val = wp_remote_retrieve_body(wp_remote_get( "https://api.github.com/repos/koolshyguy/hello-world-plugin"));
        $val = json_decode( $val, true );
        $api_response = wp_remote_post( "https://api.github.com/repos/koolshyguy/hello-world-plugin/releases", array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
        
        
        if( false !== $api_response && is_object( $api_response ) ) {
            if( version_compare( $this->version, $api_response->new_version, '<' ) )
                $_transient_data->response[$this->name] = $api_response;
        }
        return $_transient_data;   
        
            // Plugin update
            $plugin_slug = plugin_basename( $this->plugin_file );
 
            $transient->response[$plugin_slug] = (object) array(
                'new_version' => $info->version,
                'package' => $info->package_url,
                'slug' => $plugin_slug
            );
    
 
    return $transient;
}
}

new abc();
?>