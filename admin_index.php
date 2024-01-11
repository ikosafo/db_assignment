<?php include('includes/header.php');
?>


<!-- BEGIN: Content-->
<div class="app-content content ">
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
    </div>
    <div class="content-body">
      <!-- Dashboard Ecommerce Starts -->
      <section id="dashboard-ecommerce">
        <div class="row match-height">
          <!-- Medal Card -->
          <div class="col-xl-4 col-md-6 col-12">
            <div class="card card-congratulation-medal">
              <div class="card-body">
                <h5>Pending Orders</h5>
                <h3 class="mb-75 mt-2 pt-50">
                  <a href="#"> <?php

                                // Count the number of rows where status = '1'
                                $countQuery = "SELECT COUNT(*) AS TotalCount FROM dbo.tempOrder T
                                INNER JOIN dbo.Customer C ON T.genNo = C.genNo
                                WHERE T.status IS NULL";

                                $countStmt = sqlsrv_query($conn, $countQuery);

                                // Check for query execution success
                                if ($countStmt === false) {
                                  die(print_r(sqlsrv_errors(), true));
                                }

                                // Fetch the result
                                $rowCountRow = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC);

                                // Extract the row count
                                $rowCount = ($rowCountRow !== false && isset($rowCountRow['TotalCount'])) ? $rowCountRow['TotalCount'] : 0;

                                // Output the row count
                                echo $rowCount;
                                ?>
                  </a>
                </h3>
                <button type="button" class="btn btn-primary waves-effect waves-float waves-light">Go to Orders to process</button>
              </div>
            </div>
          </div>
          <!--/ Medal Card -->

          <!-- Statistics Card -->
          <div class="col-xl-8 col-md-6 col-12">
            <div class="card card-statistics">
              <div class="card-header">
                <h4 class="card-title">Statistics</h4>
              </div>
              <div class="card-body statistics-body">
                <div class="row">
                  <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-xl-0">
                    <div class="d-flex flex-row">
                      <div class="avatar bg-light-primary me-2">
                        <div class="avatar-content">
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up avatar-icon">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                          </svg>
                        </div>
                      </div>
                      <div class="my-auto">
                        <h4 class="fw-bolder mb-0">
                          <?php

                          // Count the number of rows where status = '1'
                          $countQuery = "SELECT COUNT(*) AS TotalCount FROM dbo.tempOrder 
                          WHERE status = '1'";
                          $countStmt = sqlsrv_query($conn, $countQuery);

                          // Check for query execution success
                          if ($countStmt === false) {
                            die(print_r(sqlsrv_errors(), true));
                          }

                          // Fetch the result
                          $rowCountRow = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC);

                          // Extract the row count
                          $rowCount = ($rowCountRow !== false && isset($rowCountRow['TotalCount'])) ? $rowCountRow['TotalCount'] : 0;

                          // Output the row count
                          echo $rowCount;
                          ?>

                        </h4>
                        <p class="card-text font-small-3 mb-0">Completed Orders</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-xl-0">
                    <div class="d-flex flex-row">
                      <div class="avatar bg-light-info me-2">
                        <div class="avatar-content">
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user avatar-icon">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                          </svg>
                        </div>
                      </div>
                      <div class="my-auto">
                        <h4 class="fw-bolder mb-0"> <?php

                                                    // Count the number of rows where status = '1'
                                                    $countQuery = "SELECT COUNT(*) AS TotalCount FROM dbo.Customer";
                                                    $countStmt = sqlsrv_query($conn, $countQuery);

                                                    // Check for query execution success
                                                    if ($countStmt === false) {
                                                      die(print_r(sqlsrv_errors(), true));
                                                    }

                                                    // Fetch the result
                                                    $rowCountRow = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC);

                                                    // Extract the row count
                                                    $rowCount = ($rowCountRow !== false && isset($rowCountRow['TotalCount'])) ? $rowCountRow['TotalCount'] : 0;

                                                    // Output the row count
                                                    echo $rowCount;
                                                    ?>
                        </h4>
                        <p class="card-text font-small-3 mb-0">Customers</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-sm-0">
                    <div class="d-flex flex-row">
                      <div class="avatar bg-light-danger me-2">
                        <div class="avatar-content">
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box avatar-icon">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                          </svg>
                        </div>
                      </div>
                      <div class="my-auto">
                        <h4 class="fw-bolder mb-0"> <?php

                                                    // Count the number of rows where status = '1'
                                                    $countQuery = "SELECT COUNT(*) AS TotalCount FROM dbo.Product";
                                                    $countStmt = sqlsrv_query($conn, $countQuery);

                                                    // Check for query execution success
                                                    if ($countStmt === false) {
                                                      die(print_r(sqlsrv_errors(), true));
                                                    }

                                                    // Fetch the result
                                                    $rowCountRow = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC);

                                                    // Extract the row count
                                                    $rowCount = ($rowCountRow !== false && isset($rowCountRow['TotalCount'])) ? $rowCountRow['TotalCount'] : 0;

                                                    // Output the row count
                                                    echo $rowCount;
                                                    ?>
                        </h4>
                        <p class="card-text font-small-3 mb-0">Products</p>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <!--/ Statistics Card -->
        </div>

      </section>
      <!-- Dashboard Ecommerce ends -->

    </div>
  </div>
</div>
<!-- END: Content-->


<?php include('includes/footer.php') ?>