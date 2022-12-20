<!--Настройки

data - список пунктов для селекта
value - выбранные пункты
text - текст плэйсхолдера
width - ширина инпура поиска
multi - флаг выбора много пунктов или один
max - ограничение при множественном выборе
-->
<template>
    <div class="relative" v-if="data">

        <!--        Input-select-->
        <div class="flex items-center" ref="searchBlock">
            <div @click="data.length > 0 ? listOpen = true : ''" class="w-full">
                <U-Input
                    ref="searchRef"
                    type="search"
                    :padding="!!$slots.default"
                    :text="`${text} ${max ? `(макс. ${max})` : ''}`"
                    :width="width"
                    @res="searchRes"
                    :disabled="data.length < 1"
                >
                    <slot v-if="$slots.default"></slot>
                </U-Input>
            </div>
            <div>
                <button
                    class="block !border-l-0 transition duration-300
                    -ml-[4px] border-2 border-Dark-m p-[6px] pl-[10px] bg-Dark text-Light/50 rounded-r-md"
                    :class="[listOpen ? listUp ? '!border-t-0 rounded-tr-none !pt-2' : '!border-b-0 rounded-br-none !pb-2' : '',
                    data.length < 1 ? 'bg-Dark-m/30' : 'hover:text-Light']"
                    @click="data.length > 0 ? listOpen = !listOpen : ''"
                >
                    <ChevronDown v-if="!listOpen" class="w-6 h-6"></ChevronDown>
                    <ChevronUp v-else class="w-6 h-6"></ChevronUp>
                </button>
            </div>
        </div>

        <!--        Лист data-->
        <div
            v-show="listOpen"
            ref="list"
            class="z-50 scroll:transparent border-2 py-[6px] border-Dark-m text-sm bg-Dark
            absolute after:h-[4px] after:w-[2px] after:absolute after:block after:-left-[2px] after:bg-Dark-m after:z-50"
            :class="[listUp ? 'after:-bottom-[4px] !border-b-0 rounded-t-md -translate-y-[100%] top-0' : 'after:-top-[4px] !border-t-0 rounded-b-md']"
            :style="resize()"
        >
            <div class="max-h-[100px] px-[6px] overflow-hidden hover:!overflow-y-auto">
                <ul class="w-full flex flex-column gap-0.5">
                    <li
                        v-for="item in data"
                        :key="item.id"
                        v-if="searchResult(item)"
                        class="px-[4px] py-[2px] w-full cursor-pointer relative text-Light/60 transition-all duration-300
                        hover:bg-Dark-m/40 rounded-md select-none"
                        :class="[{'!text-Light/100 bg-Done-m/50': checkSelectData(item)}, {'!bg-Error': selectOver === item.id}]"
                        @click="setSelectData(item)"
                    >
                        {{ item.name }}
                    </li>
                    <li v-if="searchFlag.length < 1 && searchValue" class="pl-[12px] pr-[4px] py-[2px]">
                        Не найдено...
                    </li>
                </ul>
            </div>
        </div>

        <!--        Лист selectData-->
        <div
            v-if="selectData.length > 0"
            class="w-full scroll:transparent border-2 py-[6px] border-Dark-m text-sm bg-Dark flex flex-wrap gap-2 px-[4px] py-[8px]
            relative after:h-[4px] after:w-[2px] after:absolute after:block after:-left-[2px] after:bg-Dark-m
            before:h-[4px] before:w-[2px] before:absolute before:block before:-right-[2px] before:bg-Dark-m"
            :class="[
                listUp
                ? 'after:-bottom-[4px] !border-b-0 rounded-t-md -translate-y-[100%] top-0 before:-bottom-[4px]'
                : 'after:-top-[4px] !border-t-0 rounded-b-md before:-top-[4px]'
            ]"
            :style="resize"
        >
            <U-Tag
                v-for="item in selectData"
                :key="item.id"
                class="text-Light/70 text-xs"
                color="error"
                border="dashed"
                :button="!!multi"
                @click="setSelectData(item)"
            >
                {{ item.name }}
            </U-Tag>
        </div>


    </div>
</template>

<script>
import {ChevronDown, ChevronUp} from 'lucide-vue';

export default {
    name: "U-Select",
    components: {
        ChevronDown,
        ChevronUp
    },
    props: {
        data: {
            default: null
        },
        value: {
            default: null
        },
        text: {
            default: ''
        },
        width: {
            default: ''
        },
        multi: {
            default: true
        },
        max: {
            default: ''
        },
    },
    data() {
        return {
            searchRef: '',
            listRef: '',

            searchValue: '',
            searchFlag: true,
            listOpen: false,
            listUp: false,
            selectOver: null,
            timeout: 0,

            selectData: [],
        }
    },
    mounted() {
        for (let i of this.value) {
            this.setSelectData(i);
        }
        this.setRefs();
    },
    methods: {
        setRefs() {
            this.searchRef = this.$refs.searchBlock;
            this.listRef = this.$refs.list;
        },
        resize() {
            return `width: ${this.searchRef.offsetWidth}px`;
        },
        searchRes(r) {
            this.searchValue = r;
            this.searchResultFlag();
        },
        res() {
            this.$emit('res', this.selectData);
        },
        searchResult(item) {
            return item.name.toLowerCase().includes(this.searchValue.toLowerCase());
        },
        searchResultFlag() {
            this.searchFlag = this.data.filter(i => i.name.toLowerCase().includes(this.searchValue.toLowerCase()));
        },
        async setSelectData(item) {
            this.selectData = await this.selectMulti(this.selectData, item);
        },
        selectMulti(data, item) {
            if (!this.multi) {
                return [item];
            } else {
                return this.selectMax(data, item);
            }
        },
        selectMax(data, item) {
            if (data.length >= Number(this.max) && this.max) {
                if (data.filter(i => i.id === item.id).length > 0) {
                    return data.filter(i => i.id !== item.id);
                } else {
                    this.checkSelectOver(item);
                    return data;
                }
            } else {
                return this.selectFilter(data, item);
            }
        },
        selectFilter(data, item) {
            if (data.filter(i => i.id === item.id).length > 0) {
                return data.filter(i => i.id !== item.id);
            } else {
                data.push(item)
                return data;
            }
        },
        checkSelectData(item) {
            return this.selectData.filter(i => i.id === item.id).length > 0;
        },
        checkHeight() {
            let app = document.getElementById('app');
            let searchBottom = this.searchRef.getBoundingClientRect().bottom + 10;
            this.$nextTick(() => {
                this.listUp = (app.getBoundingClientRect().bottom - searchBottom) < this.listRef.offsetHeight;
            });
        },
        checkSelectOver(item) {
            clearTimeout(this.timeout);
            this.selectOver = item.id;
            this.timeout = setTimeout(() => {
                this.selectOver = null;
            }, 150);
        }
    },
    watch: {
        listOpen() {
            this.checkHeight();
        },
        selectData() {
            this.res();
        },
        value() {
            for (let i of this.value) {
                this.setSelectData(i);
            }
        }
    }
}
</script>

<style scoped>
::-webkit-scrollbar {
    width: 4px; /* ширина для вертикального скролла */
    height: 4px; /* высота для горизонтального скролла */
}
</style>
