$(function(){
    loadSort();
})
function loadSort(){
    $('#tableproduct').tablesorter();
};

$(document).ready(function() {
    $('#search-form').submit(function(e) {
        e.preventDefault();
        console.log('検索開始');
        let formData = $(this).serialize();
        $.ajax({
            type: "GET",
            url: 'list',
            data: formData,
            dataType: 'html',
            success: function(data) {
                let newTable = $(data).find('#product-table');
                $('#product-table').html(newTable);
                console.log('ajax成功');
            },
            error: function() {
                console.log('ajax失敗');
            }
        });
    });

    $(document).on('click', '.delete-btn', function(e) {
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
                data: { '_method': 'DELETE' },
                success: function(results) {
                    // 通信が成功したときの処理
                    let target = clickEle.parents('tr');
                    target.remove();
                    var deleteConfirm = confirm('削除しました');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // 通信が失敗したときの処理
                    var deleteConfirm = confirm('削除に失敗しました');
                }
            });
        } else {
            console.log('削除キャンセル');
        }
    });
});
