<?php $user = (object) $this->session->userdata('user'); ?>
<?php
// print('<pre>' . print_r($user, true) . '</pre>');
// exit;
?>

<nav class="navbar">
	<a href="#" class="sidebar-toggler">
		<i data-feather="menu"></i>
	</a>
	<div class="navbar-content">
		<ul class="navbar-nav">
			<li class="nav-item dropdown nav-apps">
				<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i data-feather="grid"></i>
				</a>
				<div class="dropdown-menu" aria-labelledby="appsDropdown">
					<div class="dropdown-header d-flex align-items-center justify-content-between">
						<p class="mb-0 font-weight-medium">Web Apps</p>
					</div>
					<div class="dropdown-body">
						<div class="d-flex align-items-center apps">
							<a href="https://dashboard.telkom.co.id/pranpc/" target="_blank">
								<img src="<?= base_url() ?>assets/images/icons/telkom.png" alt="Telkom Logo" width="30px">
								<p>PraNPC</p>
							</a>
							<a href="https://starclick.telkom.co.id/scnr" target="_blank">
								<img src="<?= base_url() ?>assets/images/icons/telkom.png" alt="Telkom Logo" width="30px">
								<p>Starclick</p>
							</a>
							<a href="https://dashboard.telkom.co.id/cbd/public/login" target="_blank">
								<img src="<?= base_url() ?>assets/images/icons/telkom.png" alt="Telkom Logo" width="30px">
								<p>CBD</p>
							</a>
						</div>
						<div class="d-flex align-items-center apps">
							<a href="http://10.60.165.7/cstool" target="_blank">
								<img src="<?= base_url() ?>assets/images/icons/telkom.png" alt="Telkom Logo" width="30px">
								<p>CSTool</p>
							</a>
							<a href="https://siis.udata.id/auth/" target="_blank">
								<img src="<?= base_url() ?>assets/images/icons/telkom.png" alt="Telkom Logo" width="30px">
								<p>SIIS</p>
							</a>
							<a href="https://des.telkom.co.id/dashboard/" target="_blank">
								<img src="<?= base_url() ?>assets/images/icons/telkom.png" alt="Telkom Logo" width="30px">
								<p>Rev DES</p>
							</a>
						</div>
						<div class="d-flex align-items-center apps">
							<a href="https://dashboard.telkom.co.id/idwifi/" target="_blank">
								<img src="<?= base_url() ?>assets/images/icons/telkom.png" alt="Telkom Logo" width="30px">
								<p>Wifi</p>
							</a>
							<a href="https://telkomcare.telkom.co.id/" target="_blank" class="text-center">
								<img src="<?= base_url() ?>assets/images/icons/telkom.png" alt="Telkom Logo" width="30px">
								<p>Telkom Care</p>
							</a>
							<a href="https://siborder.telkom.co.id/sys/login.php" target="_blank">
								<img src="<?= base_url() ?>assets/images/icons/telkom.png" alt="Telkom Logo" width="30px">
								<p>SiBorder</p>
							</a>
						</div>
						<div class="d-flex align-items-center apps">
							<a href="https://dashboard.telkom.co.id/fulfillment" target="_blank">
								<img src="<?= base_url() ?>assets/images/icons/telkom.png" alt="Telkom Logo" width="30px">
								<p>Fulfillment</p>
							</a>
						</div>
					</div>
				</div>
			</li>
			<!-- <li class="nav-item dropdown nav-profile">
				<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="https://diarium.telkom.co.id/getfoto/<?= $user->nik ?>" alt="profile">
				</a>
				<div class="dropdown-menu" aria-labelledby="profileDropdown">
					<div class="dropdown-header d-flex flex-column align-items-center">
						<div class="figure mb-3">
							<img src="https://diarium.telkom.co.id/getfoto/<?= $user->nik ?>" alt="">
						</div>
						<div class="info text-center">
							<p class="name font-weight-bold mb-0"><?= $user->full_name ?></p>
						</div>
					</div>
					<div class="dropdown-body">
						<ul class="profile-nav p-0 pt-3">
							<li class="nav-item">
								<form action="<?= base_url(); ?>index.php/authenticate/logged_out" id="loggedOut" method="post"></form>
								<a href="javascript:;" onclick="doLogout()" class="nav-link">
									<i data-feather="log-out"></i>
									<span>Log Out</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</li> -->
		</ul>
	</div>
</nav>