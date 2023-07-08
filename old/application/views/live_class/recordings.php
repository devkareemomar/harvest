
<section class="panel appear-animation" data-appear-animation="" data-appear-animation-delay="100">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-video"></i> <?php echo translate('live_class') . " " . translate('recordings');?></h4>
			</header>
			<div class="panel-body mb-md">
				<table class="table table-bordered table-hover mb-none table-condensed table-export">
					<thead>
						<tr>
							<th><?=translate('sl')?></th>
							<th><?=translate('meeting_id')?></th>
							<th><?=translate('name')?></th>
							<th><?=translate('date')?></th>
							<th><?=translate('duration')?></th>
							<th><?=translate('start_time')?></th>
							<th><?=translate('end_time')?></th>
							<th><?=translate('recording')?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$count = 1;
							foreach ($recordings as $row):
								?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $row->meetingID; ?></td>
							<td><?php echo $row->name; ?></td>
							<td><?php
							
								$startTime = ceil($row->startTime / 1000) ;
								$endTime   = ceil($row->endTime / 1000) ;

								$to_time = strtotime(date('h:i:s',$startTime));
								$from_time = strtotime(date('h:i:s',$endTime));

								$duration  = (date('h:i:s',$endTime) -  date('h:i:s',$startTime));
								$duration  =round(abs($to_time - $from_time) / 60). " minutes";;

								echo date('d-m-Y',$startTime); ?>
							</td>
							<td><?php echo $duration ; ?></td>
							<td><?php echo date('h:i:s',$startTime); ?></td>
							<td><?php echo date('h:i:s',$endTime); ?></td>
							
							
							<td class="min-w-c">
								<!-- video link -->

								<a href="javascript:void(0);" class="btn btn-circle btn-default icon" data-toggle="tooltip" data-original-title="<?=translate('show')?>" 
									onclick="getHostModal('<?= $row->playback->format->url ?>');">
									<i class="fas fa-video"></i>
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
</section>
       
<div class="zoom-anim-dialog modal-block modal-block-lg mfp-hide" style="max-width: 100%;max-height: 100%;margin: 0;" id="modal">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title"><i class="fas fa-bars"></i> <?php echo translate('live_class') . " " . translate('recording'); ?></h4>
		</header>
		<div class="panel-body">
			<div id='quick_view'></div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-default modal-dismiss"><?php echo translate('close'); ?></button>
				</div>
			</div>
		</footer>
	</section>
</div>


<script type="text/javascript">

	// get details
	function getHostModal(url) {
	    $.ajax({
	        url: base_url + 'live_class/recordingModal',
	        type: 'POST',
	        data: {'url': url},
	        dataType: "html",
	        success: function (data) {
	            $('#quick_view').html(data);
	            mfp_modal('#modal');
	        }
	    });
	}

</script>