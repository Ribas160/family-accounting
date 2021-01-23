<template>
    <div class="container">
        <qrcode-stream @decode="onDecode" @init="onInit" class="stream" />
    </div>
</template>
<script>
    import axios from "axios";
    import { QrcodeStream } from 'vue-qrcode-reader';

    export default {
        components: {
            QrcodeStream,
        },
        data () {
            return {
                result: '',
                scanned: false,
            }
        },
        mounted() {
            this.$emit('loadTitle', 'QRcode scan');
        },
        methods: {
            onDecode (result) {
                axios
                    .post('https://5c3bf1fc202e.ngrok.io/projects/tmp/family-accounting/public/api/scan', {
                        data: result,
                    })
                    .then((res) => {
                        alert(res.data.message);
                        if (!res.data.error) {
                            this.$router.push('history');
                        }
                    });
            },

            async onInit (promise) {
                try {
                    await promise
                } catch (error) {
                    if (error.name === 'NotAllowedError') {
                        this.error = "ERROR: you need to grant camera access permisson"
                    } else if (error.name === 'NotFoundError') {
                        this.error = "ERROR: no camera on this device"
                    } else if (error.name === 'NotSupportedError') {
                        this.error = "ERROR: secure context required (HTTPS, localhost)"
                    } else if (error.name === 'NotReadableError') {
                        this.error = "ERROR: is the camera already in use?"
                    } else if (error.name === 'OverconstrainedError') {
                        this.error = "ERROR: installed cameras are not suitable"
                    } else if (error.name === 'StreamApiNotSupportedError') {
                        this.error = "ERROR: Stream API is not supported in this browser"
                    }
                    alert(this.error);
                }
            }
        }
    }
</script>
<style scoped>
.error {
    font-weight: bold;
    color: red;
}
.stream {
    position: fixed;
    top: 50%;
    transform: translateY(-52%);
    left: 0;
    right: 0;
    margin: 0 auto;
    max-height: 70vh;
    max-width: calc(100% - 30px);
}
</style>
