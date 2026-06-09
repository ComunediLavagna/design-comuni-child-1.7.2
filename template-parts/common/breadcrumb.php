<?php
 global $custom_class;

 if (!$custom_class) $custom_class = '';
?>

<div class="cmp-breadcrumbs <?php echo $custom_class; ?>" role="navigation">
  <?php
  if ( function_exists( 'breadcrumb_trail_2' ) ) {
    $args = array(
      'container'       => 'nav',
      'before'          => '',
      'after'           => '',
      'browse_tag'      => 'h2',
      'list_tag'        => 'ol',
      'item_tag'        => 'li',
      'show_on_front'   => true,
      'network'         => false,
      'show_title'      => true,
      'show_browse'     => false,
      'labels'          => array(
        'search'        => esc_html__( 'Ricerca','design_comuni_italia' ),
          ),
      'echo'            => false
    );
#print('<pre>'.print_r($args,true).'</pre>');
   $breadcrumbs = breadcrumb_trail_2($args);
   
   $breadcrumbs = str_replace('/vivere-il-comune/luoghi/','/luoghi/',$breadcrumbs);
   $breadcrumbs = str_replace('/vivere-il-comune/eventi/','/eventi/',$breadcrumbs);
   
   $breadcrumbs = str_replace('/incarico/','/amministrazione/',$breadcrumbs);
   $breadcrumbs = str_replace('>Incarichi<','>Amministrazione<',$breadcrumbs);
   
   #$breadcrumbs = str_replace('>Novità<','>Novità<',$breadcrumbs);
  
	$breadcrumbs = str_replace('/tipi_unita_organizzativa/area','/amministrazione/aree-amministrative',$breadcrumbs);
	$breadcrumbs = str_replace('>Area<','>Aree amministrative<',$breadcrumbs);

	$breadcrumbs = str_replace('/tipi_unita_organizzativa/servizio','/amministrazione/servizi',$breadcrumbs);
	$breadcrumbs = str_replace('>Servizio<','>Servizi<',$breadcrumbs);

	$breadcrumbs = str_replace('/tipi_unita_organizzativa/ufficio','/amministrazione/uffici',$breadcrumbs);
	$breadcrumbs = str_replace('>Ufficio<','>Uffici<',$breadcrumbs);

	$breadcrumbs = str_replace('/tipi_unita_organizzativa/commissione','/amministrazione/organi-di-governo',$breadcrumbs);

	$breadcrumbs = str_replace('/tipi_unita_organizzativa/consiglio-comunale','/amministrazione/organi-di-governo',$breadcrumbs);

	$breadcrumbs = str_replace('/tipi_unita_organizzativa/giunta-comunale','/amministrazione/organi-di-governo',$breadcrumbs);

   print($breadcrumbs);
  }
  ?>
</div>