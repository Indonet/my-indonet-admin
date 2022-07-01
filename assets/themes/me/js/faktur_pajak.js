function view_list(){ 
    $('#list_faktur_pajak').DataTable().clear().draw();
    var periode_view = $('#periode_view').val();
    var month_year_now = $('#month_year_now').val(); 
    $('#month_year_select').val(periode_view);
    $('.periode_name').html(periode_view);
    $('.btn_process_billing').addClass('hide');
    $('#periode_upload_fp').val(month_year_now);
    if(periode_view){
        $('#status_email_sent').val('');
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
            url: base_url+"check-faktur-pajak",
            type: 'POST', 
            cache: false,
            dataType: "json",
            data: {'periode':periode_view},
            success: function (res) {  
                Swal.close ()
                if(res.result){   
                    if(periode_view == month_year_now){
                        $('.btn_process_billing').removeClass('hide');
                        check_count_month_year_now(periode_view);
                        get_list_month_year_now(periode_view);
                    }else{
                        get_list(periode_view);
                        check_count(periode_view);
                    }
                }else{
                    $('#list_faktur_pajak').DataTable(); 
                    $('.div_percentage').html('');
                    Swal.fire('',res.message,'info').then((result) => {   
                        if(periode_view == month_year_now){
                            $('.btn_process_billing').removeClass('hide'); 
                        }
                    }); 
                } 
            },
            cache: false, 
        });
    }
}
function confirm_new(){ 
    var list_corporate = $("#list_corporate").is(":checked") ? 1 : 0; 
    var list_retail = $("#list_retail").is(":checked") ? 1 : 0; 
    var list_personal = $("#list_personal").is(":checked") ? 1 : 0;   
    var periode_select = $('#month_year_now').val();
    $('.error_cust_type').addClass('hide');  
    if(periode_select != ''){
        if(list_corporate != 0 || list_retail != 0 || list_personal != 0){   
            Swal.fire({
                title: "Are you sure?",
                text: "Get Customer List periode "+periode_select,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
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
                        url: base_url+"set-list-faktur-pajak",
                        type: 'POST',  
                        dataType: "json",
                        data: {'periode':periode_select, 'list_corporate':list_corporate, 'list_retail':list_retail, 'list_personal':list_personal},
                        success: function (res) {  
                            Swal.close ();
                            if(res.result){  
                                Swal.fire('','Get Customer List Periode '+periode_select+' in progress', 'info').then((result) => { 
                                    $('#modalNewList').modal('toggle');
                                    $('#periode_view').val(periode_select); 
                                    view_list(); 
                                }); 
                            }else{
                                Swal.fire('','Input Periode billing','error').then((result) => { 
                                }); 
                            } 
                        },
                        cache: false, 
                    });  
                }
            }); 
        }else{
            $('.error_cust_type').removeClass('hide'); 
        }    
    }else{
        Swal.fire('','Input Periode billing','error').then((result) => { 
        }); 
    }
} 
function confirm_send_email(){
    var send_corporate = $("#send_corporate").is(":checked") ? 1 : 0; 
    var send_retail = $("#send_retail").is(":checked") ? 1 : 0; 
    var send_personal = $("#send_personal").is(":checked") ? 1 : 0;   
    var send_non_alibaba = $("#send_non_alibaba").is(":checked") ? 1 : 0;   
    var send_alibaba = $("#send_alibaba").is(":checked") ? 1 : 0;   
    var send_non_npwp = $("#send_non_npwp").is(":checked") ? 1 : 0;   
    var send_npwp = $("#send_npwp").is(":checked") ? 1 : 0;   
    var periode_select = $('#month_year_now').val();
    $('.error_send_cust_type').addClass('hide');  
    $('.error_send_cust_type_2').addClass('hide');  
    $('.error_send_cust_npwp').addClass('hide');  
    if(periode_select != ''){
        if(send_corporate != 0 || send_retail != 0 || send_personal != 0){ 
            if(send_non_alibaba != 0 || send_alibaba != 0){
                if(send_non_npwp != 0 || send_npwp != 0){
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You Send Email billing periode "+periode_select,
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
                                url: base_url+"send-billing-faktur-pajak",
                                type: 'POST', 
                                cache: false,
                                dataType: "json",
                                data: { 'periode':periode_select, 'send_corporate':send_corporate, 'send_retail':send_retail, 'send_personal':send_personal,
                                        'send_non_alibaba':send_non_alibaba, 'send_alibaba':send_alibaba, 'send_non_npwp':send_non_npwp, 'send_npwp':send_npwp},
                                success: function (res) {  
                                    Swal.close ();
                                    if(res.result){  
                                        Swal.fire('','Send All email Customer Periode '+periode_select+' Progress', 'info').then((result) => {  
                                            $('#modalSendEmail').modal('toggle');
                                            $('#periode_view').val(periode_select); 
                                            view_list(); 
                                        }); 
                                    }else{
                                        Swal.fire('','Send All email Customer','error').then((result) => { 
                                        }); 
                                    } 
                                },
                                cache: false, 
                            });   
                        }
                    });
                }else{ 
                    $('.error_send_cust_npwp').removeClass('hide'); 
                }
            }else{ 
                $('.error_send_cust_type_2').removeClass('hide'); 
            }
        }else{
            $('.error_send_cust_type').removeClass('hide'); 
        }    
    }else{
        Swal.fire('','Input Periode billing','error').then((result) => { 
        }); 
    }
}  
function open_modal_billing_pdf(){
    $('.alibaba_posting_date').addClass('hide');
    var billing_type = $(".cust_type_billing_pdf:checked").val();
    if(billing_type == 'billing_alibaba'){
        $('.alibaba_posting_date').removeClass('hide'); 
        var posting_date = $('#alibaba_posting_date_val').val(); 
        if(posting_date != ''){ 
            $("#alibaba_posting_date").val(posting_date);
            $("#alibaba_posting_date").attr('readonly', 'readonly');
        }else{ 
            $('#alibaba_posting_date').datepicker({ 
                "autoclose": true,
                format: 'dd-mm-yyyy'
            }); 
            $("#alibaba_posting_date").datepicker("setDate", new Date());
        }
    }
    $('#btn_modal_new_billing_pdf').click(); 
}
function set_get_billing_type(){
    var billing_type = $(".cust_type_billing_pdf:checked").val();
    $('.alibaba_posting_date').addClass('hide');
    if(billing_type == 'billing_alibaba'){
        $('.alibaba_posting_date').removeClass('hide'); 
        var posting_date = $('#alibaba_posting_date_val').val();
        if(posting_date != ''){
            $("#alibaba_posting_date").val(posting_date);
            $("#alibaba_posting_date").attr('readonly', 'readonly'); 
        }else{ 
            $('#alibaba_posting_date').datepicker({ 
                "autoclose": true,
                format: 'dd-mm-yyyy'
            }); 
            $("#alibaba_posting_date").datepicker("setDate", new Date());
        }
    } 
}
function confirm_billing_pdf(){
    var billing_non_alibaba = $("#billing_non_alibaba").is(":checked") ? 1 : 0; 
    var billing_alibaba = $("#billing_alibaba").is(":checked") ? 1 : 0; 
    var billing_non_npwp = $("#billing_non_npwp").is(":checked") ? 1 : 0;   
    var billing_npwp = $("#billing_npwp").is(":checked") ? 1 : 0;   
    var periode_select = $('#month_year_now').val();
    var alibaba_posting_date = $('#alibaba_posting_date').val();  
    $('.error_cust_type').addClass('hide');   
    if(billing_alibaba == 1){
        if(alibaba_posting_date == ''){
            Swal.fire('','Input Posting date Alibaba sasd','error').then((result) => { 
                return;
            });  
        }
    }
    if(periode_select != ''){
        if(billing_non_alibaba != 0 || billing_alibaba != 0){
            if(billing_non_npwp != 0 || billing_npwp != 0){
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
                    url: base_url+"get-billing-pdf-new",
                    type: 'POST',  
                    dataType: "json",
                    data: {'periode':periode_select, 'billing_non_alibaba':billing_non_alibaba, 'billing_alibaba':billing_alibaba, 'billing_non_npwp':billing_non_npwp, 
                            'billing_npwp':billing_npwp, 'alibaba_posting_date':alibaba_posting_date},
                    success: function (res) {  
                        Swal.close ();
                        if(res.result){  
                            Swal.fire('','Generate PDF Periode '+periode_select+' Progeress', 'info').then((result) => { 
                                $('#modalNewBillingPdf').modal('toggle');
                                $('#periode_view').val(periode_select); 
                                location.reload();
                            }); 
                        }else{
                            Swal.fire('',res.message,'error').then((result) => { 
                            }); 
                        } 
                    },
                    cache: false, 
                });   
            }else{
                $('.error_cust_npwp').removeClass('hide'); 
            } 
        }else{
            $('.error_cust_type').removeClass('hide'); 
        }    
    }else{
        Swal.fire('','Input Periode billing','error').then((result) => { 
        }); 
    }
}  
var month_year_now = $('#month_year_now').val();
$("form.form_upload_pdf").submit(function(e) { 
    e.preventDefault();    
    var formData = new FormData(this);   
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
        url: base_url+"upload-pdf-fakur-pajak",
        type: 'POST',
        enctype: 'multipart/form-data',
        cache: false,
        dataType: "json",
        data: formData,
        success: function (res) { 
            if(res.result){  
                Swal.fire('','Upload file PDF Progress','info').then((result) => {  
                    $('#modalUploadPdf').modal('toggle');
                    check_count_month_year_now(month_year_now);
                });
            }else{
                Swal.fire('',res.message,'error').then((result) => {  
                    $('#modalUploadPdf').modal('toggle');
                    check_count_month_year_now(month_year_now);
                });
            }
        },
        cache: false,  
        processData: false,
        contentType: false,
    });
});
$("form.form_upload_excel").submit(function(e) { 
    e.preventDefault();    
    var formData = new FormData(this);   
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
        url: base_url+"upload-excel-fakur-pajak",
        type: 'POST',
        enctype: 'multipart/form-data',
        cache: false,
        dataType: "json",
        data: formData,
        success: function (res) { 
            if(res.result){  
                Swal.fire('','Upload file List Faktur Pajak Progress','info').then((result) => {  
                    $('#modalUploadExcel').modal('toggle');
                    check_count_month_year_now(month_year_now);
                });
            }else{
                Swal.fire('',res.message,'error').then((result) => {  
                    $('#modalUploadExcel').modal('toggle');
                    check_count_month_year_now(month_year_now);
                });
            }
        },
        cache: false,  
        processData: false,
        contentType: false,
    });
});
function get_list(periode){    
    $('#list_faktur_pajak').DataTable().destroy(); 
    $('#list_faktur_pajak').DataTable( {       
        ajax:{
            "url":  base_url+"view-list-faktur-pajak",
            "type": "POST", 
            "data": {"periode":periode}
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
            {   "data": "cust_type" },   
            {   "data": "cust_npwp_no" }, 
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
            {   "data": "faktur_pajak_file",                
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        if(data != null){
                            data = '<a href="#" onclick="view_faktur(\''+periode_view+'\',\''+data+'\')">' + data + '</a>';
                        }else{
                            data = '';
                        }
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
        "pageLength": 10, 
        "order": [[0, 'desc']]
    } );
} 
function get_list_month_year_now(periode){
    $('#list_faktur_pajak').DataTable().destroy(); 
    $('#list_faktur_pajak').DataTable( {       
        ajax:{
            "url":  base_url+"view-list-faktur-pajak-month-now",
            "type": "POST", 
            "data": {"periode":periode}
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
            {   "data": "cust_type" },    
            {   "data": "cust_npwp_no" }, 
            {   "data": "billing_amount",
                "render": function(data, type, row, meta){
                    if(type === 'display'){ 
                        if(row.billing_status == 1){
                            var amount = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            data = 'Rp. '+amount;
                        }else{
                            data = '';
                        }
                    } 
                    return data;
                }
            },
            {   "data": "billing_file",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        if(data != null){
                            if(row.billing_status == 1){
                                data = '<a href="#!" onclick="view_billing(\''+periode+'\',\''+row.cust_id+'\',\''+row.cust_name.replaceAll("\"", "")+'\')">' + data + '</a>';
                            }else if(row.billing_status == 2){
                                data = '<i class="fas fa-exclamation-circle  mr-1"></i>No Usage';
                            }else{
                                data = '';
                            }
                        }else{
                            data = '';
                        } 
                    } 
                    return data;
                }
            },   
            {   "data": "faktur_pajak_file",                
                "render": function(data, type, row, meta){ 
                    if(data != null){
                        data = '<a href="#" onclick="view_faktur(\''+periode+'\',\''+row.cust_id+'\',\''+row.cust_name.replaceAll("\"", "")+'\')">' + data + '</a>';
                    }else{
                        data = '';
                    } 
                    return data;
                }
            },     
            {   "data": "cust_id",
                "render": function(data, type, row, meta){   
                    var data_row = '';
                    if(row.cust_status == 0){
                        data_row += '<span class="label label-lg label-success label-pill label-inline mb-2">Active</span><br>';
                    }else if(row.cust_status == 1){ 
                        data_row += '<span class="label label-lg label-danger label-pill label-inline mb-2">Hold</span><br>';
                    } 
                    if(row.cust_instal_name == 'Alicloud'){
                        data_row += ' <span class="label label-lg label-primary label-pill label-inline mb-2">Alicloud</span> <br>';
                    } 
                    if(row.send_email_status == 1){
                        data_row += '<span class="label label-lg label-success label-pill label-inline mb-2"><i class="far fa-check-circle text-light mr-1"></i> email</span> <br>';
                        data_row += '<a href="#!" onclick="resent_email('+row.id+')"><i class="fas fa-envelope-open-text text-warning mr-1"></i> resent</a> <br>';
                    }else if(row.send_email_status == 2){  
                        data_row += '<span class="label label-lg label-danger label-pill label-inline mb-2"><i class="far fa-times-circle text-light mr-1"></i> email</span> <br>';
                        data_row += '<a href="#!" onclick="resent_email('+row.id+')"><i class="fas fa-envelope-open-text text-warning mr-1"></i> resent</a> <br>';
                    } else if(row.send_email_status == 0){  
                        data_row += '<span class="label label-lg label-warning label-pill label-inline mb-2"><i class="far fa-question-circle text-light mr-1"></i> email</span> <br>';
                        data_row += '<a href="#!" onclick="sent_email('+row.id+')"><i class="fas fa-envelope-open-text text-warning mr-1"></i> sent</a> <br>';
                    } 
                    return data_row;
                }
            } ,
            {   "data": "cust_id",
                "render": function(data, type, row, meta){   
                    var data_row = ''; 
                    if(row.send_email_status == 1){
                        data_row += '_#01_'; //email sukses terkirim
                    }else if(row.send_email_status == 2){  
                        data_row += '_#02_'; //email gagal terkirim
                    } else if(row.send_email_status == 0){  
                        data_row += '_#03_'; //email belum terkirim
                    } 
                    return data_row;
                }
            },
            {   "data": "cust_id",
                "render": function(data, type, row, meta){   
                    var data_row = ''; 
                    if(row.cust_instal_name == 'Alicloud'){
                        data_row += ' Alicloud';
                    }else{
                        data_row += 'Non Alicloud';
                    }
                    return data_row;
                }
            },
            {   "data": "cust_id",
                "render": function(data, type, row, meta){   
                    var data_row = ''; 
                    if(row.send_email_status == 1){
                        data_row += 'Email Sudah Terkirim';
                    }else if(row.send_email_status == 2){  
                        data_row += 'Email Gagal Terkirim';
                    } else if(row.send_email_status == 0){  
                        data_row += 'Email Belum Dikirim';
                    } 
                    return data_row;
                }
            },
            {   "data": "cust_id",
                "render": function(data, type, row, meta){   
                    var data_row = ''; 
                    if(row.send_email_status == 1){
                        data_row += row.send_email_date;
                    }
                    return data_row;
                }
            }    
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
                "targets": [ 6, 8 ],
                "className": "text-center"
            },
            {
                "targets": [ 10,11,12],
                visible: false,
                searchable: false,
            },
            {
                "targets": [ 9],
                visible: false,
                searchable: true,
            }
        ], 
        "pageLength": 10, 
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "order": [[0, 'desc']],
        dom: 'lBfrtip',
        buttons: [ 
            {
                text: '<i class="icon far fa-file-excel"></i> Export Excel',
                extend: 'excelHtml5',
                exportOptions: { 
                    columns: [ 0,1,2,3,4,5,6,7,10,11,12 ], 
                    modifier: {
                        order: 'current',
                        page: 'all',
                        selected: null,
                        search: 'none' 
                    },
                },
            }
        ],
    } );
}
function check_count(periode){ 
    $.ajax({
        url: base_url+"check-count-faktur-pajak",
        type: 'POST', 
        cache: false,
        dataType: "json",
        data: {'periode':periode},
        success: function (res) { 
            if(res.result){
                var res_data = res.data;
                var html = ''; 
                html += '<div class="d-flex align-items-center justify-content-between mb-2">'+ 
                            '<span class="text-muted font-size-sm font-weight-bold">All Customer</span>'+
                            '<span class="text-muted mr-2 font-size-sm font-weight-bold">'+getNumberWithCommas(res_data.count_cust)+'</span>'+
                        '</div>';
                html += '<div class="d-flex align-items-center justify-content-between mb-2">'+
                            '<span class="text-muted font-size-sm font-weight-bold">Customer NPWP</span>'+
                            '<span class="text-muted mr-2 font-size-sm font-weight-bold">'+getNumberWithCommas(res_data.count_npwp)+'</span>'+
                        '</div>';
                html += '<div class="d-flex align-items-center justify-content-between mb-2">'+ 
                            '<span class="text-muted font-size-sm font-weight-bold">Customer Non NPWP</span>'+
                            '<span class="text-muted mr-2 font-size-sm font-weight-bold">'+getNumberWithCommas(res_data.count_non_npwp)+'</span>'+
                        '</div>'; 
                $('.div_percentage').html(html);
                var btn_action = '';
                var btn_billing = 'hide';
                var btn_faktur = 'hide';
                var btn_all_email = 'hide';
                var html_billing = '';
                if(res_data.count_billing != 0){
                    btn_billing = 'hide';
                    btn_faktur = ''; 
                    html_billing += '<div class="d-flex align-items-center justify-content-between mb-2">'+ 
                                        '<span class="text-muted font-size-sm font-weight-bold">Billing PDF</span>'+
                                        '<span class="text-muted mr-2 font-size-sm font-weight-bold">'+getNumberWithCommas(res_data.count_billing)+'</span>'+
                                    '</div>';
                    if(res_data.count_billing == res_data.count_cust){ 
                        btn_all_email = '';
                    }else{ 
                        setTimeout(function(){check_count(periode)}, 5000);
                    }
                }else{
                    var btn_billing = '';
                }
                $('.div_count_billing').html(html_billing);
                btn_action +=   `<button class="btn btn-warning mr-1 mb-1 btn_get_biiling_pdf `+btn_billing+`" onclick="get_billing_pdf('`+periode+`')">Generate Billing PDF</button>
                                 <button class="btn btn-info mr-1 mb-1 btn_faktur_pdf `+btn_faktur+`" onclick="upload_faktur_pdf('`+periode+`')">Upload Faktur Pajak List</button>
                                 <button class="btn btn-success mr-1 btn_send_all_email `+btn_all_email+`" onclick="send_all_email('`+periode+`')">Send All E-mail</button>`; 
                $('.btn_send_all').html(btn_action);
            }else{ 
                $('.div_percentage').html('');
                $('.div_count_billing').html('');
            } 
        },
        cache: false, 
    });  
}
function get_billing_pdf(periode){
    Swal.fire({
        html: "Generated Billing PDF<br>Periode "+periode, 
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Get it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: base_url+"get-billing-pdf",
                type: 'POST', 
                cache: false,
                dataType: "json",
                data: {'periode':periode},
                success: function (res) {  
                    if(res.result){
                        Swal.fire('','Generate Billing Periode '+periode+' InProgress', 'success').then((result) => {   
                            $('.btn_get_biiling_pdf').addClass('hide');
                            $('.btn_faktur_pdf').removeClass('hide');
                            check_count(periode);
                        });  
                    }
                }
            });
        }
    });
}
function upload_faktur_pdf(periode){
    $('#periode_upload').val(periode);
    $('#file_to_upload_npwp').val(''); 
    $('#btn_upload_fp_indonet').click();

}
function getNumberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function check_count_month_year_now(periode){
    $.ajax({
        url: base_url+"check-count-faktur-pajak-new",
        type: 'POST', 
        cache: false,
        dataType: "json",
        data: {'periode':periode},
        success: function (res) { 
            if(res.result){
                var res_data = res.data; 
                $('#alibaba_posting_date_val').val(res_data.alibaba_posting_date); 
                var html = ''; 
                html += '<div class="d-flex align-items-center justify-content-between mb-2">'+ 
                            '<span class="text-muted font-size-sm font-weight-bold">All Customer</span>'+
                            '<span class="text-muted mr-2 font-size-sm font-weight-bold">'+getNumberWithCommas(res_data.count_cust)+'</span>'+
                        '</div>';
                html += '<div class="d-flex align-items-center justify-content-between mb-2">'+
                            '<span class="text-muted font-size-sm font-weight-bold">Customer NPWP</span>'+
                            '<span class="text-muted mr-2 font-size-sm font-weight-bold">'+getNumberWithCommas(res_data.count_npwp)+'</span>'+
                        '</div>';
                html += '<div class="d-flex align-items-center justify-content-between mb-2">'+ 
                            '<span class="text-muted font-size-sm font-weight-bold">Customer Non NPWP</span>'+
                            '<span class="text-muted mr-2 font-size-sm font-weight-bold">'+getNumberWithCommas(res_data.count_non_npwp)+'</span>'+
                        '</div>'; 
                html += '<hr>';
                $('.div_count_data').html(html);
                var btn_action = '';
                var btn_billing = 'hide';
                var btn_faktur = 'hide';
                var btn_all_email = 'hide';
                var html_billing = '';
                var html_status = '';
                var auto_update = 0;
                if(res_data.get_cust_list_status != 0){
                    if(res_data.get_cust_list_status == 1){
                        var billing_text_1 = `<span class="text-muted font-size-sm font-weight-bold"><i class="far fa-check-circle text-success mr-1"></i>`+res_data.get_cust_list_date+`</span>`;
                        var billing_text_2 = '';
                    }else{
                        var billing_text_1 = `<span class="text-muted font-size-sm font-weight-bold">Progress</span> `;
                        var billing_text_2 = `<div class="progress progress-xs w-100">
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div> `;
                        auto_update = 1;
                    }
                    html_status += `<div class="timeline-item"> 
                                        <span class="timeline-badge bg-success"></span>
                                        <div class="timeline-content d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column w-100 mr-2">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="mr-2 font-size-sm font-weight-bold">Get Customer List </span>`
                                                    +billing_text_1+                                                    
                                                `</div>`
                                                +billing_text_2+
                                            `</div> 
                                        </div>
                                    </div>`;
                }
                if(res_data.get_billing_pdf_status != 0){
                    if(res_data.get_billing_pdf_status == 1){
                        var billing_text_1 = `<span class="text-muted font-size-sm font-weight-bold"><i class="far fa-check-circle text-success mr-1"></i>`+res_data.get_billing_pdf_date+`</span>`;
                        var billing_text_2 = '';
                    }else{
                        var billing_text_1 = `<span class="text-muted font-size-sm font-weight-bold">Progress</span> `;
                        var billing_text_2 = `<div class="progress progress-xs w-100">
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div> `;
                        auto_update = 1;
                    }
                    html_status += `<div class="timeline-item"> 
                                        <span class="timeline-badge bg-success"></span>
                                        <div class="timeline-content d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column w-100 mr-2">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="mr-2 font-size-sm font-weight-bold">Generate Billing PDF</span>`
                                                    +billing_text_1+                                                    
                                                `</div>`
                                                +billing_text_2+
                                            `</div> 
                                        </div>
                                    </div>`;
                }
                if(res_data.upload_faktur_pdf_status != 0){
                    if(res_data.upload_faktur_pdf_status == 1){
                        var billing_text_1 = `<span class="text-muted font-size-sm font-weight-bold"><i class="far fa-check-circle text-success mr-1"></i>`+res_data.upload_faktur_pdf_date+`</span>`;
                        var billing_text_2 = '';
                    }else{
                        var billing_text_1 = `<span class="text-muted font-size-sm font-weight-bold">Progress</span> `;
                        var billing_text_2 = `<div class="progress progress-xs w-100">
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div> `;
                        auto_update = 1;
                    }
                    html_status += `<div class="timeline-item"> 
                                        <span class="timeline-badge bg-success"></span>
                                        <div class="timeline-content d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column w-100 mr-2">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="mr-2 font-size-sm font-weight-bold">Upload Faktur PDF</span>`
                                                    +billing_text_1+                                                    
                                                `</div>`
                                                +billing_text_2+
                                            `</div> 
                                        </div>
                                    </div>`;

                }
                if(res_data.upload_faktur_excel_status != 0){
                    if(res_data.upload_faktur_excel_status == 1){
                        var billing_text_1 = `<span class="text-muted font-size-sm font-weight-bold"><i class="far fa-check-circle text-success mr-1"></i>`+res_data.upload_faktur_excel_date+`</span>`;
                        var billing_text_2 = '';
                    }else{
                        var billing_text_1 = `<span class="text-muted font-size-sm font-weight-bold">Progress</span> `;
                        var billing_text_2 = `<div class="progress progress-xs w-100">
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div> `; 
                        auto_update = 1;
                    }
                    html_status += `<div class="timeline-item"> 
                                        <span class="timeline-badge bg-success"></span>
                                        <div class="timeline-content d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column w-100 mr-2">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="mr-2 font-size-sm font-weight-bold">Upload List Faktur Excel</span>`
                                                    +billing_text_1+                                                    
                                                `</div>`
                                                +billing_text_2+
                                            `</div> 
                                        </div>
                                    </div>`;

                }
                if(res_data.send_email_all_status != 0){
                    if(res_data.send_email_all_status == 1){
                        var billing_text_1 = `<span class="text-muted font-size-sm font-weight-bold"><i class="far fa-check-circle text-success mr-1"></i>`+res_data.send_email_all_date+`</span>`;
                        var billing_text_2 = '';
                    }else{
                        var billing_text_1 = `<span class="text-muted font-size-sm font-weight-bold">Progress</span> `;
                        var billing_text_2 = `<div class="progress progress-xs w-100">
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div> `;
                        auto_update = 1;
                    }
                    html_status += `<div class="timeline-item"> 
                                        <span class="timeline-badge bg-success"></span>
                                        <div class="timeline-content d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column w-100 mr-2">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="mr-2 font-size-sm font-weight-bold">Send All Email</span>`
                                                    +billing_text_1+                                                    
                                                `</div>`
                                                +billing_text_2+
                                            `</div> 
                                        </div>
                                    </div>`;

                } 
                $('.div_progress_bar').html(html_status); 
                if(auto_update == 1){
                    setTimeout(function(){
                        check_count_month_year_now(periode);
                    }, 5000); 
                }
            }else{ 
                $('.div_count_data').html('');
                $('.div_count_billing').html('');
            } 
        },
        cache: false, 
    });   
}
function resent_email(list_id){
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
        url: base_url+"get-cust-data-billing-id",
        type: 'POST', 
        cache: false,
        dataType: "json",
        data: {'list_id':list_id},
        success: function (res) { 
            Swal.close ();
            if(res.result){ 
                var res_data = res.data;
                $('#list_id_send_single_email').val(res_data.id);
                $('#list_cust_id_send_single_email').val(res_data.cust_id);
                $('#list_cust_name_send_single_email').val(res_data.cust_name);
                $('.cust_id_view').html(res_data.cust_id); 
                $('.send_text').html('Resent'); 
                var data_email =  res_data.cust_email.replace(/;/g, '\r\n'); 
                $('.cust_email_view').val(data_email); 
                $('#btn_modal_send_email_single').click();
            }else{  
                Swal.fire('','Error Customer ID','error').then((result) => { 
                }); 
            } 
        },
        cache: false, 
    });  
}
function sent_email(list_id){
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
        url: base_url+"get-cust-data-billing-id",
        type: 'POST', 
        cache: false,
        dataType: "json",
        data: {'list_id':list_id},
        success: function (res) { 
            Swal.close ();
            if(res.result){ 
                var res_data = res.data;
                $('#list_id_send_single_email').val(res_data.id);
                $('#list_cust_id_send_single_email').val(res_data.cust_id);
                $('#list_cust_name_send_single_email').val(res_data.cust_name);
                $('.send_text').html('Send'); 
                $('.cust_id_view').html(res_data.cust_name+' ('+res_data.cust_id+')'); 
                var data_email =  res_data.cust_email.replace(/;/g, '\r\n'); 
                $('.cust_email_view').val(data_email); 
                $('#btn_modal_send_email_single').click();
            }else{  
                Swal.fire('','Error Customer ID','error').then((result) => { 
                }); 
            } 
        },
        cache: false, 
    });  
}
function confirm_send_email_single(){
    var list_id = $('#list_id_send_single_email').val();
    var list_cust_id = $('#list_cust_id_send_single_email').val();
    var list_cust_name = $('#list_cust_name_send_single_email').val();
    Swal.fire({
        title: "Are you sure?",
        text: "You Send Email billing Customer name "+list_cust_name+" ("+list_cust_id+")",
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
                url: base_url+"send-billing-faktur-pajak-single",
                type: 'POST', 
                cache: false,
                dataType: "json",
                data: { 'list_id':list_id},
                success: function (res) {  
                    Swal.close ();
                    if(res.result){  
                        Swal.fire('','Send email Customer '+list_cust_name+' ('+list_cust_id+') Progress', 'info').then((result) => {  
                            $('#modalSendEmailSingle').modal('toggle'); 
                            view_list(); 
                        }); 
                    }else{
                        Swal.fire('','Send email Customer','error').then((result) => { 
                        }); 
                    } 
                },
                cache: false, 
            });   
        }
    });
}
function view_billing(periode, cust_id, cust_name){
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
        url: base_url+"view-billing-mini",
        type: 'POST', 
        cache: false,
        dataType: "html",
        data: {'periode':periode, 'cust_id':cust_id},
        success: function (res) { 
            Swal.close ();  
            $('.cust_id_view').html(cust_name+' ('+cust_id+')');
            $('.view_statement_mini').html(res);
            $('#btn_modal_view_billing').click();  
        },
        cache: false, 
    });  
}
function view_faktur(periode, cust_id, cust_name){
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
        url: base_url+"view-faktur-mini",
        type: 'POST', 
        cache: false,
        dataType: "html",
        data: {'periode':periode, 'cust_id':cust_id},
        success: function (res) { 
            Swal.close ();  
            $('.cust_id_view').html(cust_name+' ('+cust_id+')');
            $('.view_faktur_mini').html(res);
            $('#btn_modal_view_faktur').click();  
        },
        cache: false, 
    });  
}
function filter_send_email(obj){ 
    $('#list_faktur_pajak').DataTable().search( obj.value ).draw();
}