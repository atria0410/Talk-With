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
    methods: {
        // Ajaxでフォロー/フォロー解除
        follow(follow_id, input_id) {
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
                    if (followed == 1) {
                        followBtn.innerHTML = 'フォローする';
                        followBtn.classList.replace('btn-danger', 'btn-primary');
                        document.getElementById(input_id).value = 0;
                    } else {
                        followBtn.innerHTML = 'フォロー解除';
                        followBtn.classList.replace('btn-primary', 'btn-danger');
                        document.getElementById(input_id).value = 1;
                    }
                });
        }
    },
});