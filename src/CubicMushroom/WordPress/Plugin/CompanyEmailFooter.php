<?php

namespace CubicMushroom\WordPress\Plugin;

/**
 * undocumented class
 *
 * @package CubicMushroom\WordPress\Plugin
 * @author  Cubic Mushroom Ltd.
 **/
class CompanyEmailFooter 
{

    const OPTIONS_KEY = 'cm_company_email_options';

    /**
     * Single version of plugin object
     * @var object
     */
    static protected $_self;

    /**
     * Stores a cached version of the plugin option data to save repeated calls to fetch
     * @var array
     */
    protected $_option_data;

    /**
     * Supported keys in $_options_data array
     * @var string
     **/
    protected $_option_keys = array(
        'inc_company_info',
        'company_no',
        'company_address',
        'footer_text',
    );

    /**
     * Protected contructor.  Use CMCompanyEmailFooter::load()
     */
    protected function __construct() {
        add_action('init', array( $this, 'setup'));
    }

    /**
     * Loader ensures only 1 plugin object is ever created
     * 
     * @return CompanyEmailFooter
     */
    public function load() {
        if ( empty( self::$_self ) ) {
            $class = __CLASS__;
            self::$_self = new $class;
        }
        return self::$_self;
    }

    /**
     * Sets up the plugin hooks
     * 
     * @return void
     */
    public function setup() {
        /**
         * Admin interface related hooks
         */
        add_action( 'admin_init', array( $this, 'admin_register_scripts_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_action( 'admin_menu', array( $this, 'admin_add_pages' ) );
    }

    /**
     * Admin page related methods
     */
    
    /**
     * Registers JS scripts & CSS stylesheets for the admin pages
     * @return void
     */
    public function admin_register_scripts_styles() {
        wp_register_script(
            'sizzle',
            plugins_url( '/js/lib/sizzle.js', CM_COMPANY_FOOTER ),
            null,
            '1.9.4-pre',
            true
        );
        wp_register_script(
            'cm-company-email-admin',
            plugins_url( '/js/cm-company-email-admin.js', CM_COMPANY_FOOTER ),
            array( 'sizzle' ),
            false,
            true
        );
    }

    /**
     * Enqueues admin page scripts & stylesheets
     * 
     * @return void
     */
    public function admin_enqueue_scripts() {
        wp_enqueue_script( 'cm-company-email-admin' );
    }
    
    /**
     * Adds admin pages
     *
     * @return void
     */
    public function admin_add_pages() {
        add_submenu_page(
            'options-general.php',
            'Company Email Footer Config',
            'Company Email',
            'manage_options',
            'company-email',
            array($this, 'admin_page_company_email')
        );
    }

    /**
     * Displays the content of the options page
     * 
     * @return void
     */
    public function admin_page_company_email() {
        $options = $this->get_options();
        ?>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"><br></div>
            <h2>Company Email Footer</h2>
        </div>
        <form id="cm-company-email-options" method="post" action="">
            <?php echo wp_nonce_field( 'update_settings', $name = '_company_email_nonce' ); ?>
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row">
                            <label for="inc_company_info">Include company information:</label>
                        </th>
                        <td>
                            <input name="inc_company_info" type="hidden" value="0">
                            <input name="inc_company_info" type="checkbox" id="inc_company_info" value="1" <?php echo !empty( $options['inc_company_info'] ) ? 'checked="checked"' : ''; ?>>
                            Show Company Details fields
                            <p class="description">Companies registered in the UK are required to include certain information in their email footers by law.  Include this information?</p>
                        </td>
                    </tr>
                    <tr valign="top" class="company_info_fields">
                        <th scope="row">
                            <label for="company_no">Company Registration No:</label>
                        </th>
                        <td>
                            <input name="company_no" type="text" id="company_no" value="<?php echo $options['company_no']; ?>" class="regular-text">
                            <p class="description">Company registration number provided by Companies House</p>
                        </td>
                    </tr>
                    <tr valign="top" class="company_info_fields">
                        <th scope="row">
                            <label for="company_address">Company Registered Address:</label>
                        </th>
                        <td>
                            <textarea name="company_address" id="company_address">
                                <?php echo $options['company_address']; ?>
                            </textarea>
                            <p class="description">In a few words, explain what this site is about.</p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
        </form>
        <?php
    }

    /**
     * Getters & Setters
     */
    protected function get_options() {
        if ( empty( $this->_option_data ) ) {
            $this->_option_data = get_option( self::OPTIONS_KEY, array_fill_keys($this->_option_keys, '') );
        }
        return $this->_option_data;

    }

} // END class CompanyEmailFooter