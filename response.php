<?php
include "config/koneksi.php";
?>
<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Rekap Process Job</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<button class="info-box-icon bg-aqua" onclick="location.href='<?php echo '?module=home&act=list_proforma'; ?>';"><i class="fa fa-gear"></i></button>

				<div class="info-box-content">
				<span class="info-box-text">NEW PROFORMA</span>
				<span class="info-box-number">
					<?php
						$query=mysql_query("select count(aprove) as jml_new_pf from pf where aprove ='0'");
						$hasil=mysql_fetch_array($query);
						echo $hasil['jml_new_pf'];
					?>
				</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<button class="info-box-icon bg-green" onclick="location.href='<?php echo '?module=home&act=list_aprove'; ?>';"><i class="fa fa-check"></i></button>

				<div class="info-box-content">
				<span class="info-box-text">APROVED JO</span>
				<span class="info-box-number">
					<?php
						$query1=mysql_query("select count(aprove) as jml_aprove from pf where aprove !='0' and aprove!='batal'");
						$hasil1=mysql_fetch_array($query1);
						echo $hasil1['jml_aprove'];
					?>
				</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<button class="info-box-icon bg-red" onclick="location.href='<?php echo '?module=home&act=list_cancel'; ?>';"><i class="fa fa-close"></i></button>
				<div class="info-box-content">
				<span class="info-box-text">CANCELED JO</span>
				<span class="info-box-number">
					<?php
						$query2=mysql_query("select count(aprove) as jml_batal from pf where aprove='batal'");
						$hasil2=mysql_fetch_array($query2);
						echo $hasil2['jml_batal'];
					?>
				</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
			</div>

			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<button class="info-box-icon bg-yellow"  onclick="location.href='<?php echo '?module=home&act=list_total'; ?>';"><i class="fa fa-files-o"></i></button>
				<div class="info-box-content">
				<span class="info-box-text">TOTAL PROFORMA</span>
				<span class="info-box-number">
					<?php
						$query2=mysql_query("select count(id_pf) as jml_id_pf from pf");
						$hasil2=mysql_fetch_array($query2);
						echo $hasil2['jml_id_pf'];
					?>
				</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
			</div>


			
			<!--<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<?php 
					$query=mysql_query("select * from users where status_user='1' ");
				?>
				<span class="info-box-icon bg-red" data-toggle="tooltip" title="<?php while($hasil=mysql_fetch_array($query)){ echo $hasil['username']; echo '-'; }?>"><i class="fa fa-user"></i></span>
				<div class="info-box-content">
				<span class="info-box-text">USER ONLINE</span>
				<span class="info-box-number">
					<?php
						$query3=mysql_query("SELECT SUM(status_user) AS jml_online FROM users");
						$hasil3=mysql_fetch_array($query3);

							echo $hasil3['jml_online'];
						
					?>
				</span>
				</div>
			</div>
			</div> -->
		</div>
		<!--<div class="row">
			<div class="col-lg-3 col-xs-6">
			
			<div class="small-box bg-aqua">
				<div class="inner">
				<h3>150</h3>

				<p>New Orders</p>
				</div>
				<div class="icon">
				<i class="fa fa-shopping-cart"></i>
				</div>
				<a href="#" class="small-box-footer">
				More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
			</div>
			<div class="col-lg-3 col-xs-6">
			
			<div class="small-box bg-green">
				<div class="inner">
				<h3>53<sup style="font-size: 20px">%</sup></h3>

				<p>Bounce Rate</p>
				</div>
				<div class="icon">
				<i class="ion ion-stats-bars"></i>
				</div>
				<a href="#" class="small-box-footer">
				More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
			</div>
			<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
				<h3>44</h3>

				<p>User Registrations</p>
				</div>
				<div class="icon">
				<i class="ion ion-person-add"></i>
				</div>
				<a href="#" class="small-box-footer">
				More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
			</div>
			<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
				<h3>65</h3>

				<p>Unique Visitors</p>
				</div>
				<div class="icon">
				<i class="ion ion-pie-graph"></i>
				</div>
				<a href="#" class="small-box-footer">
				More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
			</div>
		</div>-->
	</div>
</div>	