<?php 
/*
    Plugin Name: Modal Terminos y Condiciones
    Description: Permite mostrar un modal para los terminos y condiciones en cualquier formulario web.
    Tags: Modal Terminos y Condiciones, Modal Elementor, Terminos y Condiciones, Terminos y Condiciones Elementor, Elementor, Pop Up Elementor
    Author: Miguel Fuentes
    Author URI: https://kodewp.com
    Version: 1.2
    Requires PHP: 5.2
    License: GPL v2 or later
*/

if (!defined('ABSPATH')) exit;

add_action( 'admin_menu', 'kwp_modalTerminosCondiciones_add_admin_menu' );
add_action( 'admin_init', 'kwp_modalTerminosCondiciones_settings_init' );

function kwp_modalTerminosCondiciones_add_admin_menu(  ) {
    add_options_page( 'Modal Terminos y Condiciones', 'Terminos y Condiciones', 'manage_options', 'settings-modal-terminos-condiciones', 'kwp_options_page' );
}

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'kwp_plugin_page_settings_modalTerminosCondiciones_link');
function kwp_plugin_page_settings_modalTerminosCondiciones_link( $links ) {
	$links[] = '<a href="' . admin_url( 'options-general.php?page=settings-modal-terminos-condiciones' ) . '">' . __('Settings') . '</a>';
	return $links;
}

function kwp_modalTerminosCondiciones_settings_init(  ) {
    register_setting( 'kwp_modalTerminosCondiciones_plugin', 'kwp_modalTerminosCondiciones_settings' );

    add_settings_section(
        'kwp_kwpPlugin_section',
        __( 'Descripción:', 'wordpress' ),
        'kwp_modalTerminosCondiciones_settings_section_callback',
        'kwp_modalTerminosCondiciones_plugin'
    );

    add_settings_field(
        'kwp_select_field_tc',
        __( 'Pagina de Terminos y Condiciones', 'wordpress' ),
        'kwp_select_field_terminos',
        'kwp_modalTerminosCondiciones_plugin',
        'kwp_kwpPlugin_section'
    );

    add_settings_field(
        'kwp_border_radius_field_terminos',
        __( 'Border Radius Modal', 'wordpress' ),
        'kwp_border_radius_field_terminos',
        'kwp_modalTerminosCondiciones_plugin',
        'kwp_kwpPlugin_section'
    );

    add_settings_field(
        'kwp_text_field_colorlink',
        __( 'Color Link Terminos y Condiciones', 'wordpress' ),
        'kwp_text_field_color_link',
        'kwp_modalTerminosCondiciones_plugin',
        'kwp_kwpPlugin_section'
    );

    add_settings_field(
        'kwp_text_field_color_link_hover',
        __( 'Color Hover Link Terminos y Condiciones', 'wordpress' ),
        'kwp_text_field_color_link_hover',
        'kwp_modalTerminosCondiciones_plugin',
        'kwp_kwpPlugin_section'
    );

    add_settings_field(
        'kwp_text_field_colorclose',
        __( 'Color boton Close', 'wordpress' ),
        'kwp_text_field_color_close',
        'kwp_modalTerminosCondiciones_plugin',
        'kwp_kwpPlugin_section'
    );

    add_settings_field(
        'kwp_text_field_color_close_hover',
        __( 'Color boton Close hover', 'wordpress' ),
        'kwp_text_field_color_hover_close',
        'kwp_modalTerminosCondiciones_plugin',
        'kwp_kwpPlugin_section'
    );
}

function kwp_select_field_terminos(  ) {

    $options = get_option( 'kwp_modalTerminosCondiciones_settings' );

	$has_pages = (bool) get_posts(
		array(
			'post_type'      => 'page',
			'posts_per_page' => 1,
			'post_status'    => 'publish'
		)
	);

	if ( $has_pages ) :
		wp_dropdown_pages(
			array(
				'name'              => 'kwp_modalTerminosCondiciones_settings[kwp_select_field_tc]',
				'show_option_none'  => __( '&mdash; Select &mdash;' ),
				'option_none_value' => '0',
				'selected'			=> $options['kwp_select_field_tc'],
				'post_status'       => array('publish' ),
				'class'				=> 'regular-text',
			)
		);
	endif;
}

function kwp_border_radius_field_terminos(  ) {
    $options = get_option( 'kwp_modalTerminosCondiciones_settings' ); ?>
    <input type='number' class="regular-text" name='kwp_modalTerminosCondiciones_settings[kwp_border_radius_field_terminos]' value='<?php echo $options['kwp_border_radius_field_terminos']; ?>'> px
<?php
}

function kwp_text_field_color_link(  ) {
    $options = get_option( 'kwp_modalTerminosCondiciones_settings' ); ?>
    <input type='text' class="kwp-color-picker" name='kwp_modalTerminosCondiciones_settings[kwp_text_field_color_link]' value='<?php echo $options['kwp_text_field_color_link']; ?>' data-default-color="#000000">
<?php
}

function kwp_text_field_color_link_hover(  ) {
    $options = get_option( 'kwp_modalTerminosCondiciones_settings' ); ?>
    <input type='text' class="kwp-color-picker" name='kwp_modalTerminosCondiciones_settings[kwp_text_field_color_link_hover]' value='<?php echo $options['kwp_text_field_color_link_hover']; ?>' data-default-color="#000000">
<?php
}

function kwp_text_field_color_close(  ) {
    $options = get_option( 'kwp_modalTerminosCondiciones_settings' ); ?>
    <input type='text' class="kwp-color-picker" name='kwp_modalTerminosCondiciones_settings[kwp_text_field_color_close]' value='<?php echo $options['kwp_text_field_color_close']; ?>' data-default-color="#000000">
<?php
}

function kwp_text_field_color_hover_close(  ) {
    $options = get_option( 'kwp_modalTerminosCondiciones_settings' ); ?>
    <input type='text' class="kwp-color-picker" name='kwp_modalTerminosCondiciones_settings[kwp_text_field_color_hover_close]' value='<?php echo $options['kwp_text_field_color_hover_close']; ?>' data-default-color="#000000">
<?php
}

function kwp_modalTerminosCondiciones_settings_section_callback(  ) {
    echo __( 'Configurar/Agregar valor segun corresponda para cada seccion <hr>');
}

function kwp_options_page(  ) {
    ?>
    <div class="wrap">
        <form action='options.php' method='post'>
            <h2>Configuración: Modal Terminos y Condiciones</h2>
            <?php
            settings_fields( 'kwp_modalTerminosCondiciones_plugin' );
            do_settings_sections( 'kwp_modalTerminosCondiciones_plugin' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function kwp_modal_enqueue_color_picker() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'kwp_custom_js', plugins_url('assets/js/kwp_custom.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'kwp_modal_enqueue_color_picker' );

add_action('wp_footer','kwp_modal_terminos_condiciones', 20);

function kwp_modal_terminos_condiciones() {
	?>
	<span class="header__menu__modal"></span>
	<section class="politicas__modal modal__various">
		<?php
		$options = get_option( 'kwp_modalTerminosCondiciones_settings' );
		$args = array( 
			'post_type' => 'page',
			'p'  => $options['kwp_select_field_tc'],
			'post_status'   => 'publish',
			'posts_per_page'    => 1,
		 );
		$wp_query = new WP_Query($args);
		if($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();  ?>
			<div class="header_title_modal">
				<h2><?php the_title(); ?></h2>
				<a title="Cerrar" class="btnCloseContact politicas__modal__close"></a>
			</div>
			<div class="politicas__modal__ctn">
				<div class="politicas__ctn wrapper__container list-none"><?php the_content(); ?></div>
			</div>
		<?php endwhile; wp_reset_postdata(); endif; ?>
	</section>
    <script>
		jQuery(document).ready(function($){
			$('.modal_terminos').click(function(event) {
				event.preventDefault();
				$('body').addClass('active');
				$('.header__menu__modal').addClass('active');
				$('.politicas__modal').addClass('active');
			});
			$('.btnCloseContact, .header__menu__modal').click(function(event) {
				event.preventDefault();
				$('body').removeClass('active');
				$('.header__menu__modal').removeClass('active');
				$('.modal__various').removeClass('active');
			});
		});               	
    </script>
    <style>
    /* MODAL TERMINOS Y CONDICIONES */
	.header__menu__modal {
	    position: fixed;
	    top: 0;
	    left: 0;
	    width: 100%;
	    height: 100%;
	    background: none;
	    opacity: 0;
	    visibility: hidden;
	    -webkit-transition: all .5s ease-in-out;
	    transition: all .5s ease-in-out;
	}
	.header__menu__modal.active {
	    opacity: .34;
	    visibility: visible;
	    z-index: 901;
	    background: #000;
	}
	.politicas__modal {
	    width: 90%;
	    height: 90%;
	    max-width: 800px;
	    max-height: 745px;
	    position: fixed;
	    top: 0;
	    bottom: 0;
	    left: 0;
	    right: 0;
	    margin: auto;
		-webkit-border-radius: <?php echo $options['kwp_border_radius_field_terminos'] ?>px;
		-moz-border-radius: <?php echo $options['kwp_border_radius_field_terminos'] ?>px;
	    border-radius: <?php echo $options['kwp_border_radius_field_terminos'] ?>px;
	    -webkit-box-shadow: 0 1px 6px 1px rgba(0, 0, 0, 0.17);
	    box-shadow: 0 1px 6px 1px rgba(0, 0, 0, 0.17);
	    background: #fff;
	    padding: 30px;
	    -webkit-box-sizing: border-box;
	    box-sizing: border-box;
	    -webkit-transition: all .3s ease-in-out;
	    transition: all .3s ease-in-out;
	}
	.modal__various{
		opacity: 0;
		visibility: hidden;
		z-index: -900;
		display: none;
	}
	.modal__various.active {
	    opacity: 1;
	    visibility: visible;
	    z-index: 904;
	    display: block;
	}
	.header_title_modal{
		position: relative;
	}
	.politicas__modal__close {
	    position: absolute;
	    top: 10px;
	    right: 0px;
	    cursor: pointer;
	}
	.btnCloseContact {
	    width: 30px;
	    height: 30px;
	}
	.btnCloseContact:before,
	.btnCloseContact:after{
		content: "";
		width: 30px;
		height: 2px;
		background: <?php echo $options['kwp_text_field_color_close'] ?>;
		position: absolute;
		top: 14px;
	    -webkit-transition: all .3s ease-in-out;
	    transition: all .3s ease-in-out;
	}
	.btnCloseContact:before{
		transform: rotate(135deg);
	}
	.btnCloseContact:after{
		transform: rotate(45deg);
	}
	.btnCloseContact:hover:before,
	.btnCloseContact:hover:after{
		background: <?php echo $options['kwp_text_field_color_hover_close'] ?>;
	}
	.politicas__modal__ctn {
	    overflow: auto;
	    height: 90%;
	    padding-right: 15px;
	    -webkit-box-sizing: border-box;
	    box-sizing: border-box;
	}
	.politicas__modal__ctn h1,
	.politicas__modal__ctn h2,
	.politicas__modal__ctn h3{
		margin-bottom: 20px;
		line-height: 1;
	}
	.politicas__modal__ctn h2{
		font-size: 25px;
	}
	.politicas__modal__ctn h3{
		font-size: 20px; 
	}
	.modal_terminos{
		color: <?php echo $options['kwp_text_field_color_link'] ?> !important;
		text-decoration: underline !important;
	}
	.modal_terminos:hover{
		color: <?php echo $options['kwp_text_field_color_link_hover'] ?> !important;
	}

    </style>
<?php
}