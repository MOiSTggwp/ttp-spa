<template>
    <div class="flex justify-center w-full my-3">
        <fieldset class="w-[280px] border-none p-0 m-0">
            <div class="text-center font-bold" :class="{'-mb-2': range != false, 'mb-2': range == false}"
                 v-if="title!=null">
                {{ title }}
            </div>
            <div class="price-field relative w-full h-[44px]" :class="{'flex justify-center items-center': range == false}">
                <div class="flex items-center">
                <span v-if="range != true" :class="{'mr-2': range == false}">
                    {{ titleDown }}
                </span>
                    <div :class="{'flex bg-dark p-0.5': range == false}">
                        <input
                            class="input-num w-12 p-2 border-lightDark"
                            :class="{'absolute left-1 top-1/2 transform -translate-y-1/2': range != false}"
                            type="number"
                            :name="nameDown"
                            v-model="lower"
                            @wheel.prevent="scrollDown"
                        >
                        <div v-if="range == false" class="flex flex-col justify-center">
                            <button type="button" class="btn px-0.5 py-0.5 text-xs border-lightDark" @click="click('lowerUp')">
                                &#9650;
                            </button>
                            <button type="button" class="btn px-0.5 py-0.5 text-xs border-lightDark" @click="click('lowerDown')">
                                &#9660;
                            </button>
                        </div>
                    </div>
                </div>
                <div class="main-ramge-input" v-if="range != false">
                    <input
                        class="left-range"
                        type="range"
                        :min="min"
                        :max="max"
                        v-model="lower"
                    >
                    <input
                        class="right-range"
                        type="range"
                        :min="min"
                        :max="max"
                        v-model="upper"
                    >
                </div>

                <div class="flex items-center">
                <span v-if="range != true" :class="{'mr-2 ml-3': range == false}">
                    {{ titleUp }}
                </span>
                    <div :class="{'flex bg-dark p-0.5': range == false}">
                        <input
                            class="input-num w-12 p-2"
                            :class="{'absolute right-1 top-1/2 transform -translate-y-1/2': range != false}"
                            type="number"
                            :name="nameUp"
                            v-model="upper"
                            @wheel.prevent="scrollUp"
                        >

                        <div v-if="range == false" class="flex flex-col justify-center">
                            <button type="button" class="btn px-0.5 py-0.5 text-xs border-lightDark" @click="click('upperUp')">
                                &#9650;
                            </button>
                            <button type="button" class="btn px-0.5 py-0.5 text-xs border-lightDark" @click="click('upperDown')">
                                &#9660;
                            </button>
                        </div>
                    </div>
                </div>

                <div class="slider-range-in absolute w-[7rem] h-[2px] bg-Dark left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 z-20 border-none overflow-hidden" v-if="range != false">
                    <div class="slider-range-right absolute z-10 w-[7rem] h-[1rem] bg-Dark -left-full top-1/2 -translate-y-1/2 ml-[0.8rem] border-none" :style="{'left': procentl + '%'}"></div>
                    <div class="slider-range-left absolute z-10 w-[7rem] h-[1rem] bg-Dark right-full top-1/2 -translate-y-1/2 mr-[0.8rem] border-none" :style="{'right': procentr + '%'}"></div>
                </div>


            </div>

        </fieldset>
    </div>
</template>

<script>
export default {
    name: "InputRangeElement",
    props: {
        two: true,
        nameUp: '',
        nameDown: '',
        modelUp: {
            type: Number,
        },
        modelDown: {
            type: Number,
        },
        min: 0,
        max: 0,
        gap: 0,
        title: '',
        range: true,
        titleDown: '',
        titleUp: '',
        loop: false,
    },
    data() {
        return {
            lower: {
                type: Number,
                default: 0,
            },
            oldLower: {
                type: Number,
                default: 0,
            },
            upper: {
                type: Number,
                default: 0,
            },
            oldUpper: {
                type: Number,
                default: 0,
            },
            mathl: 0,
            mathr: 0,
            procentl: 0,
            procentr: 0,
        }
    },
    mounted() {
        if (this.modelUp)
            this.upper = this.modelUp;
        else
            this.upper = this.max;

        if (this.modelDown)
            this.lower = this.modelDown;
        else
            this.lower = this.min;

        this.oldUpper = this.upper;
        this.oldLower = this.lower;
        // setInterval(() => {
        //
        // }, 1000);
    },
    methods: {
        go() {
            this.$emit('go',[
                this.lower,
                this.upper,
            ]);
        },
        sliderOne() {
            if (parseInt(this.upper) - parseInt(this.lower) <= this.gap) {
                this.lower = parseInt(this.upper) - this.gap;
            }
            if (this.lower < this.min || this.lower == '') {
                this.lower = this.min;
            }
        },
        sliderTwo() {
            if (parseInt(this.upper) - parseInt(this.lower) <= this.gap) {
                this.upper = parseInt(this.lower) + this.gap;
            }
            if (this.upper > this.max || this.upper == '') {
                this.upper = this.max;
            }
        },
        scrollDown(ev) {
            if (ev.deltaY < 0) {
                this.oldLower = this.lower;
                this.lower++;
            } else {
                this.oldLower = this.lower;
                this.lower--;
            }
        },
        scrollUp(ev) {
            if (ev.deltaY < 0) {
                this.oldUpper = this.upper;
                this.upper++;
            } else {
                this.oldUpper = this.upper;
                this.upper--;
            }
        },
        lowerLoop() {
            if (this.lower < this.min) {
                this.lower = this.max;
                if (this.upper == this.lower) {
                    this.lower = (this.max - 1);
                }
            } else if (this.lower > this.max) {
                this.lower = this.min;
                if (this.upper == this.lower) {
                    this.lower = (this.min + 1);
                }
            }
        },
        upperLoop() {
            if (this.upper < this.min) {
                this.upper = this.max;
                if (this.upper == this.lower) {
                    this.upper = (this.max - 1);
                }
            } else if (this.upper > this.max) {
                this.upper = this.min;
                if (this.upper == this.lower) {
                    this.upper = (this.min + 1);
                }
            }
        },
        skipLower() {
            if (this.upper == this.lower && this.lower > this.oldLower && !(this.lower < this.min) && !(this.lower > this.max)) {
                this.lower = (this.upper + 1);
            } else if (this.upper == this.lower && this.lower <= this.oldLower && !(this.lower < this.min) && !(this.lower > this.max)) {
                this.lower = (this.upper - 1);
            }
        },
        skipUpper() {
            if (this.upper == this.lower && this.upper > this.oldUpper && !(this.upper < this.min) && !(this.upper > this.max)) {
                this.upper = (this.lower + 1);
            } else if (this.upper == this.lower && this.upper <= this.oldUpper && !(this.upper < this.min) && !(this.upper > this.max)) {
                this.upper = (this.lower - 1);
            }
        },
        click(val) {
            if (val == 'upperUp'){
                this.oldUpper = this.upper;
                this.upper++;
            } else if (val == 'upperDown') {
                this.oldUpper = this.upper;
                this.upper--;
            }
            if (val == 'lowerUp'){
                this.oldLower = this.lower;
                this.lower++;
            } else if (val == 'lowerDown') {
                this.oldLower = this.lower;
                this.lower--;
            }
        }
    },
    watch: {
        upper() {
            if (this.range != false) {
                this.mathl = Math.max(parseInt(this.lower), parseInt(this.upper));
                this.procentl = ((this.mathl - this.min) / (this.max - this.min)) * 100;
            }
            if (this.loop != true) {
                this.sliderTwo();
            } else {
                this.skipUpper();
                this.upperLoop();
            }
            this.go();
        },
        lower() {
            if (this.range != false) {
                this.mathr = Math.min(parseInt(this.upper), parseInt(this.lower));
                this.procentr = (((this.mathr - this.min) / (this.min - this.max)) * 100) + 100;
            }
            if (this.loop != true) {
                this.sliderOne();
            } else {
                this.skipLower();
                this.lowerLoop();
            }
            this.go();
        }
    }
}
</script>

<style scoped>
.right-range::-webkit-slider-thumb {
    margin-left: .8rem;
}
.left-range::-webkit-slider-thumb {
    margin-left: -.8rem;
}
</style>
