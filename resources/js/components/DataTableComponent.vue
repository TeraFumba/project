<template>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th v-for="column in columns" :key="column.name" @click="column.sortable ? $emit('sort', column.name) : false"
                :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                :style="'width:'+column.width+';'+'cursor:pointer;'">
                {{column.label}} <span><i v-if="column.sortable" class="fa fa-sort"></i></span>
            </th>
        </tr>
        </thead>
        <slot></slot>
    </table>
</template>

<script>
    export default {
        props: ['columns', 'sortKey', 'sortOrders']
    }
</script>
