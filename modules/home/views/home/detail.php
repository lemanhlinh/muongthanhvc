<?php
global $tmpl;
$tmpl->addScript('plugin/Chart.min');
$tmpl->addScript('home','modules/home/assets/js');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid mb-5">
        <table id="example" class="display table table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011-04-25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011-07-25</td>
                <td>$170,750</td>
            </tr>
            <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009-01-12</td>
                <td>$86,000</td>
            </tr>
            <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2012-03-29</td>
                <td>$433,060</td>
            </tr>
            <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
                <td>2008-11-28</td>
                <td>$162,700</td>
            </tr>
            <tr>
                <td>Brielle Williamson</td>
                <td>Integration Specialist</td>
                <td>New York</td>
                <td>61</td>
                <td>2012-12-02</td>
                <td>$372,000</td>
            </tr>
            <tr>
                <td>Herrod Chandler</td>
                <td>Sales Assistant</td>
                <td>San Francisco</td>
                <td>59</td>
                <td>2012-08-06</td>
                <td>$137,500</td>
            </tr>
            <tr>
                <td>Rhona Davidson</td>
                <td>Integration Specialist</td>
                <td>Tokyo</td>
                <td>55</td>
                <td>2010-10-14</td>
                <td>$327,900</td>
            </tr>
            </tbody>
        </table>
    </div><!-- /.container-fluid -->
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Phát hành và sử dụng</h3>
                        <div class="card-tools d-none">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Top Khách sạn kích hoạt nhiều</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <select class="form-control">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                    <option>option 5</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-head-fixed text-wrap">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Reason</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>11-7-2014</td>
                                <td><span class="tag tag-success">Approved</span></td>
                                <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            </tr>
                            <tr>
                                <td>11-7-2014</td>
                                <td><span class="tag tag-warning">Pending</span></td>
                                <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            </tr>
                            <tr>
                                <td>11-7-2014</td>
                                <td><span class="tag tag-primary">Approved</span></td>
                                <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            </tr>
                            <tr>
                                <td>11-7-2014</td>
                                <td><span class="tag tag-danger">Denied</span></td>
                                <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            </tr>
                            <tr>
                                <td>11-7-2014</td>
                                <td><span class="tag tag-success">Approved</span></td>
                                <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            </tr>
                            <tr>
                                <td>11-7-2014</td>
                                <td><span class="tag tag-warning">Pending</span></td>
                                <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            </tr>
                            <tr>
                                <td>11-7-2014</td>
                                <td><span class="tag tag-primary">Approved</span></td>
                                <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            </tr>
                            <tr>
                                <td>11-7-2014</td>
                                <td><span class="tag tag-danger">Denied</span></td>
                                <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->