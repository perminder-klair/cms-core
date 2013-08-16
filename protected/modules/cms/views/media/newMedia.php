<tr>
  <td><a href="<?php echo $media->getUrl(); ?>" rel="facybox"><?php echo $media->filename; ?></a></td>
  <td>
      <?php
          $this->widget('ext.bootstrap.widgets.TbEditableField', array(
              'type' => 'select',
              'model' => $media,
              'attribute' => 'published',
              'url' => $this->createUrl('/cms/media/ajaxUpdate?for=published'),
              'source' => array(1=>'Yes',0=>'No'),
          ));
      ?>
  </td>
  <td>
      <?php
          $this->widget('ext.bootstrap.widgets.TbEditableField', array(
              'type' => 'select',
              'model' => $media,
              'attribute' => 'media_type',
              'url' => $this->createUrl('/cms/media/ajaxUpdate?for=type'),
              'source' => CmsLookup::items("MediaType"),
          ));
      ?>
  </td>
  <td><?php echo $media->adminActions(); ?></td>
</tr>