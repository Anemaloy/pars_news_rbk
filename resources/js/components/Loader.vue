<template>
    <div>
        <button @click="getNews()">Загрузить последние новости</button>
        <div v-show="loader" class="lds-dual-ring"></div>
        <p v-show="error_message" style="color: red"> {{ error_message }}</p>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                loader: false,
                error: false,
                error_message: null,
            }
        },
        methods: {
            getNews () {
                let vm = this;
                this.loader = true;
                axios.post('/api' + this.$root.$api.Articles.load)
                    .then((response) => {
                        if (response.data.original.error) {
                            vm.error = true;
                            vm.error_message = response.data.original.error_message;
                        } else {
                            this.$emit('loaded', true)
                        }
                        this.loader = false;
                    })
            },
        },
    }
</script>

<style>
.lds-dual-ring {
    display: inline-block;
    width: 80px;
    height: 80px;
}
.lds-dual-ring:after {
    content: " ";
    display: block;
    width: 64px;
    height: 64px;
    margin: 8px;
    border-radius: 50%;
    border: 6px solid #fff;
    border-color: #fff transparent #fff transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

</style>
