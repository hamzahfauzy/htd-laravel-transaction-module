window.reportDataTable = $('.report-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: location.href,
        data: function(data){
            data.filter = {
                date_start: $('#date_start').val(),
                date_end: $('#date_end').val()
            }

            return data
        }
    },
    aLengthMenu: [
        [25, 50, 100, 200],
        [25, 50, 100, 200]
    ],
    columnDefs: [
        {
        targets: 0, // index kolom No
        width: '1%',
        className: 'dt-nowrap'
        }
    ]
});

$('.btn-filter').click(function(){
    $('#filterModal').modal('hide')
    window.reportDataTable.draw()
})

$('.print-btn').click(function(){
    const data = {
        date_start: $('#date_start').val(),
        date_end: $('#date_end').val()
    }

    window.open('/reports/daily-transaction/detail/'+data.date_start)
})