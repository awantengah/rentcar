<div class="row">
    <?php echo form_open(); ?>
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-body">
                <?php alert_message();?>

                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-lg-12">
                        <div style="display: inline-flex;">
                            <div>
                                <h4 style="margin: 0.5em 0; display: inline-block;">
                                    <strong>Order Number:</strong>
                                </h4>
                            </div>
                            <div style="margin-left: 1em;">
                                <input type="text" name="order_number" class="form-control" value="<?php echo date('dmHis') . random_string('alnum', 7); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 form-inline">
                        <div class="form-group">
                            <p class="form-control-static">Car Rental Amount</p>
                        </div>
                        <div class="form-group">
                            <input type="number" name="car_rental_amount" class="form-control" placeholder="Car Rental Amount">
                        </div>
                        <button type="button" class="btn btn-default" onclick="doCRA()">Submit</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div id="boxCarRent"></div>
                    </div>
                </div>

            </div><!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Total Payment</h3>
            </div>
            <div class="box-body">
                <table id="boxTotalPayment" class="table table-striped" style="margin-bottom: 0;"></table>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script>
    function doCRA() {
        let cra = $("input[name=car_rental_amount]").val();
        if(cra !== 0 || cra !== '') {
            $("#boxCarRent").html("");
            $("#boxTotalPayment").html("");
            $.get(base_url + 'api/car_rental/call_box_rent_car', {
                num_box: cra
            })
            .then(function(response) {
                $("#boxCarRent").html(response);
            });
        }
    }
</script>
