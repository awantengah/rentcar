<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<a href="<?php echo site_url('dashboard/car-data/add'); ?>" class="btn btn-primary">Add</a>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive">
                <?php alert_message();?>
				<table id="datatable" class="table table-bordered table-striped" style="width: 100%;">
					<thead>
						<tr>
							<th>Car Name</th>
							<th>Production Year</th>
							<th>Price per Day</th>
							<th>Created At</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->

<script>
    var datatable = $('#datatable').DataTable({
        "columns": [
            null,
            null,
            null,
            null,
            {
                "width": "100"
            }
        ],
        "aaSorting": []
	});

	const IDR = value => currency(value, {
		symbol: "IDR. ",
		precision: 0,
		separator: "."
	});

    getData();

    function getData(){
        $.get(base_url + 'dashboard/car_data/get_data')
            .then(function(response) {
                datatable.clear().draw();
                $.each(response, function(key, value) {
                    datatable.row.add([
                        value.car_name,
                        value.production_year,
                        IDR(value.price_per_day).format(true),
                        value.created_at,
                        '<a href="'+base_url+'dashboard/car-data/edit/'+value.id+'.html" class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o margin-0"></i> Edit</a> ' +
                        '<a href="#" class="btn btn-danger btn-xs" onclick="deleteData('+value.id+')"><i class="fa fa-trash-o margin-0"></i> Remove</a>'
                    ]).draw(false);
                });
            })
    }

    function deleteData(id) {
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-success',
				cancelButton: 'btn btn-danger'
			},
			buttonsStyling: false
		})

		swalWithBootstrapButtons.fire({
			title: 'Are you sure?',
			text: "Your will not be able to recover this record!",
			showCancelButton: true,
			confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
		}).then((result) => {
			if (result.value) {
				$.get(base_url + 'dashboard/car-data/delete', {
						id: id
					})
					.then(function (response) {
						getData();
						swalWithBootstrapButtons.fire(
							'Deleted!',
							'Your record has been deleted.',
							'success'
						)
					})
			} else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire(
					'Cancelled',
					'Your record is safe :)',
					'error'
				)
			}
		})
	}
</script>