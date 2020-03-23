<?php

function alert_message()
{
    $ci = &get_instance();
    if ($ci->session->flashdata('message') != null) {
        $message = $ci->session->flashdata('message');
        ?>
        <div class="alert <?php echo $message['class']; ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message['message']; ?>
        </div>
        <?php
}
}

function alert_validation()
{
    echo validation_errors(
        "<div class='alert alert-danger alert-dismissable'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>",
        "</div>"
    );
}