<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<?php
  // Add the content type as a class to each result row.
  $content_type = '';

  if ($view->field['type']->original_value == 'song') {
    $content_type = 'song';
  }
  elseif ($view->field['type']->original_value == 'blog_post') {
    $content_type = 'blog_post';
  }
?>

<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
  <div <?php if ($classes_array[$id]) { print 'class="' . $classes_array[$id] .' '. $content_type  .'"';  } ?>>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
