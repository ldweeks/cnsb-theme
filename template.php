<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * A QUICK OVERVIEW OF DRUPAL THEMING
 *
 *   The default HTML for all of Drupal's markup is specified by its modules.
 *   For example, the comment.module provides the default HTML markup and CSS
 *   styling that is wrapped around each comment. Fortunately, each piece of
 *   markup can optionally be overridden by the theme.
 *
 *   Drupal deals with each chunk of content using a "theme hook". The raw
 *   content is placed in PHP variables and passed through the theme hook, which
 *   can either be a template file (which you should already be familiary with)
 *   or a theme function. For example, the "comment" theme hook is implemented
 *   with a comment.tpl.php template file, but the "breadcrumb" theme hooks is
 *   implemented with a theme_breadcrumb() theme function. Regardless if the
 *   theme hook uses a template file or theme function, the template or function
 *   does the same kind of work; it takes the PHP variables passed to it and
 *   wraps the raw content with the desired HTML markup.
 *
 *   Most theme hooks are implemented with template files. Theme hooks that use
 *   theme functions do so for performance reasons - theme_field() is faster
 *   than a field.tpl.php - or for legacy reasons - theme_breadcrumb() has "been
 *   that way forever."
 *
 *   The variables used by theme functions or template files come from a handful
 *   of sources:
 *   - the contents of other theme hooks that have already been rendered into
 *     HTML. For example, the HTML from theme_breadcrumb() is put into the
 *     $breadcrumb variable of the page.tpl.php template file.
 *   - raw data provided directly by a module (often pulled from a database)
 *   - a "render element" provided directly by a module. A render element is a
 *     nested PHP array which contains both content and meta data with hints on
 *     how the content should be rendered. If a variable in a template file is a
 *     render element, it needs to be rendered with the render() function and
 *     then printed using:
 *       <?php print render($variable); ?>
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. With this file you can do three things:
 *   - Modify any theme hooks variables or add your own variables, using
 *     preprocess or process functions.
 *   - Override any theme function. That is, replace a module's default theme
 *     function with one you write.
 *   - Call hook_*_alter() functions which allow you to alter various parts of
 *     Drupal's internals, including the render elements in forms. The most
 *     useful of which include hook_form_alter(), hook_form_FORM_ID_alter(),
 *     and hook_page_alter(). See api.drupal.org for more information about
 *     _alter functions.
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   If a theme hook uses a theme function, Drupal will use the default theme
 *   function unless your theme overrides it. To override a theme function, you
 *   have to first find the theme function that generates the output. (The
 *   api.drupal.org website is a good place to find which file contains which
 *   function.) Then you can copy the original function in its entirety and
 *   paste it in this template.php file, changing the prefix from theme_ to
 *   cnsb_theme_. For example:
 *
 *     original, found in modules/field/field.module: theme_field()
 *     theme override, found in template.php: cnsb_theme_field()
 *
 *   where cnsb_theme is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_field() function.
 *
 *   Note that base themes can also override theme functions. And those
 *   overrides will be used by sub-themes unless the sub-theme chooses to
 *   override again.
 *
 *   Zen core only overrides one theme function. If you wish to override it, you
 *   should first look at how Zen core implements this function:
 *     theme_breadcrumbs()      in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called theme hook suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node--forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and theme hook suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440 and http://drupal.org/node/1089656
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function cnsb_theme_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  cnsb_theme_preprocess_html($variables, $hook);
  cnsb_theme_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
function cnsb_theme_preprocess_html(&$variables, $hook) {

  // This adds classes to the body tag of a page depending on which facet has been selected.
  $current_adapter = facetapi_adapter_load('search_api@node_index');
  $active_items = $current_adapter->getAllActiveItems();

  if (!empty($active_items)) {
    foreach ($active_items as $key => $value) {
      $class = str_replace(':', '-', $key);
      $variables['classes_array'][] = $class;
    }
  }
}

function cnsb_theme_file_icon($vars) {
  /*
  $file = $variables['file'];
  $icon_directory = drupal_get_path('theme', 'cnsb_theme') . '/images/icons';

  $mime = check_plain($file->filemime);

  $icon_url = file_icon_url($file, $icon_directory);
  return '<img alt="" class="file-icon" src="' . $icon_url . '" title="' . $mime . '" />';
  */
  return '';
}

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function cnsb_theme_preprocess_page(&$variables, $hook) {
  if (isset($variables['node']->type)) {
    $variables['theme_hook_suggestions'][] = 'page__' . $variables['node']->type;
  }

  $node = menu_get_object();
  if ($node->type == 'song') {
    if (isset($node->field_demo)) {
      $variables['demo'] = field_view_field('node', $node, 'field_demo', 'default');
    }
  }
}

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function cnsb_theme_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function cnsb_theme_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function cnsb_theme_preprocess_block(&$variables, $hook) {
  $variables['ctools_collapsible'] = FALSE;

  if (isset($variables['block']->bid)) {
    // Filter by genre
    if ($variables['block']->bid == 'facetapi-I0yeNBvgRULkchaiqE00dg1Sgh4XMcfd') {
      $handle = '<h2 class="block-title">Filter by Genre:</h2>';
      $variables['title_and_content'] = theme('ctools_collapsible', array('handle' => $handle, 'content' => $variables['content'], 'collapsed' => TRUE));
      $variables['ctools_collapsible'] = TRUE;

      //$variables['content'] = theme('ctools_collapsible', array('handle' => $handle, 'content' => $variables['content'], 'collapsed' => TRUE));
    }
    // Filter by theme
    elseif ($variables['block']->bid == 'facetapi-8tfY1O9dl06CbIFiv0pFign5QRVf0Ch0') {
      $handle = '<h2 class="block-title">Filter by Theme:</h2>';
      $variables['title_and_content'] = theme('ctools_collapsible', array('handle' => $handle, 'content' => $variables['content'], 'collapsed' => TRUE));
      $variables['ctools_collapsible'] = TRUE;

      //$variables['content'] = theme('ctools_collapsible', array('handle' => $handle, 'content' => $variables['content'], 'collapsed' => TRUE));
    }
    // Filter by key
    elseif ($variables['block']->bid == 'facetapi-KgeL33xlACTVRvah9t2erBJxhM7AmCVj') {
      $handle = '<h2 class="block-title">Filter by Key:</h2>';
      $variables['title_and_content'] = theme('ctools_collapsible', array('handle' => $handle, 'content' => $variables['content'], 'collapsed' => TRUE));
      $variables['ctools_collapsible'] = TRUE;

      //$variables['content'] = theme('ctools_collapsible', array('handle' => $handle, 'content' => $variables['content'], 'collapsed' => TRUE));
    }
    // Filter by contributor
    elseif ($variables['block']->bid == 'facetapi-JaX0qbSgIAdVdHdLOPgJMOpa5SPe9HEN') {
      $handle = '<h2 class="block-title">Filter by Contributor:</h2>';
      $variables['title_and_content'] = theme('ctools_collapsible', array('handle' => $handle, 'content' => $variables['content'], 'collapsed' => TRUE));
      $variables['ctools_collapsible'] = TRUE;

      //$variables['content'] = theme('ctools_collapsible', array('handle' => $handle, 'content' => $variables['content'], 'collapsed' => TRUE));
    }
    // Filter by tempo
    elseif ($variables['block']->bid == 'facetapi-YqtVT1gVIEqvQqwyDYdxvL5E9aUqXWQF') {
      $handle = '<h2 class="block-title">Filter by Tempo:</h2>';
      $variables['title_and_content'] = theme('ctools_collapsible', array('handle' => $handle, 'content' => $variables['content'], 'collapsed' => TRUE));
      $variables['ctools_collapsible'] = TRUE;

      //$variables['content'] = theme('ctools_collapsible', array('handle' => $handle, 'content' => $variables['content'], 'collapsed' => TRUE));
    }
  }
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */

function cnsb_theme_preprocess_node(&$vars) {

  // Change "submitted by" to "by".
  $vars['submitted'] =  t('by !username on !datetime',
    array('!username' => $vars['name'], '!datetime' => $vars['date'],));

  // Remove the existing "Read More" link.
  unset($vars['content']['links']['node']['#links']['node-readmore']);

  // Add "Continue Reading" link.
  $vars['continue_reading'] = t('<span class="continue-reading"> <a href="!title">Continue Reading</a> </span>', array('
!title' => $vars['node_url'],));

  // Add a variable for social media share buttons
  $social_media = "<span class='st_facebook_hcount' displayText='Facebook'></span><span class='st_fblike_hcount' displayText='Facebook Like'></span><span class='st_twitter_hcount' displayText='Tweet'></span><span class='st_pinterest_hcount' displayText='Pinterest'></span><span class='st_email_hcount' displayText='Email'></span><span class='st_sharethis_hcount' displayText='ShareThis'></span>";

  if ($vars['type'] == 'blog_post') {
    // Create variables for the user profile bio and picture.
    $user_profile = profile2_load_by_user($vars['uid']);

    if (isset($user_profile['user_profile'])) {
      $vars['profile2_bio'] = field_view_field('profile2', $user_profile['user_profile'], 'field_bio', 'default');
      $vars['profile2_pic'] = field_view_field('profile2', $user_profile['user_profile'], 'field_picture', 'default');
    }

    // Change the date into the following format for blog posts: Friday, Nov 30, 2012
    $vars['date'] = format_date($vars['created'], 'blog_post');

    $vars['social_media'] = $social_media;
  }
  elseif ($vars['type'] == 'song') {
    // Add a boolean flag for existing downloads and products. Useful in the song node template file.
    if (!empty($vars['field_itunes']) || !empty($vars['field_amazon']) || !empty($vars['field_sellfy']) || !empty($vars['field_bandcamp'])) {
      $vars['can_buy'] = true;
    }
    if (!empty($vars['field_powerpoint']) || !empty($vars['field_chart']) || !empty($vars['field_lead_sheet']) || !empty($vars['field_sheet_music'])) {
      $vars['can_download'] = true;
    }
    $vars['social_media'] = $social_media;
  }
  elseif ($vars['type'] == 'liturgy_page') {
    $vars['social_media'] = $social_media;
  }
}
