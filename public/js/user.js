/* 新規登録ページ */
new Vue({
    el: '#new',
    data: {
        disabled: false　    // 登録ボタンの無効化
    },
    methods: {
        // 登録ボタン押下時処理
        submit() {
            this.disabled = true;  // 2重送信防止
        }
    },
});

/* ユーザー編集ページ */
new Vue({
    el: '#edit',
    data: {
        disabled: false　    // 登録ボタンの無効化
    },
    methods: {
        previewImage() {
            var file = this.$refs.fileSelect.files[0];
            var url = URL.createObjectURL(file);

            this.$refs.preview.src = url;
            this.$refs.fileLabel.innerHTML = file.name;
        },
        // 変更ボタン押下時処理
        submit() {
            this.disabled = true;  // 2重送信防止
        }
    }
});

/* ユーザー情報ページ */
new Vue({
    el: '#show',
    data: {
        disabled: false　    // フォローボタンの無効化
    },
    methods: {
        // Ajaxでフォロー/フォロー解除
        follow(follow_id, input_id) {
            this.disabled = true;  // 2重送信防止

            var followBtn = event.target;
            var followed = document.getElementById(input_id).value;

            var url;
            if (followed == 1) {
                url = '/user/unfollow';
            } else {
                url = '/user/follow';
            }

            const formData = new FormData();
            formData.append('follow_id', follow_id);

            axios.post(url, formData)
                .then((response) => {
                    // ボタンの変更
                    if (followed == 1) {
                        followBtn.innerHTML = 'フォローする';
                        followBtn.classList.replace('btn-danger', 'btn-primary');
                        document.getElementById(input_id).value = 0;
                    } else {
                        followBtn.innerHTML = 'フォロー解除';
                        followBtn.classList.replace('btn-primary', 'btn-danger');
                        document.getElementById(input_id).value = 1;
                    }
                })
                .finally(() => {
                    this.disabled = false;  // ボタン無効化解除
                });
        }
    },
});