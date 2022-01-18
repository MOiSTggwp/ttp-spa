<template>
    <div class="overflow-auto w-full" v-clickoutside="hide">
        <div class="float-left w-full border-2 border-Dark-m rounded-md select-none" :ref="arr.id+'_search'">
            <div class="flex justify-between items-center" :class="{'input__error': errmsg != '' && checkError}">
                <slot></slot>
                <input type="search" v-model="search" :placeholder="ph()" class="w-full h-full pr-4 cursor-pointer"
                       @input="non()" @click="show = true"/>
                <button
                    type="button"
                    class="h-10 w-12 border-l-2 border-Dark-m flex justify-center items-center cursor-pointer"
                    :class="{'text-Error': show}"
                    @click="show = !show"
                    v-text=""
                >{{ show ? '&#10006;' : '&#9660;' }}
                </button>
            </div>
            <div class="px-2 py-1 border-2 border-Dark-m float-left" v-for="(n, index) in names" :key="index">
                {{ n }}
                <button
                    type="button"
                    class="relative ml-1 flex justify-center items-center cursor-pointer bg-Dark-l rounded-md hover:text-Error accent:bg-Light"
                    @click="takeDel(index)"
                    v-if="oneOrTwo() == false || def"
                >
                   &#10006;
                </button>
            </div>
        </div>
        <div class="dropdown-list text-left" style="display: none;" v-show="show" :ref="arr.id+'_list'">
            <ul class="group">
                <!--        <li v-if="def">-->
                <!--          <input-->
                <!--              class="dropdown-input"-->
                <!--              :name="name"-->
                <!--              value="0"-->
                <!--              :id="arr0"-->
                <!--              :type="one"-->
                <!--              v-model="take"-->
                <!--              @input="maxLength()"-->
                <!--          >-->
                <!--          <label class="dropdown-label" :for="arr0">-->
                <!--            ----->
                <!--          </label>-->
                <!--        </li>-->
                <li v-for="item in arr.array" class=" select-none"
                    v-if="item.name.toLowerCase().includes(search.toLowerCase())">
                    <input
                        class="appearance-none"
                        :name="name"
                        :value="item.id"
                        :id="prefix+'_'+item.id"
                        :type="one"
                        v-model="take"
                        @input="maxLength()"
                    >
                    <label class="dropdown-label" :for="prefix+'_'+item.id">
                        {{ item.name }}
                    </label>
                </li>
                <li v-if="none != false || arr.array.length < 1">
                    Ничего не найдено...
                </li>
            </ul>
<!--                        <ul v-else>-->
<!--                            <li v-for="item in array" class="dropdown-li select-none"-->
<!--                                v-if="item.title.toLowerCase().includes(search.toLowerCase())">-->
<!--                                <input-->
<!--                                    class="dropdown-input"-->
<!--                                    :name="name"-->
<!--                                    :value="item.id"-->
<!--                                    :id="prefix+'_'+item.id"-->
<!--                                    :type="one"-->
<!--                                    v-model="take"-->
<!--                                    @click="non()"-->
<!--                                >-->
<!--                                <label class="dropdown-label" :for="prefix+'_'+item.id">-->
<!--                                    {{ item.title }}-->
<!--                                </label>-->
<!--                            </li>-->
<!--                            <li v-if="none != false">-->
<!--                                Ничего не найдено...-->
<!--                            </li>-->
<!--                        </ul>-->
        </div>
<!--        <div class="error text-sm" v-if="errmsg != '' && checkError">{{ errmsg }}</div>-->
    </div>
</template>

<script>
export default {
    name: "SelectElement",
    props: {
        arr: [],
        name: '',
        prefix: '',
        array: ['1', '2', '3'],
        title: '',
        radio: false,
        checkError: false,
        model: null,
        more: {
            default: null,
        },
        btn: false,
        max: null,
        requir: true,
        def: false,
    },
    data() {
        return {
            show: false,
            search: '',
            ul: [],
            take: [],
            takeDef: [],
            moreDef: null,
            names: [],
            // namesDef: [],
            windowHeight: null,
            blockSearch: null,
            blockList: null,
            math: null,
            none: false,
            one: 'checkbox',
            errmsg: '',
            error: false,
        }
    },
    mounted() {
        this.window();
        this.oneOrTwo();
        this.required();
        this.go();
        this.moreDef = this.more;
        this.modelToTake();
        setInterval(() => {
            this.blockList.style.maxWidth = '' + this.blockSearch.getBoundingClientRect().width + 'px';
            // console.log();
            // console.log(this.names);
            //console.log(this.take);
        }, 1000);
    },

    updated() {
        // this.window();
    },

    methods: {
        modelToTake() {
            if (this.model != null && this.radio != false) {
                this.take = [];
                this.take = this.model;
                this.takeDef = this.take;
            } else if (this.model != null && this.radio != true) {
                this.take = [];
                for (let i = 0; i < this.model.length; i++) {
                    if (this.model[0].id != null) {
                        this.take.push(this.model[i].id);
                    } else {
                        this.take.push(this.model[i]);
                    }
                    this.takeDef = this.take;
                }
            }
        },
        ph() {
            if (this.max != null) {
                return this.title + ' (макс. ' + this.max + ')';
            } else {
                return this.title;
            }

        },
        maxLength() {
            this.$nextTick(() => {
                if (this.take.length > this.max && this.max != null) {
                    this.take = this.take.slice(0, this.max);
                }
            });
        },
        oneOrTwo() {
            if (this.radio != false) {
                this.one = 'radio';
                return true;
            } else if (this.radio != true) {
                this.one = 'checkbox';
                return false;
            }
        },
        getNames() {
            if (this.radio != false) {
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
        required() {
            if (this.take.length <= 0 && this.requir != false) {

                this.errmsg = 'Выберите пункт из списка.';
                this.error = true;

            } else {

                this.errmsg = '';
                this.error = false;
            }
        },
        hide() {
            this.show = false
        },
        go() {
            this.$emit('go', [
                this.take,
                this.error
            ])
        },
    },
    directives: {
        clickoutside: {
            bind: function (el, binding, vnode) {
                el.clickOutsideEvent = function (event) {
                    // here I check that click was outside the el and his childrens
                    if (!(el == event.target || el.contains(event.target))) {
                        // and if it did, call method provided in attribute value
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
            this.window();
        },
        take() {
            this.names = [];
            this.required();
            this.go();
            if (this.take.length != []) {
                this.getNames();
            }
            this.maxLength();
        },
        more() {
            if ((typeof this.take) == 'object') {
                if (this.model != null) {
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
                if (this.model != null) {
                    this.take = this.model;
                } else {
                    this.take = '';
                }
            }
        },
        error() {
            this.go();
        }
    }
}
</script>

<style scoped>

</style>
