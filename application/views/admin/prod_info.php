<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Products Info</h5>  
            </div> 
        </div>
    </div> 
    <div class="d-flex flex-column-fluid">  
		<div class="container-fluid">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Products List
                        <span class="d-block text-muted pt-2 font-size-sm">your products list Indonet</span></h3>
                    </div> 
                </div>
                <div class="card-body"> 
                    <table class="table table-bordered table-checkable" id="kt_datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product Name</th> 
                                <th>Total</th> 
                                <th>Status</th> 
                            </tr>
                        </thead>
                        <tbody> 
                            <?php
                                $no = 1;
                                foreach ($prod_list as $key => $value) { 
                                    $status = '';
                                    if($value->STATUS == 'Active'){
                                        $status = '<span class="label label-success label-dot mr-2"></span><span class="font-weight-bold text-success">Active</span>';
                                    }else{
                                        $status = '<span class="label label-danger label-dot mr-2"></span><span class="font-weight-bold text-danger">Close</span>';
                                    }
                                    ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td><?=$value->INVOICEDESCRIPTION?></td>
                                        <td><?="Rp " . number_format($value->AMOUNT,2,',','.');?></td>
                                        <td><?=$status?></td>
                                    </tr>
                                    <?php 
                                    $no++;
                                }
                            ?> 
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>