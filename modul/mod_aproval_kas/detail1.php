<?php
$query1=mysql_query("select * from jurnal where no_ref = '$_GET[id]'");
		//$hasil1=mysql_fetch_array($query1);
		?>
		<section class="content-header">
			<h1>Aproval Pengeluaran Kas dan Bank</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
				<li class="active">Aproval Kas dan Bank</li>
			</ol>
		</section>
		<section class="content">
			<div class="box box-default">
				<div class="box-body">
					<p><h3>No Referensi : <?=$_GET['id']?></h3></p>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Keterangan</th>
								<th>Nominal</th>
							</tr>
						</thead>
						<?php
						$no=1;
						while ($hasil=mysql_fetch_array($query1)){
						    if(($hasil['id_perkiraan']!='73')or($hasil['dk']!='D')){
    							$nominal=$hasil['nominal'];
    							$total=$total+$nominal;
						    
						?>
							<tr>
								<td><?=$no?></td>
								<td><?=$hasil['tgl']?></td>
								<td><?=$hasil['ket']?></td>
								<td align="right"><?=number_format($hasil['nominal'])?></td>
							</tr>
						<?php
							$no++;
						        
						    }
						}
						?>
						<tr>
							<td></td>
							<td></td>
							<td align="right"><b>Total</b></td>
							<td align="right"><b><?=number_format($total)?></b></td>
							
						</tr>
					</table>
				</div>
			</div>
		</section>
