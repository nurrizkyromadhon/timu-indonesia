
		<section class="content-header">
			<h1>Saldo Bank</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
				<li class="active">Saldo Bank</li>
			</ol>
		</section>
		<section class="content">
			<div class="box box-default">
				<div class="box-body">
									  <div id="myTable3" class="table-responsive">
									  <table  class="table table-bordered table-striped">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>ID Perkiraan</th>
										  <th>NAMA PERKIRAAN</th>
										  <th>JUMLAH</th>
									  </tr> 
									  </thead>
									  <tbody>
									  
									  	  
									  <?php
										$no=1;
										$query="select * from jurnal as j
										join perkiraan as p on j.id_perkiraan=p.id_perkiraan  where kode_perkiraan like '1.1.02%' group by j.id_perkiraan order by kode_perkiraan asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){	
											$a=$hasil['id_perkiraan'];
												
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['id_perkiraan']?></td>
											<td><?=$hasil['kode_perkiraan']?>-<?=$hasil['nm_perkiraan']?></td>
											<td align="right">
												<?php
										  			$jmld=0;
													$jmlk=0;
													$sisa=0;
										  			$query1=mysql_query("select * from jurnal where id_perkiraan='$a'");
													while($hasil1=mysql_fetch_array($query1)){
														if ($hasil1['dk']=='D'){
															$jmld=$jmld+$hasil1['nominal'];
														}
														if ($hasil1['dk']=='K'){
															$jmlk=$jmlk+$hasil1['nominal'];
														}
														$sisa=$jmld-$jmlk;
													}
                                                    $total=$total+$sisa;
											  	?>	
											  	<?=number_format("$sisa")?>
											</td>
											<td>
												<button type="button" class="btn " onclick="window.open('<?php echo "oklogin.php?module=bukubesarall&kode_perkiraan=$hasil[kode_perkiraan]";?>','_blank');" ><i class="fa fa-eye"></i></button>
											</td>
										  </tr>
									  <?php
										$no++; } 
                                      ?>
                                      <tr>
											  <td></td>
											  <td></td>
											  <td align="right"><b>Total</b></td>
											  <td align="right"><b><?=number_format($total)?></b></td>
											  <td></td>
										  </tr>
									  </tbody>
									</table>
									</div>
				</div>
			</div>
		</section>
		