
$(function() {
    $('.delete').on('click', function() {
        var deleteConfirm = confirm('削除スタート');
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        var url = 'delete'
        $.ajax({
            url: 'url',
            type: 'GET'
        }).done(function (results) {
            //通信が成功したときの処理
            var deleteConfirm = confirm('削除しました');
        }).fail(function (jqXHR, textStatus, errorThrown) {
            //通信が失敗したときの処理
            var deleteConfirm = confirm('削除に失敗しました');
        });
    });
});

$("#search").change(function(){
    $.ajax({
        type:"GET",
        url:"{{ route('list') }}",
        data:JSON,
    })
    .done(function(json){
        alert('ajax成功');
    })
    .fail(function(){
        alert('ajax失敗');
    })
    .always(function(){
        //通信の成功と失敗に関わらず実行される処理
    });
});