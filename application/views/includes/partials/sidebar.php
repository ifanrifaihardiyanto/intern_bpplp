<?php
$paths = $_SERVER['PATH_INFO'];
?>

<nav class="sidebar">
  <div class="sidebar-header">
    <a href="<?= base_url() . "index.php/dashboard" ?>" class="sidebar-brand">
      <img src="<?= base_url() . "assets/images/bright-meta.png" ?>" alt="bright-meta-logo" width="50px">
      MetaBright
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category <?= strpos($paths, 'frontend/dashboard') ? 'active' : '' ?>">
        <a href="#dashboard" class="nav-link mb-3 pb-3" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
          <span class="link-title ml-0">Dashboard</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
      </li>
      <div class="<?= strpos($paths, 'frontend/dashboard') ? 'show active' : 'collapse' ?>" id="dashboard">
        <li class="nav-item <?= strpos($paths, 'index') ? 'active' : '' ?>" onclick="setActive('Infographic', 'dashboard')">
          <?php if (strpos($paths, 'frontend')) : ?>
            <router-link class="nav-link" :to="{ name: 'dashboard' }">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Infographic</span>
            </router-link>
          <?php else : ?>
            <a href="<?= base_url(); ?>index.php/frontend/dashboard/index" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Infographic</span>
            </a>
          <?php endif; ?>
        </li>
        <li class="nav-item <?= strpos($paths, 'trend/financial') ? 'active' : '' ?>" onclick="setActive('Trend Financial', 'dashboard')">
          <?php if (strpos($paths, 'frontend')) : ?>
            <router-link class="nav-link" :to="{ name: 'trend-financial' }">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Trend Financial</span>
            </router-link>
          <?php else : ?>
            <a href="<?= base_url(); ?>index.php/frontend/dashboard/trend/financial" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Trend Financial</span>
            </a>
          <?php endif; ?>
        </li>
        <li class="nav-item <?= strpos($paths, 'trend/operational') ? 'active' : '' ?>" onclick="setActive('Trend Operational', 'dashboard')">
          <?php if (strpos($paths, 'frontend')) : ?>
            <router-link class="nav-link" :to="{ name: 'trend-operational' }">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Trend Operational</span>
            </router-link>
          <?php else : ?>
            <a href="<?= base_url(); ?>index.php/frontend/dashboard/trend/operational" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Trend Operational</span>
            </a>
          <?php endif; ?>
        </li>
        <li class="nav-item <?= strpos($paths, 'analytic') ? 'active' : '' ?>" onclick="setActive('Analytic', 'dashboard')">
          <?php if (strpos($paths, 'frontend')) : ?>
            <router-link class="nav-link" :to="{ name: 'analytic' }">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Analytic</span>
            </router-link>
          <?php else : ?>
            <a href="<?= base_url(); ?>index.php/frontend/dashboard/analytic" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Analytic</span>
            </a>
          <?php endif; ?>
        </li>
      </div>

      <!-- Start Legal -->
      <li class="nav-item nav-category">
        <a class="nav-link mb-3 pb-3" data-toggle="collapse" href="#legal" role="button" aria-expanded="<?= $sidebar['parent_active'] == 'Legal' ? 'true' : 'false' ?>" aria-controls="legal">
          <span class="link-title ml-0">Legal</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
      </li>
      <!-- Start Document Tracking -->
      <div class="<?= $sidebar['parent_active'] == 'Legal' ? 'show active' : 'collapse' ?>" id="legal">
        <li class="nav-item <?= $sidebar['category_active'] == 'Document Tracking' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/legal/document_tracking/">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">Document Tracking</span>
          </a>
        </li>
      </div>
      <!-- End Document Tracking -->
      <!-- End Legal -->

      <!-- Start Revenue Assurance -->
      <li class="nav-item nav-category">
        <a class="nav-link mb-3 pb-3" data-toggle="collapse" href="#revenue_assurance" role="button" aria-expanded="<?= $sidebar['parent_active'] == 'Revenue Assurance' ? 'true' : 'false' ?>" aria-controls="revenue_assurance">
          <span class="link-title ml-0">Revenue Assurance</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
      </li>
      <!-- Start PSAK -->
      <div class="<?= $sidebar['parent_active'] == 'Revenue Assurance' ? 'show active' : 'collapse' ?>" id="revenue_assurance">
        <li class="nav-item <?= $sidebar['category_active'] == 'PSAK' ? 'active' : '' ?>">
          <a class="nav-link" data-toggle="collapse" href="#psak" role="button" aria-expanded="<?= $sidebar['category_active'] == 'PSAK' ? 'true' : 'false' ?>" aria-controls="psak">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">PSAK</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="<?= $sidebar['category_active'] == 'PSAK' ? 'show active' : 'collapse' ?>" id="psak">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/revenue_assurance/psak/psak_72_mct" class="nav-link <?= $sidebar['item_active'] == 'PSAK 72 MCT' ? 'active' : '' ?>">PSAK 72 MCT</a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/revenue_assurance/psak/psak_72_non_mct" class="nav-link <?= $sidebar['item_active'] == 'PSAK 72 NON MCT' ? 'active' : '' ?>">PSAK 72 NON MCT</a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/revenue_assurance/psak/psak_73" class="nav-link <?= $sidebar['item_active'] == 'PSAK 73' ? 'active' : '' ?>">PSAK 73</a>
              </li>
            </ul>
          </div>
        </li>
      </div>
      <!-- End PSAK -->
      <!-- End Revenue Assurance -->

      <!-- Start Logistic -->
      <li class="nav-item nav-category">
        <a class="nav-link mb-3 pb-3" data-toggle="collapse" href="#logistic" role="button" aria-expanded="<?= $sidebar['parent_active'] == 'Logistic' ? 'true' : 'false' ?>" aria-controls="logistic">
          <span class="link-title ml-0">Logistic</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
      </li>
      <!-- Start KHS -->
      <div class="<?= $sidebar['parent_active'] == 'Logistic' ? 'show active' : 'collapse' ?>" id="logistic">
        <li class="nav-item <?= $sidebar['category_active'] == 'KHS' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/logistic/khs/">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">KHS</span>
          </a>
        </li>
        <li class="nav-item <?= $sidebar['category_active'] == 'Report PR' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/logistic/report_pr/">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">Report PR</span>
          </a>
        </li>
      </div>
      <!-- End KHS -->
      <!-- End Logistic -->

      <!-- Start Program 9 Bintang -->
      <li class="nav-item nav-category">
        <a class="nav-link mb-3 pb-3" data-toggle="collapse" href="#program_9_bintang" role="button" aria-expanded="<?= $sidebar['parent_active'] == 'Program 9 Bintang' ? 'true' : 'false' ?>" aria-controls="program_9_bintang">
          <span class="link-title ml-0">Program 9 Bintang</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
      </li>

      <div class="<?= $sidebar['parent_active'] == 'Program 9 Bintang' ? 'show active' : 'collapse' ?>" id="program_9_bintang">
        <li class="nav-item <?= $sidebar['category_active'] == 'SUMMARY' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/program_bintang/program_bintang/summary">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">SUMMARY</span>
          </a>
        </li>
      </div>
      <div class="<?= $sidebar['parent_active'] == 'Program 9 Bintang' ? 'show active' : 'collapse' ?>" id="program_9_bintang">
        <li class="nav-item <?= $sidebar['category_active'] == 'VISITING & PROFILING' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/program_bintang/program_bintang/visiting_profiling">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">VISITING & PROFILING</span>
          </a>
        </li>
      </div>
      <div class="<?= $sidebar['parent_active'] == 'Program 9 Bintang' ? 'show active' : 'collapse' ?>" id="program_9_bintang">
        <li class="nav-item <?= $sidebar['category_active'] == 'EKOSISTEM BISNIS' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/program_bintang/program_bintang/ekosistem_bisnis">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">EKOSISTEM BISNIS</span>
          </a>
        </li>
      </div>
      <div class="<?= $sidebar['parent_active'] == 'Program 9 Bintang' ? 'show active' : 'collapse' ?>" id="program_9_bintang">
        <li class="nav-item <?= $sidebar['category_active'] == 'INDIBIZ SALES' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/program_bintang/program_bintang/indibiz_sales">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">INDIBIZ SALES</span>
          </a>
        </li>
      </div>
      <div class="<?= $sidebar['parent_active'] == 'Program 9 Bintang' ? 'show active' : 'collapse' ?>" id="program_9_bintang">
        <li class="nav-item <?= $sidebar['category_active'] == 'PS/RE' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/program_bintang/program_bintang/psre">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">PS/RE</span>
          </a>
        </li>
      </div>
      <div class="<?= $sidebar['parent_active'] == 'Program 9 Bintang' ? 'show active' : 'collapse' ?>" id="program_9_bintang">
        <li class="nav-item <?= $sidebar['category_active'] == 'COLLECTION NON POTS' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/program_bintang/program_bintang/collection_non_pots">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">COLLECTION NON POTS</span>
          </a>
        </li>
      </div>
      <div class="<?= $sidebar['parent_active'] == 'Program 9 Bintang' ? 'show active' : 'collapse' ?>" id="program_9_bintang">
        <li class="nav-item <?= $sidebar['category_active'] == 'COMBAT THE CHURN' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/program_bintang/program_bintang/combat_the_churn">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">COMBAT THE CHURN</span>
          </a>
        </li>
      </div>
      <div class="<?= $sidebar['parent_active'] == 'Program 9 Bintang' ? 'show active' : 'collapse' ?>" id="program_9_bintang">
        <li class="nav-item <?= $sidebar['category_active'] == 'C3MR BILLING PERDANA' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/program_bintang/program_bintang/c3mr_billing_perdana">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">C3MR BILLING PERDANA</span>
          </a>
        </li>
      </div>
      <div class="<?= $sidebar['parent_active'] == 'Program 9 Bintang' ? 'show active' : 'collapse' ?>" id="program_9_bintang">
        <li class="nav-item <?= $sidebar['category_active'] == 'C3MR ALL BILLING' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url(); ?>index.php/program_bintang/program_bintang/c3mr_all_billing">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">C3MR ALL BILLING</span>
          </a>
        </li>
      </div>
      <!-- End Program 9 Bintang -->


      <li class="nav-item nav-category">
        <a class="nav-link mb-3 pb-3" data-toggle="collapse" href="#uploader" role="button" aria-expanded="<?= $sidebar['parent_active'] == 'Uploader' ? 'true' : 'false' ?>" aria-controls="uploader">
          <span class="link-title ml-0">UPLOADER</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
      </li>
      <div class="<?= $sidebar['parent_active'] == 'Uploader' ? 'show active' : 'collapse' ?>" id="uploader">
        <li class="nav-item <?= $sidebar['category_active'] == 'Revenue Assurance Uploader' ? 'active' : '' ?>">
          <a class="nav-link" data-toggle="collapse" href="#revenue_assurance_uploader" role="button" aria-expanded="<?= $sidebar['category_active'] == 'Revenue Assurance Uploader' ? 'true' : 'false' ?>" aria-controls="revenue_assurance_uploader">
            <i class="link-icon" data-feather="circle"></i>
            <span class="link-title">Revenue Assurance</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="<?= $sidebar['category_active'] == 'Revenue Assurance Uploader' ? 'show active' : 'collapse' ?>" id="revenue_assurance_uploader">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/revenue_assurance/uploader/index" class="nav-link <?= $sidebar['item_active'] == 'Uploader' ? 'active' : '' ?>">Upload Data</a>
              </li>
            </ul>
          </div>
        </li>
      </div>
    </ul>
  </div>
</nav>

<nav class="settings-sidebar">
  <div class="sidebar-body">
    <a href="#" class="settings-sidebar-toggler">
      <i data-feather="settings"></i>
    </a>
    <h6 class="text-muted">Sidebar:</h6>
    <!-- <div class="form-group border-bottom"> -->
    <div class="form-check form-check-inline">
      <label class="form-check-label">
        <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight" value="sidebar-light" checked>
        Light
      </label>
    </div>
    <div class="form-check form-check-inline">
      <label class="form-check-label">
        <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark" value="sidebar-dark">
        Dark
      </label>
    </div>
  </div>
</nav>