$('.custom-file-input').on('change',function(){
    $(this).next('.custom-file-label').html($(this)[0].files[0].name);
})

// ルーム作成ボタン
function createRoom(user_id) {
    if (user_id == 1) {
        alert("ゲストユーザーはルームを作成できません。");
        return;
    }

    window.location.href = '/room/new';
}