    function add_new_faktur(){
        $('#periode_upload').val('');
        $('#file_to_upload_npwp').val('');
        $('#file_to_upload_non_npwp').val('');
        $('#btn_upload_fp_alibaba').click();
    }
    function view_list(){
        $('#list_faktur_pajak').DataTable().clear().draw();
        var periode_view = $('#periode_view').val();
        $('.periode_name').html(periode_view);
        if(periode_view){
            Swal.fire ({
                onBeforeOpen: () => {
                    swal.fire({
                        html: '<h5>Please wait...</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    Swal.showLoading ()
                }
            });
            $.ajax({
                url: base_url+"check-faktur-pajak-alibaba",
                type: 'POST', 
                cache: false,
                dataType: "json",
                data: {'periode':periode_view},
                success: function (res) {  
                    Swal.close ()
                    if(res.result){  
                        check_count(); 
                        get_list(periode_view);
                    }else{
                        $('#list_faktur_pajak').DataTable(); 
                        $('.div_percentage').html('');
                        Swal.fire('',res.message,'error').then((result) => {   
                        }); 
                    } 
                },
                cache: false, 
            });
        }
    }
    function get_list(){  
        var periode_view = $('#periode_view').val();
        $('#list_faktur_pajak').DataTable().destroy(); 
        $('#list_faktur_pajak').DataTable( {       
            ajax:{
                "url":  base_url+"view-faktur-pajak-alibaba",
                "type": "POST", 
                "data": {"periode":periode_view}
            },
            "columns": [   
                {   "data": "cust_id" },  
                {   "data": "cust_name" },   
                {   "data": "cust_email",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            if(data) {
                                var data = data.replace(/;/g, '<br>');
                            }
                        } 
                        return data;
                    }
                
                },   
                {   "data": "type" },   
                {   "data": "no_npwp" }, 
                {   "data": "billing_amount",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            var amount = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            data = 'Rp. '+amount;
                        } 
                        return data;
                    }
                },
                {   "data": "billing_file",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = '<a href="#" onclick="view_billing(\''+periode_view+'\',\''+data+'\')">' + data + '</a>';
                        } 
                        return data;
                    }
                },   
                {   "data": "faktur_file",                
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = '<a href="#" onclick="view_faktur(\''+periode_view+'\',\''+data+'\')">' + data + '</a>';
                        } 
                        return data;
                    }
                },     
                {   "data": "cust_id",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = '<a href="#" placholder="send email" onclick="send_email(\''+periode_view+'\',\''+data+'\')"><i class="text-dark-50 flaticon-multimedia-2"></i></a>';
                        } 
                        return data;
                    }
                },     
            ],  
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "orderable": false
                },
                {
                    "targets": [ 5 ],
                    "className": "text-right"
                },
                {
                    "targets": [ 8 ],
                    "className": "text-center"
                } 
            ],     
            "pageLength": 25, 
            "order": [[4, 'desc']]
        } );
    } 
    $("form.upload_fp_alibaba").submit(function(e) {
        var periode_upload = $('#periode_upload').val();
        e.preventDefault();    
        var formData = new FormData(this);   
        Swal.fire({
            title: "Are you sure?",
            text: "You submit billing periode "+periode_upload,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Upload it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                Swal.fire ({
                    onBeforeOpen: () => {
                        swal.fire({
                            html: '<h5>Please wait...</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                        Swal.showLoading ()
                    }
                });
                $.ajax({
                    url: base_url+"upload-faktur-pajak-alibaba",
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    cache: false,
                    dataType: "json",
                    data: formData,
                    success: function (res) { 
                        if(res.result){  
                            Swal.fire('','Upload file success','success').then((result) => {  
                                $('#modal_upload_fp_alibaba').modal('toggle');
                                $('#periode_view').val($('#periode_upload').val()); 
                                view_list(); 
                            });
                        }else{
                            Swal.fire('',res.message,'error').then((result) => { 
                                
                            }); 
                        } 
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else if (result.dismiss === "cancel") {
            }
        });
    }); 
    function submit_upload(){
        var periode_upload = $('#periode_upload').val();
        if(periode_upload != ''){
            $.ajax({
                url: base_url+"check-faktur-pajak-alibaba",
                type: 'POST', 
                cache: false,
                dataType: "json",
                data: {'periode':periode_upload},
                success: function (res) {  
                    Swal.close ();
                    if(res.result){  
                        Swal.fire('','Billing periode '+periode_upload+' sudah diupload','error').then((result) => { 
                        }); 
                    }else{
                        $('#submit_upload_btn').click();  
                    } 
                },
                cache: false, 
            });        
        }else{
            Swal.fire('','Input Periode billing','error').then((result) => { 
            }); 
        }
    }
    function view_billing(periode, billing_name){
        Swal.fire ({
            onBeforeOpen: () => {
                swal.fire({
                    html: '<h5>Get data<br>Please wait...</h5>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                Swal.showLoading ()
            }
        }); 
        $.ajax({
            url: base_url+"view-billing-alibaba-pdf",
            type: 'POST', 
            cache: false,
            dataType: "json",
            data: {'periode':periode, 'billing_name':billing_name},
            success: function (res) {  
                Swal.close ()
                if(res.result){  
                    var filePath = base_url+res.data.url_billing;
                    window.open(filePath, '_blank'); 
                }else{
                    Swal.fire('',res.message,'error').then((result) => {  
                    });  
                } 
            },
            cache: false, 
        });          
    }
    function view_faktur(periode, faktur_name){
        Swal.fire ({
            onBeforeOpen: () => {
                swal.fire({
                    html: '<h5>Get data<br>Please wait...</h5>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                Swal.showLoading ()
            }
        }); 
        $.ajax({
            url: base_url+"view-faktur-alibaba-pdf",
            type: 'POST', 
            cache: false,
            dataType: "json",
            data: {'periode':periode, 'faktur_name':faktur_name},
            success: function (res) {  
                Swal.close ()
                if(res.result){  
                    var filePath = base_url+res.data.url_faktur;
                    window.open(filePath, '_blank'); 
                }else{
                    Swal.fire('',res.message,'error').then((result) => {  
                    });  
                } 
            },
            cache: false, 
        });          
    }
    function check_count(){
        var periode_view = $('#periode_view').val();
        $.ajax({
            url: base_url+"check-count-billing-faktur-alibaba-pdf",
            type: 'POST', 
            cache: false,
            dataType: "json",
            data: {'periode':periode_view},
            success: function (res) { 
                if(res.result){ 
                    var html = '';
                    html += '<div class="d-flex align-items-center justify-content-between mb-2">'+
                                '<span class="text-muted font-size-sm font-weight-bold">Generate Billing PDF</span>'+
                                '<span class="text-muted mr-2 font-size-sm font-weight-bold">'+res.data.percentage_billing+'%</span>'+
                            '</div>'+
                            '<div class="progress progress-xs w-100 mb-5">'+
                                '<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: '+res.data.percentage_billing+'%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>'+
                            '</div>';
                    html += '<div class="d-flex align-items-center justify-content-between mb-2">'+
                                '<span class="text-muted font-size-sm font-weight-bold">Generate Faktur PDF</span>'+
                                '<span class="text-muted mr-2 font-size-sm font-weight-bold">'+res.data.percentage_faktur+'%</span>'+
                            '</div>'+
                            '<div class="progress progress-xs w-100 mb-5">'+
                                '<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: '+res.data.percentage_faktur+'%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>'+
                            '</div>'; 
                    $('.div_percentage').html(html);  
                    var btn_send_email_all = '';
                    if(res.data.billing_status == 1 && res.data.faktur_status == 1){
                        if(res.data.send_email_all == 0){
                            btn_send_email_all += '<button class="btn btn-success" onclick="send_all_email(\''+periode_view+'\')">Send All E-mail</button>';
                        }else{
                            btn_send_email_all += '<mark>All E-mail sent on <b>'+res.data.send_email_all_date+'</b> - <a href="#" onclick="view_log_send_email_all(\''+periode_view+'\');">logs.txt</a> -</mark>';
                        }
                    }else{
                        btn_send_email_all += '<button class="btn btn-secondary" disabled style="cursor: default">Send All E-mail</button>'; 
                    }
                    $('.btn_send_all').html(btn_send_email_all);
                    if(res.data.percentage_billing != '100' || res.data.percentage_faktur != '100'){ 
                        setTimeout(function(){check_count()},5000);
                    }
                }else{ 
                    $('.div_percentage').html('');
                } 
            },
            cache: false, 
        });  
    }
    function send_all_email(periode_view){ 
        Swal.fire({
            title: "Are you sure?",
            text: "Send All E-mail to Customer periode "+periode_view,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Send it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                Swal.fire ({
                    onBeforeOpen: () => {
                        swal.fire({
                            html: '<h5>Please wait...</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                        Swal.showLoading ()
                    }
                });
                $.ajax({
                    url: base_url+"send-all-billing-alibaba",
                    type: 'POST', 
                    cache: false,
                    dataType: "json",
                    data: {'periode_view':periode_view},
                    success: function (res) {  
                        Swal.close ()
                        if(res.result){   
                            Swal.fire('',res.message,'success').then((result) => {  
                                view_list(); 
                            });   
                        }else{
                            Swal.fire('',res.message,'error').then((result) => {  
                            });  
                        } 
                    },
                    cache: false, 
                });     
            }
        });     
    }
    function view_log_send_email_all(periode_view){
        Swal.fire ({
            onBeforeOpen: () => {
                swal.fire({
                    html: '<h5>Get data<br>Please wait...</h5>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                Swal.showLoading ()
            }
        }); 
        $.ajax({
            url: base_url+"view-log-send-email-all-billing-alibaba",
            type: 'POST', 
            cache: false,
            dataType: "json",
            data: {'periode_view':periode_view},
            success: function (res) {  
                Swal.close ()
                if(res.result){  
                    var filePath = base_url+res.data.url_logs;
                    window.open(filePath, '_blank'); 
                }else{
                    Swal.fire('',res.message,'error').then((result) => {  
                    });  
                } 
            },
            cache: false, 
        });     
    }
    function send_email(periode_view, cust_id){
        Swal.fire({
            title: "Are you sure?",
            text: "Send All E-mail to Customer id "+cust_id+" periode "+periode_view,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Send it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                Swal.fire ({
                    onBeforeOpen: () => {
                        swal.fire({
                            html: '<h5>Please wait...</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                        Swal.showLoading ()
                    }
                });
                $.ajax({
                    url: base_url+"send-email-billing-alibaba",
                    type: 'POST', 
                    cache: false,
                    dataType: "json",
                    data: {'periode_view':periode_view, 'cust_id':cust_id},
                    success: function (res) {  
                        Swal.close ();
                        if(res.result){  
                            Swal.fire('',res.message,'success').then((result) => {  
                                view_list(); 
                            });   
                        }else{
                            Swal.fire('',res.message,'error').then((result) => {  
                            });  
                        } 
                    },
                    cache: false, 
                });     
            }
        });     
    }