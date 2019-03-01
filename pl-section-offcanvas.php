<?php
/*

  Plugin Name: PageLines Section Off Canvas
  Description: A simple off canvas menu.

  Author:      iHeart PageLines
  Version:     2.1

  PageLines:   PL_Section_Off_Canvas
  Tags:         menu, offcanvas

  Category:     framework, sections
  Filter:       nav

*/




/** A guard to prevent the section from being loaded if platform isn't installed or at the wrong time */
if( ! class_exists('PL_Section') ){
  return;
}

class PL_Section_Off_Canvas extends PL_Section {

  /**
   * This function will load on all site page loads, both front and back end.
   * Use it for hooks, global settings, etc...
   */
  function section_persistent(){

    function prefix_nav_description( $item_output, $item, $depth, $args ) {
    if ( !empty( $item->description ) ) {
        $item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
    }

    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'prefix_nav_description', 10, 4 );

  }

  /**
   * Include extra scripts and styles here
   * Use the pl_script and pl_style functions (which enqueues the files)
   */
  function section_styles(){

    /** Include the sample script */
    pl_script( $this->id, $this->base_url . '/script.js' );

  }

  /**
   * Return the option array for the section.
   */
  function section_opts(){

    $options [] = array(
         'type'  => 'multi',
         'key'    => 'nav_content',
         'title'  => __( 'Logo', 'pl-section-offcanvas' ),
         'opts'  => array(
           array(
             'type'    => 'image_upload',
             'key'      => 'logo',
             'label'    => __( 'Logo', 'pl-section-offcanvas' ),
             'has_alt'  => true
           ),
           array(
             'type'    => 'dragger',
             'label'    => __( 'Logo Size / Height', 'pl-section-offcanvas' ),
             'opts'  => array(
               array(
                 'key'      => 'logo_height',
                 'min'      => 0,
                 'max'      => 30,
                 'default'  => 0,
                 'unit'    => 'vw'
               ),
               array(
                 'key'      => 'logo_height_min',
                 'min'      => 0,
                 'max'      => 300,
                 'default'  => 35,
                 'unit'    => 'Min (px)'
             ),
           ),
         ),
       )
     );

     $options[] = array(
           'type' 		=> 'multi',
           'title'		=> 'Off Canvas Options',
           'opts'	=> array(
             array(
               'key'      => 'menu',
               'type'    => 'select_menu',
               'label'    => 'Select Menu',
               'default'  => ''
             ),
             array(
              'type'    => 'text',
              'key'      => 'sf_text',
              'label'    => 'Off Canvas Text (copyright information)',
              'default'  =>  '' . get_bloginfo('name')
           ),
               pl_std_opt('scheme'),
               pl_std_opt('background_color', array('label' => 'Menu Background Color')),
               pl_std_opt('background_image', array('label' => 'Menu Background Image')),
               pl_std_opt('background_image', array('key' => 'icon_image', 'label' => 'Close Icon Image', 'default' => $this->base_url . '/close.svg')),
               pl_std_opt('background_image', array('key' => 'open_image', 'label' => 'Open Icon Image', 'default' => $this->base_url . '/open.svg')),


        )
     );


    return $options;
  }

  function nav_config(){
   $config = array(
     'key'             => 'menu',
     'menu_class'      => 'ihp-canvas',
     'menu'            => $this->opt('menu'),
     'depth'           => 1,
     'theme_location'  => 'pl-nav'
   );

   return $config;
 }


  /**
   * The section HTML output
   */
  function section_template(){ ?>

    <div class="offcanvas-wrapper">
      <div class="offcanvas-container">

        <div class="offcanvas-head">
          <div class="menu-ham">
            <button type="button" class="off-open" data-bind="plbg: open_image"></i></button>
          </div>

          <div class="offcanvas-logo-wrap">
            <a class="offcanvas-logo site-logo" href="<?php echo home_url('/');?>" >
                    <img itemprop="logo" src="" alt="<?php echo get_bloginfo('name');?>" data-bind="visible: logo(), plimg: logo, style: {'height': logo_height() ? logo_height() + 'vw' : '50px', 'min-height': logo_height_min() ? logo_height_min() + 'px' : '30px'}" />
                    <span class="site-name canvasnav-name" data-bind="visible: ! logo()">
                      <?php echo get_bloginfo('name');?>
                    </span>
            </a>
          </div>
        </div>



          <div class="menu-overlay">
            <div class="menu-slide" data-bind="plbg: background_image, style: {'background-color': background_color}, plclassname: [scheme()]">

              <div class="menu-close">
                <button type="button" class="off-close" data-bind="plbg: icon_image" ></button>
                </div>

              <div class="menu-holder">
                      <?php echo pl_dynamic_nav( $this->nav_config() ); ?>
              </div>

              <div class="offcanvas-footer">
                 <span>&copy; <?php echo date("Y"); ?></span><span class="sf-copy" data-bind="pltext: sf_text"></span>
              </div>

            </div>
          </div>



      </div>
    </div>


    <?php
  }

}
