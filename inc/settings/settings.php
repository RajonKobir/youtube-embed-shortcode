<?php 

//  no direct access 
if( !defined('ABSPATH') ) : exit(); endif;

/**
 * Create Settings Menu
 */
function youtube_embed_shortcode_settings_menu() {

    add_menu_page(
        __( 'YouTube Embed Shortcode', YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME ),
        __( 'YouTube Embed Shortcode', YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME ),
        'manage_options',
        YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME.'_settings_page',
        'youtube_embed_shortcode_settings_template_callback',
        'dashicons-youtube',
        10
    );

}
add_action('admin_menu', 'youtube_embed_shortcode_settings_menu');



/**
 * Settings Template Page
 */
function youtube_embed_shortcode_settings_template_callback() {

    // installing bootstrap
    echo '<link rel="stylesheet" href="' . YOUTUBE_EMBED_SHORTCODE_PLUGIN_URL . 'inc/shortcodes/includes/css/bootstrap-min.css">';

    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <div class="row">

            <div class="col-md-6">
                <form action="options.php" method="post">

                    <?php 
                        // security field
                        settings_fields( YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_settings_page' );

                        // output settings section here
                        do_settings_sections(YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_settings_page');

                        // save settings button 
                        submit_button( 'Save Settings' );

                    ?>
                </form>
            </div>

            <div class="col-md-6">
                
                <?php 

                    // making HTML table
                    $pageHTML = '';

                    $pageHTML .= "<table class='table table-striped horse_racing_table'>";

                    $pageHTML .= "<tbody>";

                    $pageHTML .= "<tr style='' class='' >";
                    $pageHTML .= "<td colspan='2' class='' >
                    Shortcode: 
<pre>
    yt_embed_shortcode
</pre>
                    </td>";
                    $pageHTML .= "</tr>";

                    $pageHTML .= "</tr>";


                    $pageHTML .= "<tr style='' class='' >";
                    $pageHTML .= "<td class='' >
                    Default Parameter Values: 
<pre>
    'keyword' => '',
    'title' => 'Related Videos',
    'count' => 5,
    'iframe_width' => 560,
    'iframe_height' => 315,
</pre>
                    </td>";
                    
                    $pageHTML .= "</tr>";

                    $pageHTML .= "<tr style='' class='' >";
                    $pageHTML .= "<td colspan='2' class='' >
                    Example Use: 
<pre>
    [yt_embed_shortcode keyword=&quot;keyword&quot; title=&quot;Title&quot; count=&quot;6&quot;]
</pre>
                    </td>";
                    $pageHTML .= "</tr>";

                    $pageHTML .= "</tbody>";

                    $pageHTML .= "</table>";

                    echo $pageHTML;

                ?>

            </div>


        </div>


    </div>
    <?php 
}




/**
 * Settings Template
 */
add_action( 'admin_init', 'youtube_embed_shortcode_settings_init' );

function youtube_embed_shortcode_settings_init() {

    // Setup settings section 1
    add_settings_section(
        YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_settings_section',
        'Google API Credentials',
        '',
        YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_settings_page',
        // array(
        //     'before_section' => '<div class="row"><div class="%s">',
        //     'after_section'  => '</div>',
        //     'section_class'  => 'col-md-6',
        // )
    );

    // Register input field
    register_setting(
        YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_settings_page',
        YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_api_key',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        )
    );

    add_settings_field(
        YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_api_key',
        __( 'Google API Key', YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME ),
        'youtube_embed_shortcode_api_key_field_callback',
        YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_settings_page',
        YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_settings_section'
    );



}
// Settings Template ends here 


// Text field template
function youtube_embed_shortcode_api_key_field_callback() {
    $youtube_embed_shortcode_input_field = get_option(YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_api_key');
    ?>
    <input type="text" name="<?php echo YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME;?>_api_key" class="regular-text" placeholder='Google API Key...' value="<?php echo isset($youtube_embed_shortcode_input_field) && $youtube_embed_shortcode_input_field != '' ? $youtube_embed_shortcode_input_field : ''; ?>" />
    <?php 
}




?>