<style scoped>
    .list {
        overflow: hidden auto;
        height: 91vh;
    }

    .list > div {
        height: 10vh;
        text-align: center;
        color: white;
        line-height: 10vh;
    }

    .list > div:nth-of-type(odd) {
        background: #71cdf4;
    }

    .list > div:nth-of-type(even) {
        background: #66b7ff;
    }
</style>

<template>
    <div>
        <div class="list" v-if="!res">
            <div v-for="(val,key) in filelist" :key="key" @click="start(key)">{{ val }}</div>
        </div>
        <div class="list" v-else>
            <div v-for="(val,key) in res" :key="key">{{ val.title }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index",
        data() {
            return {
                filelist: [],
                res: null,
            }
        },
        methods: {
            start(key) {
                this.$axios.get('/start/getst/' + key)
                    .then(res => {
                        this.res = res.data.data;
                    })
                    .catch(err => {
                        swal('出错了', '就是出错了');
                    });
            }
        },
        mounted() {
            this.$axios.get('/filelist')
                .then(res => {
                    if (res.data.err == 0) {
                        this.filelist = res.data.data;
                    } else {
                        swal("出错了", res.data.msg);
                    }
                })
                .catch(err => {
                    swal("出错了", "请求失败了哦(〃＞目＜)");
                });
        }
    }
</script>