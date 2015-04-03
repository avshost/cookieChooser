<?php

/*
  Plugin Name: Cookie Chooser Plugin
  Plugin URI: https://github.com/avshost/cookieChooser
  Description: Sets a cookie based on the line the person selects in the dropdown. Uses short tags to create dropdowns.
  Version: 1.0.0
  Author: Terry Pearson
  Author URI: http://www.avshost.com
  License: GPL V3
 */

class CookieChooser {
	private static $instance = null;
	private $plugin_path;
	private $plugin_url;
    	private $text_domain = '';

	/**
	 * Creates or returns an instance of this class.
	 */
	public static function get_instance() {
		// If an instance hasn't been created and set to $instance create an instance and set it to $instance.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Initializes the plugin by setting localization, hooks, filters, and administrative functions.
	 */
	private function __construct() {
		$this->plugin_path = plugin_dir_path( __FILE__ );
		$this->plugin_url  = plugin_dir_url( __FILE__ );

		load_plugin_textdomain( $this->text_domain, false, $this->plugin_path . '\lang' );

		add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_styles' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );

		register_activation_hook( __FILE__, array( $this, 'activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );

		$this->run_plugin();
	}

	public function get_plugin_url() {
		return $this->plugin_url;
	}

	public function get_plugin_path() {
		return $this->plugin_path;
	}

    /**
     * Place code that runs at plugin activation here.
     */
    public function activation() {

	}

    /**
     * Place code that runs at plugin deactivation here.
     */
    public function deactivation() {

	}

    /**
     * Enqueue and register JavaScript files here.
     */
    public function register_scripts() {
	
	 // Register the script like this for a plugin:
    	wp_register_script( 'jquerycookie', plugins_url( '/js/jquery.cookie.js', __FILE__ ) );
 
    	// For either a plugin or a theme, you can then enqueue the script:
    	wp_enqueue_script( 'jquerycookie' );

	}

    /**
     * Enqueue and register CSS files here.
     */
    public function register_styles() {

	}

    /**
     * Place code for your plugin's functionality here.
     */
    private function run_plugin() {

	}
    
    public function baztag_func( $atts, $content = "" ) {
		return "content = $content";
	}

    public function shortcode_func( $atts ) {

	//Looking for a comma separated list like this: "Store 1:lakeville,Store 2 cool:Farmington"
	//Colans separate the name from the value in the dropdown. Whatever the value is, that is what
	//the cookie will be.

	

	$atts = shortcode_atts( array(
		'name' => 'chooserbox',
		'options' => ''
	), $atts, 'chooser' );

	$name=$atts['name'];
	$options=$atts['options'];

	$optionsArray=explode("|",$options);

	$optionSelectString="";

	foreach($optionsArray as $opt){
		$row=explode(":",$opt);
		$optionSelectString=$optionSelectString."<option value='$row[1]'>$row[0]</option>";		
	}


	$SELECTOR="$";
	$outputVar = <<<OUTPUT

	<select name="$name" id="$name">
                $optionSelectString
        <select>

	<script>
	(function ($) {
	$SELECTOR(document).ready(function(){

		// when a new option is selected this is triggered
                $SELECTOR('#$name').change(function() {
                    // new cookie is set when the option is changed
                
		    $SELECTOR.cookie('$name-value', $('#$name option:selected').val(),  { expires: 90, path: '/'});
		    $SELECTOR.cookie('$name-text', $('#$name option:selected').text(), { expires: 90, path: '/'});

		});
		
		//Just a simple default value
		$SELECTOR('#$name option').filter(function () { return $(this).html() == $SELECTOR.cookie('$name-text'); }).prop('selected',true);
	});

	}(jQuery));

	</script>

OUTPUT;
	return $outputVar;

}


}

CookieChooser::get_instance();
add_shortcode( 'chooser', array( 'CookieChooser', 'shortcode_func' ) );


