<?php
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php

$download_links = array();

if (isset($fields['title'])):
  print $fields['title']->wrapper_prefix;
    print $fields['title']->label_html;
    print $fields['title']->content;
  print $fields['title']->wrapper_suffix;
endif;

if (isset($fields['field_demo'])):
  print $fields['field_demo']->wrapper_prefix;
    print $fields['field_demo']->label_html;
    print $fields['field_demo']->content;
  print $fields['field_demo']->wrapper_suffix;
endif;

if (isset($fields['field_chart'])):
  $download_links[] = array(
    'title' => t('Chart'),
    'href' => $fields['field_chart']->content,
    'target' => "_blank",
  );
endif;

if (isset($fields['field_lead_sheet'])):
  $download_links[] = array(
    'title' => t('Lead Sheet'),
    'href' => $fields['field_lead_sheet']->content,
    'target' => "_blank",
  );
endif;

if (isset($fields['field_powerpoint'])):
  $download_links[] = array(
    'title' => t('Powerpoint'),
    'href' => $fields['field_powerpoint']->content,
    'target' => "_blank",
  );
endif;

if (isset($fields['field_sheet_music'])):
  $download_links[] = array(
    'title' => t('Sheet Music'),
    'href' => $fields['field_sheet_music']->content,
    'target' => "_blank",
  );
endif;

if (!empty($download_links)) {
  print theme('ctools_dropdown', array('title' => t('Downloads'), 'links' => $download_links));
}

if (isset($fields['field_buy_song'])):
  print $fields['field_buy_song']->wrapper_prefix;
    print $fields['field_buy_song']->label_html;
    print $fields['field_buy_song']->content;
  print $fields['field_buy_song']->wrapper_suffix;
endif; ?>