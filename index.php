<?php

/**
 * This plugin uses the page.create:after hook to store 2 additional fields into
 * the page, the creation and modification date/time as a Unix Epoch. With the
 * page.update:after and the page.changeTitle:after hooks only the modification
 * date is updated.
 * 
 * In addition to that, the plugin provides a field method "epoch2date" to return
 * this epoch in a formatted string. The default format of this sring is set to
 * "D, j M Y H:i:s T", but this can be changed on a global level in site-config
 * with
 * 
 * 'adspectus.date-extended.date_format' => string or constant
 * 
 * or as a parameter to the field method.
 */

 Kirby::plugin('adspectus/date-extended', [
  'options' => [
    'date_format' => 'D, j M Y H:i:s T',
  ],
  'fieldMethods' => [
    'epoch2date' => function ($field,$format = '') {
      if ($format == '') { $format = option('adspectus.date-extended.date_format'); }
      return date($format,$field->value());
    },
  ],
  'hooks' => [
    'page.create:after' => function ($page) {
      $page->update([
        'date_created_epoch' => time(),
        'date_modified_epoch' => time(),
      ]);
    },
    'page.update:after' => function ($newPage, $oldPage) {
      $newPage->update([
        'date_modified_epoch' => time(),
      ]);
    },
    'page.changeTitle:after' => function ($newPage, $oldPage) {
      $newPage->update([
        'date_modified_epoch' => time(),
      ]);
    },
  ]
]);
