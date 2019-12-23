<template>
    <div v-if="show">
        <hr>
        <h4 class="mb-3">Сгенерированный отчет</h4>
        <p v-for="(value, name) in report">{{ name }}: {{ value }}</p>
    </div>
</template>

<script>
    export default {

        props: ['userId'],

        data () {
            return {
                report: [],
                show: false
            }
        },

        mounted() {
            Echo
                .private('report-total.' + this.userId)
                .listen('CreatedTotalReport', (data) => {

                    this.report = data.report;
                    this.show = true;

                });
        }
    }
</script>
