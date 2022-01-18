<template>
    <div class="w-full" v-clickoutside="hide">
        <div class="relative float-left w-full border-2 border-Dark-m rounded-md select-none" :ref="arr.id+'_search'">
            <div class="h-full flex border-Dark-m justify-between items-center" :class="{'border-b-2': !arr.radio && names.length > 0}">
                <div class="text-Dark-m mx-1.5">
                    <slot></slot>
                </div>
                <div @click="show = true">
                    <input
                        v-if="!arr.radio"
                        type="search"
                        class="w-full peer bg-transparent placeholder-transparent outline-none h-10 px-2 cursor-pointer"
                        :placeholder="ph()"
                        v-model="search"
                        @input="non"
                        autocomplete="off"
                        :id="arr.id"/>
                    <input
                        v-else
                        type="search"
                        class="w-full peer bg-transparent placeholder-transparent outline-none h-10 px-2 cursor-pointer"
                        :placeholder="ph()"
                        v-model="names"
                        disabled
                        @input="non"
                        :id="arr.id"/>

                    <label
                        :for="arr.id"
                        class="absolute left-2.5 -top-4 text-sm font-bold text-Dark-l text-opacity-100 transition-all duration-300
                                peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-md peer-placeholder-shown:px-7 peer-placeholder-shown:text-opacity-50
                                peer-focus:-top-4 peer-focus:text-sm peer-focus:px-0 peer-focus:text-opacity-100"
                    >
                        {{ ph() }}
                    </label>
                </div>



                <button
                    type="button"
                    class="h-10 w-14 transition-all border-l-2 border-Dark-m flex justify-center items-center cursor-pointer"
                    :class="{'text-Error': show, 'hover:text-Info active:text-Done': !show}"
                    @click="show = !show"
                >
                    {{ show ? '&#10006;' : '&#9660;' }}
                </button>
            </div>
            <div
                class="flex m-1 px-2 py-1 rounded-md bg-Dark-m float-left"
                v-if="!arr.radio"
                v-for="(n, index) in names"
                :key="index">
                {{ n }}
                <button
                    type="button"
                    class="relative transition-all duration-300 ml-2 px-1 text-xs flex justify-center items-center cursor-pointer bg-Error rounded-md hover:bg-Light hover:text-Error active:text-Done"
                    @click="takeDel(index)"
                    v-if="oneOrTwo() == false || arr.btn"
                >
                    &#10006;
                </button>
            </div>
        </div>

        <div
            class="w-full max-h-[220px] overflow-y-auto absolute z-50 border-2 border-Dark-m p-2 bg-Dark rounded-md translate-y-0 float-left mt-[45px] text-left"
            style="display: block;"
            v-show="show"
            :ref="arr.id+'_list'">
            <ul class="group space-y-1">
                <li v-for="item in arr.array" :key="item.id" class="select-none"
                    v-if="item.name.toLowerCase().includes(search.toLowerCase())">
                    <input
                        class="appearance-none hidden"
                        :name="arr.name"
                        :value="item.id"
                        :id="arr.id+'_'+item.id"
                        :type="one"
                        v-model="take"
                        @input="maxLength()"
                    >
                    <label class="hover:bg-Dark-m w-full px-2 py-1 rounded-md" :class="{'text-Info': takeSet(item.id)}" :for="arr.id+'_'+item.id">
                        {{ item.name }}
                    </label>
                </li>
                <li v-if="none != false || arr.array.length < 1">
                    Ничего не найдено...
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "SelectNew",

    components: {},

    props: ['arr'],

    data() {
        return {
            windowHeight: null,
            blockSearch: null,
            blockList: null,
            math: 0,
            take: [],
            takeDef: [],
            search: '',
            names: [],
            one: 'radio',
            none: false,
            show: false,
            moreDef: [],
        }
    },

    mounted () {
        this.window();
        this.oneOrTwo();
        this.modelToTake();
    },

    methods: {
        window() {
            this.windowHeight = document.getElementById("app");
            this.blockSearch = this.$refs[`${this.arr.id}_search`];
            this.blockList = this.$refs[`${this.arr.id}_list`];

            if (this.blockSearch != null && this.windowHeight != null) {
                this.math = this.windowHeight.getBoundingClientRect().bottom - this.blockSearch.getBoundingClientRect().bottom;

                if (this.math <= 200) {
                    this.blockList.style.marginBottom = '45px';
                    this.blockList.style.marginTop = '0px';
                    this.blockList.style.transform = 'translateY(-100%)';
                } else {
                    this.blockList.style.marginTop = '45px';
                    this.blockList.style.marginBottom = '0px';
                    this.blockList.style.transform = 'translateY(0%)';
                }
            }
        },

        maxLength() {
            this.$nextTick(() => {
                if (this.take.length > this.arr.max && this.arr.max != null) {
                    this.take = this.take.slice(0, this.arr.max);
                }
            });
        },

        getNames() {
            if (this.arr.radio !== false) {
                this.names.push(this.arr.array.filter(a => a.id == this.take)[0].name);
                this.hide();
            } else {
                for (var i = 0; i < this.take.length; i++) {
                    this.names.push(this.arr.array.filter(a => a.id == this.take[i])[0].name);

                }
            }
        },

        takeDel(i) {
            if (this.take.length > 1)
                this.take.splice(i, 1);
            else
                this.take = [];
        },

        takeSet(id) {
            if (!this.arr.radio){
                return this.take.filter((t) => t === id).length > 0;
            } else {
                return this.take === id;
            }

        },

        non() {
            var e = 0;
            for (let i = 0; i < this.arr.array.length; i++) {
                if (this.arr.array[i].name.toLowerCase().includes(this.search.toLowerCase()))
                    e++;
            }
            if (e == 0)
                this.none = true;
            else
                this.none = false;
        },

        hide() {
            this.show = false
        },

        oneOrTwo() {
            if (this.arr.radio !== false) {
                this.one = 'radio';
                return true;
            } else {
                this.one = 'checkbox';
                return false;
            }
        },

        ph() {
            if (this.arr.max != null && !this.arr.radio) {
                return this.arr.text + ' (макс. ' + this.arr.max + ')';
            } else {
                return this.arr.text;
            }

        },

        modelToTake() {
            if (this.arr.value != null && this.arr.radio) {
                this.take = [];
                this.take = this.arr.value;
                this.takeDef = this.take;
            } else if (this.arr.value != null && !this.arr.radio) {
                this.take = [];
                for (let i = 0; i < this.arr.value.length; i++) {
                    if (this.arr.value[0].id != null) {
                        this.take.push(this.arr.value[i].id);
                    } else {
                        this.take.push(this.arr.value[i]);
                    }
                    this.takeDef = this.take;
                }
            }
        },

        res() {
            this.$emit('res', [
                this.take,
            ])
        },
    },

    directives: {
        clickoutside: {
            bind: function (el, binding, vnode) {
                el.clickOutsideEvent = function (event) {

                    if (!(el == event.target || el.contains(event.target))) {
                        vnode.context[binding.expression](event);
                    }
                };
                document.body.addEventListener('click', el.clickOutsideEvent)
            },
            unbind: function (el) {
                document.body.removeEventListener('click', el.clickOutsideEvent)
            },
            stopProp(event) {
                event.stopPropagation()
            }
        }
    },

    watch: {
        show() {
          if (this.show){
              this.blockList.style.maxWidth = '' + this.blockSearch.getBoundingClientRect().width + 'px';
          }
        },
        take() {
            this.names = [];
            this.res();
            if (this.take.length != []) {
                this.getNames();
            }
            this.maxLength();
        },

        arr() {
            if ((typeof this.take) == 'object') {
                if (this.arr.value != null) {
                    for (var i = 0; i < this.take.length; i++) {
                        //console.log(this.array.find(item => item.id == Number(this.take[i])));
                        if (this.arr.array.find(item => item.id == Number(this.take[i])) == null) {
                            this.take.splice(i, 1); //////////////////////////////////////////////////////////////////
                            // console.log(i);
                        } else {
                            this.modelToTake();
                        }
                    }
                } else {
                    this.take = [];
                }
            } else {
                if (this.arr.value != null) {
                    this.take = this.arr.value;
                } else {
                    this.take = '';
                }
            }
        },
    }
}
</script>

<style scoped>

</style>
