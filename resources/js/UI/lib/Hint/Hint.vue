<!--Настройки

text - Текст сообщения
show - Флаг отображения
-->
<template>
    <div>
        <div ref="tipTarget" class="relative" @mouseover="show ? hint() : null"
             @mouseout="show ? tipHidden() : null">
            <slot></slot>
            <div
                v-show="show"
                ref="tip"
                class="absolute min-w-max z-[100] left-[0px] top-[0px] flex justify-center"
                :class="hintShow ? 'opacity-90' : 'opacity-0'"
            >
                <div class="max-w-auto whitespace-normal rounded-md bg-Dark bg-opacity-[96%] border-2 border-Dark-m border-opacity-[66%]
                shadow-md px-2 py-1 text-center pointer-events-none select-none">
                    {{ text }}
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "U-Hint",
    props: {
        text: {default: ''},
        show: {default: true},
    },
    data() {
        return {
            hintShow: false,
            timeout: null,
            app: document.getElementById("app"),
            tip: null,
            target: null,
            left: null,
            right: null,
        }
    },
    mounted() {
        // if (this.show == undefined || this.show == null) this.show = true;
        if (this.show) this.setItems();
    },
    methods: {
        setItems() {
            this.tip = this.$refs.tip;
            this.target = this.$refs.tipTarget;
        },
        default() {
            this.left = this.target.getBoundingClientRect().left;
            this.right = this.app.getBoundingClientRect().width - this.target.getBoundingClientRect().right;
            this.tip.style.width = '100%';
            this.tip.style.minWidth = 'max-content';
            this.tip.style.left = `${(this.target.offsetWidth / 2) - (this.tip.offsetWidth / 2)}px`;
        },
        checkLeftRight() {
            if (this.left + (this.target.offsetWidth / 2) < (this.tip.offsetWidth / 2) && this.right + (this.target.offsetWidth / 2) < (this.tip.offsetWidth / 2)) {
                this.tip.style.width = '300px';
                this.tip.style.minWidth = 'auto';
                this.tip.style.left = `${(this.target.offsetWidth / 2) - (this.tip.offsetWidth / 2)}px`;
                if (this.left + (this.target.offsetWidth / 2) < (this.tip.offsetWidth / 2) && (this.right + this.target.offsetWidth) >= this.tip.offsetWidth) {
                    this.tip.style.left = '0px';
                } else if ((this.left + this.target.offsetWidth) >= this.tip.offsetWidth && this.right + (this.target.offsetWidth / 2) < (this.tip.offsetWidth / 2)) {
                    this.tip.style.left = 'auto';
                    this.tip.style.right = '0px';
                }
            } else if (this.left + (this.target.offsetWidth / 2) < (this.tip.offsetWidth / 2)) {
                this.tip.style.left = '0px';
                if ((this.right + this.target.offsetWidth) < this.tip.offsetWidth) {
                    this.tip.style.width = '300px';
                    this.tip.style.minWidth = 'auto';
                }
            } else if (this.right + (this.target.offsetWidth / 2) < (this.tip.offsetWidth / 2)) {
                this.tip.style.left = 'auto';
                this.tip.style.right = '0px';
                if ((this.left + this.target.offsetWidth) < this.tip.offsetWidth) {
                    this.tip.style.width = '300px';
                    this.tip.style.minWidth = 'auto';
                }
            }
        },
        preHint() {
            let math = this.app.getBoundingClientRect().bottom - this.target.getBoundingClientRect().bottom;
            this.default();
            this.checkLeftRight();
            if (math <= (this.target.offsetHeight + this.tip.offsetHeight + 10)) {
                this.tip.style.top = `-${this.tip.offsetHeight + 10}px`;
            } else {
                this.tip.style.top = `${this.target.offsetHeight + 10}px`;
            }
        },
        hint() {
            this.timeout = setTimeout(() => {
                this.tip.style.display = 'flex';
                this.preHint();
                this.hintShow = true;
                clearTimeout(this.timeout);
            }, 1250);
        },
        tipHidden() {
            this.tip.style.display = 'none';
            this.hintShow = false;
            clearTimeout(this.timeout);
        },
    },
    watch: {
        options() {
            if (this.show == undefined || this.show == null) this.show = true;
        },
        tip() {
            this.default();
            this.tip.style.display = 'none';
        }
    }
}
</script>

<style scoped>

</style>
