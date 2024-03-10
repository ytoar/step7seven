$(function(){
    loadSort();
})
function loadSort(){
    $('#tableproduct').tablesorter();
};

$(document).on('click', '#search', function(e) {
    e.preventDefault();
    console.log('読み込みOK');
    console.log('検索開始');
    let formData = $('#search-form').serialize();
    $.ajax({
        type: "GET",
        url: 'list',
        data: formData,
        dataType: 'html',
    }).done(function(data) {
        let newTable = $(data).find('#product-table');
        $('#product-table').html(newTable);
        console.log('ajax成功');

        // 削除ボタンのイベントを再度バインドする
        $('.delete-btn').off('click').on('click', function(e) {
            e.preventDefault();
            var deleteConfirm = confirm('削除スタート');
            if (deleteConfirm) {
                let clickEle = $(this);
                let deleteId = clickEle.data('delete-id');
                console.log(deleteId);
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                $.ajax({
                    url: 'products/' + deleteId,
                    type: 'POST',
                    data: { '_method': 'DELETE' }
                }).done(function(results) {
                    // 通信が成功したときの処理
                    let target = clickEle.parents('tr');
                    target.remove();
                    var deleteConfirm = confirm('削除しました');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // 通信が失敗したときの処理
                    var deleteConfirm = confirm('削除に失敗しました');
                });
            } else {
                console.log('削除キャンセル');
            }
        });
    }).fail(function() {
        console.log('ajax失敗');
    });
});