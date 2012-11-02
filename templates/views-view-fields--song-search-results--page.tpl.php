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

//dpm($fields, "Fields");

$download_links = array();
$buy_links = array();

if (isset($fields['field_demo'])) {
  print $fields['field_demo']->wrapper_prefix;
    print $fields['field_demo']->label_html;
    print $fields['field_demo']->content;
  print $fields['field_demo']->wrapper_suffix;
}

if (isset($fields['title'])) {
  print $fields['title']->wrapper_prefix;
    print $fields['title']->label_html;
    print $fields['title']->content;
  print $fields['title']->wrapper_suffix;
}

if (isset($fields['field_chart'])) {

  $charts = explode("@", $fields['field_chart']->content);

  foreach ($charts as $chart) {
    $chart = explode("|", $chart);

    $download_links[] = array(
      'title' => t($chart[1]),
      'href' => $chart[0],
      'attributes' => array('target' => "_blank"),
    );
  }
}

if (isset($fields['field_lead_sheet'])) {

  $lead_sheets = explode("@", $fields['field_lead_sheet']->content);

  foreach ($lead_sheets as $lead_sheet) {
    $lead_sheet = explode("|", $lead_sheet);

    $download_links[] = array(
      'title' => t($lead_sheet[1]),
      'href' => $lead_sheet[0],
      'attributes' => array('target' => "_blank"),
    );
  }
}

if (isset($fields['field_powerpoint'])) {

  $powerpoints = explode("@", $fields['field_powerpoint']->content);

  foreach ($powerpoints as $powerpoint) {
    $powerpoint = explode("|", $powerpoint);

    $download_links[] = array(
      'title' => t($powerpoint[1]),
      'href' => $powerpoint[0],
      'attributes' => array('target' => "_blank"),
    );
  }
}

if (isset($fields['field_sheet_music'])) {

  $music_sheets = explode("@", $fields['field_sheet_music']->content);

  foreach ($music_sheets as $music_sheet) {
    $music_sheet = explode("|", $music_sheet);

    $download_links[] = array(
      'title' => t($music_sheet[1]),
      'href' => $music_sheet[0],
      'attributes' => array('target' => "_blank"),
    );
  }
}

if (!empty($download_links)) {
  print theme('ctools_dropdown', array('title' => t('Downloads'), 'links' => $download_links));
}

if (!empty($fields['field_sellfy']->content)) {

  $sheets_for_sale = explode("@", $fields['field_sellfy']->content);

  foreach ($sheets_for_sale as $sheet) {
    $sheet = explode("|", $sheet);

    $buy_links[] = array(
      'title' => t($sheet[0]),
      'href' => $sheet[1],
      'attributes' => array('target' => "_blank"),
    );
  }
}

if (!empty($fields['field_itunes_url']->content)) {
  $buy_links[] = array(
    'title' => 'iTunes',
    'href' => $fields['field_itunes_url']->content,
    'attributes' => array('target' => "_blank"),
  );
}

if (!empty($fields['field_amazon_url']->content)) {
  $buy_links[] = array(
    'title' => 'Amazon',
    'href' => $fields['field_amazon_url']->content,
    'attributes' => array('target' => "_blank"),
  );
}

if (!empty($fields['field_bandcamp_url']->content)) {
  $buy_links[] = array(
    'title' => 'Bandcamp',
    'href' => $fields['field_bandcamp_url']->content,
    'attributes' => array('target' => "_blank"),
  );
}

if (!empty($buy_links)) {
  print theme('ctools_dropdown', array('title' => t('Buy'), 'links' => $buy_links));
}

?>
