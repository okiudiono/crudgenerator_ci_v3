<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Tbl_hak_akses List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Id User Level</th>
		<th>Id Menu</th>
		
            </tr><?php
            foreach ($tbl_hak_akses_data as $tbl_hak_akses)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $tbl_hak_akses->id_user_level ?></td>
		      <td><?php echo $tbl_hak_akses->id_menu ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>