<!--Настройки

links - пагинация links
pagination - пагинация meta
-->
<template>
    <div v-if="lastPage && lastPage > 1">
        <div v-if="linksList != null" class="flex justify-center items-center gap-[4px] sm:gap-[8px]">
            <div class="flex justify-center items-center gap-[4px] sm:gap-[8px]">
                <U-Button
                    class="max-w-min"
                    @click="setLink(linksList.get('first').url)"
                    :tip="false"
                    :text="linksList.get('first').label"
                    :disabled="disabledCheck(linksList.get('first').url)"
                ></U-Button>
                <U-Button
                    class="max-w-min"
                    @click="setLink(linksList.get('prev').url)"
                    :tip="false"
                    :text="linksList.get('prev').label"
                    :disabled="disabledCheck(linksList.get('prev').url)"
                ></U-Button>
            </div>
            <div>
                <U-Number
                    :val="currentPage"
                    width="50"
                    :min="pagination.first_page"
                    :max="pagination.last_page"
                    @res="inputRes"
                ></U-Number>
            </div>
            <div class="flex justify-center items-center gap-[4px] sm:gap-[8px]">
                <U-Button
                    class="max-w-min"
                    @click="setLink(linksList.get('next').url)"
                    :tip="false"
                    :text="linksList.get('next').label"
                    :disabled="disabledCheck(linksList.get('next').url)"
                ></U-Button>
                <U-Button
                    class="max-w-min"
                    @click="setLink(linksList.get('last').url)"
                    :tip="false"
                    :text="linksList.get('last').label"
                    :disabled="disabledCheck(linksList.get('last').url)"
                ></U-Button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "U-Paginate",
    props: {
        links: {},
        pagination: {},
    },
    data() {
        return {
            linksList: null,
            lastPage: null,
            currentPage: 1,
            link: '/api',
            webPath: '',
            timeout: 0,
        }
    },
    methods: {
        setWebPath() {
            let url = new URL(this.linksList.get('first').url).pathname;
            this.webPath = this.$attrs ? this.$attrs['web-path'] : url.replace('/api', '');
        },
        disabledCheck(link) {
            this.currentPage = this.pagination.current_page;
            if (link == null) return true;
            let url = new URL(link);
            let page = url.searchParams.get('page');
            if (page == this.pagination.current_page || (window.location.search === '' && page === '1')) return true;
        },
        createLinksList() {
            let map = new Map();
            for (let i in this.links) {
                if (i === 'prev') map.set('prev', {label: '«', 'url': this.links[i]});
                if (i === 'first') map.set('first', {label: '1', 'url': this.links[i]});
                if (i === 'last') map.set('last', {label: this.pagination.last_page, 'url': this.links[i]});
                if (i === 'next') map.set('next', {label: '»', 'url': this.links[i]});
            }
            this.linksList = map;
        },
        setLink(link) {
            this.link = new URL(link);
            window.history.pushState(null, "", `${this.webPath + this.link.search}`);
            this.change();
        },
        change() {
            this.$emit('change');
        },
        inputRes(r){
            if(r != '' && r != this.currentPage){
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    this.currentPage = r;
                    let url = new URL(this.linksList.get('first').url);
                    url.searchParams.set('page', String(this.currentPage));
                    this.setLink(url)
                }, 750);
            }

        }
    },
    watch: {
        links() {
            this.createLinksList();
            this.setWebPath();
        },
        webPath() {
            this.link += this.webPath;
        },
        pagination() {
            this.lastPage = this.pagination.last_page;
            if (this.pagination.current_page > this.pagination.last_page || this.pagination.current_page < 1) {
                window.history.pushState(null, "", `${this.webPath}`);
                this.change();
            }
        },
    }
}
</script>

<style scoped>

</style>
