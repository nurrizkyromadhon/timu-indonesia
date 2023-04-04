
		<section class="content-header">
			<h1>Saldo Kas</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
				<li class="active">Aproval Kas dan Bank</li>
			</ol>
		</section>
		<section class="content">
			<div class="box box-default">
				<div class="box-body">
				<form name="submit" metode="GET" action="<?=$aksi?>" >
									<table class="table table-bordered table-striped">
										<thead bgcolor=#A5B4EC>
										<tr>
											<th>No</th>
											<th>Tanggal</th>
											<th>BKK dan BKM</th>
											<th>Nominal</th>
											<th><a class="checkall" href="#"> Check All</a> - <a class="uncheckall" href="#"> Uncheck All</a></th>
										</tr>
										</thead>
										<tbody>
										<?php
											$no=1;
											$query=mysql_query("SELECT * FROM jurnal where aproval not in ('' , 'NA') group by no_ref ORDER BY tgl desc");
											
											while ($hasil=mysql_fetch_array($query)){
												$no_ref=$hasil['no_ref'];
												$query1=mysql_query("select * from jurnal where no_ref= '$hasil[no_ref]'");
												$jml=0;
												while ($hasil1=mysql_fetch_array($query1)){
												    if(($hasil1['id_perkiraan']!='73')or($hasil1['dk']!='D')){
													    $jml=$jml+$hasil1['nominal'];
												    }
												}
												?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
														<td>
															<a href="?module=aproval_kas&act=view_aproval_kas&id=<?=$hasil['no_ref']?>"><?=$no_ref?></a>
														</td>
														<td><?=number_format($jml)?></td>
														<td align="center">
															<!--<button type="button" class="btn btn-info" onclick="window.open('<?php echo "$aksi?module=jurnal&act=cetakkeu&id=$hasil[no_ref]";?>','_blank');" ><i class="fa fa-print"></i></button>-->
															<input type="checkbox" name="cek_item[]" value="<?=$no_ref?>" id="cek_item[]" [[!+checkresourceschecked]] >
														</td>
													</tr>
													
												<?php
												
												$no++;
											}
										?>
									<input type="hidden" id="input_form" value="<?=$no-1?>"/>
									</tbody>
									</table>
									<p align="right"><input type="submit" name="batal" value="submit"></p>
								</form>
				</div>
			</div>
		</section>
		