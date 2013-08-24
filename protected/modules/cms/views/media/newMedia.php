<tr>
  <td><a href="<?php echo $media->getUrl(); ?>" rel="facybox"><?php echo $media->filename; ?></a></td>
  <td>
      <?php
          if (!Yii::app()->request->isAjaxRequest)
          $this->widget('ext.bootstrap.widgets.TbEditableField', array(
              'type' => 'select',
              'model' => $media,
              'attribute' => 'published',
              'url' => $this->createUrl('/cms/media/ajaxUpdate?for=published'),
              'source' => array(1=>'Yes',0=>'No'),
          ));
          else
              echo 'Yes';
      ?>
  </td>
  <td>
      <?php
          if (!Yii::app()->request->isAjaxRequest)
          $this->widget('ext.bootstrap.widgets.TbEditableField', array(
              'type' => 'select',
              'model' => $media,
              'attribute' => 'media_type',
              'url' => $this->createUrl('/cms/media/ajaxUpdate?for=type'),
              'source' => CmsLookup::items("MediaType"),
          ));
          else
              echo 'Other';
      ?>
  </td>
  <td><?php echo $media->adminActions(); ?></td>
</tr>