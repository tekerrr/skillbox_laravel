<script>
    export default {
        render: () => { return null },

        mounted() {
            Echo
                .join('admin')
                .listen('UpdatedPost', (data) => {
                    this.makeTaskUpdatedToast(data.title, data.changes, data.href);
                });
        },
        methods: {
            makeTaskUpdatedToast(title, fields, href) {
                this.$bvToast.toast('Изменены: ' + fields, {
                    href: href,
                    title: 'Статья обновлена: ' + title,
                    toaster: 'b-toaster-bottom-right',
                    variant: 'success',
                    autoHideDelay: 10000
                });
            }
        },
    }
</script>
