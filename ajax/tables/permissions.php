<?php
include('../../config.php');
include('../../system_functions.php');

$query = sqlsrv_query($conn, "SELECT userid FROM dbo.userpermission GROUP BY userid");

if ($query === false) {
    die(print_r(sqlsrv_errors(), true)); // Print the SQLSRV error message
}

?>

<section id="datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table mt-2" id="table-data">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Permission</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                            $userid = $result['userid'];
                        ?>
                            <tr>
                                <td>
                                    <?php echo getStaffName($conn, $userid); ?>
                                </td>
                                <td>
                                    <?php
                                    $q = sqlsrv_query($conn, "SELECT * FROM dbo.userpermission WHERE userid = '$userid'");
                                    if ($q === false) {
                                        die(print_r(sqlsrv_errors(), true)); // Print the SQLSRV error message
                                    }
                                    while ($r = sqlsrv_fetch_array($q, SQLSRV_FETCH_ASSOC)) {
                                        $permid = $r['permid'];
                                        echo $r['permission'] ?>
                                        <br>
                                        <a class="deletepermissionbtn" title="Delete Permission" i_index=<?php echo $permid; ?>>
                                            <span class="icon-wrapper cursor-pointer" title="Delete Permission">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>
                                            </span>
                                        </a> <br>
                                        <hr style="border-bottom: 0.5px solid rgb(230, 255, 230);">
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>