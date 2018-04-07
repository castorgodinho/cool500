<div style="width: 970px;" >
    <div class="row invoice-container">
        <div class="row invoice-header">
            <div class="col-md-12 col-sm-12">
                <h1 class="text-center">Goa Industrial Development Corporation</h1>
                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <p>
                            <b>Address</b><br>
                            This is some lines of the address. <br>
                            This is some lines of the address. <br>
                        </p>
                        <p><b>Phone Number: </b>0832-2786566</p>
                        <p><b>Mobile Number: </b>+(91) - 9876726524</p>
                        <p><b>Email: </b> gidc@gmail.com</p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                        <p><b>Other Information: </b> 7120199232</p>
                        <p><b>Information: </b>+(91) - ABCD1231</p>
                        <p><b>Other data here: </b> HUYI2661</p>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        
        <h1 class="text-center">INVOICE</h1>
        <div class="row company-detail">
            <h3>Company Details</h3>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <p><b>Unit Name: </b> <?= $company->name;  ?></p>
                <p><b>Address: </b> <?= $company->address;  ?></p>
                <p><b>GSTIN: </b> <?= $company->gstin;  ?></p>
                <p><b>Constitution: </b> <?= $company->constitution;  ?></p>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <p><b>Owner Name: </b> <?= $company->owner_name;  ?></p>
                <p><b>Phone Number: </b> <?= $company->owner_phone;  ?></p>
                <p><b>Mobile: </b> <?= $company->owner_mobile;  ?></p>
                <p><b>Email: </b> <?= $company->user->email;  ?></p>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <p><b>Competent's Name: </b> <?= $company->competent_name;  ?></p>
                <p><b>Competent's Mobile: </b> <?= $company->competent_mobile;  ?></p>
                <p><b>Competent's Email: </b> <?= $company->competent_email;  ?></p>
                <p><b>Products: </b> <?= $company->products;  ?></p>
            </div>
        </div>
        <div class="lease-details">
            <h3>Lease Details</h3>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <p><b>Plot Number: </b> <?php 
                    foreach($plots as $plot){
                        echo $plot->plot->name. ' ';
                    }
                ?></p>
                <p><b>Area: </b> <?php 
                $total_area = 0;
                    foreach($plots as $plot){
                        $total_area += $plot->plot->area_of_plot;
                    }
                    echo $total_area. ' SqMtr'
                ?></p>
                <p><b>Allotment date: </b> <?= $plots[0]->start_date;  ?></p>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>

        <div class="table-data">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Content</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Lease rent payment of the annual year 2018. </td>
                        <td><?= $total_area * 15;  ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-right"> GST</td>
                        <td><?= ($total_area * 15) * 0.18;  ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-right">Interest</td>
                        <td><?= 0  ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-right">Grand Total</td>
                        <td> <b><?= ($total_area * 15) * 0.18;  ?></b></td>
                    </tr>
                    <tr>
                        <td colspan=3><b>TOTAL IN WORDS: </b></td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</div>