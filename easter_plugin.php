<?php
ob_start();
class Make_easter {
	public $options;
	
	/* Init plugin, register settings, register script & css, call api function */
	public function __construct() {
		$this->make_easter_register_settings();
		$this->make_easter_register_scripts();
		$this->make_easter_loadTextDomain();
		$this->options  = get_option('make_easter_plugin_options');
	}

	public function make_easter_register_settings() {
		register_setting('make_easter_plugin_options', 'make_easter_plugin_options');	 //3 param er callback
		add_settings_section('make_easter_section', __('Online Easter Quiz', 'make_easter'), array($this,'make_easter_main_section_cb'), __FILE__);
		add_settings_field('make_easter_subdomain',__('Web Address: <span id="make_easter_question">?</span> ','make_easter'), array($this, 'make_easter_subdomain_setting'), __FILE__, 'make_easter_section');
	}

	public function make_easter_remove() {
		delete_option("make_easter_plugin_options");
	}

	public function make_easter_register_scripts() {
		wp_register_style('make_easter_css', plugins_url('/css/make_easter.css',__FILE__), '', '1.1', 'all');
		wp_register_style('lato', 'http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic', '', '1.1', 'all');
		wp_register_script('make_easter_js', plugins_url('/js/make_easter.js',__FILE__), '', '1.1', 'all');
	}
	
	public function make_easter_loadTextDomain() {
		//$path = dirname( plugin_basename( __FILE__ ) . ('/languages/',__FILE__);
		load_plugin_textdomain('make_easter', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	public static function add_menu_page() { //legg til menypunkt i settings menyen
		$page = add_options_page(__('Easter Quiz settings', 'make_easter'),__('Easter Quiz settings', 'make_easter'),'administrator',__FILE__, array('Make_easter','make_easter_display_options_page'));
		add_action( 'admin_print_styles-' . $page, array('Make_easter', 'make_easter_load_scripts'));
	}

	/* Load CSS AND Javascript */
	public static function make_easter_load_scripts() { //load inn custom css og javascript
		wp_enqueue_style('make_easter_css' );
		wp_enqueue_style('lato' );
		wp_enqueue_script('make_easter_js' );
	}

	public function make_easter_main_section_cb() {
		//callback
	}
	
	//Brukernavn setting /felt
	public function make_easter_subdomain_setting() {
		echo "<input type='text' class='make_easter_subdomain' name='make_easter_plugin_options[make_easter_subdomain]' value='{$this->options['make_easter_subdomain']}' />". " " . "<span class='make_easter_domain'>.påskenøtter.com</span>";
	}

	public static function make_easter_display_options_page() { //vis frem optionssiden
		$op = get_option('make_easter_plugin_options');
?>
		<div class="make_easter_wrap">
			<div class="make_easter-help" id="make_easter-help">
            	<?php _e('<h2>Please insert your easter calendar Web Address</h2><br />
				This option can be found in your Easter Quiz admin, under Settings > General settings > Web address.<br />
				If this doesn\'t make sense to you, you\'ll probably need to register an account first.','make_easter'); ?>
            </div>
<?php if(!empty($op['make_easter_subdomain'])) { ?>
            <p class="make_easter_account"><?php _e('<span>Haven\'t got an account?</span><br /><a target="_blank" class="button button-primary" href="http://påskenøtter.com/">Register here</a>', 'make_easter') ?></p>
<?php }else{ ?>
			<p class="make_easter_account make_easter_animation_helper"><?php _e('<span>Haven\'t got an account?</span><br /><a target="_blank" class="button button-primary" href="http://påskenøtter.com/">Register here</a>', 'make_easter') ?></p>
<?php }; ?>
            <div class="make_easter_settings">
                <form action="options.php" method="post">
                <?php screen_icon(); ?>
                
				<?php
					settings_fields('make_easter_plugin_options');
					do_settings_sections(__FILE__);
				?>
                	<table class="form-table">
                    	<tr>
                        	<th></th>
                            <td><input id="submit" class="button-primary" type="submit" value="<?php _e('Save','make_easter');?>" name="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <?php 
				if(!empty($_GET['settings-updated']))
					if( $_GET['settings-updated'] === 'true') { ?>
            		<div class="make_easter-alert">
                    	<p>
            <?php
					
					if(!empty($op['make_easter_subdomain'])) {
			 			_e('Paste the shortcode <span>[easter_quiz]</span> into your page or post.<br /><br />
						 Available options are:<ul><li>width (in px or %)</li><li>height (in px)</li><li>border (in px)</li>
						 <li>bordercolor (in hex where ff0000 would be bright red)</li></ul>
						 <br /><p>Use the options as attributes of the shortcode tag like:</p><br />
						 <span>[easter_quiz width="810px" height="800px" border="3" bordercolor="000000"]</span>
						 ','make_easter'); 
					?>
            		
            <?php 
					}else{
			       		_e('Please insert your Web Address.<br />
						This option can be found in your Easter Quiz admin, under Settings > General settings > Web address','make_easter'); 
            		}
			?>
            			</p>
					</div>
			<?php
				}
				
			?>
            <div class="make_easter_disclaimer">
            	<p><?php _e('Brought to you by <a target="_blank" href="http://påskenøtter.com">Påskenøtter.com','make_easter'); ?></a></p>
            </div>
           <div class="makelogo"></div>  
        </div>
      
    
<?php

	}

}