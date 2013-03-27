<tr>
  <td><a href="<?=$media->getUrl();?>" rel="facybox"><?=$media->filename;?></a></td>
  <td><?=$media->published==1?'Yes':'No';?></td>
  <td><?=$media->adminActions();?></td>
</tr>