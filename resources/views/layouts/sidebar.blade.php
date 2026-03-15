  <div class="app-menu navbar-menu">
      <!-- LOGO -->
      <div class="navbar-brand-box">
          <!-- Dark Logo-->
          <a href="{{ route('dashboard') }}" class="logo logo-dark">
              <span class="logo-sm">
                  <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
              </span>
              <span class="logo-lg">
                  <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
              </span>
          </a>
          <!-- Light Logo-->
          <a href="index.html" class="logo logo-light">
              <span class="logo-sm">
                  <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
              </span>
              <span class="logo-lg">
                  <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17">
              </span>
          </a>
          <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
              id="vertical-hover">
              <i class="ri-record-circle-line"></i>
          </button>
      </div>

      <div id="scrollbar">
          <div class="container-fluid">

              <div id="two-column-menu">
              </div>
              <ul class="navbar-nav" id="navbar-nav">
                  <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarDashboards">
                          <i class="bx bxs-dashboard"></i> <span data-key="t-dashboards">Dashboards</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarDashboards">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                  <a href="{{ route('dashboard') }}" class="nav-link" data-key="t-analytics"> Halaman
                                      Utama
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </li> <!-- end Dashboard Menu -->
                  @if (hasRole(['Admin', 'Direktur']))
                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                              aria-expanded="false" aria-controls="sidebarApps">
                              <i class="bx bx-layer"></i> <span data-key="t-apps">Master Data</span>
                          </a>
                          <div class="collapse menu-dropdown" id="sidebarApps">
                              <ul class="nav nav-sm flex-column">
                                  <li class="nav-item">
                                      <a href="#sidebarProjects" class="nav-link" data-bs-toggle="collapse"
                                          role="button" aria-expanded="false" aria-controls="sidebarProjects"
                                          data-key="t-projects">
                                          Revenue
                                      </a>
                                      <div class="collapse menu-dropdown" id="sidebarProjects">
                                          <ul class="nav nav-sm flex-column">
                                              <li class="nav-item">
                                                  <a href="{{ route('revenue_categories.index') }}" class="nav-link"
                                                      data-key="t-list">
                                                      Revenue Category </a>
                                              </li>
                                              <li class="nav-item">
                                                  <a href="{{ route('medical_services.index') }}" class="nav-link"
                                                      data-key="t-overview"> Medical Services </a>
                                              </li>
                                          </ul>
                                      </div>
                                  </li>
                                  <li class="nav-item">
                                      <a href="#sidebarTasks" class="nav-link" data-bs-toggle="collapse" role="button"
                                          aria-expanded="false" aria-controls="sidebarTasks" data-key="t-tasks">
                                          Expenses
                                      </a>
                                      <div class="collapse menu-dropdown" id="sidebarTasks">
                                          <ul class="nav nav-sm flex-column">
                                              <li class="nav-item">
                                                  <a href="{{ route('expense_categories.index') }}" class="nav-link"
                                                      data-key="t-kanbanboard"> Expenses Category </a>
                                              </li>
                                              <li class="nav-item">
                                                  <a href="apps-tasks-details.html" class="nav-link"
                                                      data-key="t-task-details"> Task Details </a>
                                              </li>
                                          </ul>
                                      </div>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('financial-targets.index') }}" target="_blank"
                                          class="nav-link" data-key="t-vertical">Financial Target</a>
                                  </li>
                              </ul>
                          </div>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                              aria-expanded="false" aria-controls="sidebarAuth">
                              <i class="bx bx-user-circle"></i> <span data-key="t-authentication">Setting</span>
                          </a>
                          <div class="collapse menu-dropdown" id="sidebarAuth">
                              <ul class="nav nav-sm flex-column">
                                  <li class="nav-item">
                                      <a href="#sidebarSignIn" class="nav-link" data-bs-toggle="collapse"
                                          role="button" aria-expanded="false" aria-controls="sidebarSignIn"
                                          data-key="t-signin">
                                          Administrator
                                      </a>
                                      <div class="collapse menu-dropdown" id="sidebarSignIn">
                                          <ul class="nav nav-sm flex-column">
                                              <li class="nav-item">
                                                  <a href="{{ route('units.index') }}" class="nav-link"
                                                      data-key="t-products"> Unit </a>
                                              </li>
                                              <li class="nav-item">
                                                  <a href="{{ route('roles.index') }}" class="nav-link"
                                                      data-key="t-product-Details"> Role </a>
                                              </li>
                                              <li class="nav-item">
                                                  <a href="{{ route('positions.index') }}" class="nav-link"
                                                      data-key="t-create-product"> Positions </a>
                                              </li>
                                              <li class="nav-item">
                                                  <a href="{{ route('users.index') }}" class="nav-link"
                                                      data-key="t-orders"> Users </a>
                                              </li>
                                          </ul>
                                      </div>
                                  </li>
                              </ul>
                          </div>
                      </li>
                  @endif
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarPages">
                          <i class="bx bx-file"></i> <span data-key="t-pages">Revenue</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarPages">
                          <ul class="nav nav-sm flex-column">
                              {{-- <li class="nav-item">
                                  <a href="{{ route('revenues.index') }}" class="nav-link" data-key="t-starter">
                                      Pendapatan </a>
                              </li> --}}
                              <li class="nav-item">
                                  <a href="{{ route('targets.index') }}" class="nav-link" data-key="t-starter">
                                      Target Revenue </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('visits.index') }}" class="nav-link" data-key="t-starter">
                                      Aktual Revenue </a>
                              </li>
                              {{-- <li class="nav-item">
                                  <a href="#sidebarProfile" class="nav-link" data-bs-toggle="collapse"
                                      role="button" aria-expanded="false" aria-controls="sidebarProfile"
                                      data-key="t-profile"> Kunjungan Pasien
                                  </a>
                                  <div class="collapse menu-dropdown" id="sidebarProfile">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item">
                                              <a href="{{ route('finance.daily', date('Y-m-d')) }}" class="nav-link"
                                                  data-key="t-simple-page">
                                                  Daily </a>
                                          </li>
                                          <li class="nav-item">
                                              <a href="{{ route('visits.index') }}" class="nav-link"
                                                  data-key="t-settings"> Visit </a>
                                          </li>
                                          <li class="nav-item">
                                              <a href="{{ route('targets.index') }}" class="nav-link"
                                                  data-key="t-settings"> Target </a>
                                          </li>
                                      </ul>
                                  </div>
                              </li> --}}
                          </ul>
                      </div>
                  </li>

                  <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Components</span>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarAdvanceUI" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarAdvanceUI">
                          <i class="bx bx-briefcase-alt"></i> <span data-key="t-advance-ui">Expenses</span>
                          <span class="badge badge-pill bg-success" data-key="t-new">New</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarAdvanceUI">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                  <a href="{{ route('target_expenses.index') }}" class="nav-link"
                                      data-key="t-nestable-list">Target Expenses</a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('expenses.index') }}" class="nav-link"
                                      data-key="t-sweet-alerts">Aktual Expense</a>
                              </li>
                          </ul>
                      </div>
                  </li>

              </ul>
          </div>
          <!-- Sidebar -->
      </div>
  </div>
  <!-- Left Sidebar End -->
  <!-- Vertical Overlay-->
  <div class="vertical-overlay"></div>
