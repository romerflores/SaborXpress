<?php require (ROOT_VIEW.'/templates/header.php')?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0 font-weight-bold">Bienvenido!!</h3>
                <p></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 d-flex grid-margin stretch-card">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-4 d-flex grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between">
                            <h4 class="card-title mb-3">Sale Analysis Trend</h4>
                        </div>
                        <div class="mt-2">
                            <div class="d-flex justify-content-between">
                                <small>Order Value</small>
                                <small>155.5%</small>
                            </div>
                            <div class="progress progress-md  mt-2">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 80%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex justify-content-between">
                                <small>Total Products</small>
                                <small>238.2%</small>
                            </div>
                            <div class="progress progress-md  mt-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mt-4 mb-5">
                            <div class="d-flex justify-content-between">
                                <small>Quantity</small>
                                <small>23.30%</small>
                            </div>
                            <div class="progress progress-md mt-2">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <canvas id="salesTopChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 d-flex grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between">
                            <h4 class="card-title mb-3">Project status</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <img class="img-sm rounded-circle mb-md-0 mr-2" src="images/faces/face30.png" alt="profile image">
                                                <div>
                                                    <div> Company</div>
                                                    <div class="font-weight-bold mt-1">volkswagen</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            Budget
                                            <div class="font-weight-bold  mt-1">$2322 </div>
                                        </td>
                                        <td>
                                            Status
                                            <div class="font-weight-bold text-success  mt-1">88% </div>
                                        </td>
                                        <td>
                                            Deadline
                                            <div class="font-weight-bold  mt-1">07 Nov 2019</div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <img class="img-sm rounded-circle mb-md-0 mr-2" src="images/faces/face31.png" alt="profile image">
                                                <div>
                                                    <div> Company</div>
                                                    <div class="font-weight-bold  mt-1">Land Rover</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            Budget
                                            <div class="font-weight-bold  mt-1">$12022 </div>
                                        </td>
                                        <td>
                                            Status
                                            <div class="font-weight-bold text-success  mt-1">70% </div>
                                        </td>
                                        <td>
                                            Deadline
                                            <div class="font-weight-bold  mt-1">08 Nov 2019</div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <img class="img-sm rounded-circle mb-md-0 mr-2" src="images/faces/face32.png" alt="profile image">
                                                <div>
                                                    <div> Company</div>
                                                    <div class="font-weight-bold  mt-1">Bentley </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            Budget
                                            <div class="font-weight-bold  mt-1">$8,725</div>
                                        </td>
                                        <td>
                                            Status
                                            <div class="font-weight-bold text-success  mt-1">87% </div>
                                        </td>
                                        <td>
                                            Deadline
                                            <div class="font-weight-bold  mt-1">11 Jun 2019</div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <img class="img-sm rounded-circle mb-md-0 mr-2" src="images/faces/face33.png" alt="profile image">
                                                <div>
                                                    <div> Company</div>
                                                    <div class="font-weight-bold  mt-1">Morgan </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            Budget
                                            <div class="font-weight-bold  mt-1">$5,220 </div>
                                        </td>
                                        <td>
                                            Status
                                            <div class="font-weight-bold text-success  mt-1">65% </div>
                                        </td>
                                        <td>
                                            Deadline
                                            <div class="font-weight-bold  mt-1">26 Oct 2019</div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <img class="img-sm rounded-circle mb-md-0 mr-2" src="images/faces/face34.png" alt="profile image">
                                                <div>
                                                    <div> Company</div>
                                                    <div class="font-weight-bold  mt-1">volkswagen</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            Budget
                                            <div class="font-weight-bold  mt-1">$2322 </div>
                                        </td>
                                        <td>
                                            Status
                                            <div class="font-weight-bold text-success mt-1">88% </div>
                                        </td>
                                        <td>
                                            Deadline
                                            <div class="font-weight-bold  mt-1">07 Nov 2019</div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial -->
</div>
<!-- main-panel ends -->
<?php require (ROOT_VIEW.'/templates/footer.php')?>