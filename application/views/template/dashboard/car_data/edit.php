<div class="box box-primary">
	<?php echo form_open(); ?>
	<div class="box-body">
		<?php alert_message();?>

		<div class="form-group <?php echo form_error('car_name') ? 'has-error' : ''; ?>">
			<label for="car_name">Car Name</label>
			<input type="text" name="car_name" id="car_name" class="form-control" placeholder="Car Name"
				value="<?php echo isset($car_data) ? $car_data->car_name : set_value('car_name'); ?>">
			<?php echo form_error('car_name', '<p class="help-block text-red">', '</p>'); ?>
        </div>

		<div class="form-group <?php echo form_error('production_year') ? 'has-error' : ''; ?>">
			<label for="production_year">Production Year</label>
			<input type="text" name="production_year" id="production_year" class="form-control" placeholder="Production Year"
				value="<?php echo isset($car_data) ? $car_data->production_year : set_value('production_year'); ?>">
			<?php echo form_error('production_year', '<p class="help-block text-red">', '</p>'); ?>
		</div>

	</div><!-- /.box-body -->

	<div class="box-footer">
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
	<?php echo form_close(); ?>
</div>
