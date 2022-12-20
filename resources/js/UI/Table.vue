<template>
    <table v-if="columns && data" class="w-full border-2 border-Dark-l">
        <thead class="bg-Dark-m">
        <tr>
            <th
                v-for="(column, index) in columns"
                :key="index"
                :class="[`p-2 border-2 border-Dark-l`]"
                :style="`width: ${column.width}%; text-align: ${column.text.position ? column.text.position : 'left'};`"
                data-name="column.name"
            >
                {{ column.title }}
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(item, index) in data" :key="item.id" :class="{'bg-Light bg-opacity-10': index % 2 == 1}">
            <td v-for="(column, index) in columns" :key="index"
                class="p-2 border-l-2"
            >
                <div v-if="!column.button" :style="`justify-content: ${column.text.position ? column.text.position : 'left'};`">
                    <div v-if="column.toggle && toggle[item.id].toggle" class="w-full">
                        <Input
                            v-if="column.toggle == 'input'"
                            :arr="{
                                value: name(item, column) ? name(item, column) : 'Незаполено',
                                type: 'text',
                                id: name(item, column),
                            }"
                            :padding="false"
                            @res="pushArr"
                        >
                        </Input>
                    </div>
                    <div v-else>
                        <router-link v-if="column.link" :to="{ name: column.link, params: { id: item.id }}">
                            {{ name(item, column) ? name(item, column) : 'Незаполено' }}
                        </router-link>
                        <U-Img
                            v-else-if="column.img"
                            :url="name(item, column)"
                            :alt="name(item, column) ? name(item, column) : 'Незаполено'"
                            w="100"
                        ></U-Img>
<!--                        <img v-else-if="column.img"-->
<!--                             :src="name(item, column)"-->
<!--                             :alt="name(item, column) ? name(item, column) : 'Незаполено'"-->
<!--                             width="100"-->
<!--                        >-->
                        <div v-else>
                            {{ name(item, column) ? name(item, column) : 'Незаполено' }}
                        </div>
                    </div>
                </div>


                <div v-else class="flex space-x-2"
                     :style="`display: flex; margin: auto; justify-content: ${column.text.position ? column.text.position : 'left'};`"
                >
                    <U-Button
                        v-for="btn in column.button"
                        :key="btn.name"
                        class="max-w-min"
                        @click="btn.toggle == true ? toggleClick(item) : click(btn, item)"
                        :text="btn.text"
                        position="top"
                    ><Edit3></Edit3></U-Button>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import Input from "./Input";
import {Edit3} from 'lucide-vue';

export default {
    name: "Table",
    props: {
        columns: [],
        data: [],
    },
    components: {
        Input,
        Edit3
    },
    data() {
        return {
            arr: [],
            toggle: {},
        }
    },
    mounted() {

    },
    methods: {
        name(item, column) {
            if (column.name.length <= 1) {
                return item[column.name[0]]
            }
            let name = item;
            for (let i of column.name) {
                name = name[i];
            }
            return name;
        },
        click(btn, item) {
            this.$emit('click', [btn.name, item.id]);
        },
        pushArr(r) {
            console.log(r)
        },
        setToggle() {
            for (let i of this.data) {
                this.$set(this.toggle, i.id, {'toggle': false});
            }
        },
        toggleClick(item) {
            for(let i in this.toggle){
                if(i == item.id) {
                    console.log(this.toggle[i].toggle)
                    this.toggle[i].toggle = !this.toggle[i].toggle;
                }
            }
        }
    },
    watch: {
        data() {
            this.setToggle();
        }
    }
}
</script>

<style scoped>

</style>
