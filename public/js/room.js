/* 新規作成ページ */
new Vue({
    el: '#new',
    methods: {
        uploadFile() {
            var file = this.$refs.fileSelect.files[0];
            var url = URL.createObjectURL(file);

            this.$refs.preview.src = url;
            console.log(this.$refs);
            this.$refs.fileLabel.innerHTML = file.name;
        }
    }
});

/* メッセージフォームのサイズを自動調整する */
new Vue({
    el: '#app',
    data: {
        stragePath: '',     // ストレージパス
        room_id: '',        // ルームID
        owner_id: '',       // オーナーのユーザーID
        chats: [],          // 全チャットデータ
        date: '',           // 日付
        message: '',        // 入力メッセージ
        image: '',          // 画像
        defaultHright: 0,   // テキストエリアのデフォルト高さ
        previousHeight: 0,  // テキストエリアの更新前の高さ
        row: 1              // テキストエリアの行数
    },
    methods: {
        // Ajaxでメッセージを取得
        getChats() {
            const url = '/room/' + this.room_id + '/get';

            axios.get(url)
                .then((response) => {
                    this.chats = response.data;
                })
                .finally(() => {
                    // 画面を一番下までスクロール
                    var elm = document.documentElement;
                    var bottom = elm.scrollHeight - elm.clientHeight;
                    window.scroll(0, bottom);
                });
        },
        // Ajaxでメッセージを送信
        send() {
            const url = '/room/' + this.room_id + '/send';
            
            const formData = new FormData();
            formData.append('message', this.message);
            formData.append('image', this.image);

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            axios.post(url, formData, config)
              .then((response) => {
                    this.message = '';
                    this.image = '';
                    this.$refs.image_file.value = null;
                });
        },
        // 日付フォーマットを設定
        dateFormat(date, format) {
            return moment(date).format(format);
        },
        // 画像ファイル選択時処理
        selectedImage() {
            this.image = this.$refs.image_file.files[0];
        }
    },
    watch: {
        // テキストエリアのサイズを更新
        message() {
            const textarea = this.$refs.adjust_textarea;
            const sendbtn = this.$refs.send_btn;

            if (textarea.scrollHeight > this.previousHeight) {
                // 前回よりサイズが大きくなった場合
                this.row++;
            } else if (textarea.scrollHeight < this.previousHeight) {
                // 前回よりサイズが小さくなった場合
                this.row--;
            }
            
            if (this.row <= 3) {
                // 3行以下のときのみ更新
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
                sendbtn.style.marginTop = textarea.scrollHeight - this.defaultHright + 'px';
            }

            this.previousHeight = textarea.scrollHeight;
        }
    },
    filters: {
        moment(value, format) {
            return moment(value).format(format);
        }
    },
    mounted() {
        // ルームIDを取得
        this.room_id = this.$refs.room_id.value;
        // オーナーのユーザーIDを取得
        this.owner_id = this.$refs.owner_id.value;
        
        // 画像ストレージのパスを取得
        this.stragePath = this.$refs.strage_path.value;

        // テキストエリアのサイズを取得
        const textarea = this.$refs.adjust_textarea;
        this.defaultHright = textarea.scrollHeight;
        this.previousHeight = textarea.scrollHeight;

        this.getChats();

        Echo.channel('chat').listen('MessageCreated', (e) => {
            this.getChats(); // 全メッセージを再読込
        });

    }
});