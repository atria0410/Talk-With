/* 画像のプレビューを更新する */
new Vue({
    el: '#app',
    methods: {
        uploadFile() {
            var file = this.$refs.fileSelect.files[0];
            var url = URL.createObjectURL(file);

            this.$refs.preview.src = url;
            this.$refs.fileLabel.innerHTML = file.name;
        }
    }
});

new Vue({
    el: '#show',
    data: {
        stragePath: '',  // ストレージパス
        user_id: '',     // ユーザーID
        followed: null,  // フォロー済みフラグ
        btn_text: '',    // フォローボタンのテキスト
        btn_class: '',   // フォローボタンのクラス属性
        followers: [],   // フォロワーデータ
    },
    methods: {
        // Ajaxでフォロワー取得
        getFollower(user_id) {
            const url = '/user/' + user_id + '/follower';

            axios.get(url)
                .then((response) => {
                    this.followers = response.data;
                })
        },
        // Ajaxでフォロー/フォロー解除
        follow(follower_id) {
            var status = document.getElementById(follower_id).value;

            var url;
            if (status == 1) {
                url = '/user/unfollow';
            } else {
                url = '/user/follow';
            }

            const formData = new FormData();
            formData.append('follow_id', follower_id);

            axios.post(url, formData)
                .then((response) => {
                    this.btnChange(follower_id);
                });
        },
        // フォローボタン/フォロー解除ボタンの切り替え
        btnChange(btn_id) {
            var status = document.getElementById(btn_id).value;
            var followBtn = document.getElementById('btn' + btn_id);

            if (status == 1) {
                document.getElementById(btn_id).value = 0;
                followBtn.innerHTML = 'フォローする';
                followBtn.classList.replace('btn-danger', 'btn-primary');
            } else {
                document.getElementById(btn_id).value = 1;
                followBtn.innerHTML = 'フォロー解除';
                followBtn.classList.replace('btn-primary', 'btn-danger');
            }
        }
    },
    mounted() {
        // ユーザーID取得
        this.user_id = this.$refs.user_id.value;
        // フォロー済み判定取得
        this.followed = this.$refs.followed.value;
        // 画像ストレージのパスを取得
        this.stragePath = this.$refs.strage_path.value;

        // フォロワーを取得
        this.getFollower(this.user_id);
        
    }
});