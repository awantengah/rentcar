<?php if ($num_box): ?>
    <?php for ($i = 0; $i < $num_box; $i++): ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Car</label>
                            <select name="car_data[<?php echo $i; ?>]" class="form-control" onchange="chooseCar(this.value, <?php echo $i; ?>)">
                                <option value="">Choose Car</option>
                                <?php if ($car_data): ?>
                                <?php foreach ($car_data as $row): ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->car_name; ?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Rent Start</label>
                            <input type="text" name="rent_begin[<?php echo $i; ?>]" class="form-control datepicker" onchange="countRentDay(<?php echo $i; ?>)">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Rent End</label>
                            <input type="text" name="rent_end[<?php echo $i; ?>]" class="form-control datepicker" onchange="countRentDay(<?php echo $i; ?>)">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div id="detailCar<?php echo $i; ?>"></div>
                    </div>
                    <div class="col-md-6">
                        <table id="detailRent<?php echo $i; ?>" class="table table-striped" style="margin-bottom: 0;"></table>
                    </div>
                </div>
            </div>
        </div>
    <?php endfor;?>
<?php endif;?>

<script>
        $(".datepicker").datepicker();

        const IDR = value => currency(value, {
            symbol: "",
            precision: 0,
            separator: "."
        });

    function chooseCar(selectedCar, i) {
		if (selectedCar != '') {
			$.get(base_url + 'api/car_rental/selected_car', {
					id_selected_car: selectedCar
				})
				.then(function (response) {
                    if(response) {
                        $("#detailCar"+i).html(
                            '<table class="table table-striped" style="margin-bottom: 0;">' +
                            '<tr>' +
                            '<td width="150">Car Name</td>' +
                            '<td width="10">:</td>' +
                            '<td>'+response.car_name+'</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>Production Year</td>' +
                            '<td>:</td>' +
                            '<td><span id="py'+i+'">'+response.production_year+'</span></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>Price per Day</td>' +
                            '<td>:</td>' +
                            '<td><span id="ppd'+i+'">'+response.price_per_day+'</span></td>' +
                            '</tr>' +
                            '</table>'
                        );

                        totalPayment();
                    }
				});
		}
	}

    function countRentDay(i){
        let rent_begin = $("input[name=rent_begin\\["+i+"\\]]").datepicker("getDate");
        let rent_end = $("input[name=rent_end\\["+i+"\\]]").datepicker("getDate");

        if(rent_begin && rent_end) {
            days = (rent_end - rent_begin) / (1000 * 60 * 60 * 24);
            $("#detailRent"+i).html(
               '<tr>' +
                '<td width="200">Rent Start</td>' +
                '<td width="10">:</td>' +
                '<td>'+($.datepicker.formatDate("mm/dd/yy", rent_begin))+'</td>' +
                '</tr>' +
                '<tr>' +
                '<td width="200">Rent End</td>' +
                '<td width="10">:</td>' +
                '<td>'+($.datepicker.formatDate("mm/dd/yy", rent_end))+'</td>' +
                '</tr>' +
                '<tr>' +
                '<td width="200">Rent Days</td>' +
                '<td width="10">:</td>' +
                '<td><span id="rd'+i+'">'+Math.round(days)+'</span></td>' +
                '</tr>'
           );

           totalPayment();

        }
    }

    function totalPayment() {
           let cra = $("input[name=car_rental_amount]").val();
           $("#boxTotalPayment").html("");

           for(let x = 0; x < cra; x++) {
                let ppd = $("#ppd"+x).text();
                let ppd_rent_begin = $("input[name=rent_begin\\["+x+"\\]]").datepicker("getDate");
                let ppd_rent_end = $("input[name=rent_end\\["+x+"\\]]").datepicker("getDate");
                let ppd_days = (ppd_rent_end - ppd_rent_begin) / (1000 * 60 * 60 * 24);
                let ppd_total = ppd * ppd_days;

                $("#boxTotalPayment").append(
                    '<tr>' +
                    '<td>'+(IDR(ppd).format(true))+' x '+Math.round(ppd_days)+'</td>' +
                    '<td width="10">:</td>' +
                    '<td class="text-right">'+(IDR(ppd_total).format(true))+'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="text-right"><em>Discount <span id="discountText'+x+'"></span></em></td>' +
                    '<td width="10">:</td>' +
                    '<td class="text-right" style="color: red;">(<span id="discount'+x+'"></span>)</td>' +
                    '</tr>'
                );
           }

           discount();
    }

    function discount() {
        let cra = $("input[name=car_rental_amount]").val();

        let total_payment = 0;

        for(let x = 0; x < cra; x++) {

            let rd = $("#rd"+x).text();
            let py = $("#py"+x).text();

            let ppd = $("#ppd"+x).text();
            let ppd_rent_begin = $("input[name=rent_begin\\["+x+"\\]]").datepicker("getDate");
            let ppd_rent_end = $("input[name=rent_end\\["+x+"\\]]").datepicker("getDate");
            let ppd_days = (ppd_rent_end - ppd_rent_begin) / (1000 * 60 * 60 * 24);
            let ppd_total = ppd * ppd_days;

            let discount1 = 0;
            let discount2 = 0;
            let discount3 = 0;

            let discount1_text = '';
            let discount2_text = '';
            let discount3_text = '';

            let ppd_discount1 = 0;
            let ppd_discount2 = 0;
            let ppd_discount3 = 0;

            if(Math.round(rd) >= 3) { //lebih dari sama dengan 3 hari
                discount1 = 0.05; //5%
                discount1_text = " 5% ";

                ppd_discount1 = ppd_total * discount1;
            } else {
                ppd_discount1 = 0;
            }

            if(cra >= 2) { //lebih dari sama dengan 2 mobil
                discount2 = 0.1; //10%
                discount2_text = " 10% ";

                ppd_discount2 = discount1 == 0 ? (ppd_total * discount2) : (ppd_discount1 * discount2);
            } else {
                ppd_discount2 = 0;
            }

            if(py < 2010 && py != 0) {
                discount3 = 0.07; //7%
                discount3_text = " 7% ";

                ppd_discount3 = discount2 == 0 ? (ppd_total * discount3) : (ppd_discount2 * discount3);
            } else {
                ppd_discount3 = 0;
            }

            $("#discountText"+x).html(
                (discount1_text != '' ? discount1_text.concat('+') : '') + (discount3_text != '' ? discount2_text.concat('+') : discount2_text) + discount3_text
            );

            $("#discount"+x).html(
                IDR(parseInt(ppd_discount1) + parseInt(ppd_discount2) + parseInt(ppd_discount3)).format(true)
            );

            total_payment += ppd_total - (parseInt(ppd_discount1) + parseInt(ppd_discount2) + parseInt(ppd_discount3));
        }

        $("#boxTotalPayment").append(
               '<tr>' +
                '<td>Total</td>' +
                '<td width="10">:</td>' +
                '<td class="text-right">'+(IDR(total_payment).format(true))+'</td>' +
                '</tr>' +
               '<tr>' +
                '<td colspan="3"><button type="submit" class="btn btn-primary">Submit Rent</button></td>' +
                '</tr>'
           );

    }
</script>