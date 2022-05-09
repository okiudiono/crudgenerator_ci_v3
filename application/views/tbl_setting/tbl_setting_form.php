<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Tbl_setting <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama Setting <?php echo form_error('nama_setting') ?></label>
            <input type="text" class="form-control" name="nama_setting" id="nama_setting" placeholder="Nama Setting" value="<?php echo $nama_setting; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Value <?php echo form_error('value') ?></label>
            <input type="text" class="form-control" name="value" id="value" placeholder="Value" value="<?php echo $value; ?>" />
        </div>
	    <input type="hidden" name="id_setting" value="<?php echo $id_setting; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tbl_setting') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>