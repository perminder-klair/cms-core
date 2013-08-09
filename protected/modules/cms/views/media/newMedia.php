<tr>
  <td><a href="<?php echo $media->getUrl(); ?>" rel="facybox"><?php echo $media->filename; ?></a></td>
  <td><?php echo  $media->published==1?'Yes':'No'; ?></td>
  <td><?php echo CmsLookup::item("MediaType", $media->media_type); ?></td>
  <td><?php echo $media->adminActions(); ?></td>
</tr>