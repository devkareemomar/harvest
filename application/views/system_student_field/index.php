<?php if (is_superadmin_loggedin() ): ?>
<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><?=translate('select_ground')?></h4>
	</header>
	<?php echo form_open($this->uri->uri_string(), array('class' => 'validate'));?>
	<div class="panel-body">
		<div class="row mb-sm">
			<div class="col-md-offset-3 col-md-6">
				<div class="form-group">
					<label class="control-label"><?=translate('branch')?> <span class="required">*</span></label>
					<?php
						$arrayBranch = $this->app_lib->getSelectList('branch');
						echo form_dropdown("branch_id", $arrayBranch, set_value('branch_id'), "class='form-control'
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
					?>
				</div>
			</div>
		</div>
	</div>
	<footer class="panel-footer">
		<div class="row">
			<div class="col-md-offset-10 col-md-2">
				<button type="submit" name="search" value="1" class="btn btn-default btn-block"> <i class="fas fa-filter"></i> <?=translate('filter')?></button>
			</div>
		</div>
	</footer>
	<?php echo form_close();?>
</section>
<?php 
endif;
	if (!empty($branch_id)): 
 		if (is_superadmin_loggedin()) { ?>
<div class="row appear-animation" data-appear-animation="<?=$global_config['animations'] ?>" data-appear-animation-delay="100">
<?php } else { ?>
<div class="row">
<?php } ?>	
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-sliders-h"></i> <?=translate('system_student_field') . " " . translate('list') ?></h4>
			</header>
			<?php echo form_open('system_student_field/save', array('class' => 'frm-submit-msg')); ?>
			<input type="hidden" name="branch_id" value="<?php echo $branch_id ?>">
			<div class="panel-body">
				<div class="mb-md mt-md">
					<table class="table table-bordered table-hover table-condensed mt-sm" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th><?php echo translate('fields') . " " . translate('name') ?></th>
								<th> 
									<div class="checkbox-replace"> 
										<label class="i-checks"><input type="checkbox" id="all_view" value="1"><i></i> <?php echo translate('active'); ?></label> 
									</div>
								</th>
								<th>
									<div class="checkbox-replace"> 
										<label class="i-checks"><input type="checkbox" id="all_add" value="1"><i></i> <?php echo translate('required'); ?></label> 
									</div>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$result = $this->student_fields_model->getStatusArr($branch_id);
							unset($result[6]);
							foreach ($result as $key => $value) {
								?>
							<input type="hidden" name="system_fields[<?php echo $value->id ?>][fields_id]" value="<?php echo $value->id ?>">
							<tr>
								<td class="pl-xl"><i class="far fa-arrow-alt-circle-right text-md"></i> <?php echo ucwords(str_replace('_', ' ', $value->prefix)) ?></td>
								<td>
									<div class="checkbox-replace"> 
										<label class="i-checks"><input type="checkbox" class="cb_view" name="system_fields[<?php echo $value->id ?>][status]" <?php echo $value->status == 1 ? 'checked' : '' ?> value="1" >
											<i></i>
										</label>
									</div>
								</td>
								<td>
									<div class="checkbox-replace"> 
										<label class="i-checks"><input type="checkbox" class="cb_add" <?php echo $value->status == 0 ? 'disabled checked' : '' ?> name="system_fields[<?php echo $value->id ?>][required]" <?php echo $value->required == 1 ? 'checked' : '' ?> value="1" >
											<i></i>
										</label>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php if (get_permission('system_student_field', 'is_edit')) { ?>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-offset-10 col-md-2">
						<button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
							<i class="fas fa-plus-circle"></i> <?php echo translate('save'); ?>
						</button>
					</div>
				</div>
			</footer>
			<?php } ?>
			<?php echo form_close(); ?>
		</section>
	</div>
</div>
<?php endif; ?>

<script type="text/javascript">
    $('#all_view').on('click', function(){
        var cbRequired = $('.cb_add');
        if (this.checked) {
            cbRequired.prop('disabled', false);
        } else {
            cbRequired.prop('disabled', true);
        }
    });

    $('.cb_view').on('click', function(){
        var cbRequired = $(this).parents('tr').find("[class='cb_add']");
        if (this.checked) {
            cbRequired.prop('disabled', false);
        } else {
            cbRequired.prop('disabled', true);
        }
    });
</script>