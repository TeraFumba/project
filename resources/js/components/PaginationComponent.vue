<template>
    <nav class="pagination pull-right" style="margin: 0px;float: right">
        <span class="" style="margin-right: 10px"><strong>{{pagination.from}} - {{pagination.to}} of {{pagination.total}}</strong></span>
        <a v-if="pagination.prevPageUrl" class="btn btn-default" @click="$emit('prev');">Prev</a>
        <a class="btn btn-default" v-else :disabled="true">Prev</a>
        <a v-if="pagination.nextPageUrl" class="btn btn-default" @click="$emit('next');">Next</a>
        <a class="btn btn-default" v-else :disabled="true">Next</a>
    </nav>
</template>

<script>
    export default {
        props: ['pagination', 'client', 'filtered']
    }
</script>
