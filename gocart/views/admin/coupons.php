<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_coupon');?>');
}
</script>

<?php if (!$couponenabled): ?>
	<a class="btn btn-primary"  style="float:right;" href="<?php echo site_url($this->config->item('admin_folder').'/coupons/enable'); ?>"><i class="icon-ok icon-white"></i> <?php echo lang('enable_couponcodes');?></a>

<?php else: ?>
<div class="btn-group" style="float:right">
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/coupons/form'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_coupon');?></a>
	<a class="btn btn-danger" href="<?php echo site_url($this->config->item('admin_folder').'/coupons/disable'); ?>"><i class="icon-ban-circle icon-white"></i> <?php echo lang('disable_couponcodes');?></a>
</div>		
<table class="table">
	<thead>
		<tr>
		  <th><?php echo lang('code');?></th>
		  <th><?php echo lang('usage');?></th>
		  <th></th>
		</tr>
	</thead>
	<tbody>
	<?php echo (count($coupons) < 1)?'<tr><td style="text-align:center;" colspan="3">'.lang('no_coupons').'</td></tr>':''?>
<?php foreach ($coupons as $coupon):?>
		<tr>
			<td><?php echo  $coupon->code; ?></td>
			<td>
			  <?php echo  $coupon->num_uses ." / ". $coupon->max_uses; ?>
			</td>
			<td>
				<div class="btn-group" style="float:right;">
					<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/coupons/form/'.$coupon->id); ?>"><i class="icon-pencil"></i> <?php echo lang('edit');?></a>
					<a class="btn btn-danger" href="<?php echo site_url($this->config->item('admin_folder').'/coupons/delete/'.$coupon->id); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
				</div>
			</td>
	  </tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php endif;?>
<?php include('footer.php'); ?>
