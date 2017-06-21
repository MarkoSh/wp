<?php
// #####################################################################
// ### SLIDE ANYTHING PLUGIN - PHP FUNCTIONS FOR WORDPRESS FRONT-END ###
// #####################################################################

add_shortcode('slide-anything', 'slide_anything_shortcode');

/* ##### ROOT FUNCTION THAT IS CALLED TO BY THE 'slide-anything' SHORTCODE ##### */
function slide_anything_shortcode($atts) {
	$sa_pro_version = validate_slide_anything_pro_registration();
	wp_enqueue_script('jquery');
	wp_register_script('owl_carousel_js', SA_PLUGIN_PATH.'owl-carousel/owl.carousel.min.js', array('jquery'), '2.2.1', true);
	wp_enqueue_script('owl_carousel_js');
	wp_register_style('owl_carousel_css', SA_PLUGIN_PATH.'owl-carousel/owl.carousel.css', array(), '2.2.1', 'all');
	wp_enqueue_style('owl_carousel_css');
	wp_register_style('owl_theme_css', SA_PLUGIN_PATH.'owl-carousel/sa-owl-theme.css', array(), '2.0', 'all');
	wp_enqueue_style('owl_theme_css');
	wp_register_style('owl_animate_css', SA_PLUGIN_PATH.'owl-carousel/animate.min.css', array(), '2.0', 'all');
	wp_enqueue_style('owl_animate_css');
	if ($sa_pro_version) {
		// JAVASCRIPT/CSS FOR MAGNIFIC POPUP
		wp_register_script('magnific-popup_js', SA_PLUGIN_PATH.'magnific-popup/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', true);
		wp_enqueue_script('magnific-popup_js');
		wp_register_style('magnific-popup_css', SA_PLUGIN_PATH.'magnific-popup/magnific-popup.css', array(), '1.1.0', 'all');
		wp_enqueue_style('magnific-popup_css');
	}

	// EXTRACT SHORTCODE ATTRIBUTES
	extract(shortcode_atts(array(
		'id' => 0,
	), $atts));
	$output = '';
	
	if ($id == 0) {
		// SHORTCODE 'id' PARAMETER PROVIDED IS INVALID
		$output .= "<div id='sa_invalid_postid'>Slide Anything shortcode error: A valid ID has not been provided</div>\n";
	} else {
		$post_status = get_post_status($id);
		if ($post_status == 'publish') {
			$metadata = get_metadata('post', $id);
		}
		if (($post_status != 'publish') || (count($metadata) == 0)) {
			// SHORTCODE 'id' PARAMETER PROVIDED IS INVALID
			$output .= "<div id='sa_invalid_postid'>Slide Anything shortcode error: A valid ID has not been provided</div>\n";
		} else {
			// ### VALID 'id' PROVIDED - PROCESS SHORTCODE ###
			// GET SLIDE DATA FROM DATABASE AND SAVE IN ARRAY
			$slide_data = array();
			$slide_data['num_slides'] = $metadata['sa_num_slides'][0];
			$slide_data['shortcodes'] = $metadata['sa_shortcodes'][0];
			if ($slide_data['shortcodes'] == '1') {
				$slide_data['shortcodes'] = 'true';
			} else {
				$slide_data['shortcodes'] = 'false';
			}
			$slide_data['css_id'] = $metadata['sa_css_id'][0];
			for ($i = 1; $i <= $slide_data['num_slides']; $i++) {
				// get the valid content character count and the actual content character count
				$slide_data["slide".$i."_valid_char_count"] = $metadata["sa_slide".$i."_char_count"][0];
				if ($slide_data["slide".$i."_valid_char_count"] == 0) {
					$slide_data["slide".$i."_actual_char_count"] = 0; // valid character count does not exist so set actual count to matching zero
				} else {
					$slide_data["slide".$i."_actual_char_count"] = strlen($metadata["sa_slide".$i."_content"][0]);
				}
				// apply 'the_content' filter to slide content to process any shortcodes
				if ($slide_data['shortcodes'] == 'true') {
					$slide_data["slide".$i."_content"] = apply_filters('the_content', $metadata["sa_slide".$i."_content"][0]);
				} else {
					$slide_data["slide".$i."_content"] = $metadata["sa_slide".$i."_content"][0];
				}
				$slide_data["slide".$i."_image_id"] = $metadata["sa_slide".$i."_image_id"][0];
				$slide_data["slide".$i."_image_pos"] = $metadata["sa_slide".$i."_image_pos"][0];
				$slide_data["slide".$i."_image_size"] = $metadata["sa_slide".$i."_image_size"][0];
				$slide_data["slide".$i."_image_repeat"] = $metadata["sa_slide".$i."_image_repeat"][0];
				$slide_data["slide".$i."_image_color"] = $metadata["sa_slide".$i."_image_color"][0];
				$slide_data["slide".$i."_link_url"] = $metadata["sa_slide".$i."_link_url"][0];
				$slide_data["slide".$i."_link_target"] = $metadata["sa_slide".$i."_link_target"][0];
				if ($slide_data["slide".$i."_link_target"] == '') {
					$slide_data["slide".$i."_link_target"] = '_self';
				}
				if ($sa_pro_version) {
					// ### PRO VERSION - GET POPUP DATA ###
					$slide_data["slide".$i."_popup_type"] = $metadata["sa_slide".$i."_popup_type"][0];
					$slide_data["slide".$i."_popup_imageid"] = $metadata["sa_slide".$i."_popup_imageid"][0];
					$slide_data["slide".$i."_popup_imagetitle"] = $metadata["sa_slide".$i."_popup_imagetitle"][0];
					$slide_data["slide".$i."_popup_image"] = '';
					$slide_data["slide".$i."_popup_background"] = 'no';
					if ($slide_data["slide".$i."_popup_type"] == 'IMAGE') {
						if (($slide_data["slide".$i."_popup_imageid"] != '') && ($slide_data["slide".$i."_popup_imageid"] != 0)) {
							$popup_full_images = wp_get_attachment_image_src($slide_data["slide".$i."_popup_imageid"], 'full');
							$slide_data["slide".$i."_popup_image"] = $popup_full_images[0];
							$slide_data["slide".$i."_popup_background"] = $metadata["sa_slide".$i."_popup_background"][0];
							if ($slide_data["slide".$i."_popup_background"] == '') {
								$slide_data["slide".$i."_popup_background"] = 'no';
							}
						}
					}
					$slide_data["slide".$i."_popup_video_id"] = $metadata["sa_slide".$i."_popup_video_id"][0];
					$slide_data["slide".$i."_popup_video_type"] = $metadata["sa_slide".$i."_popup_video_type"][0];
					$slide_data["slide".$i."_popup_html"] = $metadata["sa_slide".$i."_popup_html"][0];
					$slide_data["slide".$i."_popup_shortcode"] = $metadata["sa_slide".$i."_popup_shortcode"][0];
					$slide_data["slide".$i."_popup_bgcol"] = $metadata["sa_slide".$i."_popup_bgcol"][0];
					$slide_data["slide".$i."_popup_width"] = $metadata["sa_slide".$i."_popup_width"][0];
					if ($slide_data["slide".$i."_popup_type"] == 'HTML') {
						$slide_data["slide".$i."_popup_css_id"] = $slide_data['css_id']."_popup".$i;
					} else {
						$slide_data["slide".$i."_popup_css_id"] = '';
					}
				}
			}
			$slide_data['slide_duration'] = floatval($metadata['sa_slide_duration'][0]) * 1000;
			if ($slide_data['slide_duration'] == 0) {
				$slide_data['slide_duration'] = 'false';
			}
			$slide_data['slide_transition'] = floatval($metadata['sa_slide_transition'][0]) * 1000;
			$slide_data['loop_slider'] = $metadata['sa_loop_slider'][0];
			if ($slide_data['loop_slider'] == '1') {
				$slide_data['loop_slider'] = 'true';
			} else {
				$slide_data['loop_slider'] = 'false';
			}
			$slide_data['stop_hover'] = $metadata['sa_stop_hover'][0];
			if ($slide_data['stop_hover'] == '1') {
				$slide_data['stop_hover'] = 'true';
			} else {
				$slide_data['stop_hover'] = 'false';
			}
			$slide_data['random_order'] = $metadata['sa_random_order'][0];
			if ($slide_data['random_order'] == '1') {
				$slide_data['random_order'] = 'true';
			} else {
				$slide_data['random_order'] = 'false';
			}
			$slide_data['nav_arrows'] = $metadata['sa_nav_arrows'][0];
			if ($slide_data['nav_arrows'] == '1') {
				$slide_data['nav_arrows'] = 'true';
			} else {
				$slide_data['nav_arrows'] = 'false';
			}
			$slide_data['pagination'] = $metadata['sa_pagination'][0];
			if ($slide_data['pagination'] == '1') {
				$slide_data['pagination'] = 'true';
			} else {
				$slide_data['pagination'] = 'false';
			}
			$slide_data['mouse_drag'] = $metadata['sa_mouse_drag'][0];
			if ($slide_data['mouse_drag'] == '1') {
				$slide_data['mouse_drag'] = 'true';
			} else {
				$slide_data['mouse_drag'] = 'false';
			}
			$slide_data['touch_drag'] = $metadata['sa_touch_drag'][0];
			if ($slide_data['touch_drag'] == '1') {
				$slide_data['touch_drag'] = 'true';
			} else {
				$slide_data['touch_drag'] = 'false';
			}
			$slide_data['items_width1'] = $metadata['sa_items_width1'][0];
			$slide_data['items_width2'] = $metadata['sa_items_width2'][0];
			$slide_data['items_width3'] = $metadata['sa_items_width3'][0];
			$slide_data['items_width4'] = $metadata['sa_items_width4'][0];
			$slide_data['items_width5'] = $metadata['sa_items_width5'][0];
			$slide_data['items_width6'] = $metadata['sa_items_width6'][0];
			if ($slide_data['items_width6'] == '') {
				$slide_data['items_width6'] = $slide_data['items_width5'];
			}
			$slide_data['transition'] = $metadata['sa_transition'][0];
			$slide_data['background_color'] = $metadata['sa_background_color'][0];
			$slide_data['border_width'] = $metadata['sa_border_width'][0];
			$slide_data['border_color'] = $metadata['sa_border_color'][0];
			$slide_data['border_radius'] = $metadata['sa_border_radius'][0];
			$slide_data['wrapper_padd_top'] = $metadata['sa_wrapper_padd_top'][0];
			$slide_data['wrapper_padd_right'] = $metadata['sa_wrapper_padd_right'][0];
			$slide_data['wrapper_padd_bottom'] = $metadata['sa_wrapper_padd_bottom'][0];
			$slide_data['wrapper_padd_left'] = $metadata['sa_wrapper_padd_left'][0];
			$slide_data['slide_min_height_perc'] = $metadata['sa_slide_min_height_perc'][0];
			$slide_data['slide_padding_tb'] = $metadata['sa_slide_padding_tb'][0];
			$slide_data['slide_padding_lr'] = $metadata['sa_slide_padding_lr'][0];
			$slide_data['slide_margin_lr'] = $metadata['sa_slide_margin_lr'][0];
			$slide_data['slide_icons_location'] = $metadata['sa_slide_icons_location'][0];
			$slide_data['autohide_arrows'] = $metadata['sa_autohide_arrows'][0];
			if ($slide_data['autohide_arrows'] == '1') {
				$slide_data['autohide_arrows'] = 'true';
			} else {
				$slide_data['autohide_arrows'] = 'false';
			}
			$slide_data['slide_icons_visible'] = $metadata['sa_slide_icons_visible'][0];
			if ($slide_data['slide_icons_visible'] == '1') {
				$slide_data['slide_icons_visible'] = 'true';
			} else {
				$slide_data['slide_icons_visible'] = 'false';
			}
			$slide_data['slide_icons_color'] = $metadata['sa_slide_icons_color'][0];
			if ($slide_data['slide_icons_color'] != 'black') {
				$slide_data['slide_icons_color'] = 'white';
			}

			// RE-ORDER SLIDES IN A RANDOM ORDER IF 'Random Order' CHECKBOX IS CHECKED
			if ($slide_data['random_order'] == 'true') {
				$reorder_arr = array();
				for ($i = 1; $i <= $slide_data['num_slides']; $i++) {
					$reorder_arr[$i-1]['content'] = $slide_data["slide".$i."_content"];
					$reorder_arr[$i-1]['image_id'] = $slide_data["slide".$i."_image_id"];
					$reorder_arr[$i-1]['image_pos'] = $slide_data["slide".$i."_image_pos"];
					$reorder_arr[$i-1]['image_size'] = $slide_data["slide".$i."_image_size"];
					$reorder_arr[$i-1]['image_repeat'] = $slide_data["slide".$i."_image_repeat"];
					$reorder_arr[$i-1]['image_color'] = $slide_data["slide".$i."_image_color"];
					$reorder_arr[$i-1]['link_url'] = $slide_data["slide".$i."_link_url"];
					$reorder_arr[$i-1]['link_target'] = $slide_data["slide".$i."_link_target"];
					if ($sa_pro_version) {
						$reorder_arr[$i-1]['popup_type'] = $slide_data["slide".$i."_popup_type"];
						$reorder_arr[$i-1]['popup_imageid'] = $slide_data["slide".$i."_popup_imageid"];
						$reorder_arr[$i-1]['popup_imagetitle'] = $slide_data["slide".$i."_popup_imagetitle"];
						$reorder_arr[$i-1]['popup_image'] = $slide_data["slide".$i."_popup_image"];
						$reorder_arr[$i-1]['popup_background'] = $slide_data["slide".$i."_popup_background"];
						$reorder_arr[$i-1]['popup_video_id'] = $slide_data["slide".$i."_popup_video_id"];
						$reorder_arr[$i-1]['popup_video_type'] = $slide_data["slide".$i."_popup_video_type"];
						$reorder_arr[$i-1]['popup_html'] = $slide_data["slide".$i."_popup_html"];
						$reorder_arr[$i-1]['popup_shortcode'] = $slide_data["slide".$i."_popup_shortcode"];
						$reorder_arr[$i-1]['popup_bgcol'] = $slide_data["slide".$i."_popup_bgcol"];
						$reorder_arr[$i-1]['popup_width'] = $slide_data["slide".$i."_popup_width"];
						$reorder_arr[$i-1]['popup_css_id'] = $slide_data["slide".$i."_popup_css_id"];
					}
				}
				shuffle($reorder_arr);
				for ($i = 1; $i <= $slide_data['num_slides']; $i++) {
					$slide_data["slide".$i."_content"] = $reorder_arr[$i-1]['content'];
					$slide_data["slide".$i."_image_id"] = $reorder_arr[$i-1]['image_id'];
					$slide_data["slide".$i."_image_pos"] = $reorder_arr[$i-1]['image_pos'];
					$slide_data["slide".$i."_image_size"] = $reorder_arr[$i-1]['image_size'];
					$slide_data["slide".$i."_image_repeat"] = $reorder_arr[$i-1]['image_repeat'];
					$slide_data["slide".$i."_image_color"] = $reorder_arr[$i-1]['image_color'];
					$slide_data["slide".$i."_link_url"] = $reorder_arr[$i-1]['link_url'];
					$slide_data["slide".$i."_link_target"] = $reorder_arr[$i-1]['link_target'];
					if ($sa_pro_version) {
						$slide_data["slide".$i."_popup_type"] = $reorder_arr[$i-1]['popup_type'];
						$slide_data["slide".$i."_popup_imageid"] = $reorder_arr[$i-1]['popup_imageid'];
						$slide_data["slide".$i."_popup_imagetitle"] = $reorder_arr[$i-1]['popup_imagetitle'];
						$slide_data["slide".$i."_popup_image"] = $reorder_arr[$i-1]['popup_image'];
						$slide_data["slide".$i."_popup_background"] = $reorder_arr[$i-1]['popup_background'];
						$slide_data["slide".$i."_popup_video_id"] = $reorder_arr[$i-1]['popup_video_id'];
						$slide_data["slide".$i."_popup_video_type"] = $reorder_arr[$i-1]['popup_video_type'];
						$slide_data["slide".$i."_popup_html"] = $reorder_arr[$i-1]['popup_html'];
						$slide_data["slide".$i."_popup_shortcode"] = $reorder_arr[$i-1]['popup_shortcode'];
						$slide_data["slide".$i."_popup_bgcol"] = $reorder_arr[$i-1]['popup_bgcol'];
						$slide_data["slide".$i."_popup_width"] = $reorder_arr[$i-1]['popup_width'];
						$slide_data["slide".$i."_popup_css_id"] = $reorder_arr[$i-1]['popup_css_id'];
					}
				}
			}
			
			// GENERATE HTML CODE FOR THE OWL CAROUSEL SLIDER
			$wrapper_style =  "background:".$slide_data['background_color']."; ";
			$wrapper_style .=  "border:solid ".$slide_data['border_width']."px ".$slide_data['border_color']."; ";
			$wrapper_style .=  "border-radius:".$slide_data['border_radius']."px; ";
			$wrapper_style .=  "padding:".$slide_data['wrapper_padd_top']."px ";
			$wrapper_style .= $slide_data['wrapper_padd_right']."px ";
			$wrapper_style .= $slide_data['wrapper_padd_bottom']."px ";
			$wrapper_style .= $slide_data['wrapper_padd_left']."px;";
			$output .= "<div class='".$slide_data['slide_icons_color']."' style='".esc_attr($wrapper_style)."'>\n";
			if ($slide_data['pagination'] == 'true') {
				if ($slide_data['autohide_arrows'] == 'true') {
					$output .= "<div id='".esc_attr($slide_data['css_id'])."' class='owl-carousel owl-pagination-true autohide-arrows sa_owl_theme'>\n";
				} else {
					$output .= "<div id='".esc_attr($slide_data['css_id'])."' class='owl-carousel owl-pagination-true sa_owl_theme'>\n";
				}
			} else {
				if ($slide_data['autohide_arrows'] == 'true') {
					$output .= "<div id='".esc_attr($slide_data['css_id'])."' class='owl-carousel autohide-arrows sa_owl_theme'>\n";
				} else {
					$output .= "<div id='".esc_attr($slide_data['css_id'])."' class='owl-carousel sa_owl_theme'>\n";
				}
			}
			if ($sa_pro_version) {
				// PRO VERSION - INITIALISE VAIRABLES FOR MAGNIFIC POPUP
				$lightbox_function = "open_lightbox_gallery_".$slide_data['css_id'];
				$lightbox_gallery_id = "lightbox_button_".$slide_data['css_id'];
				$lightbox_count = 0;
			}
			for ($i = 1; $i <= $slide_data['num_slides']; $i++) {
				$valid_char_count = $slide_data["slide".$i."_valid_char_count"];
				$actual_char_count = $slide_data["slide".$i."_actual_char_count"];
				// validate that slide content contains the correct number of characters, otherwise do not display slide
				// {to prevent malicious content being inserted into slides)
				if ($valid_char_count == $actual_char_count) {
					$slide_content = $slide_data["slide".$i."_content"];
					$slide_image_src = wp_get_attachment_image_src($slide_data["slide".$i."_image_id"], 'full');
					// SA PRO VERSION - USE POPUP IMAGE AS SLIDE BACKGROUND IMAGE (IF THIS OPTION SELECTED)
					if (($sa_pro_version) && ($slide_data["slide".$i."_popup_type"] == 'IMAGE')) {
						if (($slide_data["slide".$i."_popup_background"] != 'no') && ($slide_data["slide".$i."_popup_image"] != '')) {
							$slide_image_src = wp_get_attachment_image_src($slide_data["slide".$i."_popup_imageid"], $slide_data["slide".$i."_popup_background"]);
						}
					}
					$slide_image_size = $slide_data["slide".$i."_image_size"];
					$slide_image_pos = $slide_data["slide".$i."_image_pos"];
					$slide_image_repeat = $slide_data["slide".$i."_image_repeat"];
					$slide_image_color = $slide_data["slide".$i."_image_color"];
					$slide_style =  "padding:".$slide_data['slide_padding_tb']."% ".$slide_data['slide_padding_lr']."%; ";
					$slide_style .= "margin:0px ".$slide_data['slide_margin_lr']."%; ";
					$slide_style .= "background-image:url(\"".$slide_image_src[0]."\"); ";
					$slide_style .= "background-position:".$slide_image_pos."; ";
					$slide_style .= "background-size:".$slide_image_size."; ";
					$slide_style .= "background-repeat:".$slide_image_repeat."; ";
					$slide_style .= "background-color:".$slide_image_color."; ";

					// BUILD SLIDE LINK HOVER BUTTON
					$link_output = '';
					if ($slide_data["slide".$i."_link_url"] != '') {
						$link_output =  "<a class='sa_slide_link_icon' href='".$slide_data["slide".$i."_link_url"]."' ";
						$link_output .= "target='".$slide_data["slide".$i."_link_target"]."'></a>";
					}

					// BUILD POPUP HOVER BUTTON - PRO VERSION ONLY!
					$popup_output = '';
					if ($sa_pro_version) {
						if (($slide_data["slide".$i."_popup_type"] == 'IMAGE') && ($slide_data["slide".$i."_popup_image"] != '')) {
							$lightbox_count++;
							$popup_output =  "<div class='sa_popup_zoom_icon' onClick='".$lightbox_function."(".$lightbox_count.");'></div>";
						}
						if (($slide_data["slide".$i."_popup_type"] == 'VIDEO') && ($slide_data["slide".$i."_popup_video_id"] != '')) {
							$lightbox_count++;
							$popup_output =  "<div class='sa_popup_video_icon' onClick='".$lightbox_function."(".$lightbox_count.");'></div>";
						}
						if ($slide_data["slide".$i."_popup_type"] == 'HTML') {
							$lightbox_count++;
							$popup_output =  "<div class='sa_popup_zoom_icon' onClick='".$lightbox_function."(".$lightbox_count.");'></div>";
						}
					}

					// DISPLAY SLIDE OUTPUT
					//$data_hash = $slide_data['css_id']."_slide".sprintf('%02d', $i);
					//$output .= "<div class='sa_hover_container' data-hash='".$data_hash."' style='".esc_attr($slide_style)."'>";
					$output .= "<div class='sa_hover_container' style='".esc_attr($slide_style)."'>";
					if (($link_output != '') || ($popup_output != '')) {
						if ($slide_data['slide_icons_location'] == 'Top Left') {
							// icons location - top left
							$style = "top:0px; left:0px; margin:0px;";
						} elseif ($slide_data['slide_icons_location'] == 'Top Center') {
							// icons location - top center
							if (($link_output != '') && ($popup_output != ''))	{ $hov_marginL = '-40px'; }
							else																{ $hov_marginL = '-20px'; }
							$style = "top:0px; left:50%; margin-left:".$hov_marginL.";";
						} elseif ($slide_data['slide_icons_location'] == 'Top Right') {
							// icons location - top right
							$style = "top:0px; right:0px; margin:0px;";
						} elseif ($slide_data['slide_icons_location'] == 'Bottom Left') {
							// icons location - bottom left
							$style = "bottom:0px; left:0px; margin:0px;";
						} elseif ($slide_data['slide_icons_location'] == 'Bottom Center') {
							// icons location - bottom center
							if (($link_output != '') && ($popup_output != ''))	{ $hov_marginL = '-40px'; }
							else																{ $hov_marginL = '-20px'; }
							$style = "bottom:0px; left:50%; margin-left:".$hov_marginL.";";
						} elseif ($slide_data['slide_icons_location'] == 'Bottom Right') {
							// icons location - bottom right
							$style = "bottom:0px; right:0px; margin:0px;";
						} else {
							// icons location - center center (default)
							if (($link_output != '') && ($popup_output != '')) { $hov_marginL = '-40px'; }
							else																{ $hov_marginL = '-20px'; }
							$style = "top:50%; left:50%; margin-top:-20px; margin-left:".$hov_marginL.";";
						}
						if ($slide_data['slide_icons_visible'] == 'true') {
							$output .= "<div class='sa_hover_buttons always_visible' style='".$style."'>";
						} else {
							$output .= "<div class='sa_hover_buttons' style='".$style."'>";
						}
						if ($link_output != '') {
							$output .= $link_output;
						}
						if ($popup_output != '') {
							$output .= $popup_output;
						}
						$output .= "</div>\n"; // .sa_hover_buttons
					}
					$output .= $slide_content."</div>\n"; // .sa_hover_container
				}
			}
			$output .= "</div>\n";
			$output .= "</div>\n";



			// PRO VERSION - CREATE A (HIDDEN) DIV FOR EACH 'HTML' POPUP
			if ($sa_pro_version) {
				for ($i = 1; $i <= $slide_data['num_slides']; $i++) {
					if ($slide_data["slide".$i."_popup_type"] == 'HTML') {
						$popup_css_id = $slide_data["slide".$i."_popup_css_id"];
						$popup_bgcol = $slide_data["slide".$i."_popup_bgcol"];
						$popup_width = $slide_data["slide".$i."_popup_width"];
						$output .= "<div id='".$popup_css_id."' class='mfp-hide sa_custom_popup' ";
						$output .= "style='background:".$popup_bgcol."; max-width:".$popup_width."px;'>\n";
						if ($slide_data["slide".$i."_popup_shortcode"] == '1') {
							$output .= do_shortcode($slide_data["slide".$i."_popup_html"]);
						} else {
							$output .=  $slide_data["slide".$i."_popup_html"];
						}
						$output .=  "</div>\n";
					}
				}
			}



			// ### GENERATE JQUERY CODE FOR THE OWL CAROUSEL SLIDER ###
			if (wp_script_is('jquery', 'done')) { // Only generate JQuery code if JQuery has been loaded
				if (($slide_data['items_width1'] == 1) && ($slide_data['items_width2'] == 1) && ($slide_data['items_width3'] == 1) &&
					 ($slide_data['items_width4'] == 1) && ($slide_data['items_width5'] == 1) && ($slide_data['items_width6'] == 1)) {
					$single_item = 1;
				} else {
					$single_item = 0;
				}
				$output .= "<script type='text/javascript'>\n";
				$output .= "	jQuery(document).ready(function() {\n";

				// JQUERY CODE FOR OWN CAROUSEL
				$output .= "		jQuery('#".esc_attr($slide_data['css_id'])."').owlCarousel({\n";
				if ($single_item == 1) {
					$output .= "			items : 1,\n";
					if (($slide_data['transition'] == 'Fade') || ($slide_data['transition'] == 'fade')) {
						$output .= "			animateOut : 'fadeOut',\n";
					} elseif (($slide_data['transition'] == 'Slide Down') || ($slide_data['transition'] == 'goDown')) {
						$output .= "			animateOut : 'slideOutDown',\n";
						$output .= "			animateIn : 'fadeIn',\n";
					} elseif ($slide_data['transition'] == 'Zoom In') {
						$output .= "			animateOut : 'fadeOut',\n";
						$output .= "			animateIn : 'zoomIn',\n";
					} elseif ($slide_data['transition'] == 'Zoom Out') {
						$output .= "			animateOut : 'zoomOut',\n";
						$output .= "			animateIn : 'fadeIn',\n";
					} elseif ($slide_data['transition'] == 'Flip Out X') {
						$output .= "			animateOut : 'flipOutX',\n";
						$output .= "			animateIn : 'fadeIn',\n";
					} elseif ($slide_data['transition'] == 'Flip Out Y') {
						$output .= "			animateOut : 'flipOutY',\n";
						$output .= "			animateIn : 'fadeIn',\n";
					} elseif ($slide_data['transition'] == 'Rotate Left') {
						$output .= "			animateOut : 'rotateOutDownLeft',\n";
						$output .= "			animateIn : 'fadeIn',\n";
					} elseif ($slide_data['transition'] == 'Rotate Right') {
						$output .= "			animateOut : 'rotateOutDownRight',\n";
						$output .= "			animateIn : 'fadeIn',\n";
					} elseif ($slide_data['transition'] == 'Bounce Out') {
						$output .= "			animateOut : 'bounceOut',\n";
						$output .= "			animateIn : 'fadeIn',\n";
					} elseif ($slide_data['transition'] == 'Roll Out') {
						$output .= "			animateOut : 'rollOut',\n";
						$output .= "			animateIn : 'fadeIn',\n";
					}
					$output .= "			smartSpeed : ".esc_attr($slide_data['slide_transition']).",\n";
				} else {
					$output .= "			responsive:{\n";
					$output .= "				0:{ items:".esc_attr($slide_data['items_width1'])." },\n";
					$output .= "				480:{ items:".esc_attr($slide_data['items_width2'])." },\n";
					$output .= "				768:{ items:".esc_attr($slide_data['items_width3'])." },\n";
					$output .= "				980:{ items:".esc_attr($slide_data['items_width4'])." },\n";
					$output .= "				1200:{ items:".esc_attr($slide_data['items_width5'])." },\n";
					$output .= "				1500:{ items:".esc_attr($slide_data['items_width6'])." }\n";
					$output .= "			},\n";
				}
				if ($slide_data['slide_duration'] == 0) {
					$output .= "			autoplay : false,\n";
				} else {
					$output .= "			autoplay : true,\n";
					$output .= "			autoplayTimeout : ".esc_attr($slide_data['slide_duration']).",\n";
				}
				$output .= "			smartSpeed : ".esc_attr($slide_data['slide_transition']).",\n";
				$output .= "			fluidSpeed : ".esc_attr($slide_data['slide_transition']).",\n";
				$output .= "			autoplaySpeed : ".esc_attr($slide_data['slide_transition']).",\n";
				$output .= "			navSpeed : ".esc_attr($slide_data['slide_transition']).",\n";
				$output .= "			dotsSpeed : ".esc_attr($slide_data['slide_transition']).",\n";
				$output .= "			loop : ".esc_attr($slide_data['loop_slider']).",\n";
				$output .= "			autoplayHoverPause : ".esc_attr($slide_data['stop_hover']).",\n";
				$output .= "			nav : ".esc_attr($slide_data['nav_arrows']).",\n";
				$output .= "			navText : ['',''],\n";
				$output .= "			dots : ".esc_attr($slide_data['pagination']).",\n";
				$output .= "			responsiveRefreshRate : 200,\n";
				$output .= "			mergeFit : true,\n";
				//$output .= "			URLhashListener : true,\n";
				$output .= "			mouseDrag : ".esc_attr($slide_data['mouse_drag']).",\n";
				$output .= "			touchDrag : ".esc_attr($slide_data['touch_drag'])."\n";
				$output .= "		});\n";

				// JAVASCRIPT 'WINDOW RESIZE' EVENT TO SET CSS 'min-height' OF SLIDES WITHIN THIS SLIDER
				$slide_min_height = $slide_data['slide_min_height_perc'];
				if (($slide_min_height != '') && ($slide_min_height != '0')) {
					$output .= "		sa_resize_".esc_attr($slide_data['css_id'])."();\n";	// initial call of resize function
					$output .= "		window.addEventListener('resize', sa_resize_".esc_attr($slide_data['css_id']).");\n"; // create resize event
											// RESIZE EVENT FUNCTION (to set slide CSS 'min-heigh')
					$output .= "		function sa_resize_".esc_attr($slide_data['css_id'])."() {\n";
												// get slide min height setting
					$output .= "			var min_height = '".$slide_min_height."';\n";
												// get window width
					$output .= "			var win_width = jQuery(window).width();\n";
					$output .= "			var slider_width = jQuery('#".esc_attr($slide_data['css_id'])."').width();\n";
												// calculate slide width according to window width & number of slides
					$output .= "			if (win_width < 480) {\n";
					$output .= "				var slide_width = slider_width / ".esc_attr($slide_data['items_width1']).";\n";
					$output .= "			} else if (win_width < 768) {\n";
					$output .= "				var slide_width = slider_width / ".esc_attr($slide_data['items_width2']).";\n";
					$output .= "			} else if (win_width < 980) {\n";
					$output .= "				var slide_width = slider_width / ".esc_attr($slide_data['items_width3']).";\n";
					$output .= "			} else if (win_width < 1200) {\n";
					$output .= "				var slide_width = slider_width / ".esc_attr($slide_data['items_width4']).";\n";
					$output .= "			} else if (win_width < 1500) {\n";
					$output .= "				var slide_width = slider_width / ".esc_attr($slide_data['items_width5']).";\n";
					$output .= "			} else {\n";
					$output .= "				var slide_width = slider_width / ".esc_attr($slide_data['items_width6']).";\n";
					$output .= "			}\n";
					$output .= "			slide_width = Math.round(slide_width);\n";
												// calculate CSS 'min-height' using the captured 'min-height' data settings for this slider
					$output .= "			var slide_height = '0';\n";
					$output .= "			if (min_height == 'aspect43') {\n";
					$output .= "				slide_height = (slide_width / 4) * 3;";
					$output .= "				slide_height = Math.round(slide_height);\n";
					$output .= "			} else if (min_height == 'aspect169') {\n";
					$output .= "				slide_height = (slide_width / 16) * 9;";
					$output .= "				slide_height = Math.round(slide_height);\n";
					$output .= "			} else {\n";
					$output .= "				slide_height = (slide_width / 100) * min_height;";
					$output .= "				slide_height = Math.round(slide_height);\n";
					$output .= "			}\n";
												// set the slide 'min-height' css value
					$output .= "			jQuery('#".esc_attr($slide_data['css_id'])." .owl-item .sa_hover_container').css('min-height', slide_height+'px');\n";
					$output .= "		}\n";
				}
				$output .= "	});\n";
				$output .= "</script>\n";
			}



			// ### GENERATE JQUERY CODE FOR THE MAGNIFIC POPUP ###
			if (wp_script_is('jquery', 'done')) { // Only generate JQuery code if JQuery has been loaded
				if (($sa_pro_version) && ($lightbox_count > 0)) {
					$output .= "<script type='text/javascript'>\n";
					$output .= "jQuery(document).ready(function() {\n";
					$output .= "	jQuery('#".$lightbox_gallery_id."').magnificPopup({\n";
					$output .= "		items: [\n";
					$count = 0;
					for ($i = 1; $i <= $slide_data['num_slides']; $i++) {
						// LOOP THROUGH EACH SLIDE
						if (($slide_data["slide".$i."_popup_type"] == 'IMAGE') && ($slide_data["slide".$i."_popup_image"] != '')) {
							// SLIDE CONTAINS AN IMAGE POPUP
							$img_url = $slide_data["slide".$i."_popup_image"];
							$img_title = $slide_data["slide".$i."_popup_imagetitle"];
							if ($img_title != '') {
								$output .= "			{ src: '".esc_attr($img_url)."', title: '".esc_attr($img_title)."' }";
							} else {
								$output .= "			{ src: '".esc_attr($img_url)."' }";
							}
							$count++;
							if ($count < $lightbox_count) {	$output .= ",\n"; }
							else {									$output .= "\n"; }
						}
						if (($slide_data["slide".$i."_popup_type"] == 'VIDEO') && ($slide_data["slide".$i."_popup_video_id"] != '')) {
							// SLIDE CONTAINS A VIDEO POPUP
							$video_id = $slide_data["slide".$i."_popup_video_id"];
							$video_type = $slide_data["slide".$i."_popup_video_type"];
							if ($video_type == 'youtube') {
								$video_url = "http://www.youtube.com/watch?v=".$video_id;
							} elseif ($video_type == 'vimeo') {
								$video_url = "http://vimeo.com/".$video_id;
							}
							$output .= "			{ src: '".esc_attr($video_url)."', type: 'iframe' }";
							$count++;
							if ($count < $lightbox_count) {	$output .= ",\n"; }
							else {									$output .= "\n"; }
						}
						if ($slide_data["slide".$i."_popup_type"] == 'HTML') {
							// SLIDE CONTAINS A HTML POPUP
							$popup_css_id = "#".$slide_data["slide".$i."_popup_css_id"];
							$output .= "			{ src: '".esc_attr($popup_css_id)."', type: 'inline' }";
							$count++;
							if ($count < $lightbox_count) {	$output .= ",\n"; }
							else {									$output .= "\n"; }
						}
					}
					$output .= "		],\n";
					$output .= "		gallery: { enabled: true, tCounter: '' },\n";
					$output .= "		mainClass: 'sa_popup',\n";
					$output .= "		closeBtnInside: true,\n";
					$output .= "		callbacks: {\n";
					$output .= "			open: function() {\n";
					$output .= "				jQuery('#".esc_attr($slide_data['css_id'])."').trigger('stop.owl.autoplay');\n";
					if ($slide_data['slide_duration'] != 0) {
						$output .= "				jQuery('#".esc_attr($slide_data['css_id'])."').unbind('mouseleave');\n";
					}
					$output .= "			}\n";
					$output .= "		},\n";
					$output .= "		type: 'image'\n";
					$output .= "	});\n";
					$output .= "});\n";

					// JAVASCRIPT FUNCTION WHICH OPENS THIS MAGNIFIC POPUP ON A SPECIFIED SLIDE
					$output .= "function ".$lightbox_function."(slide) {\n";
					$output .= "	jQuery('#".$lightbox_gallery_id."').magnificPopup('open');\n";
					$output .= "	jQuery('#".$lightbox_gallery_id."').magnificPopup('goTo', slide-1);\n";
					$output .= "}\n";
					$output .= "</script>\n";

					// DIV CONTAINER WHICH HOLDS THIS MAGNIFIC POPUP CONTENT (HIDDEN)
					$output .= "<div id='".$lightbox_gallery_id."' style='display:none;'></div>\n";
				}
			}
		}
	}
	return $output;
}
?>